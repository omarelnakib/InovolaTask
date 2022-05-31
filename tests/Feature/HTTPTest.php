<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class HTTPTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUpdateStore()
    {
        // foreach($session as $key=>$value){
        //     Session::set($key, $value);
        // }
        // $user = new User(array('id'=>'1','name' => 'omar')); $this->be($user);
        $user = new User([
            'id' => 1,
            'name' => 'omar'
        ]);
        $this->be($user);
        $response = $this->patch('/store/1',['name' =>'firstShop',
        'vat_percent' => '25']);
        // dd($response);
        $response->assertStatus(200);
    }
    public function testStore()
    {
        // foreach($session as $key=>$value){
        //     Session::set($key, $value);
        // }
        // $user = new User(array('id'=>'1','name' => 'omar')); $this->be($user);
        // $user = new User([
        //     'id' => 1,
        //     'name' => 'yish'
        // ]);
        // $this->be($user);
        // $response = $this->post('/store',['name' =>'pets2',
        // 'vat_percent' => '25']);
        // // dd($response);
        // $response->assertStatus(200);
    }
}
