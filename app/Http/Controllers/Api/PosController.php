<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pos;
use App\Models\Product;
use Illuminate\Http\Request;

class PosController extends Controller
{
    public function index()
    {
        return response()->json(Pos::all());
    }
    public function store(Request $request)
    {
        $product = Product::findOrFail($request->id);

        if ($product->stock !=  0){
            $checkProduct = Pos::where('product_id', $request->id)->first();
            if ($checkProduct){
                if ($product->stock <= $checkProduct->quantity ){
                    return response()->json(['message' =>'Minimum qty is lesthen or equal '.$product->stock ], 500);
                }else{
                    $checkProduct->increment('quantity');
                    $subTotal = $checkProduct->quantity * $checkProduct->price;
                    $checkProduct->update([
                        'sub_total' => $subTotal
                    ]);
                    return response()->json(['message' =>'Update To Cart'], 200);
                }

            }else{
                Pos::create([
                    'product_id' => $request->id,
                    'title' => $product->title,
                    'quantity' => 1,
                    'price' => $product->selling_price,
                    'sub_total' => $product->selling_price,
                    'photo' => $product->photo
                ]);
            }

        }else{
            return response()->json(['message' =>'Product Minimum quantity is not available'], 500);
        }

        return response()->json(['message' =>'Product Add To Cart'], 200);
    }
    public function incrementProductQty($id){

        $cartInfo = Pos::findOrFail($id);
        $proId =  $cartInfo->product_id;
        $product = Product::findOrFail($proId);

        if ($product->stock != 0){
            if ($product->stock <= $cartInfo->quantity){
                return response()->json(['message' =>'Minimum qty is lesthen or equal '.$product->stock], 500);
            }else{
                $cartInfo->increment('quantity');
                $subTotal = $cartInfo->quantity * $cartInfo->price;
                $cartInfo->update([
                    'sub_total' => $subTotal
                ]);
                return response()->json(['message' =>'Update To Cart'], 200);
            }
        }else{
            return response()->json(['message' =>'Product Minimum quantity is not available'], 500);
        }


    }
    public function decrementProductQty($id){
        $cartProduct = Pos::findOrFail($id);
        if ($cartProduct->quantity <= 1){
            return response()->json(['message' =>'Minimum Qty is 1'], 500);
        }else{
            $cartProduct->decrement('quantity');
            $subTotal = $cartProduct->quantity * $cartProduct->price;
            $cartProduct->update([
                'sub_total' => $subTotal
            ]);
            return response()->json(['message' =>'Update To Cart'], 200);
        }
    }
    public function show(Pos $pos)
    {
        //
    }
    public function update(Request $request, Pos $pos)
    {
        //
    }
    public function destroy(Pos $pos)
    {
        return $pos;
//        $pos->delete();
//        return response()->json(['message' =>'Product Delete Form Cart'], 200);
    }

    public function deleteItem($id){
        $posItem = Pos::findOrFail($id);
        $posItem->delete();
        return response()->json(['message' =>'Product Delete Form Cart'], 200);
    }
}
