<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AttributeRequest;
use App\Models\Attribute;
use App\Services\Dashboard\AttributeService;
use Illuminate\Support\Facades\Session;

class AttributeController extends Controller
{
    protected $attributeService;
    public function __construct(AttributeService $attributeService)
    {
        $this->attributeService = $attributeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.attributes.index');
    }
    public function getAll()
    {
        return $this->attributeService->getAllAttributes();
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AttributeRequest $request)
    {
    $attribute = $this->attributeService->store($request->all());
        if (!$attribute) {
            return response()->json([
                'status' => 'error',
                'message' => __('dashboard.error_msg'),
            ],500);
        }
        return response()->json([
            'status' => 'success',
            'message' => __('dashboard.success_msg'),
        ],201);
    }
        /*
 "name" => array:2 [
     "ar" => "Kermit Frye"
     "en" => "Ulric Holman"
   ]
   "value" => array:2 [
     1 => array:2 [
       "ar" => "Facere et maxime vol"
       "en" => "Et enim voluptatibus"
     ]
     2 => array:2 [
       "ar" => "Magnam enim tempor e"
       "en" => "Voluptas sint quaera"
     ]
   ]
        Attribute::create([
            'name' => $request->name
        ])
        ->attributeValues()->createMany(
            collect($request->value)->map(function($value){
                return ['value' => $value];
            })->toArray()
        );

        collect ->[
   ['ar' => '...', 'en' => '...'],
   ['ar' => '...', 'en' => '...'],
 ] Collections give you powerful, readable methods like:map filter reduce
  map() does ->
Loops over each element
Transforms it into a new structure
Returns a new collection
Each $value here is:
[
   'ar' => 'Facere et maxime vol',
   'en' => 'Et enim voluptatibus'
]
After map():
[
  ['value' => ['ar' => '...', 'en' => '...']],
  ['value' => ['ar' => '...', 'en' => '...']]
]
  ->toArray()->
Converts the Collection back into a plain PHP array
Required because createMany() expects an array
createMany(...)

->attributeValues()->createMany([...]);

What createMany() does->
Inserts multiple records at once
Automatically sets attribute_id
Uses one clean relationship call
 */


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttributeRequest $request, string $id)
    {
        $attribute = $this->attributeService->update($id, $request->all());
        if (!$attribute) {
            return response()->json([
                'status' => 'error',
                'message' => __('dashboard.error_msg'),
            ],500);
        }
        return response()->json([
            'status' => 'success',
            'message' => __('dashboard.success_msg'),
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deleted = $this->attributeService->delete($id);
        if (!$deleted) {
            return response()->json([
                'status' => 'error',
                'message' => __('dashboard.error_msg'),
            ],500);
        }
        return response()->json([
            'status' => 'success',
            'message' => __('dashboard.success_msg'),
        ],200);
    }
}
