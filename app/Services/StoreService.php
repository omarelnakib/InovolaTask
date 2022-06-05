<?php
namespace App\Services;
use App\Models\Store;
use App\Models\User;
use DB;
class StoreService{

    public function getUserStores(User $user){
        $stores = $user->store()->get();
        return $stores;
    }

    public function getStore(Store $store){
        return $store;
    }

    public function getStoreProducts(Store $store){
        $products = $store->products()->get();
        return $products;
    }

    public function addStoretoUser(User $user,$data){
       $user->store()->create($data);
    }

    public function updateStore(Store $store, $data){
        $store->update($data);
    }

 
}