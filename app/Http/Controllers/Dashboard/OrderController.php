<?php

namespace App\Http\Controllers\Dashboard;

use App\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index(Request $request){
        $orders=Order::whereHas('client',function($q)use ($request){
            return $q->where('name','like','%'.$request->search.'%');
        })->latest()->paginate(9);
        return view('dashboard.clients.orders.index',compact('orders'));
    }//end of index function

    public function products(Order $order){
        $products = $order->products;
        return view('dashboard.clients.orders._ordersProducts', compact('order', 'products'));
    }//end of products

    public function create(){

    }//end of create function

    public function store(Request $request){

    }//end of store function

    public function show(){

    }//end of show function



    public function edit(Order $order){

    }//end of edit function

    public function update(Request $request, Order $order){

    }//end of update function

    public function destroy(Order $order){
    foreach ($order->products as $product){
        $product->update([
            'stock'=>$product->stock +$product->pivot->quantity
        ]);
    }//end of foreach
        $order->products()->detach();
        $order->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.orders.index');
    }//end of destroy function

}
