<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    //     public function up(): void
    // {
    //     Schema::create('order_items', function (Blueprint $table) {
    //         $table->id();

    //         $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
    //         $table->foreignId('product_id')->nullable()->constrained('products')->nullOnDelete();
    //         // do not forget to null on delete
    //         $table->foreignId('product_variant_id')->nullable()->constrained()->onDelete('cascade');

    //         $table->string('product_name');
    //         $table->longText('product_desc');
    //         $table->integer('product_quantity');
    //         $table->decimal('product_price');
    //         $table->json('attributes')->nullable();
    //         $table->timestamps();
    //     });
    // }
    protected $fillable = [
        'order_id',
        'product_id',
        'product_variant_id',
        'product_name',
        'product_desc',
        'product_quantity',
        'product_price',
        'attributes',
    ];
    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function product(){
        return $this->belongsTo(Product::class);
    }
    public function variant(){
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
    public function getAttributesArrayAttribute($attributes){
        return $attributes ? json_decode($attributes, true) : [];
    }
}
