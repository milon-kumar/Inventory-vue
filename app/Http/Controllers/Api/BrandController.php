<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        return response()->json(Brand::all());
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|max:30|min:1|unique:brands',
            'photo' => 'required',
        ]);
        $photo = $request->image;
        $imageName = time().random_int(1,9999).'.'.$photo->getClientOriginalExtension();

        $photo->storeAs('public/brands/', $imageName);
        $uploadPath = "storage/brands/$imageName";

        $data = $request->all();
        $data['slug'] = Str::slug($request->title);
        $data['photo'] = $uploadPath;
        Brand::create($data);
        return response()->json(['message' => 'Brand save successfully done.'], 200);
    }
    public function show(Brand $brand)
    {
        return response()->json($brand);
    }
    public function update(Request $request, Brand $brand)
    {
        //
    }
    public function destroy(Brand $brand)
    {
        //
    }
}
