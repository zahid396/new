@extends('admin.layouts.app')

@section('title', 'Store Settings')

@section('content')
    <div class="page-header">
        <h1>Store Settings</h1>
        <p>Configure your store's general information.</p>
    </div>

    <form method="POST" action="{{ route('admin.store-settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="card">
            <div class="card-body">
                <div class="form-section">
                    <h4 class="form-section-title">Store Identity</h4>
                    <div class="form-group">
                        <label for="store_name">Store Name <span class="required">*</span></label>
                        <input type="text" id="store_name" name="store_name" class="form-control @error('store_name') is-invalid @enderror" value="{{ old('store_name', $settings['store_name']) }}" required>
                        @error('store_name')<div class="form-error">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Store Logo</label>
                            @if($settings['store_logo'])
                                <div style="margin-bottom:0.75rem;">
                                    <img src="{{ asset('storage/store/' . $settings['store_logo']) }}" style="max-height:80px; border:1px solid var(--border); border-radius:var(--radius);">
                                </div>
                            @endif
                            <div class="upload-area" onclick="document.getElementById('logoInput').click()">
                                <div class="upload-icon">&#128444;</div>
                                <p>Click to upload logo</p>
                                <input type="file" id="logoInput" name="store_logo" accept="image/*" class="form-control" onchange="previewLogo(this)">
                            </div>
                            <div class="upload-preview">
                                <img id="logoPreview" style="display:none;">
                            </div>
                            @error('store_logo')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label>Favicon</label>
                            @if($settings['store_favicon'])
                                <div style="margin-bottom:0.75rem;">
                                    <img src="{{ asset('storage/store/' . $settings['store_favicon']) }}" style="width:48px; height:48px; border:1px solid var(--border); border-radius:var(--radius);">
                                </div>
                            @endif
                            <div class="upload-area" onclick="document.getElementById('faviconInput').click()">
                                <div class="upload-icon">&#128444;</div>
                                <p>Click to upload favicon</p>
                                <input type="file" id="faviconInput" name="store_favicon" accept="image/*" class="form-control" onchange="previewFavicon(this)">
                            </div>
                            <div class="upload-preview">
                                <img id="faviconPreview" style="display:none;">
                            </div>
                            @error('store_favicon')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="form-section-title">About</h4>
                    <div class="form-group">
                        <label for="about_text">About Text</label>
                        <textarea id="about_text" name="about_text" class="form-control @error('about_text') is-invalid @enderror" rows="5">{{ old('about_text', $settings['about_text']) }}</textarea>
                        @error('about_text')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="form-section-title">Contact Information</h4>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="contact_email">Contact Email</label>
                            <input type="email" id="contact_email" name="contact_email" class="form-control @error('contact_email') is-invalid @enderror" value="{{ old('contact_email', $settings['contact_email']) }}" placeholder="support@example.com">
                            @error('contact_email')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="contact_phone">Contact Phone</label>
                            <input type="text" id="contact_phone" name="contact_phone" class="form-control @error('contact_phone') is-invalid @enderror" value="{{ old('contact_phone', $settings['contact_phone']) }}" placeholder="+880 1XXX-XXXXXX">
                            @error('contact_phone')<div class="form-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h4 class="form-section-title">Footer Text</h4>
                    <div class="form-group">
                        <label for="copyright_text">Copyright Text</label>
                        <input type="text" id="copyright_text" name="copyright_text" class="form-control @error('copyright_text') is-invalid @enderror" value="{{ old('copyright_text', $settings['copyright_text']) }}" placeholder="&copy; {{ date('Y') }} Your Store. All rights reserved.">
                        @error('copyright_text')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label for="footer_text">Footer Text</label>
                        <textarea id="footer_text" name="footer_text" class="form-control @error('footer_text') is-invalid @enderror" rows="3">{{ old('footer_text', $settings['footer_text']) }}</textarea>
                        @error('footer_text')<div class="form-error">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Save Settings</button>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    function previewLogo(input) {
        const preview = document.getElementById('logoPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                preview.style.maxHeight = '80px';
                preview.style.border = '1px solid var(--border)';
                preview.style.borderRadius = 'var(--radius)';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewFavicon(input) {
        const preview = document.getElementById('faviconPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                preview.style.width = '48px';
                preview.style.height = '48px';
                preview.style.border = '1px solid var(--border)';
                preview.style.borderRadius = 'var(--radius)';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
