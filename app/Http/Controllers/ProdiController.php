<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Prodi;
use App\Models\Kampus;
use Validator;

class ProdiController extends Controller
{
    public function index()
    {
        try {

            // $prodi = Prodi::leftJoin('kampuses', function($join) { 
            //     $join->on('kampuses.id', '=', 'prodis.kampus_id')
            //         ->on('kampuses.id', '=', 
            //         \DB::raw("(SELECT max(id) from kampuses WHERE kampuses.id = prodis.kampus_id)")); 
            //     })
            //     ->select(array('prodis.*', 'kampuses.name as kampus_id'))
            //     ->get();

            $prodi = Prodi::with('kampus')
                    ->get();
                    
            $countAll = Prodi::count();

            if ($prodi == null) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Empty'
                ]);
            }

            return response()->json([
                'success'       => true,
                'recordsTotal'  => $countAll,
                'data'          => $prodi
            ], 200);
        }
        catch (\Exception $e) {
            return response()->json([
                'success'   => false,
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
                'name' => 'required',
                'kampus_id' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success'   => false,
                    'message'   => $validator->errors()->all() ,
                ], 422);
            }
    
            $id_kampus = Kampus::findOrFail($request->kampus_id);

            $prodi = new Prodi();
            $prodi->name = $request->name;

            if ($id_kampus) {
                $prodi->kampus_id = $id_kampus->id;
            }

            $prodi->save();

            \DB::commit();

            return response()->json([
                'success'   => true,
                'message'   =>'Prodi Has Been Added',
                'data'      => $prodi
            ], 200);
        } 
        catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'success'   => false,
                'message'   => $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $prodi = Prodi::findOrFail($id);

            return response()->json($prodi);        
        }
        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Not Found'
            ]);        
        }
    }

    public function update(Request $request)
    {
        \DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'name' => 'required',
                'kampus_id' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success'   => false,
                    'message'   => $validator->errors()->all() ,
                    'data'      => null
                ], 422);
            }
    
            $id_kampus = Kampus::findOrFail($request->kampus_id);
            $prodi = Prodi::findOrFail($request->id);
            $prodi->name = $request->name;

            if ($id_kampus) {
                $prodi->kampus_id = $id_kampus->id;
            }

            $prodi->update();
            \DB::commit();
    
            return response()->json([
                'success'   => true,
                'message'   =>'Prodi Has Been Updated',
                'data'      => $prodi
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
            $prodi = Prodi::findOrFail($id);
            $prodi->delete();

            return response()->json([
                'success' => true,
                'message' => 'Prodi Has Been Deleted'
            ]);
        }

        catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to delete entry'
            ]);
        }
    }
}
