@extends('layouts.app')

@section('content')

<nav class="breadcrumb">
  商品一覧 &gt; {{ $product->name }}
</nav>

<div class="edit-form-wrapper">
    {{-- 更新フォーム --}}
    <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="edit-form-container">

            {{-- 左側：画像 --}}
            <div class="edit-form-left">
                <label>画像</label>
                <img id="preview-image" class="preview-image" src="{{ asset('storage/' . $product->image) }}" alt="画像プレビュー">
                <input id="image-input" class="image-input" type="file" name="image" accept="image/*">
                <span id="file-name" class="file-name"></span>
                @error('image')
                <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            {{-- 右側：商品名、価格、季節 --}}
            <div class="edit-form-right">
                <div class="form-group">
                    <label for="name">商品名</label>
                    <input id="name" class="fields" type="text" name="name" value="{{ old('name', $product->name) }}">
                    @error('name')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="price">値段</label>
                    <input id="price" class="fields" type="text" name="price" value="{{ old('price', $product->price) }}">
                    @error('price')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group seasons-group">
                    <label>季節</label>
                    <div class="seasons-checkboxes">
                        @foreach($seasons as $season)
                        <label class="checkbox-label">
                            <input type="checkbox" name="seasons[]" value="{{ $season->id }}"
                            {{ in_array($season->id, old('seasons', $product->seasons->pluck('id')->toArray())) ? 'checked' : '' }}>
                            {{ $season->name }}
                        </label>
                        @endforeach
                    </div>
                    @error('seasons')
                    <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
            </div>

        </div>

        {{-- 下に商品説明 --}}
        <div class="edit-form-description">
            <label for="description">商品説明</label>
            <textarea id="description" class="fields" name="description">{{ old('description', $product->description) }}</textarea>
            @error('description')
            <div class="error-message">{{ $message }}</div>
            @enderror
        </div>

        <div class="edit-form__button">
            <a href="{{ route('products.index') }}" class="correction-button">戻る</a>
            <button type="submit" class="send-button-submit">変更を保存</button>
        </div>
    </form>

    {{-- 削除フォーム（更新フォームの外） --}}
    <form action="{{ route('products.destroy', $product->id) }}" method="post" class="delete-form" onsubmit="return confirm('本当に削除しますか？');">
        @csrf
        @method('DELETE')
        <button type="submit" class="delete-button" title="削除">
            🗑️
        </button>
    </form>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('image-input').addEventListener('change', function(){
    const file = this.files[0];
    const fileNameSpan = document.getElementById('file-name');
    const previewImage = document.getElementById('preview-image');

    if(file){
        fileNameSpan.textContent = file.name;

        const reader = new FileReader();
        reader.onload = function(e){
            previewImage.src = e.target.result;
        }
        reader.readAsDataURL(file);
    } else {
        fileNameSpan.textContent = '';
        previewImage.src = '{{ asset('storage/' . $product->image) }}';
    }
});
</script>
@endpush
