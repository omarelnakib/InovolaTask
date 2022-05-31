<?php

namespace App\Http\Controllers;
use App\Models\Store;

use Illuminate\Http\Request;

class StoresController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    //retrieve all stores for the authenticated user
    public function index(){
        $user = auth()->user();
        // dd($user);
        if($user->type=='Merchant'){

            $stores = Store::where('user_id',1)->get();
            return compact('stores');
        }
        abort(404, "It's a Consumer Account!");

    }

    //show certain store
    public function show(Store $store){
        // dd($user);
        $this->authorize('update', $store);

        return compact('store');
    }

    //add store to current user
    public function store(){

        $data = request()->validate([
            'name' => 'required',
            'shipping_cost'=>'',
            'vat_percent'=>''
        ]);

        auth()->user()->store()->create($data);

        return true;

    }

    //update store data
    public function update(Store $store){
        $this->authorize('update', $store);

        $data = request()->validate([
            'name' => 'required',
            'shipping_cost'=>'',
            'vat_percent'=>''
        ]);

        auth()->user()->store()->whereId($store->id)->update($data);

        return true;

    }
    
}
