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
                                or aan.cod like '%".$valor."%' 
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
                        or aan.cod like '%".$valor."%' 
                       )";
                    }
    
                }
                    $query_ajuste_positivos = DB::table('inv__ajuste_positivos as aan')
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
                        'aan.activo as activo',
                        'aan.cod as cod',
                        'aan.id_ingreso as id_ingreso')
                        ->whereRaw($sqls)
                        ->paginate(15);
                        
            }
      
            return 
            [
                    'pagination'=>
                        [
                            'total'         =>    $query_ajuste_positivos->total(),
                            'current_page'  =>    $query_ajuste_positivos->currentPage(),
                            'per_page'      =>    $query_ajuste_positivos->perPage(),
                            'last_page'     =>    $query_ajuste_positivos->lastPage(),
                            'from'          =>    $query_ajuste_positivos->firstItem(),
                            'to'            =>    $query_ajuste_positivos->lastItem(),
                        ] ,
                    'query_ajuste_positivos'=>$query_ajuste_positivos,
            ];
        }else {

            $query_ajuste_positivos = DB::table('inv__ajuste_positivos as aan')
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
            'aan.activo as activo',
            'aan.cod as cod',
            'aan.id_ingreso as id_ingreso')
            //->whereraw($sqls)
            ->paginate(15);
            return [
                    'pagination'=>[
                        'total'         =>    $query_ajuste_positivos->total(),
                        'current_page'  =>    $query_ajuste_positivos->currentPage(),
                        'per_page'      =>    $query_ajuste_positivos->perPage(),
                        'last_page'     =>    $query_ajuste_positivos->lastPage(),
                        'from'          =>    $query_ajuste_positivos->firstItem(),
                        'to'            =>    $query_ajuste_positivos->lastItem(),
                    ] ,
                    'query_ajuste_positivos'=>$query_ajuste_positivos,
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

    public function listarProductoLineaIngreso(Request $request)
    {
        $cod = $request->query('respuesta0');
     
      $productos = DB::table('prod__productos as pp')
      ->join('alm__ingreso_producto as ai', 'pp.id', '=', 'ai.id_prod_producto')
      ->join('prod__lineas as pl', 'pl.id', '=', 'pp.idlinea')
      ->leftJoin('prod__dispensers as pd_1', 'pd_1.id', '=', 'pp.iddispenserprimario')
      ->leftJoin('prod__dispensers as pd_2', 'pd_2.id', '=', 'pp.iddispensersecundario')
      ->leftJoin('prod__dispensers as pd_3', 'pd_3.id', '=', 'pp.iddispenserterciario')
      ->leftJoin('prod__forma_farmaceuticas as ff_1', 'ff_1.id', '=', 'pp.idformafarmaceuticaprimario')
      ->leftJoin('prod__forma_farmaceuticas as ff_2', 'ff_2.id', '=', 'pp.idformafarmaceuticasecundario')
      ->leftJoin('prod__forma_farmaceuticas as ff_3', 'ff_3.id', '=', 'pp.idformafarmaceuticaterciario')
      ->join('alm__almacens as aa', 'aa.id', '=', 'ai.idalmacen')
      ->join('adm__sucursals as ass', 'ass.id', '=', 'aa.idsucursal')
      ->join('prod__lineas as l', 'l.id', '=', 'pp.idlinea')
      ->where('ai.stock_ingreso', '>', 0)
      ->where('aa.codigo', $cod) 
      ->select(
        'aa.codigo as cod',
        'ai.id as id_ingreso',
        'ai.id_prod_producto as id_producto',
        'ai.lote as lote',
        'ai.stock_ingreso as stock_ingreso',
        'ai.cantidad as cantidad_ingreso',
        'ai.created_at as fecha_ingreso',
        'ai.fecha_vencimiento as fecha_vencimiento',
        'pp.nombre as nombre',
        'pp.codigo as codigo_producto',
        'pp.cantidadprimario as cantidad_dispenser_p',
        'pp.cantidadsecundario as cantidad_dispenser_s',
        'pp.cantidadterciario as cantidad_dispenser_t',
        'l.nombre as nombre_linea',
        'pd_1.nombre as nombre_dispenser_1',
        'pd_2.nombre as nombre_dispenser_2',
        'pd_3.nombre as nombre_dispenser_3',
        'ff_1.nombre as nombre_farmaceutica_1',
        'ff_2.nombre as nombre_farmaceutica_2',
        'ff_3.nombre as nombre_farmaceutica_3',
        'ass.id AS id_sucursal',
        'ass.razon_social as razon_social',
        DB::raw('null as id_tienda'),
        'ai.idalmacen as id_almacen'
    );

  $tiendas = DB::table('prod__productos as pp')
  ->join('tda__ingreso_productos as ti', 'pp.id', '=', 'ti.id_prod_producto')
  ->join('prod__lineas as pl', 'pl.id', '=', 'pp.idlinea')
  ->leftJoin('prod__dispensers as pd_1', 'pd_1.id', '=', 'pp.iddispenserprimario')
  ->leftJoin('prod__dispensers as pd_2', 'pd_2.id', '=', 'pp.iddispensersecundario')
  ->leftJoin('prod__dispensers as pd_3', 'pd_3.id', '=', 'pp.iddispenserterciario')
  ->leftJoin('prod__forma_farmaceuticas as ff_1', 'ff_1.id', '=', 'pp.idformafarmaceuticaprimario')
  ->leftJoin('prod__forma_farmaceuticas as ff_2', 'ff_2.id', '=', 'pp.idformafarmaceuticasecundario')
  ->leftJoin('prod__forma_farmaceuticas as ff_3', 'ff_3.id', '=', 'pp.idformafarmaceuticaterciario')
  ->join('adm__sucursals as ass', 'ass.id', '=', 'ti.idtienda')
  ->join('prod__lineas as l', 'l.id', '=', 'pp.idlinea')
  ->join('tda__tiendas as tt', 'tt.id', '=', 'ti.idtienda')
      ->where('ti.stock_ingreso', '>', 0)
      ->where('tt.codigo', $cod) 
      ->select(
        'tt.codigo as cod',
        'ti.id as id_ingreso',
        'ti.id_prod_producto as id_producto',
        'ti.lote as lote',
        'ti.stock_ingreso as stock_ingreso',
        'ti.cantidad as cantidad_ingreso',
        'ti.created_at as fecha_ingreso',
        'ti.fecha_vencimiento as fecha_vencimiento',
        'pp.nombre as nombre',
        'pp.codigo as codigo_producto',
        'pp.cantidadprimario as cantidad_dispenser_p',
        'pp.cantidadsecundario as cantidad_dispenser_s',
        'pp.cantidadterciario as cantidad_dispenser_t',
        'l.nombre as nombre_linea',
        'pd_1.nombre as nombre_dispenser_1',
        'pd_2.nombre as nombre_dispenser_2',
        'pd_3.nombre as nombre_dispenser_3',
        'ff_1.nombre as nombre_farmaceutica_1',
        'ff_2.nombre as nombre_farmaceutica_2',
        'ff_3.nombre as nombre_farmaceutica_3',
        'ass.id AS id_sucursal',
        'ass.razon_social as razon_social',
        'ti.idtienda as id_tienda',
        DB::raw('null as id_almacen')
      );

  $result = $productos->unionAll($tiendas)->get();

  return $result;
    }
    public function listarSucursal(){
     
 
       $tiendas = DB::table('tda__tiendas')
       ->select('tda__tiendas.id as id_tienda', DB::raw('null as id_almacen'), 'tda__tiendas.codigo', 'adm__sucursals.razon_social', 'adm__sucursals.razon_social as sucursal', DB::raw('"Almacen" as tipoCodigo'))
       ->join('adm__sucursals', 'tda__tiendas.idsucursal', '=', 'adm__sucursals.id');
   
   $almacenes = DB::table('alm__almacens as aa')
       ->join('adm__sucursals as ass', 'ass.id', '=', 'aa.idsucursal')
       ->select(DB::raw('null as id_tienda'), 'aa.id as id_almacen', 'aa.codigo', 'aa.nombre_almacen as razon_social', 'ass.razon_social as sucursal', DB::raw('"Tienda" as tipoCodigo'));
   
   $result = $tiendas->unionAll($almacenes)->get();
   
   
           $jsonSucrusal = [];
   
   foreach ($result as $key=>$sucursal) {
       $elemento = [
           'id' => $key,
           'id_tienda' => $sucursal->id_tienda,
           'id_almacen' => $sucursal->id_almacen,
           'codigo' => $sucursal->codigo,
           'razon_social' => $sucursal->razon_social,
           'sucursal' => $sucursal->sucursal,
           'tipoCodigo' =>$sucursal->tipoCodigo,
       ];
   
       $jsonSucrusal[] = $elemento;
   }

       return $jsonSucrusal;
     
     }
     public function listarTipo(){
        $productoTipo = DB::table('prod__tipo_entradas')
        ->select(DB::raw('MIN(id) as id'), 'nombre')
        ->whereNotIn('id', [13])
        ->groupBy('nombre')
        ->get();
        return $productoTipo;
    }
}
