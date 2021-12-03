<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Cart;

class CartController extends Controller
{
    //method untuk menampilkan semua data product (read)
    public function index()
    {
        $carts = Cart::all();

        if(count($carts)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $carts
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    //method untuk menampilkan 1 data cart (search)
    public function show($id)
    {
        $cart = Cart::find($id);

        if(!is_null($cart)){
            return response([
                'message' => 'Retrieve Cart Success',
                'data' => $cart
            ], 200);
        }

        return response([
            'message' => 'Cart Not Found',
            'data' => null
        ], 400);
    }

    //method untuk menambah 1 data cart baru (create)
    public function store(Request $request)
    {
        $storeData = $request->all(); //mengambil semua input dari api client
        $validate = Validator::make($storeData, [
            'product_name' => 'required|max:60',
            'price' => 'required|numeric',
        ]); //membuat rule validasi input

        if($validate->fails())
            return  response(['message' => $validate->errors()], 400); //return error invalid input

        $cart = Cart::create($storeData);
        return response([
            'message' => 'Add Cart Success',
            'data' => $cart
        ], 200);
    }

    //method untuk menghapus 1 data product (delete)
    public function destroy($id)
    {
        $cart = Cart::find($id); //mencari data product berdasarkan id

        if(is_null($cart)){
            return response([
                'message' => 'Cart Not Found',
                'data' => null
            ], 404);
        }

        if($cart->delete()){
            return response([
                'message' => 'Delete Cart Success',
                'data' => $cart
            ], 200);
        }

        return response([
            'message' => 'Delete Cart Failed',
            'data'  => null,
        ], 400);
    }
        
    //method untuk mengubah 1 data cart (update)
    public function update(Request $request, $id)
    {
        $cart = Cart::find($id); //menbcaru data cart berdasarkan id
        if(is_null($cart)){
            return response([
                'message' => 'Cart Not Found',
                'data' => null
            ], 400);
        }

        $updateData = $request->all(); //mengambil semua input dari api client
        $validate = Validator::make($updateData, [
            'product_name' => 'required|max:60',
            'price' => 'required|numeric',
        ]); //membuat rule validasi 

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); //return error invalid input
            
        $cart->product_name = $updateData['product_name']; //edit product_name
        $cart->price = $updateData['price']; //edit price

        if($cart->save()){
            return response([
                'message' => 'Update Cart Success',
                'data' => $cart
            ], 200);
        }
        return response([
            'message' => 'Updated Cart Failed',
            'data' => null,
        ], 400);
    }
}