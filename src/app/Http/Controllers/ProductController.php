<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Season;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    // ➀　商品一覧画面（一覧表示・検索・並び替え）
    public function index(Request $request)
    {
        $query = Product::query();  //Productモデルのデータベース検索のためのスタート地点

        $order = $request->input('sort');

        // 検索条件ごとにローカルスコープ適用
        $query->nameSearch($request->name)
              ->sortByPrice($order);

        $products = $query->paginate(6)->withQueryString(); // ページネーション：7件ずつ＋ページ移動時も検索条件を保持
        $seasons = Season::all();   //季節選択

        return view('product.index', compact('products', 'seasons','order'));
    }


    
    // ➁－１　商品詳細・変更画面（商品詳細ページ表示）
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $seasons = Season::all(); 

        return view('product.edit', compact('product', 'seasons'));
    }

    // ➁－２　商品詳細・変更画面（商品の更新）
    public function update(ProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);

        // アップロード画像の処理（任意：元画像削除もできる）(保存先：storage/app/public/images)
        $path = $request->file('image')->store('images', 'public');
        $product->image = $path; // 上書き
        
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;

        // 中間テーブル（多対多）更新
        $product->seasons()->sync($request->seasons);

        $product->save(); 

        return redirect()->route('product.index')->with('success', '商品を更新しました');
    }

    //➁－３ 商品詳細・変更画面（商品の削除）
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('product.index')->with('success', '商品を削除しました');
    }



    //➂－１ 商品登録画面（商品登録画面表示）
    public function register()
    {
        $seasons = Season::all();

        return view('product.register',compact('seasons'));
    }

    //➂－２　商品登録画面（登録処理）
    public function store(ProductRequest $request)
    {
        // 画像アップロード処理
        $imagePath = $request->file('image')->store('images', 'public'); // storage/app/public/images に保存
    
        // products テーブルに商品を保存
        $product = new Product();
        $product->name = $request->name;
        $product->price = $request->price;
        $product->description = $request->description;
        $product->image = $imagePath;
        $product->save();

        // 季節（多対多）の保存（中間テーブルへ）
        $product->seasons()->attach($request->seasons); // attachで中間テーブルに保存

        return redirect()->route('product.index')->with('success', '商品を登録しました');
    }


}
