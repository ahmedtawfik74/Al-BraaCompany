<?php

namespace App\Http\Controllers\Dashboard\Clients;

use App\Category;
use App\Client;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function index()
    {

    }

    public function create(Client $client)
    {
        $categories=Category::with('products')->get();
        return view('dashboard.clients.orders.create',compact('categories','client'));
    }

    public function store(Request $request,Client $client)
    {
        $request->validate([
            'products'=>'required|array'
        ]);
        $this->attach_order($request,$client);
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.orders.index');
    }//end of store order to specific client
    public function show(Order $order){}
    public function edit(Client $client,Order $order)
    {
        $categories=Category::with('products')->get();
        return view('dashboard.clients.orders.edit',compact('client','order','categories'));
    }

    public function update(Request $request, Client $client,Order $order)
    {
        $request->validate([
            'products'=>'required|array'
        ]);
        $this->detach_order($order);
        $this->attach_order($request, $client);
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.orders.index');
    }

    private function attach_order($request,$client){
        $total_price=0;
        $order=$client->orders()->create([]);
        $order->products()->attach($request->products);
        foreach($request->products as $id=>$quantity){
            $product=Product::findOrFail($id);
            $total_price += $product->sale_price * $quantity['quantity'];
            $product->update([
                'stock'=>$product->stock -  $quantity['quantity']
            ]);
        }//end of foreach
        $order->update([
            'total_price'=>$total_price
        ]);
    }// end of attach_order
    private function detach_order($order){
        foreach($order->products as $product){
            $product->update([
                'stock'=>$product->stock + $product->pivot->quantity
            ]);
        }//end of for each
        $order->delete();
    }//end of detach order
}
