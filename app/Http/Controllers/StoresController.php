<?php

namespace App\Http\Controllers;
use App\Models\Store;
use App\Services\StoreService;

use Illuminate\Http\Request;

class StoresController extends Controller
{
    protected $store_service ;

    public function __construct()
    {
        // $this->middleware('auth');
        $this->store_service = new StoreService();

    }
    //retrieve all stores for the authenticated user
    public function index(){
        $user = auth()->user();
        $this->authorize('viewAny',Store::class);
        $stores = $this->store_service->getUserStores($user);
        return compact('stores');
        }

    //show certain store
    public function show(Store $store){
        $this->authorize('view', $store);
        $store = $this->store_service->getStore($store);
        return compact('store');
    }

    //show store products
    public function showProducts(Store $store){
        $this->authorize('view', $store);
        $products = $this->store_service->getStoreProducts($store);
        return compact('products');
    }
    //add store to current user
    public function store(){
        $data = request()->validate(['name' => 'required','vat_percent'=>'']);
        $user = auth()->user();
        $this->store_service->addStoretoUser($user, $data);
        return true;
    }

    //update store data
    public function update(Store $store){
        $this->authorize('update', $store);
        $data = request()->validate(['name' => 'required','vat_percent'=>'']);
        $this->store_service->updateStore($store,$data);
        return true;

    }
    
}
