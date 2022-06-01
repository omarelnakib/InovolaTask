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
        // $user = new User([
        //     'id' => 1,
        //     'name' => 'omar'
        // ]);
        // $this->be($user);
        // $response = $this->patch('/store/1',['name' =>'firstShop',
        // 'vat_percent' => '25']);
        // $response->assertStatus(200);
    }
    public function testStore()
    {
       
        $user = new User([
            'id' => 2,
            'name' => 'yish',
            'type' => 'Consumer'
        ]);
        $this->be($user);
        $response = $this->post('/cart',['product_id' =>'2',
        'quantity' => '25']);
        $response->assertStatus(200);
    }
}
