@extends('admin.layouts.app')

@section('title', 'Create Banner')

@section('content')
    <div class="page-header">
        <h1>Add New Banner</h1>
        <p>Create a new homepage banner.</p>
    </div>

    <form method="POST" action="{{ route('admin.banners.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-section">
                    <h4 class="form-section-title">Banner Content</h4>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}">
                        @error('title')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="subtitle">Subtitle</label>
                        <input type="text" id="subtitle" name="subtitle" class="form-control @error('subtitle') is-invalid @enderror" value="{{ old('subtitle') }}">
                        @error('subtitle')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="upload-area" onclick="document.getElementById('imageInput').click()">
                        <div class="upload-icon">&#128444;</div>
                        <p>Click to upload banner image</p>
                        <input type="file" id="imageInput" name="image" accept="image/*" class="form-control" onchange="previewImage(this)">
                    </div>
                    <div class="upload-preview">
                        <img id="imagePreview" style="display:none;">
                    </div>
                    @error('image')<div class="form-error">{{ $message }}</div>@enderror
                </div>

                <div class="form-section">
                    <h4 class="form-section-title">Button & Action</h4>
                    <div class="form-group">
                        <label for="button_text">Button Text</label>
                        <input type="text" id="button_text" name="button_text" class="form-control @error('button_text') is-invalid @enderror" value="{{ old('button_text') }}">
                        @error('button_text')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label>Action Type</label>
                        <div style="display:flex; flex-wrap:wrap; gap:1.5rem; margin-top:0.375rem;">
                            <label class="form-check">
                                <input type="radio" name="action_type" value="none" {{ old('action_type', 'none') == 'none' ? 'checked' : '' }} onchange="toggleActionFields()">
                                <span>None</span>
                            </label>
                            <label class="form-check">
                                <input type="radio" name="action_type" value="product" {{ old('action_type') == 'product' ? 'checked' : '' }} onchange="toggleActionFields()">
                                <span>Open Specific Product</span>
                            </label>
                            <label class="form-check">
                                <input type="radio" name="action_type" value="product_page" {{ old('action_type') == 'product_page' ? 'checked' : '' }} onchange="toggleActionFields()">
                                <span>Product Details Page</span>
                            </label>
                            <label class="form-check">
                                <input type="radio" name="action_type" value="external_url" {{ old('action_type') == 'external_url' ? 'checked' : '' }} onchange="toggleActionFields()">
                                <span>External URL</span>
                            </label>
                        </div>
                        @error('action_type')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group" id="productSelect" style="display:none;">
                        <label for="action_product_id">Select Product</label>
                        <select id="action_product_id" name="action_product_id" class="form-control">
                            <option value="">Select Product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('action_product_id') == $product->id ? 'selected' : '' }}>{{ $product->title }}</option>
                            @endforeach
                        </select>
                        @error('action_product_id')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group" id="externalUrlField" style="display:none;">
                        <label for="action_url">External URL</label>
                        <input type="url" id="action_url" name="action_url" class="form-control @error('action_url') is-invalid @enderror" value="{{ old('action_url') }}" placeholder="https://example.com">
                        @error('action_url')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="form-section-title">Options</h4>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="sort_order">Sort Order</label>
                            <input type="number" id="sort_order" name="sort_order" min="0" class="form-control" value="{{ old('sort_order', 0) }}">
                        </div>
                    </div>
                    <div class="form-check">
                        <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active') ? 'checked' : 'checked' }}>
                        <label for="is_active">Active</label>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <a href="{{ route('admin.banners.index') }}" class="btn btn-outline">Cancel</a>
                <button type="submit" class="btn btn-primary">Create Banner</button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    function previewImage(input) {
        const preview = document.getElementById('imagePreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function toggleActionFields() {
        const checked = document.querySelector('input[name="action_type"]:checked');
        if (!checked) return;
        const value = checked.value;
        document.getElementById('productSelect').style.display = value === 'product' ? 'block' : 'none';
        document.getElementById('externalUrlField').style.display = value === 'external_url' ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', toggleActionFields);
</script>
@endpush
