<?php

namespace App\Http\Controllers;

use App\Models\Alm_AjusteNegativo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AlmAjusteNegativoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pruebas ="esto es una prueba";
        $productos = DB::table('prod__productos as pp')
        ->join('prod__lineas as pl', 'pp.idlinea', '=', 'pl.id')
        ->join('alm__ingreso_producto as aip', 'aip.id_prod_producto', '=', 'pp.id')
        ->select(
            'pp.id as id',
            'pp.codigo as codigoProducto',
            'pp.nombre as name',
            'pp.codigointernacional as codigointernacional',
            'pl.codigo as codigolinea',
            'pl.nombre as linea',
            'aip.cantidad as cantidad',
            'aip.lote as lote',
            'aip.created_at as fechaIngreso',
            'aip.fecha_vencimiento as fecha_vencimiento '
        )
        ->orderBy('pp.nombre','asc')
        ->get();

        $tipos = DB::table('alm__tipo')->get();

        return ['pruebas' =>$pruebas,'productos'=>$productos,'tipos'=>$tipos ];
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }



    public function getProductoLineaIngreso(){
        $productos = DB::table('prod__productos as pp')
        ->join('prod__lineas as pl', 'pp.idlinea', '=', 'pl.id')
        ->join('alm__ingreso_producto as aip', 'aip.id_prod_producto', '=', 'pp.id')
        ->select(
            'pp.id as id',
            'pp.codigo as codigoProducto',
            'pp.nombre as name',
            'pp.codigointernacional as codigointernacional',
            'pl.codigo as codigolinea',
            'pl.nombre as linea',
            'aip.cantidad as cantidad',
            'aip.lote as lote'
        )
        ->orderBy('pp.nombre','asc')
        ->get();
        
       return $productos; 
    }

    public function getTipo(){
        $tipos = DB::table('alm__tipo')->get();
         return $tipos;
    }
    /**
     * Display the specified resource.
     */
    public function show(Alm_AjusteNegativo $alm_AjusteNegativo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alm_AjusteNegativo $alm_AjusteNegativo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alm_AjusteNegativo $alm_AjusteNegativo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alm_AjusteNegativo $alm_AjusteNegativo)
    {
        //
    }
}
