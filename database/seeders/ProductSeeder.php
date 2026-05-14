<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

use App\Models\{
    Category, Brand, Product, ProductVariant,
    ProductImage, Tag, Attribute, AttributeValue,
    VariantAttribute
};

class ProductSeeder extends Seeder
{
    private array $cache = [];

    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        DB::table('variant_attributes')->truncate();
        DB::table('product_variants')->truncate();
        DB::table('product_images')->truncate();
        DB::table('product_tags')->truncate();
        DB::table('products')->truncate();
        DB::table('attribute_values')->truncate();
        DB::table('attributes')->truncate();
        DB::table('tags')->truncate();
        DB::table('categories')->truncate();
        DB::table('brands')->truncate();

        Schema::enableForeignKeyConstraints();

        // -------------------------------------------------
        // ROBUST IMAGE GENERATOR (PICSUM → PLACEHOLD → SVG)
        // -------------------------------------------------
        $generateImage = function ($text, $folder, $key, $size = 600) {

            if (isset($this->cache[$key])) {
                return $this->cache[$key];
            }

            $fileName = Str::random(20) . '.jpg';
            $path = $folder . '/' . $fileName;

            // -------------------------
            // 1. PICSUM (BEST REAL IMAGES)
            // -------------------------
            $picsumUrl = "https://picsum.photos/seed/" . urlencode($key) . "/{$size}/{$size}";

            try {
                $response = Http::timeout(10)->get($picsumUrl);

                if ($response->successful()) {
                    Storage::disk('public')->put($path, $response->body());
                    return $this->cache[$key] = $fileName;
                }
            } catch (\Throwable $e) {}

            // -------------------------
            // 2. PLACEHOLD.CO (TEXT IMAGES)
            // -------------------------
            $placeholdUrl = "https://placehold.co/{$size}x{$size}?text=" . urlencode($text);

            try {
                $response = Http::timeout(10)->get($placeholdUrl);

                if ($response->successful()) {
                    Storage::disk('public')->put($path, $response->body());
                    return $this->cache[$key] = $fileName;
                }
            } catch (\Throwable $e) {}

            // -------------------------
            // 3. FINAL FALLBACK (SVG - ALWAYS WORKS)
            // -------------------------
            $svg = '
            <svg width="600" height="600" xmlns="http://www.w3.org/2000/svg">
                <rect width="100%" height="100%" fill="#e5e5e5"/>
                <text x="50%" y="50%" font-size="24" text-anchor="middle" fill="#333">
                    ' . htmlspecialchars($text) . '
                </text>
            </svg>';

            Storage::disk('public')->put($path, $svg);

            return $this->cache[$key] = $fileName;
        };

        // -------------------------
        // CATEGORIES
        // -------------------------
        $categoriesData = [
            ['Fashion', 'أزياء', 'fashion'],
            ['Electronics', 'إلكترونيات', 'electronics'],
            ['Sports', 'رياضة', 'sports'],
            ['Accessories', 'إكسسوارات', 'accessories'],
        ];

        $categories = collect();

        foreach ($categoriesData as [$en, $ar, $key]) {
            $icon = $generateImage($key . ' category', 'uploads/categories', "cat_$key");

            $categories->push(
                Category::create([
                    'name' => ['en' => $en, 'ar' => $ar],
                    'icon' => $icon,
                ])
            );
        }

        // -------------------------
        // BRANDS
        // -------------------------
        $brandsData = [
            ['Nike', 'نايكي', 'nike'],
            ['Apple', 'أبل', 'apple'],
            ['Samsung', 'سامسونج', 'samsung'],
            ['Adidas', 'أديداس', 'adidas'],
        ];

        $brands = collect();

        foreach ($brandsData as [$en, $ar, $key]) {
            $logo = $generateImage($key . ' logo', 'uploads/brands', "brand_$key");

            $brands->push(
                Brand::create([
                    'name' => ['en' => $en, 'ar' => $ar],
                    'logo' => $logo,
                ])
            );
        }

