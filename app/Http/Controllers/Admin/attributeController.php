<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;

class attributeController extends Controller
{
    use ApiResponse;

    // Attribute Name
    public function index_attribute_name()
   {
       $data = Attribute::get();
       return view('admin/Attribute/attribute', get_defined_vars());
   }

  

   public function store_attribute_name(Request $request)
{
    $validation = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255',
        'id' => 'nullable|integer', 
    ]);

    if ($validation->fails()) {
        return response()->json(['status' => 'error', 'message' => $validation->errors()->first()]);
    }

    Attribute::updateOrCreate(
        ['id' => $request->id ?? null],
        ['name' => $request->name, 'slug' => $request->slug]
    );

    return response()->json(['status' => 'success', 'message' => 'Successfully updated', 'reload' => true]);
}
 


//    Attribute Value
   public function index_attribute_value()
   {
       $data = AttributeValue::with('singleAttribute')->get();
    //    echo"<pre>";print_r($data);die();
       $attribute = Attribute::get();
       return view('admin/Attribute/attribute_value', get_defined_vars());
   }

   
  public function store_attribute_value(Request $request)
{
    $validation = Validator::make($request->all(), [
        'attributes_id' => 'required|exists:attributes,id',
        'value'         => 'required|string|max:255',
        'id'            => 'nullable|integer',
    ]);

    if ($validation->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => $validation->errors()->first()
        ]);
    }

    // Save or update record
    AttributeValue::updateOrCreate(
        ['id' => $request->id ?? null], 
        ['attributes_id' => $request->attributes_id, 'value' => $request->value]
    );

    return response()->json([
        'status' => 'success',
        'message' => 'Attribute value successfully updated!', // Success message add kiya
        'reload' => true
    ]);
}


}