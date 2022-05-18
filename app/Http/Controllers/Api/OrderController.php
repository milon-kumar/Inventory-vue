<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Pos;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(Order::with('customer')->get());
    }
    public function store(Request $request)
    {
        $subTotal = Pos::sum('sub_total');
        $quantity = Pos::sum('quantity');
        $vat = 5;
        $vatTotal = ($subTotal*$vat)/100;
        $grandTotal = $subTotal+$vatTotal;

        $month = date('F');
        $year = date('Y');
        $date = date('d/m/Y');


        $data['customer_id'] = $request->customer;
        $data['quantity'] = $quantity;
        $data['sub_total'] = $subTotal;
        $data['grand_total'] = $grandTotal;
        $data['vat'] = $vat;
        $data['pay_bill'] = $request->payBill;
        $data['pay_due'] = $request->totalDue;
        $data['payby'] = $request->payby;
        $data['order_date'] = $date;
        $data['order_month'] = $month;
        $data['order_year'] = $year;


        $order = Order::create($data);

        $posProducts = Pos::all();

        foreach ($posProducts as $product){

            $qtyProduct = Product::findORFail($product->product_id);
            $qtyProduct->update([
                'stock' => $qtyProduct->stock - $product->quantity
            ]);

            $oProduct['order_id'] = $order->id;
            $oProduct['product_id'] = $product->product_id;
            $oProduct['product_title'] = $product->title;
            $oProduct['product_quantity'] = $product->quantity;
            $oProduct['product_price'] = $product->price;
            $oProduct['sub_total'] = $product->sub_total;
            $oProduct['product_image'] = $product->photo;

            OrderDetails::create($oProduct);
        }

        DB::table('pos')->delete();
        return response()->json(['message' =>'Order save successfully done.'], 200);
    }
    public function show(Order $order)
    {
        return response()->json(Order::find('id',$order->id)->with('orderdetails')->first());
    }

    public function orderDetails($id){
        return Order::with('orderdetails')->findOrFail($id);
    }

    public function update(Request $request, Order $order)
    {
        //
    }
    public function destroy(Order $order)
    {
        //
    }
}
