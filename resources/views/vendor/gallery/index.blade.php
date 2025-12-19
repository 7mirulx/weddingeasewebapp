@extends('layouts.vendor')

@section('page-title', 'Gallery')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold text-indigo-700 mb-6">Gallery Management</h2>

        <!-- Upload Section -->
        <div class="mb-8 p-6 border-2 border-dashed border-indigo-300 rounded-lg bg-indigo-50">
            <h3 class="text-lg font-semibold text-indigo-700 mb-4">Upload New Image</h3>
            <p class="text-gray-600 mb-4">Max 4 images • JPG, PNG, GIF • Max 2MB per image</p>

            <form id="gallery-upload-form" action="{{ route('vendor.gallery.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-4">
                @csrf
                <input type="file" 
                    id="image" 
                    name="image" 
                    accept="image/*"
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                    @if(count($gallery) >= 4) disabled @endif>
                
                @if(count($gallery) >= 4)
                    <p class="text-yellow-600 font-semibold">You have reached the maximum of 4 images. Delete an image to upload a new one.</p>
                @else
                    <button type="submit" class="px-6 py-2 bg-indigo-600 text-white font-semibold rounded-lg hover:bg-indigo-700 transition">
                        Upload Image
                    </button>
                @endif
            </form>

            @error('image')
                <div class="mt-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <!-- Current Gallery -->
        <div>
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Current Images ({{ count($gallery) }}/4)</h3>

            @if(count($gallery) > 0)
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($gallery as $index => $image)
                        <div class="relative group rounded-lg overflow-hidden shadow-lg bg-gray-100">
                            <img src="{{ asset('storage/' . $image) }}" 
                                alt="Gallery image" 
                                class="w-full h-48 object-cover">
                            
                            <form action="{{ route('vendor.gallery.delete', $index) }}" 
                                method="POST" 
                                class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 flex items-center justify-center opacity-0 group-hover:opacity-100 transition"
                                onsubmit="return confirm('Delete this image?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                                    Delete
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 bg-gray-50 rounded-lg text-center">
                    <p class="text-gray-500">No images yet</p>
                    <p class="text-gray-400 text-sm mt-2">Upload your first image to get started</p>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.getElementById('gallery-upload-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const fileInput = document.getElementById('image');
        const file = fileInput.files[0];
        
        if (!file) {
            alert('Please select an image');
            return;
        }
        
        // Check file size (2MB = 2097152 bytes)
        const maxSize = 2 * 1024 * 1024;
        if (file.size > maxSize) {
            alert('Image is too large! Maximum file size is 2MB.\n\nYour file: ' + (file.size / 1024 / 1024).toFixed(2) + 'MB');
            return;
        }
        
        const formData = new FormData(this);
        
        fetch('{{ route("vendor.gallery.store") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            return response.text();
        })
        .then(text => {
            console.log('Raw response:', text);
            try {
                const data = JSON.parse(text);
                if (data.success) {
                    window.location.reload();
                } else {
                    alert('Error uploading image: ' + (data.error || 'Unknown error'));
                }
            } catch (e) {
                alert('Error parsing response: ' + e.message + '\nResponse: ' + text.substring(0, 200));
            }
        })
        .catch(error => {
            alert('Error uploading image: ' + error.message);
        });
    });
</script>
@endsection
