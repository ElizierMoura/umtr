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
        $customers = Customer::orderBy("id","desc")->paginate(2);
        
        // Se caso quiser criar um campo de busca pode usar LIKE e concatenar com outras colunasm, ex: orWhere com email like $var.
        //$customers = Customer::where("name","LIKE","%Eliz%")->paginate(10);
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
            return response()->json([
                'status' => false,
                'message'=> 'Usuário não pode ser cadastrado.',
            ], 400);
        }
    }
    
    public function destroy(Customer $customer)
    {
        DB::beginTransaction();
        try {
            $customer->delete();

            DB::commit();


            return response()->json([
            'status'    => true,
            'message'   => 'Usuário apagado com sucesso.',
            ]);

        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message'=> 'Usuário não pode ser apagado.',
            ], 400);
        }
    }
}
