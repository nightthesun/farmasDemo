<?php

namespace App\Http\Controllers;

use App\Models\Inv_AjusteNegativo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvAjusteNegativoController extends Controller
{
            /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       
        $buscararray=array();
       
        if(!empty($request->buscar))
        {
            $buscararray = explode(" ",$request->buscar);
            $valor=sizeof($buscararray);
            if($valor > 0){
                $sqls='';
                
                foreach($buscararray as $valor)
                {
                    if(empty($sqls)){
                        $sqls="(
                                aan.codigo like '%".$valor."%' 
                                or aan.linea like '%".$valor."%' 
                                or aan.producto like '%".$valor."%'
                                or pte.nombre like '%".$valor."%' 
                                or aan.descripcion like '%".$valor."%'
                                or ass.razon_social like '%".$valor."%'
                               )";
                    }
                    else
                    {
                        $sqls.="and (aan.codigo like '%".$valor."%' 
                        or aan.linea like '%".$valor."%' 
                        or aan.producto like '%".$valor."%' 
                        or pte.nombre like '%".$valor."%' 
                        or aan.descripcion like '%".$valor."%'
                        or ass.razon_social like '%".$valor."%'
                       )";
                    }
    
                }
                    $query_ajuste_negativos = DB::table('inv__ajuste_negativos as aan')
                        ->join('prod__tipo_entradas as pte', 'aan.id_tipo', '=', 'pte.id')
                        ->join('adm__sucursals as ass', 'aan.id_sucursal', '=', 'ass.id')
                        ->select('aan.id as id',
                        'aan.id_producto_linea as id_producto_linea',
                        'aan.usuario as nombre_usuario',
                        'aan.producto as nombreProd',
                        'aan.codigo as codigo',
                        'aan.linea as linea',
                        'aan.descripcion as descripcion',
                        'aan.cantidad as cantidad',
                        'aan.id_tipo as id_tipo',
                        'pte.nombre as nombreTipo',
                        'aan.fecha as fecha',
                       
                        'aan.id_sucursal as id_sucursal',
                        'ass.razon_social as razon_social',
                        'aan.created_at as fecha_creacion',
                        'aan.activo as activo')
                        ->whereRaw($sqls)
                        ->paginate(15);
                        
            }
      
            return 
            [
                    'pagination'=>
                        [
                            'total'         =>    $query_ajuste_negativos->total(),
                            'current_page'  =>    $query_ajuste_negativos->currentPage(),
                            'per_page'      =>    $query_ajuste_negativos->perPage(),
                            'last_page'     =>    $query_ajuste_negativos->lastPage(),
                            'from'          =>    $query_ajuste_negativos->firstItem(),
                            'to'            =>    $query_ajuste_negativos->lastItem(),
                        ] ,
                    'query_ajuste_negativos'=>$query_ajuste_negativos,
            ];
        }else {

            $query_ajuste_negativos = DB::table('inv__ajuste_negativos as aan')
            ->join('prod__tipo_entradas as pte', 'aan.id_tipo', '=', 'pte.id')
            ->join('adm__sucursals as ass', 'aan.id_sucursal', '=', 'ass.id')
            ->select('aan.id as id',
            'aan.id_producto_linea as id_producto_linea',
            'aan.id_tipo as id_tipo',
            'aan.usuario as nombre_usuario',
            'aan.producto as nombreProd',
            'aan.codigo as codigo',
            'aan.linea as linea',
            'aan.descripcion as descripcion',
            'aan.cantidad as cantidad',
            'pte.nombre as nombreTipo',
            
            'aan.fecha as fecha',
            'aan.id_sucursal as id_sucursal',
            'ass.razon_social as razon_social',
            'aan.created_at as fecha_creacion',
            'aan.activo as activo')
            //->whereraw($sqls)
            ->paginate(15);
            return [
                    'pagination'=>[
                        'total'         =>    $query_ajuste_negativos->total(),
                        'current_page'  =>    $query_ajuste_negativos->currentPage(),
                        'per_page'      =>    $query_ajuste_negativos->perPage(),
                        'last_page'     =>    $query_ajuste_negativos->lastPage(),
                        'from'          =>    $query_ajuste_negativos->firstItem(),
                        'to'            =>    $query_ajuste_negativos->lastItem(),
                    ] ,
                    'query_ajuste_negativos'=>$query_ajuste_negativos,
               ];
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
    /**
 * @method POST
 */
    public function store(Request $request)
    {
        $ajusteNegativo=new Inv_AjusteNegativo();
        $ajusteNegativo->id_usuario = auth()->user()->id;
        $ajusteNegativo->usuario = auth()->user()->name;
        $ajusteNegativo->id_tipo=$request->id_tipo;
        $ajusteNegativo->id_producto_linea=$request->id_producto_linea;
        $ajusteNegativo->codigo=$request->codigo;
        $ajusteNegativo->linea=$request->linea;
        $ajusteNegativo->producto=$request->producto;
        $ajusteNegativo->cantidad=$request->cantidad;
        $ajusteNegativo->descripcion=$request->descripcion;
        $ajusteNegativo->fecha=$request->fecha;
        $ajusteNegativo->activo=$request->activo;
        $ajusteNegativo->id_sucursal=$request->id_sucursal;
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

    public function listarSucursal(){
       
        $sucursales = DB::table('inv__ajuste_negativos as aan')
        ->join('adm__sucursals as ass', 'aan.id_sucursal', '=', 'ass.id')
        ->select('aan.id_sucursal', 'ass.razon_social')
        ->distinct('ass.id')
        // ->orderBy('pp.nombre', 'asc')
        ->get();
    
    return $sucursales;
    
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
    public function show(Inv_AjusteNegativo $alm_AjusteNegativo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Inv_AjusteNegativo $alm_AjusteNegativo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Inv_AjusteNegativo $alm_AjusteNegativo)
    {
        
        $updateAjusteNegativo=Inv_AjusteNegativo::find($request->id);
        $updateAjusteNegativo->id_usuario_modifica= auth()->user()->id;
        $updateAjusteNegativo->id_tipo=$request->id_tipo;
       $updateAjusteNegativo->linea=$request->id_producto_linea;
       $updateAjusteNegativo->codigo=$request->codigo;
        $updateAjusteNegativo->linea=$request->linea;
        $updateAjusteNegativo->producto=$request->producto;
        $updateAjusteNegativo->cantidad=$request->cantidad;
       
        $updateAjusteNegativo->descripcion=$request->descripcion;
        $updateAjusteNegativo->fecha=$request->fecha;
        $updateAjusteNegativo->id_sucursal=$request->id_sucursal;
       
        $updateAjusteNegativo->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Inv_AjusteNegativo $alm_AjusteNegativo)
    {
        //
    }
    public function desactivar(Request $request){
        $updateAjusteNegativo = Inv_AjusteNegativo::findOrFail($request->id);
        $updateAjusteNegativo->activo=0;
        $updateAjusteNegativo->id_usuario_modifica= auth()->user()->id;
        $updateAjusteNegativo->save();
    }
    public function activar(Request $request){
        $updateAjusteNegativo = Inv_AjusteNegativo::findOrFail($request->id);
        $updateAjusteNegativo->activo=1;
        $updateAjusteNegativo->id_usuario_modifica= auth()->user()->id;
        $updateAjusteNegativo->save();
    }
}
