<?php

namespace App\Repositories\Dashboard;

use App\Models\Attribute;
use Illuminate\Support\Facades\DB;

class AttributeRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //

    }
    public function getAllAttributes()
    {
        $attributes = Attribute::with('attributeValues')->get();
        return $attributes;
    }
    public function createAttribute($data)
    {
        $attribute = Attribute::create([
            'name' => $data['name']
        ]);
        return $attribute;
    }
     public function createAttributeValue($data ,$attribute)
    {
        if(isset($data['value']) && is_array($data['value'])&& count($data['value']) > 0){
        return $attribute->attributeValues()->createMany(collect($data['value'])->map(function($value){
        return ['value' => $value];
       }))->toArray();

        }
        return null;
    }

    public function update($attribute, $data)
{
     try {
    DB::beginTransaction();

        $attribute->update([
            'name' => $data['name']
        ]);
        if (!empty($data['value']) && is_array($data['value'])&&array_key_exists('value', $data)) {
            $attribute->attributeValues()->delete();
            $this->createAttributeValue($data, $attribute);
        }
        DB::commit();
        return $attribute;

    } catch (\Exception $e) {
        DB::rollBack();
return false;
    }
}
public function delete($attribute): bool|null
{
    if (!$attribute) {
        abort(404);
    }
    return $attribute->delete();
}
}
