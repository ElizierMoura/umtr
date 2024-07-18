<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use DB;
use Exception;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * 
     * @return  \Illuminate\Http\JsonResponse
     **/ 
    public function index()
    {
        $customers = Customer::orderBy("id","desc")->paginate(1);
        return response()->json([
            'status' => true,
            'customers' => $customers,
        ]);
    } 

    /**
     * @param App\Models\Customer;
     * @return \Illuminate\Http\JsonResponse
     **/ 
    public function show( Customer $customer)
    {
        return response()->json([
            'status' => true,
            'customers' => $customer,
        ]);
    } 

    /**
     * @param App\Models\Customer;
     * @return \Illuminate\Http\JsonResponse
     **/ 
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {

            Customer::create([
                'name'=> $request->name,
                'email' =>  $request->email,
                'situation' => $request->situation,
            ]);

            DB::commit();

            return response()->json([
            'status'    => true,
            'message'   => 'Usuário criado com sucesso.',
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            print($e);
            return response()->json([
                'status' => false,
                'message'=> 'Usuário não pode ser cadastrado.',
            ], 400);
        }
        // return response()->json([
        //     'status' => true,
        //     'customers' => $customer,
        // ]);
    } 
}
