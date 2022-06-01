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
        $this->authorize('viewAny',Store::class);
        $stores = Store::where('user_id',$user->id)->get();
            return compact('stores');
        

    }

    //show certain store
    public function show(Store $store){
        // dd($user);
        $this->authorize('view', $store);

        return compact('store');
    }

    //add store to current user
    public function store(){

        $data = request()->validate([
            'name' => 'required',
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
            'vat_percent'=>''
        ]);

        $store->update($data);

        return true;

    }
    
}
