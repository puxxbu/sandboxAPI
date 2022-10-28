<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Customer;
use Illuminate\Support\Facades\Validator;


class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();

        if (count($customers) > 0) {
            return response([
                'message' =>'Retrieve All Success',
                'data' => $customers
            ],200);
        }

        return response([
            'message' =>'Empty',
            'data' => null        
        ],400);
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
        $storeData = $request->all();
        $validate = Validator::make($storeData,[
            'nama_customer' => 'required|regex:/^[\pL\s]+$/u',
            'membership' => ['required', Rule::in(['Bronze','Platinum','Gold'])],
            'alamat' => 'required',
            'tgl_lahir' => 'required|date_format:Y-m-d',
            'no_telp' => 'required|regex:/(08)[0-9]{9,11}$/'
        ]);

        if ($validate->fails()) {
            return response([
                'message' => $validate->errors()
            ],400);
        }
        

        $customer = Customer::create($storeData);
        return response([
            'message' => 'Add Customer Success',
            'data' => $customer
        ],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::find($id);

        if (!is_null($customer)) {
            return response([
                'message' => 'Retrieve Customer Success',
                'data' => $customer
            ],200);
        }

        return response([
            'message' => 'Customer Not Found',
            'data' => null
        ],400);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);
        if (is_null($customer)) {
            return response([
                'message' => 'Customer Not Found',
                'data' => null
            ],404);
        }

        $updateData = $request->all();
        $validate = Validator::make($updateData,[
            'nama_customer' => 'required|regex:/^[\pL\s]+$/u',
            'membership' => ['required', Rule::in(['Bronze','Platinum','Gold'])],
            'alamat' => 'required',
            'tgl_lahir' => 'required|date_format:Y-m-d',
            'no_telp' => 'required|regex:/(08)[0-9]{9,11}$/'
        ]);

        if ($validate->fails()) {
            return response([
                'message' => $validate->errors()
            ],400);
        }

        $customer->nama_customer = $updateData['nama_customer'];
        $customer->membership = $updateData['membership'];
        $customer->alamat = $updateData['alamat'];
        $customer->tgl_lahir = $updateData['tgl_lahir'];
        $customer->no_telp = $updateData['no_telp'];

        if ($customer->save()) {
            return response([
                'message' => 'Update Customer Success',
                'data' => $customer
            ],200);
        }

        return response([
            'message' => 'Update Customer Failed',
            'data' => null
        ],400);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);
        if (is_null($customer)) {
            return response([
                'message' => 'Customer Not Found',
                'data' => null
            ],404);
        }

        if ($customer->delete()) {
            return response([
                'message' => 'Delete Customer Success',
                'data' => $customer
            ],200);
        }

        return response([
            'message' => 'Delete Customer Failed',
            'data' => null
        ],400);
    }
}
