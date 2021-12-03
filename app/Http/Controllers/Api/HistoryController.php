<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use App\Models\History;

class HistoryController extends Controller
{
    //method untuk menampilkan semua data product (read)
    public function index()
    {
        $histories = History::all();

        if(count($histories)>0){
            return response([
                'message' => 'Retrieve All Success',
                'data' => $histories
            ], 200);
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400);
    }

    //method untuk menampilkan 1 data history (search)
    public function show($id)
    {
        $history = History::find($id);

        if(!is_null($history)){
            return response([
                'message' => 'Retrieve History Success',
                'data' => $history
            ], 200);
        }

        return response([
            'message' => 'History Not Found',
            'data' => null
        ], 400);
    }

    //method untuk menambah 1 data history baru (create)
    public function store(Request $request)
    {
        $storeData = $request->all(); //mengambil semua input dari api client
        $validate = Validator::make($storeData, [
            'booking_by' => 'required|max:60',
            'date' => 'required',
            'time' => 'required|numeric',
        ]); //membuat rule validasi input

        if($validate->fails())
            return  response(['message' => $validate->errors()], 400); //return error invalid input

        $history = History::create($storeData);
        return response([
            'message' => 'Add History Success',
            'data' => $history
        ], 200);
    }

    //method untuk menghapus 1 data product (delete)
    public function destroy($id)
    {
        $history = History::find($id); //mencari data product berdasarkan id

        if(is_null($history)){
            return response([
                'message' => 'History Not Found',
                'data' => null
            ], 404);
        }

        if($history->delete()){
            return response([
                'message' => 'Delete History Success',
                'data' => $history
            ], 200);
        }

        return response([
            'message' => 'Delete History Failed',
            'data'  => null,
        ], 400);
    }
        
    //method untuk mengubah 1 data history (update)
    public function update(Request $request, $id)
    {
        $history = History::find($id); //menbcaru data history berdasarkan id
        if(is_null($history)){
            return response([
                'message' => 'History Not Found',
                'data' => null
            ], 400);
        }

        $updateData = $request->all(); //mengambil semua input dari api client
        $validate = Validator::make($updateData, [
            'booking_by' => 'required|max:60',
            'date' => 'required',
            'time' => 'required|numeric',
        ]); //membuat rule validasi 

        if($validate->fails())
            return response(['message' => $validate->errors()], 400); //return error invalid input
            
        $history->booking_by = $updateData['booking_by']; //edit booking_by
        $history->date = $updateData['date']; //edit date
        $history->time = $updateData['time']; //edit time

        if($history->save()){
            return response([
                'message' => 'Update History Success',
                'data' => $cart
            ], 200);
        }
        return response([
            'message' => 'Updated History Failed',
            'data' => null,
        ], 400);
    }
}