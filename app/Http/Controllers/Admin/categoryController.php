<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;
use App\Traits\SaveFile;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\CategoryAttribute;

class categoryController extends Controller
{
    use ApiResponse;
    // use SaveFile;

    public function index()
    {
        $data = Category::get();
        return view('admin/Category/category', get_defined_vars());
    }



    public function store(Request $request)
    {

        $validation = Validator::make($request->all(), [
            'name'    => 'required|string|max:255',
            'slug'    => 'required|string|max:255',
            'image'   => 'mimes:jpeg,png,webp,jpg,gif|max:5120', //max 5 MB
            'id'    => 'required',
        ]);

        if ($validation->fails()) {
            return $this->error($validation->errors()->first(), 400, []);
            // return response()->json(['status'=>400,'message'=>$validation->errors()->first()]);
        } else {

            // Category::updateOrCreate(
            //     ['id' => $request->id],
            //     ['name' => $request->name, 'slug' => $request->slug]
            // );
            return $this->success(['reload' => true], 'Successfully update');
        }
    }

    public function index_category_attribute() {}

    public function store_category_attribute(Request $request) {}
}
