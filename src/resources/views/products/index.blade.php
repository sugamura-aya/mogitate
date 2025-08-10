@extends('layouts.app')

@section('content')

<div class="list-header">
    <h1 class="list-title">商品一覧</h1>
    <form action="/products/register" class="register-btn" method="get">
        <button class="register-btn__submit" type="submit">＋商品追加</button>
    </form>
</div>

<div class="list">
    <form action="/products" class="search" method="get">
        <div class="search-name">
            <input type="text" class="search-name__text" name="name" value="{{request('name')}}">
            
            <div class="search-button">
                <button class="search-button__submit" type="submit">検索</button>
            </div>
        </div>

        <div class="search-price">
            <p class="search-price__title">価格順で表示</p>
            <select name="sort" id="" class="search-price__select">
                <option value="high" {{ request('sort') === 'high' ? 'selected' : '' }}>高い順に表示</option>
                <option value="low" {{ request('sort') === 'low' ? 'selected' : '' }}>低い順に表示</option>
            </select>

            {{-- 並び替えタグ表(タグ表示右横の側の「✖」ボタンをクリックすると並び替えをリセット)--}}
            @if ($order === 'high')
            <div class="sort-tag">
                高い順に表示
                <a href="{{ route('products.index', request()->except('sort')) }}" class="sort-tag__remove">✖</a>
            </div>
            @elseif ($order === 'low')
            <div class="sort-tag">
                低い順に表示
                <a href="{{ route('products.index', request()->except('sort')) }}" class="sort-tag__remove">✖</a>
            </div>
            @endif
        </div>
    </form>

    <div class="products">
        <ul class="product-list">
            @foreach ($products as $product)
                <li class="product-list__item">
                    <a href="{{ route('products.edit', $product->id) }}">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    </a>
                    <div class="product-info">
                        <p class="row-name">{{ $product->name }}</p>
                        <p class="row-price">&yen;{{ $product->price }}</p>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>

{{-- ページネーションリンクの表示 --}}
<div class="pagination-wrapper">
    {{ $products->links() }}
</div>

@endsection