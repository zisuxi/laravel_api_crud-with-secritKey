<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\customer;

class customerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cusomer_detail = customer::all();
        return  view('customer.customerView', compact('cusomer_detail'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('customer.customer');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);

        $create_customer = customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'access_token' => uniqid(),
        ]);
        if ($create_customer) {
            return redirect('/api/customer');
        } else {
            echo "some thing went wronge";
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = customer::where('id', $id)->first();
        return  response()->json([
            'status' => 200,
            'data' => $customer,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $edit_record = customer::where('id', $id)->first();
        return  view('customer.editcustomer', compact('edit_record'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        customer::where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        return redirect('/api/customer');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        customer::where('id', $id)->delete();
        return  redirect('api/customer');
    }
    public function updateToken($id)
    {
        customer::where('id', $id)->update([
            'access_token' => uniqid(),
        ]);
        return  response()->json([
             'data'=>200,
        ]);
    }
}
