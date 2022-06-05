<?php
namespace App\Services;
use App\Models\User;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Store;
use DB;
class CartService{

    public function getCartId(User $user){
        return Cart::firstOrCreate(['user_id'=>$user->id]);
    }

    public function getUserCartProducts(User $user){
                
        $cart =$user->cart()->first()->with('products')->get();
        return $cart;
    }

    public function addProductToCart(Cart $cart, $product_id, $quantity ){
        
        DB::beginTransaction();
        try {
           //insert into the pivot table
            DB::table('cart_product')->insert([
                'cart_id' => $cart['id'],
                'product_id' => $product_id,
                'quantity' => $quantity
            ]);
             
            //calculate the new total for the cart
            $this->calculateCartTotal($cart);

            DB::commit();
            // all good
        } catch (Exception $e) {
            DB::rollback();
            return $e;
            // something went wrong
        }
    }
    public function updateCartProduct(Cart $cart, Product $product,$quantity){
        
        DB::beginTransaction();
        try {

        $affected= DB::table('cart_product')->where('cart_id',$cart->id)->where('product_id',$product->id)->update(['quantity'=>$quantity]);
        $this->calculateCartTotal($cart);
        DB::commit(); 
    } catch (Exception $e) {
        DB::rollback();
        return $e;
        // something went wrong
    }
    }
    public function calculateCartTotal(Cart $cart){
        try {
            //get cart products
        $cartData = $cart->first()->with('products')->get();
        $cartArray = $cartData->toArray();
        $newTotal = 0;
        foreach($cartArray[0]['products'] as $item )
        {
         //calculate the subtotal for the cart
         $SubTotal=$item['price'] * $item['pivot']['quantity'];

         //get vat value of store
         $vat = Store::where('id',$item['store_id'])->pluck('vat_percent')->first();
         //if vat not included in price then add it
         if(!$item['vat_included'])
         $SubTotal+= ($SubTotal*($vat/100));

         $newTotal += $SubTotal;
        }
        $cart->update(['total'=>$newTotal]);  
    } catch (Exception $e) {
        return $e;
        // something went wrong
    }
    }
}