<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use DB; 
use App\Models\Product;

use Illuminate\Http\Request;

class ProductsController extends Controller
{
    protected $product_service ;
    public function __construct()
    {   
        $this->product_service = new ProductService();
    }
    //retrieve all products
    public function index(){

            $products = $this->product_service->all();
            return compact('products');
     
    }

    //show certain product
    public function show(Product $product){
        $product = $this->product_service->getProduct($product);
        return compact('product');
    }

    //add product to current Merchant user store
    public function store(){

        $data = request()->validate([
            'name' => 'required',
            'description'=>'required',
            'price'=>'required',
            'vat_included'=>'',
            'store_id'=>'required'
        ]);
        $this->authorize('create',[Product::class,$data['store_id']]);

        $this->product_service->addProductToStore($data['store_id'], $data);

        return true;

    }

    //update product data
    public function update(Product $product){
        $this->authorize('update', $product);

        $data = request()->validate([
            'name' => 'required',
            'description'=>'required',
            'price'=>'required',
            'vat_included'=>'',
        ]);
        
        $this->product_service->updateStoreProduct($product, $data);

        return true;

    }
    
}
