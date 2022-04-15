<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CsvImportTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testImport()
    {
        $data = [
            'id' => "1001"
            'first_name' => "New Product",
            'description' => "This is a product",
            'units' => 20,
            'price' => 10,
            'image' => "https://images.pexels.com/photos/1000084/pexels-photo-1000084.jpeg?auto=compress&cs=tinysrgb&dpr=2&h=650&w=940"
        ];
        //$user = factory(\App\User::class)->create();
       // $response = $this->actingAs($user, 'api')->json('POST', '/api/products',$data);
        $response = $this->json('POST', '/customer',$data);
        $response->assertStatus(200);
        $response->assertJson(['status' => true]);
        $response->assertJson(['success' => '<strong>Sucesso!</strong></br>Os clientes foram importados.']);
        $response->assertJson(['data' => $data]);
    }
}
