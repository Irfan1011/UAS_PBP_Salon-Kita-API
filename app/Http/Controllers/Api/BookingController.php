<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\Booking;

class BookingController extends Controller
{
    //method untuk menampilkan semua data product (read)
    public function index()
    {
        $bookings = Booking::all();

        if(count($bookings)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $bookings
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    //method untuk menampilkan 1 data booking (search)
    public function show($id)
    {
        $booking = Booking::find($id);

        if(!is_null($booking)){
            return response([
                'message' => 'Retrieve Booking Success',
                'data' => $booking
            ], 200);
        }

        return response([
            'message' => 'Booking Not Found',
            'data' => null
        ], 400);
    }

    //method untuk menambah 1 data booking baru (create)
    public function store(Request $request)
    {
        $storeData = $request->all(); //mengambil semua input dari api client
        $validate = Validator::make($storeData, [
            'name' => 'required|max:60',
            'phone_number' => 'required|digits_between:10,13|numeric|regex:/(08)[0-9]{1}/',
            'date' => 'required',
            'time' => 'required|numeric'
        ]); //membuat rule validasi input

        if($validate->fails())
            return  response(['message' => $validate->errors()], 400); //return error invalid input

        $booking = Booking::create($storeData);
        return response([
            'message' => 'Add Booking Success',
            'data' => $booking
        ], 200);
    }

    //method untuk menghapus 1 data product (delete)
    public function destroy($id)
    {
        $booking = Booking::find($id); //mencari data product berdasarkan id

        if(is_null($booking)){
            return response([
                'message' => 'Booking Not Found',
                'data' => null
            ], 404);
        }

        if($booking->delete()){
            return response([
                'message' => 'Delete Booking Success',
                'data' => $booking
            ], 200);
        }

        return response([
            'message' => 'Delete Booking Failed',
            'data'  => null,
        ], 400);
    }
        
    //method untuk mengubah 1 data booking (update)
    public function update(Request $request, $id)
    {
        $booking = Booking::find($id); //menbcaru data booking berdasarkan id
        if(is_null($booking)){
            return response([
                'message' => 'Booking Not Found',
                'data' => null
            ], 400);
        }

        $updateData = $request->all(); //mengambil semua input dari api client
        $validate = Validator::make($updateData, [
            'name' => 'required|max:60',
            'phone_number' => 'required|digits_between:10,13|numeric|regex:/(08)[0-9]{1}/',
            'date' => 'required',
            'time' => 'required|numeric'
        ]); //membuat rule validasi 

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); //return error invalid input
            
        $booking->name = $updateData['name']; //edit name
        $booking->phone_number = $updateData['phone_number']; //edit phone_number
        $booking->date = $updateData['date'];
        $booking->time = $updateData['time'];

        if($booking->save()){
            return response([
                'message' => 'Update Booking Success',
                'data' => $booking
            ], 200);
        }
        return response([
            'message' => 'Updated Booking Failed',
            'data' => null,
        ], 400);
    }
}