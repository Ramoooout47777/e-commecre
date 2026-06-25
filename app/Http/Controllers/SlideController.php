<?php
namespace App\Http\Controllers;

use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function index()
    {
        $slides = Slide::latest()->get();
        return view('slides.index', compact('slides'));
    }

    public function create()
    {
        return view('slides.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'title_kh' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
        ]);

        $slide = new Slide();
        $slide->title = $request->title;
        $slide->title_kh = $request->title_kh;
        $slide->description = $request->description;
        $slide->slug = Str::slug($request->title) . '-' . rand(1000, 9999);
        $slide->is_active = $request->has('is_active');

        if ($request->hasFile('image')) {
            $slide->image = $request->file('image')->store('slides', 'public');
        }

        $slide->save();
        return redirect()->route('slides.index')->with('success', 'Slide created successfully.');
    }

    public function edit(Slide $slide)
    {
        return view('slides.edit', compact('slide'));
    }

    public function update(Request $request, Slide $slide)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $slide->title = $request->title;
        $slide->title_kh = $request->title_kh;
        $slide->description = $request->description;
        $slide->is_active = $request->has('is_active');

        if ($request->hasFile('image')) {
            // Delete old image
            if ($slide->image) { Storage::disk('public')->delete($slide->image); }
            $slide->image = $request->file('image')->store('slides', 'public');
        }

        $slide->save();
        return redirect()->route('slides.index')->with('success', 'Slide updated!');
    }
}