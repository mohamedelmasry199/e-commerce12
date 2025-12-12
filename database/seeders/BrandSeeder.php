<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run()
    {
        $brands = [
            'Apple', 'Samsung', 'Sony', 'Huawei', 'Xiaomi',
            'LG', 'Dell', 'HP', 'Lenovo', 'Nokia'
        ];

        foreach ($brands as $brand) {

            Brand::create([
                'name' => [
                    'en' => $brand,
                    'ar' => $this->getArabicName($brand),
                ],
                'slug' => Str::slug($brand),
                'status' => rand(0, 1),
                'logo' => 'uploads/brands/' . Str::slug($brand) . '.png',
            ]);
        }
    }

    private function getArabicName($name)
    {
        return match ($name) {
            'Apple' => 'أبل',
            'Samsung' => 'سامسونج',
            'Sony' => 'سوني',
            'Huawei' => 'هواوي',
            'Xiaomi' => 'شاومي',
            'LG' => 'إل جي',
            'Dell' => 'ديل',
            'HP' => 'إتش بي',
            'Lenovo' => 'لينوفو',
            'Nokia' => 'نوكيا',
            default => $name,
        };
    }
}
