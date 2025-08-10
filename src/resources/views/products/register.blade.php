@extends('layouts.app')

@section('content')

<div class="register-form-wrapper">
     <h1 class="register-form__title">商品登録</h1>
    <form action="{{ url('/products/register') }}" method="post" enctype="multipart/form-data">
        @csrf

        {{-- 商品名 --}}
        <div class="form-group">
            <div class="form-label">商品名<span class="required">必須</span></div>
            <input class="fields" type="text" name="name" value="{{ old('name') }}">
            @error('name')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- 価格 --}}
        <div class="form-group">
            <div class="form-label">価格<span class="required">必須</span></div>
            <input class="fields" type="text" name="price" value="{{ old('price') }}">
            @error('price')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- 商品画像 --}}
        <div class="form-group">
            <div class="form-label">商品画像<span class="required">必須</span></div>
            <img id="preview-image" class="preview-image" style="display:none;" alt="画像プレビュー">
            <input id="image-input" class="image-input" type="file" name="image" accept="image/*">
            <span id="file-name" class="file-name"></span>
            @error('image')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- 季節 --}}
        <div class="form-group">
            <div class="form-label">季節<span class="required">必須</span></div>
            <div class="checkbox-group">
                @foreach($seasons as $season)
                    <label>
                        <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                        {{ (is_array(old('seasons')) && in_array($season->id, old('seasons'))) ? 'checked' : '' }}>
                        {{ $season->name }}
                    </label>
                @endforeach
            </div>
            @error('seasons')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- 商品説明 --}}
        <div class="form-group edit-form-description">
            <div class="form-label">商品説明<span class="required">必須</span></div>
            <textarea class="fields" name="description">{{ old('description') }}</textarea>
            @error('description')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        {{-- ボタン --}}
        <div class="register-form__button">
            <a href="{{ url('/products') }}" class="register-correction-button">戻る</a>
            <button type="submit" class="send-button-submit">登録</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('image-input').addEventListener('change', function(){
    const file = this.files[0];
    const previewImage = document.getElementById('preview-image');
    const fileNameSpan = document.getElementById('file-name');
    
    if(file){
        fileNameSpan.textContent = file.name;
        const reader = new FileReader();
        reader.onload = function(e){
            previewImage.src = e.target.result;
            previewImage.style.display = 'block';
        }
        reader.readAsDataURL(file);
    } else {
        fileNameSpan.textContent = '';
        previewImage.src = '';
        previewImage.style.display = 'none';
    }
});
</script>
@endpush
