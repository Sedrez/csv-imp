<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the Customers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('index');
    }

     /**
     * Display a chart of the Data.
     *
     * @return \Illuminate\Http\Response
     */
    public function data_chart()
    {
        //Suporte ao REGEX no MYSQL parece não ser suficiente para validar todos os emails
        //$customers = Customer::get(['last_name', 'gender']);
        $customers = DB::table('customers')
            ->select('last_name', 'gender', 'email')
            ->get();
        return response()->json($customers);
    }

     /**
     * Display a list of the Data.
     *
     * @return \Illuminate\Http\Response
     */
    public function data_list()
    {
        $customers = Customer::all();
        return response()->json($customers);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request = json_decode($request->getContent(), true);        
        try {
            DB::table('customers')->upsert($request, ['id']);
        } catch (\Illuminate\Database\QueryException $e) {
            report($e);
            return response()->json(['error' => '<strong>Ops, algo deu errado na importação!</strong></br>Confira o padrão dos dados do arquivo CSV e tente novamente!']);
        }
        
        return response()->json(['success' => '<strong>Sucesso!</strong></br>Os clientes foram importados.']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Customer  $Customer
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $Customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
       //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Customer  $Customer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $customer)
    {
        
       //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
