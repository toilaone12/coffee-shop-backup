<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_product';
    protected $table = 'product';
    protected $fillable = [
        'id_category',
        'image_product',
        'name_product',
        'subname_product',
        'slug_product',
        'price_product',
        'description_product',
        'number_reviews_product',
        'is_special'
    ];
    public $timestamps = true;
}
