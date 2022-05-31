<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;


class HTTPProductTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
          
        $user = new User([
            'id' => 1,
            'name' => 'yish',
            'type' => 'Merchant'
        ]);
        $this->be($user);
        $response = $this->patch('/product/2',['name' =>json_encode([
            "ar"=> "ميرا",
            "en"=> "Mera",
               ]),'description' =>json_encode([
                "ar"=> "ميرا دراي فوود",
                "en"=> "Mera",
               ]),
        'available_quantity' => '20', 'vat_included'=>false, 'price'=>'42']);
        $response->assertStatus(200);
        //         $user = new User([
        //     'id' => 1,
        //     'name' => 'yish',
        //     'type' => 'Merchant'
        // ]);
        // $this->be($user);
        // $response = $this->post('/product',['name' =>json_encode([
        //     "ar"=> "ريتا",
        //     "en"=> "Rita",
        //        ]),'description' =>json_encode([
        //         "ar"=> "ريتا",
        //         "en"=> "Rita",
        //        ]),
        // 'available_quantity' => '25', 'vat_included'=>true, 'price'=>'42','store_id'=>'2']);
        // $response->assertStatus(200);
    }

    public function updateTest(){
       
    }
}
