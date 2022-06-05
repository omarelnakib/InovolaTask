<?php
namespace App\Services;
use App\Models\Product;
use App\Models\Store;
use DB;
class ProductService{

    public function all(){
        $products = Product::all();
        return $products;
    }

    public function getProduct(Product $product){
        return $product;
    }

    public function addProductToStore($store_id, $data){
       Store::where('id',$store_id)->first()->products()->create($data);
    }

    public function updateStoreProduct(Product $product, $data){
        $product->update($data);
    }
}