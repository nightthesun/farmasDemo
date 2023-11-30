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
        $buscararray=array();
        if (!empty($request->buscar)) {
            $buscararray = explode(" ",$request->buscar);
            $valor=sizeof($buscararray);
                if ($valor > 0) {
                    $sql='';
                    foreach($buscararray as $valor)
                    {
                        if(empty($sqls)){
                          $sqls="
                          select aan.id as id, aan.producto as nombreProd, aan.descripcion as descripcion ,aan.usuario as nombre_usuario, aan.codigo as codigo, aan.linea as linea, aan.cantidad as cantidad,pte.nombre as nombreTipo,aan.fecha as fecha,aan.estado as estado,aan.created_at as fecha_creacion, aan.activo as activo
                          from alm__ajuste_negativos aan 
                          join prod__tipo_entradas pte on aan.tipo=pte.id"      
                        }
                    }
                }
        }
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
        $ajusteNegativo=new Alm_AjusteNegativo();
        $ajusteNegativo->id_usuario = auth()->user()->id;
        $ajusteNegativo->usuario = auth()->user()->name;
        $ajusteNegativo->codigo=$request->codigo;
        $ajusteNegativo->linea=$request->linea;
        $ajusteNegativo->producto=$request->producto;
        $ajusteNegativo->cantidad=$request->cantidad;
        $ajusteNegativo->tipo=$request->tipo;
        $ajusteNegativo->descripcion=$request->descripcion;
        $ajusteNegativo->fecha=$request->fecha;
        $ajusteNegativo->activo=$request->activo;
        $ajusteNegativo->estado=$request->estado;
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
