<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /*以下のカラムを操作可能に設定*/
    protected $fillable = [
        'name',
        'price',
        'image',
        'description'
    ];

    /*リレーションを繋げる（多対多）（一つの商品は1以上の季節に属する）*/
    public function seasons(){

        return $this->belongsToMany(Season::class,'product_season', 'product_id', 'season_id'); //複数選択したseasonを中間テーブルに保存
    }

    /* 商品名検索スコープ（部分一致）*/
    public function scopeNameSearch($query, $name)
    {
        if (!empty($name)) {
            $query->where('name','like', '%'.$name.'%');
        }
    }

    /*並び替えローカルスコープ（価格順）*/
    public function scopeSortByPrice($query, $order)
    {
        if ($order === 'asc' || $order === 'desc') {
            $query->orderBy('price', $order);
    }
}
}
