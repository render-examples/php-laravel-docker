<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    function list()
    {
        $result = DB::table('customers')->get();
        return view('customer.index', ['customers' => $result]);
    }

    function create()
    {
        return view('customer.new');
    }

    function store(Request $request)
    {
        try{
            // 驗證
            // 是不是資料庫真人
            // 是不是資料庫產品，數量對不對
            // dd($request->all());
            $validator = Validator::make(
                $request->all(), 
                [
                    'name' => 'required|unique:customers,name|max:30',
                    'phone' => 'required|numeric|string',
                    'taxIdNumber' => 'required|numeric|unique:customers,tax_id_number',
                    'address' => 'required|string',
                ],
            );
            if ($validator->fails()) {
                return redirect('customer/create')
                        ->withErrors($validator)
                        ->withInput();
            }

            $result = Customer::create([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'tax_id_number' => $request->taxIdNumber,
                    'address' => $request->address,
            ]);
            if($result){
                // 存入
                return redirect('customer/index');
            } else {
                return redirect('customer/create')
                        ->withErrors($validator)
                        ->withInput();
            }

        } catch (ValidationException $exception) {
            $errorMessage =
                $exception->validator->getMessageBag()->getMessages();
        }
    }
}
