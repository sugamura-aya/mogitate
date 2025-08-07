<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>もぎたて</title>
  {{--リセットCSS--}}
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
  {{--common.css(共通するCSSコードをまとめたCSSファイル)を呼び出し--}}
  <link rel="stylesheet" href="{{ asset('css/common.css') }}" />
  {{--商品一覧のCSSファイル呼び出し--}}
  <link rel="stylesheet" href="{{ asset('css/product.css') }}">
  {{--webフォント--}}
</head>
  

<body>
    <header class="header">
        <div class="header__inner">mogitate</div>
    </header>

    <main>
    {{--各ページに @yield ディレクティブを記述--}}
    @yield('content')
    </main>

</body>

</html>