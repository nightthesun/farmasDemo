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
    public function index(Request $request)
    {
    
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
        dd($request);
        exit;
        $letracodigo='ALM';
        $maxcorrelativo = Alm_Almacen::select(DB::raw('max(correlativo) as maximo'))
                                      ->get()->toArray();
        $correlativo=$maxcorrelativo[0]['maximo'];
        if(is_null($correlativo))
            $correlativo=1;
        else
            $correlativo=$correlativo+1;

        if($correlativo<10)
            $codigo='00'.$correlativo;
        else
            if($correlativo<100)
                $codigo='0'.$correlativo;
                
        
        $codigo=$letracodigo.$codigo;
        $ajusteNegativo=new Alm_AjusteNegativo();
        $ajusteNegativo->id_usuario = auth()->user()->id;
        $ajusteNegativo->usuario = auth()->user()->name;
        $ajusteNegativo->codigo=$request->codigo;
        $ajusteNegativo->linea=$request->liena;
        $ajusteNegativo->producto=$request->producto;
        $ajusteNegativo->cantidad=$request->cantidad;
        $ajusteNegativo->tipo=$request->tipo;
        $ajusteNegativo->descripcion=$request->descripcion;
        $ajusteNegativo->fecha=$request->estado;
        $ajusteNegativo->activado=$request->activado;
        $ajusteNegativo->save();
      
    }



    public function listarProductoLineaIngreso(){
        $productos = DB::table('prod__productos as pp')
                ->join('prod__lineas as pl', 'pp.idlinea', '=', 'pl.id')
                ->join('alm__ingreso_producto as aip', 'aip.id_prod_producto', '=', 'pp.id')
                ->join('alm__almacens as aa', 'aa.id', '=', 'aip.idalmacen')
                ->join('adm__sucursals as ass', 'ass.id', '=', 'aa.idsucursal')
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
                'aip.fecha_vencimiento as fecha_vencimiento',
                'aa.codigo as codigoAlmacen',
                'aa.id as id_almacen',
                'ass.id as id_sucursal',
                'ass.nombre_comercial as nombreSucursal'    
                )
        ->orderBy('pp.nombre','asc')
        ->get();
        
       return $productos; 
    }

    public function listarTipo(){
        $productoTipo = DB::table('prod__tipo_entradas')
        ->select(DB::raw('MIN(id) as id'), 'nombre')
        ->whereNotIn('id', [13])
        ->groupBy('nombre')
        ->get();
        return $productoTipo;
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
