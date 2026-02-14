<?php

namespace App\Repositories\Dashboard;

use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\VariantAttribute;

class ProductRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }
     public function createProduct($data)
    {
        return Product::create($data);
    }
    public function createProductVariant($data)
    {
        return ProductVariant::create($data);
    }
      public function createProductVariantAttribute($data)
    {
        return VariantAttribute::create($data);
    }
}
