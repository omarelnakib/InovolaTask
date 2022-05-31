<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Store;
use App\Models\Cart;

use Illuminate\Http\Request;

class CartsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    //retrieve all products
    public function index(){


            $products = auth()->user()->cart()->first()->products()->get();
            return compact('products');
     
    }

    //show certain product
    public function show(Product $product){

        return compact('product');
    }

    //add product to current Merchant user store
    public function store(){

        $data = request()->validate([
            'name' => 'required',
            'description'=>'required',
            'available_quantity'=>'required',
            'price'=>'required',
            'vat_included'=>'',
            'store_id'=>'required'
        ]);
        $this->authorize('create',[Product::class,$data['store_id']]);

        auth()->user()->store()->find($data['store_id'])->products()->create($data);

        return true;

    }

    //update store data
    public function update(Product $product){
        $this->authorize('update', $product);

        $data = request()->validate([
            'name' => 'required',
            'description'=>'required',
            'available_quantity'=>'required',
            'price'=>'required',
            'vat_included'=>'',
        ]);

        $product->update($data);

        return true;

    }
    
}
