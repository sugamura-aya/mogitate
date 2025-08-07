<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Season extends Model
{
    use HasFactory;

    /*以下のカラムを操作可能に設定*/
    protected $fillable = [
        'name',
    ];

    /*リレーションを繋げる（多対多）（一つの季節に属する商品は複数）*/
    public function products(){

        return $this->belongsToMany(Product::class, 'product_season', 'season_id', 'product_id'); //この季節に属する複数の商品を取得（多対多）
    }
}
