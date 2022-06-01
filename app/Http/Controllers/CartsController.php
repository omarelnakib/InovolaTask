<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Store;
use App\Models\Cart;
use DB; 

use Illuminate\Http\Request;

class CartsController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    //retrieve all cart products
    public function index(){

        
            $cart = auth()->user()->cart()->first()->with('products')->get();
            return compact('cart');
     
    }

    //add item to cart
    public function store(){

        $data = request()->validate([
            'product_id' => 'required',
            'quantity'=>'required',
        ]);   

        $this->authorize('create',Cart::class);

        // assumed that each user has only one cart
        // $data['cart_id']=auth()->user()->id;
       $cart= Cart::firstOrCreate(['user_id'=>auth()->user()->id]);
        DB::beginTransaction();
        try {
           //insert into the pivot table
            DB::table('cart_product')->insert([
                'cart_id' => $cart['id'],
                'product_id' => $data['product_id'],
                'quantity' => $data['quantity']
            ]);
             
            //calculate the new total for the cart
            $item = Product::where('id',$data['product_id'])->with('store')->first();
            $SubTotal=$item->price * $data['quantity'];
            $vat = $item->store->vat_percent;
            
            if(!$item->vat_included)
            $SubTotal+= ($SubTotal*($vat/100));


            $newTotal = $SubTotal+ $cart->total;
            $cart->update(['total'=>$newTotal]);
            DB::commit();
            // all good
        } catch (Exception $e) {
            DB::rollback();
            return $e;
            // something went wrong
        }
    }
   

    //update product quantity data
    public function update(Cart $cart, Product $product){

        $data = request()->validate([
            'quantity'=>'required'
        ]);

        DB::beginTransaction();
        try {

        $affected= DB::table('cart_product')->where('cart_id',$cart->id)->where('product_id',$product->id)->update(['quantity'=>$data['quantity']]);
        $cartData = auth()->user()->cart()->first()->with('products')->get();
        $cartArray = $cartData->toArray();
        $newTotal = 0;
        foreach($cartArray[0]['products'] as $item )
        {
         //calculate the new total for the cart
         $SubTotal=$item['price'] * $item['pivot']['quantity'];
         $vat = Store::where('id',$item['store_id'])->pluck('vat_percent')->first();
         if(!$item['vat_included'])
         $SubTotal+= ($SubTotal*($vat/100));

         $newTotal += $SubTotal;
        }
        $cart->update(['total'=>$newTotal]);  
        DB::commit(); 
    } catch (Exception $e) {
        DB::rollback();
        return $e;
        // something went wrong
    }
        return true;

    }
    
}
