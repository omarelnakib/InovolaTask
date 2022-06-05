<?php

namespace App\Http\Controllers;
use App\Services\CartService;
use DB; 
use App\Models\Cart;
use App\Models\Product;

use Illuminate\Http\Request;

class CartsController extends Controller
{
    protected $cart_service ;
    public function __construct()
    {   
        $this->cart_service = new CartService();
    }
    //retrieve all cart products
    public function index(){
            $authUser = auth()->user();
            $cart =  $cart_service->getUserCartProducts($authUser);
            return compact('cart');
    }

    //add item to cart
    public function store(){

        $data = request()->validate(['product_id' => 'required','quantity'=>'required' ]);   
        $this->authorize('create',Cart::class);

       $cart = $this->cart_service->getCartId(auth()->user());
       return $this->cart_service->addProductToCart($cart, $data['product_id'], $data['quantity']); 
        
    }
   

    //update product quantity data
    public function update(Cart $cart, Product $product){

        $data = request()->validate(['quantity'=>'required']);
        $this->authorize('update',$cart);
        $this->cart_service->updateCartProduct($cart, $product, $data['quantity']);
        return true;

    }
    
}
