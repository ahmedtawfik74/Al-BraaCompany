<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $categories = Category::all();
        $products = Product::when($request->search, function ($q) use ($request) {
            return $q->whereTranslationLike('name', '%' . $request->search . '%');
        })->when($request->category_id,function($q)use($request){
            return $q->where('category_id',$request->category_id) ;
        })->latest()->paginate(8);
        return view('dashboard.products.index',compact('categories','products'));
    }

    public function create()
    {
        $categories=Category::all();
        return view('dashboard.products.create',compact('categories'));
    }


    public function store(Request $request)
    {
        $rules=[
            'category_id'=>'required'
        ];
        foreach( config('translatable.locales') as $locale){
            $rules +=[$locale.'.name'=>'required|unique:product_translations,name'];
            $rules +=[$locale.'.description'=>'required'];
        }
        $rules +=[
            'image'=>'image',
            'purchase_price'=>'required',
            'sale_price'=>'required',
            'stock'=>'required'
        ];
        $request->validate($rules);
        $request_data=$request->all();
        if($request->image){
            Image::make($request->image)->resize(300,null,function ($constraint){
                $constraint->aspectRatio();})
            ->save(public_path('uploads/products_images/'.$request->image->hashName()));
            $request_data['image']=$request->image->hashName();
        }//end of if image check
        Product::create($request_data);
        session()->flash('success',__('site.added_successfully'));
        return redirect()->route('dashboard.products.index');
    }// end of store product

    public function edit(Product $product)
    {
        $categories=Category::all();
        return view('dashboard.products.edit',compact('categories','product'));
    }

    public function update(Request $request, Product $product)
    {
        $rules=[
            'category_id' => 'required'
        ];
        foreach( config('translatable.locales') as $locale){
            $rules +=[$locale.'.name'=>['required',Rule::unique('product_translations','name')->ignore($product->id,'product_id')]] ;
            $rules +=[$locale.'.description'=>'required'];
        }
        $rules +=[
            'image'=>'image',
            'purchase_price'=>'required',
            'sale_price'=>'required',
            'stock'=>'required'

        ];

        $request->validate($rules);
        $request_data=$request->all();
        if($request->image){
            if( $product->image != 'default.png' ){
               Storage::disk('public_uploads')->delete('products_images/'.$product->image);
            }
            Image::make($request->image)->resize(300,null,function ($constraint){
                $constraint->aspectRatio();})
                ->save(public_path('uploads/products_images/'.$request->image->hashName()));
            $request_data['image']=$request->image->hashName();

        }
        $product->update($request_data);
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route('dashboard.products.index');
    }//end of update product


    public function destroy(Product $product)
    {
        if ($product->image != 'default.png'){
            Storage::disk('public_uploads')->delete('products_images/'.$product->image);
        }
        $product->delete();
        session()->flash('success',__('site.deleted_successfully'));
        return redirect()->route('dashboard.products.index');
    }
}
