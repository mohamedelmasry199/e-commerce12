<?php

namespace App\Services\Dashboard;

use App\Models\Attribute;
use App\Repositories\Dashboard\AttributeRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AttributeService
{
    /**
     * Create a new class instance.
     */
    protected $attributeRepository;
    public function __construct(AttributeRepository $attributeRepository)
    {
        $this->attributeRepository = $attributeRepository;
    }
    public function getAllAttributes()
    {
        $attributes = $this->attributeRepository->getAllAttributes();
        return datatables($attributes)
        ->addIndexColumn()
        ->addColumn('name' , function(Attribute $attribute){
            return $attribute->getTranslation('name',app()->getLocale());
        })
        ->addColumn('attributeValues', function($item){
            return view('dashboard.attributes.datatables.attribute-values',compact('item'));
        })
        ->addColumn('action',function($item){
            return view('dashboard.attributes.datatables.actions',compact('item'));
        })
        ->addColumn('created_at', function(Attribute $attribute){
            return $attribute->created_at;
        })
        ->make(true);
    }
    public function getAttributeById($id)
    {
        return Attribute::with('attributeValues')->find($id);
    }
    public function store($data)
    {
        DB::beginTransaction();
        try{
            $attribute = $this->attributeRepository->createAttribute($data);
            $this->attributeRepository->createAttributeValue($data, $attribute);
                    DB::commit();
            return $attribute;
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating attribute: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
return false;
        }
    }
    public function update($id, $data)
    {
        $attribute = $this->getAttributeById($id);
        if (!$attribute) {
            return false;
        }
        return $this->attributeRepository->update($attribute, $data);

    }
    public function delete($id)
    {
        $attribute = $this->getAttributeById($id);
        if (!$attribute) {
            return false;
        }
        try {
            $attribute->delete();
            return true;
        } catch (\Exception $e) {
            Log::error('Error deleting attribute: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return false;
        }
    }
}
