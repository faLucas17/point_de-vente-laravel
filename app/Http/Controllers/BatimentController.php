<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Batiment;

class BatimentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('batiment.index');
    }

    public function data()
    {
        $batiment = Batiment::orderBy('id_batiment', 'desc')->get();

        return datatables()
            ->of($batiment)
            ->addIndexColumn()
            ->addColumn('aksi', function ($batiment) {
                return '
                <div class="btn-group">
                    <button onclick="editForm(`'. route('batiment.update', $batiment->id_batiment) .'`)" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-pencil"></i></button>
                    <button onclick="deleteData(`'. route('batiment.destroy', $batiment->id_batiment) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi'])
            ->make(true);
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
    // visit "codeastro" for more projects!
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $batiment = new Batiment();
        $batiment->nama_batiment = $request->nama_batiment;
        $batiment->save();

        return response()->json('Data saved successfully', 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $batiment = Batiment::find($id);

        return response()->json($batiment);
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
    $batiment = Batiment::find($id);
    $batiment->nama_batiment = $request->nama_batiment;
    $batiment->save();

    return response()->json('Data saved successfully', 200);
}




    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $batiment = Batiment::find($id);
        $batiment->delete();

        return response(null, 204);
    }
}