        // -------------------------
        // TAGS
        // -------------------------
        $tags = collect([
            Tag::create(['slug' => 'new']),
            Tag::create(['slug' => 'hot']),
            Tag::create(['slug' => 'sale']),
        ]);

        // -------------------------
        // ATTRIBUTES
        // -------------------------
        $size = Attribute::create(['name' => ['en' => 'Size', 'ar' => 'الحجم']]);
        $color = Attribute::create(['name' => ['en' => 'Color', 'ar' => 'اللون']]);

        $sizes = collect([
            AttributeValue::create(['attribute_id' => $size->id, 'value' => ['en' => 'S']]),
            AttributeValue::create(['attribute_id' => $size->id, 'value' => ['en' => 'M']]),
            AttributeValue::create(['attribute_id' => $size->id, 'value' => ['en' => 'L']]),
        ]);

        $colors = collect([
            AttributeValue::create(['attribute_id' => $color->id, 'value' => ['en' => 'Red']]),
            AttributeValue::create(['attribute_id' => $color->id, 'value' => ['en' => 'Blue']]),
            AttributeValue::create(['attribute_id' => $color->id, 'value' => ['en' => 'Black']]),
        ]);

        // -------------------------
        // PRODUCTS
        // -------------------------
        $names = ['T-Shirt','Hoodie','Sneakers','Watch','Headphones','Backpack','Laptop','Smartphone','Jacket','Cap'];

        $descs = [
            'High quality product with modern design',
            'Premium build and elegant finish',
            'Best seller with excellent performance',
            'Comfortable and durable material',
        ];

        $stock = fn() => rand(0, 50);

        $discount = fn($price) =>
            rand(0, 1)
                ? [1, rand(5, (int)($price * 0.4)), now(), now()->addDays(rand(2, 10))]
                : [0, 0, null, null];

        for ($i = 1; $i <= 100; $i++) {

            $name = $names[array_rand($names)] . " " . rand(100, 999);
            $price = rand(20, 500);

            $product = Product::create([
                'name' => ['en' => $name, 'ar' => $name],
                'small_desc' => ['en' => $descs[array_rand($descs)], 'ar' => $descs[array_rand($descs)]],
                'desc' => ['en' => "Full description for $name", 'ar' => 'وصف كامل للمنتج'],
                'status' => 1,
                'available_for' => now()->addDays(rand(0, 30)),
                'views' => rand(0, 1000),
                'has_variants' => 1,
                'category_id' => $categories->random()->id,
                'brand_id' => $brands->random()->id,
            ]);

            $product->tags()->attach($tags->random(rand(1, 2))->pluck('id'));

            $image = $generateImage($name, 'uploads/products', "product_$i");

            ProductImage::create([
                'file_name' => $image,
                'file_size' => rand(1000, 5000),
                'file_type' => 'jpg',
                'is_main' => 1,
                'product_id' => $product->id,
            ]);

            for ($v = 0; $v < rand(2, 4); $v++) {

                [$hasDiscount, $disc, $start, $end] = $discount($price);

                $variant = ProductVariant::create([
                    'product_id' => $product->id,
                    'price' => $price + rand(-10, 50),
                    'manage_stock' => 1,
                    'stock' => $stock(),
                    'sku' => strtoupper(substr($name, 0, 3)) . "-V{$i}{$v}",
                    'has_discount' => $hasDiscount,
                    'discount' => $disc,
                    'start_discount' => $start,
                    'end_discount' => $end,
                ]);

                VariantAttribute::create([
                    'product_variant_id' => $variant->id,
                    'attribute_value_id' => $sizes->random()->id,
                ]);

                VariantAttribute::create([
                    'product_variant_id' => $variant->id,
                    'attribute_value_id' => $colors->random()->id,
                ]);
            }
        }
    }
}
