<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-900">Slides</h2>
            <a href="{{ route('slides.create') }}" class="bg-gray-900 hover:bg-black text-white px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                + Add Slide
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg text-sm">{{ session('success') }}</div>
            @endif

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table id="slides-table" data-dt class="admin-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Title (KH)</th>
                                <th>Image</th>
                                <th style="text-align:center">Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($slides as $slide)
                                <tr>
                                    <td class="font-semibold text-gray-900">{{ $slide->title }}</td>
                                    <td class="text-gray-500">{{ $slide->title_kh ?? '—' }}</td>
                                    <td>
                                        @if($slide->image)
                                            <img src="{{ Storage::url($slide->image) }}" class="w-20 h-12 object-cover rounded-lg border border-gray-200">
                                        @else
                                            <div class="w-20 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-[9px]">IMG</div>
                                        @endif
                                    </td>
                                    <td style="text-align:center">
                                        <span class="inline-flex px-2.5 py-0.5 rounded-full text-xs font-semibold {{ $slide->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                            {{ $slide->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="flex justify-end items-center gap-4">
                                            <a href="{{ route('slides.edit', $slide->id) }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Edit</a>
                                            <form action="{{ route('slides.destroy', $slide->id) }}" method="POST" onsubmit="return confirm('Delete this slide?')">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-sm font-medium text-red-500 hover:text-red-700 transition-colors">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-16 text-center text-sm text-gray-400">No slides yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
