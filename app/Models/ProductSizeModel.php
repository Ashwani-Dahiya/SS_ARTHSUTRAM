<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSizeModel extends Model
{
    use HasFactory;
    protected $table = 'product_size';
    protected $fillable = [
        'product_id',
        'value',
    ];

    public function product()
    {
        return $this->belongsTo(ProductModel::class,'id','product_id');
    }
}
