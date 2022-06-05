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
    public function testInsertStore()
    {
        $user = new User([
            'id' => 4,
            'name' => 'ahmed'
        ]);
        $this->be($user);
        $response = $this->post('/store',['name' =>'Hyper2',
        'vat_percent' => '10']);
        $response->assertStatus(200);
    }
    public function testUpdateStore()
    {
       
        $user = new User([
            'id' => 4,
            'name' => 'yish',
            'type' => 'Merchant'
        ]);
        $this->be($user);
        $response = $this->patch('/store/7',['name'=>'hyper1']);
        $response->assertStatus(200);
    }

    public function testInsertProduct()
    {
        
        $user = new User([
            'id' => 4,
            'name' => 'yish',
            'type' => 'Merchant'
        ]);
        $this->be($user);

        $response = $this->post('/product',['name' =>json_encode(["ar"=> "شيبسي",  "en"=> "chipsy",])
        ,'description' =>json_encode(["ar"=> "رقائق البطاطاس", "en"=> "potato chips" ]),
        'price' => 3.5, 'vat_included'=>true, 'store_id' =>7]);
        $response->assertStatus(200);
    }

    public function testUpdateProduct()
    {
        $user = new User([
            'id' => 4,
            'name' => 'yish',
            'type' => 'Merchant'
        ]);
        $this->be($user);

        $response = $this->patch('/product/5',['name' =>json_encode(["ar"=> "مياه نسلة",  "en"=> "nestle water",])
        ,'description' =>json_encode(["ar"=> "مياه معدنية نقية", "en"=> "clear water" ]),
        'price' => 2, 'vat_included'=>true]);
        $response->assertStatus(200);
    }

    public function testAddItemToCart(){
        $user = new User([
            'id' => 2,
            'name' => 'yish',
            'type' => 'Consumer'
        ]);
        $this->be($user);

        $response = $this->post('/cart',['product_id' => 3, 'quantity'=>9]);
        $response->assertStatus(200);
    }

    public function testUpdateCartItem(){
        $user = new User([
            'id' => 2,
            'name' => 'yish',
            'type' => 'Consumer'
        ]);
        $this->be($user);

        $response = $this->patch('/cart/4/3',['quantity'=>2]);
        $response->assertStatus(200);
    }
}
