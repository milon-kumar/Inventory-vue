<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class CustomerController extends Controller
{
    public function index()
    {
        return response()->json(Customer::all());
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|max:30|min:1',
            'email' => 'required|unique:employees',
            'phone' => 'required|unique:employees',
        ]);

        if ($request->photo){
            $photo = $request->photo;
            $position = strpos($photo, ';');
            $subString = substr($photo, 0,$position);
            $imageExt = explode( '/',$subString )[1];
            $imageName = time().rand(0000,9999).'.'.$imageExt;
            $resize = Image::make($photo)->resize(200, 180)->encode('jpg');
            Storage::put("public/customers/$imageName", $resize->__toString());


            $uploadPath = "storage/customers/$imageName";

            Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'position' => $request->position,
                'address' => $request->address,
                'photo' => $uploadPath,
            ]);
            return response()->json(['message' =>'Customer save with image'], 200);
        }else{
            Customer::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'position' => $request->position,
                $userImage = ['user.svg', 'default.png'],
                'address' => $request->address,
                'photo' => 'storage/customers/'.$userImage[array_rand($userImage, 1)],
            ]);
            return response()->json(['message' =>'Customer save without image'], 200);
        }
    }
    public function show(Customer $customer)
    {
        return response()->json($customer);
    }
    public function update(Request $request, Customer $customer)
    {
        $customer->update($request->all());
        return response()->json(['message' =>'Customer update without image'], 200);
    }
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(['message' =>'Customer delete without image'], 200);
    }
}
