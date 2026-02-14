<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Attribute::truncate();
        AttributeValue::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $attributes = [
            [
                'name' => ['en' => 'Color', 'ar' => 'اللون'],
                'values' => [
                    ['en' => 'Red', 'ar' => 'أحمر'],
                    ['en' => 'Blue', 'ar' => 'أزرق'],
                    ['en' => 'Green', 'ar' => 'أخضر'],
                ],
            ],
            [
                'name' => ['en' => 'Size', 'ar' => 'المقاس'],
                'values' => [
                    ['en' => 'Small', 'ar' => 'صغير'],
                    ['en' => 'Medium', 'ar' => 'متوسط'],
                    ['en' => 'Large', 'ar' => 'كبير'],
                ],
            ],
        ];
        foreach ($attributes as $attributeData) {
            $attribute = Attribute::create([
                'name' => $attributeData['name'],
            ]);

            foreach ($attributeData['values'] as $valueData) {
                AttributeValue::create([
                    'attribute_id' => $attribute->id,
                    'value' => $valueData,
                ]);
            }
        }
    }
}
