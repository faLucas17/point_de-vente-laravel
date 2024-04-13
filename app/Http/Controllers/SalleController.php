<?php

namespace App\Http\Controllers;

use App\Models\Batiment;
use App\Models\Departement;
use Illuminate\Http\Request;
use App\Models\Salle;
use PDF;

class SalleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $batiment = Batiment::all()->pluck('nama_batiment', 'id_batiment');
        $departement = Departement::all()->pluck('nama_department', 'id_departement');

        return view('salle.index', compact('batiment', 'departement'));
    }

    public function data()
    {
        $salle = Salle::leftJoin('batiment', 'departement', 'batiment.id_batiment', 'departement.id_departement', 'salle.id_batiment', 'salle.id_departement')
            ->select('salle.*', 'nama_batiment', 'nama_departement')
            // ->orderBy('numero', 'asc')
            ->get();

        return datatables()
            ->of($salle)
            ->addIndexColumn()
            ->addColumn('select_all', function ($salle) {
                return '
                    <input type="checkbox" name="id_salle[]" value="'. $salle->id_salle .'">
                ';
            })
            ->addColumn('numero', function ($salle) {
                return '<span class="label label-success">'. $salle->numero .'</span>';
            })
            ->addColumn('capacite', function ($salle) {
                return format_uang($salle->capacite);
            })
            ->addColumn('aksi', function ($salle) {
                return '
                <div class="btn-group">
                    <button type="button" onclick="editForm(`'. route('salle.update', $salle->id_salle) .'`)" class="btn btn-xs btn-primary btn-flat"><i class="fa fa-pencil"></i></button>
                    <button type="button" onclick="deleteData(`'. route('salle.destroy', $salle->id_salle) .'`)" class="btn btn-xs btn-danger btn-flat"><i class="fa fa-trash"></i></button>
                </div>
                ';
            })
            ->rawColumns(['aksi', 'numero', 'select_all'])
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $salle = Salle::latest()->first() ?? new Salle();
        $request['numero'] = 'P'. tambah_nol_didepan((int)$salle->id_salle +1, 6);

        $salle = Salle::create($request->all());

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
        $salle = Salle::find($id);

        return response()->json($salle);
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
        $salle = Salle::find($id);
        $salle->update($request->all());

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
        $salle = Salle::find($id);
        $salle->delete();

        return response(null, 204);
    }

    public function deleteSelected(Request $request)
    {
        foreach ($request->id_salle as $id) {
            $salle = Salle::find($id);
            $salle->delete();
        }

        return response(null, 204);
    }
    // visit "codeastro" for more projects!
    public function cetakBarcode(Request $request)
    {
        $datasalle = array();
        foreach ($request->id_salle as $id) {
            $salle = Salle::find($id);
            $datasalle[] = $salle;
        }

        $no  = 1;
        $pdf = PDF::loadView('salle.barcode', compact('datasalle', 'no'));
        $pdf->setPaper('a4', 'potrait');
        return $pdf->stream('salle.pdf');
    }
}
