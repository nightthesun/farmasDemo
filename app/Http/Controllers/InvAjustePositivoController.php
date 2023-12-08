<?php

namespace App\Http\Controllers;

use App\Models\Inv_AjustePositivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvAjustePositivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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

    /**
     * Display the specified resource.
     */
    public function show(Inv_AjustePositivo $inv_AjustePositivo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inv_AjustePositivo $inv_AjustePositivo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inv_AjustePositivo $inv_AjustePositivo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inv_AjustePositivo $inv_AjustePositivo)
    {
        //
    }

    public function listarProductoLineaIngreso()
    {
        $productos = DB::table('alm__ingreso_producto as aip')
    ->join('prod__productos as pp', 'aip.id_prod_producto', '=', 'pp.id')
    ->join('prod__dispensers as pd', 'pd.id', '=', 'pp.iddispenserprimario')
    ->join('prod__forma_farmaceuticas as ff', 'pp.idformafarmaceuticaprimario', '=', 'ff.id')
    ->join('prod__lineas as l', 'l.id', '=', 'pp.idlinea')
    ->join('alm__almacens as aa', 'aa.id', '=', 'aip.idalmacen')
    ->join('adm__sucursals as ass', 'ass.id', '=', 'aa.idsucursal')
    ->where('aip.stock_ingreso', '>', 0)
    ->select(
        'aip.id as id_ingreso',
        'aip.id_prod_producto as id_producto',
        'aip.lote as lote',
        'aip.cantidad as cantidad_ingreso',
        'aip.stock_ingreso as stock_ingreso',
        'aip.created_at as fecha_ingreso',
        'aip.fecha_vencimiento as fecha_vencimiento',
        'pp.nombre as nombre',
        'pp.codigo as codigo_producto',
        'pp.cantidadprimario as cantidad_dispenser_p',
        'l.nombre as nombre_linea',
        'pd.nombre as nombre_dispenser',
        'ff.nombre as nombre_farmaceutica'
    )
    ->get();

     return $productos;  
    }
}
