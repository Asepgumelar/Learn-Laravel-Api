<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kampus;
use Validator;

class KampusController extends Controller
{
  
    public function index()
    {
        try {
            $kampus = Kampus::all();
            $countAll = Kampus::count();

            if ($kampus == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Empty'
                ]);
            }
            
            return response()->json([
                'success'       => true,
                'recordsTotal'  => $countAll,
                'data'          => $kampus
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'success'   => failed,
                'message'   => 'Internal Server Error',
                'error'     => $e->getMessage()
            ], 500);
        }
    }

    public function store(Request $request)
    {
        \DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success'   => false,
                    'message'   => $validator->errors()->all() ,
                ], 422);
            }
    
            $kampus = new Kampus();
            $kampus->name = $request->name;
            $kampus->save();
    
            \DB::commit();

            return response()->json([
                'success'   => true,
                'message'   =>'Kampus Has Been Added',
                'data'      => $kampus
            ], 201);
        }
        catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'success'   => false,
                'message'   => $e->getMessage(),
                'data'      => null
            ], 500);
        }

    }

    public function show($id)
    {
        try {
            $kampus = Kampus::findOrFail($id);

            return response()->json($kampus);
        }
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Not Found'
            ]);
        }

    }

    public function update(Request $request, $id)
    {
        \DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'name' => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success'   => false,
                    'message'   => $validator->errors()->all() ,
                    'data'      => null
                ], 422);
            }
            $kampus = Kampus::findOrFail($request->id);
            $kampus->name = $request->name;
            $kampus->update();

            \DB::commit();
    
            return response()->json([
                'success'   => true,
                'message'   =>'Kampus Has Been Updated',
                'data'      => $kampus
            ], 200);
        } catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'success'   => false,
                'message'   => $e->getMessage(),
                'data'      => null
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $kampus = Kampus::findOrFail($id);
            $kampus->delete();
    
            return response()->json([
                'success' => true,
                'message' => 'Kmpus Has Been Deleted'
            ], 204);
        }
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to delete entry'
            ]);
        }
    }
}
