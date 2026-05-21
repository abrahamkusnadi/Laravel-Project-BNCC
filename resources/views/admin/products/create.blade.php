@extends('layout.admin')

@section('title', 'Add New Product')

@section('content')
<div class="max-w-2xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
    
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Add New Product</h1>
        <p class="text-sm text-gray-500 mt-1">Create a new item in your inventory with category and stock details.</p>
    </div>

    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Category</label>
                    <select name="category_id" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-900 transition duration-200 appearance-none text-gray-900" required>
                        <option value="" disabled selected>Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-900 mb-2">Product Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" minlength="5" maxlength="80" placeholder="e.g. Premium Fried Rice" required
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-900 transition duration-200">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Price (IDR)</label>
                        <div class="relative mt-1 rounded-xl shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                                <span class="text-gray-500 sm:text-sm">Rp</span>
                            </div>
                            <input type="number" name="price" value="{{ old('price') }}" placeholder="15000" required
                                   class="w-full pl-11 pr-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-900 transition duration-200">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-semibold text-gray-900 mb-2">Initial Stock</label>
                        <input type="number" name="stock" value="{{ old('stock') }}" placeholder="0" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:outline-none focus:ring-2 focus:ring-gray-900 transition duration-200">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Product Image</label>
                    
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl relative overflow-hidden bg-gray-50 hover:bg-gray-100 transition h-48 cursor-pointer" onclick="document.getElementById('image').click()">
                        
                        <div class="space-y-1 text-center flex flex-col items-center justify-center" id="upload-ui">
                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <span class="relative bg-transparent rounded-md font-medium text-gray-900 hover:text-blue-600 focus-within:outline-none">
                                    Upload a file
                                </span>
                            </div>
                            <p class="text-xs text-gray-500" id="file-info">PNG, JPG, JPEG up to 2MB</p>
                        </div>

                        <input id="image" name="image" type="file" class="sr-only" accept="image/png, image/jpeg, image/jpg" onchange="previewImage(event)">

                        <div id="image-preview-container" class="hidden absolute inset-0 w-full h-full bg-white flex flex-col items-center justify-center">
                            <img id="image-preview" src="" alt="Preview" class="h-full w-full object-contain p-2">
                            
                            <div class="absolute bottom-3 bg-gray-900/70 text-white text-xs px-4 py-1.5 rounded-full backdrop-blur-sm shadow-sm flex items-center gap-2 hover:bg-gray-900 transition">
                                <span id="preview-file-name">filename.jpg</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="mt-10 pt-6 border-t border-gray-100 flex items-center justify-end gap-4">
                <a href="{{ route('admin.products.index') }}" class="text-sm font-medium text-gray-500 hover:text-gray-900 transition">
                    Cancel
                </a>
                <button type="submit" class="bg-gray-900 hover:bg-black text-white px-8 py-2.5 rounded-lg text-sm font-medium transition shadow-sm">
                    Save Product
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const input = event.target;
        const uploadUI = document.getElementById('upload-ui');
        const previewContainer = document.getElementById('image-preview-container');
        const previewImage = document.getElementById('image-preview');
        const previewFileName = document.getElementById('preview-file-name');

        // Pastikan ada file yang dipilih
        if (input.files && input.files[0]) {
            const file = input.files[0];
            
            // Buat URL sementara untuk file gambar yang dipilih di lokal
            previewImage.src = URL.createObjectURL(file);
            
            // Tampilkan nama file di pill hitam bawah gambar
            previewFileName.textContent = file.name;
            
            // Sembunyikan ikon upload, tampilkan gambar preview
            uploadUI.classList.add('hidden');
            previewContainer.classList.remove('hidden');
        }
    }
</script>
@endsection

