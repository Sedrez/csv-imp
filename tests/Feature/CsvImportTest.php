<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class CsvImportTest extends TestCase
{
    /**
     * A basic import test.
     *
     * @return void
     */
    public function testImport()
    {
        $data[0] = [
            "id" => '1001',
            "first_name" => 'TestFirstName',
            "last_name" => 'LastNameTest',
            "email" => "email@test",
            "gender" => "undefined",
            "ip_address" => "192.168.1.1",
            "company" => "Shell",
            "city" => "Rainville",
            "title"=> 'Software Engineer' ,
            "website" => "https://github.com/Sedrez/csv-imp"
            
        ];
        $response = $this->json('POST', route('customers.store') , $data);
        $response->assertStatus(200);
        $response->assertJson(['success' => '<strong>Sucesso!</strong></br>Os clientes foram importados.']);
    }
}
