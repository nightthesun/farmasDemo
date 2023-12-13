<template>
    <main class="main">
        <!-- Breadcrumb -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Home</li>
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
      
        </ol>
        <div class="container-fluid">
            <!-- Ejemplo de tabla Listado -->
            <div class="card">
                <div class="card-header">
                    <i class="fa fa-align-justify"></i> Ajustes Negativos
                    <button type="button" class="btn btn-secondary" @click="abrirModal('registrar');ProductoLineaIngreso();" :disabled="sucursalSeleccionada==0" >
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                    <span v-if="sucursalSeleccionada==0" class="error">&nbsp; &nbsp;Debe Seleccionar una sucursal</span>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-2" style="text-align:center">
                            <label for="" >Sucursales Disponibles:</label>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <select class="form-control" @change="listarAjusteNegativos(0)" v-model="sucursalSeleccionada">
                                    <option value="0" disabled>Seleccionar...</option>
                                    <option v-for="sucursal in arraySucursal" :key="sucursal.id" :value="sucursal.id" v-bind:value="sucursal.razon_social" v-text="'Sucursal:'+sucursal.razon_social "></option>
                                </select>                              
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <input type="text" id="texto" name="texto" class="form-control" placeholder="Texto a buscar" v-model="buscar"  @keyup.enter="listarAjusteNegativos(1)">
                                <button type="submit" class="btn btn-primary" @click="listarAjusteNegativos(1)"><i class="fa fa-search" ></i> Buscar</button>
                            </div>
                        </div>
                    </div>


                    <!---codigo antiguo-->
                    <div class="form-group row">
                        <div class="col-md-8">
                            <div class="input-group">
                                <input type="text" id="texto" name="texto" class="form-control" placeholder="Texto a buscar" v-model="buscar" @keyup.enter="listarAjusteNegativos(1)">
                                <button type="submit" class="btn btn-primary" @click="listarAjusteNegativos(1)"><i class="fa fa-search" ></i> Buscar</button>
                            </div>
                            
                        </div>
                                <div class="col-md-4">
                                    
                                    <select name="" id="" v-model="sucursalSeleccionada" class="form-control" @change="listarAjusteNegativos(1)">
                                        <option v-bind:value="0" disabled>Buscar por local...</option>
                                        <option v-for="sucursal in arraySucursal" :key="sucursal.id" v-bind:value="sucursal.razon_social" v-text="'Sucursal:'+sucursal.razon_social " @key.enter="listarAjusteNegativos(1)"></option>
                                         <option v-bind:value="0">Restablecer...</option>
                                    </select>
                                </div>
                    </div>
              <!---------------------------------------------------------------->
                        <table class="table table-bordered table-striped table-sm table-responsive">
                        <thead>
                            <tr>
                                <th>Opciones</th>
                                <th>Usuario</th>
                                <th>Codigó</th>
                                <th>Linea</th>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Tipo</th>
                                <th>Descripción</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                            </tr>
                        </thead>

                        <tbody>
                         <!--botones de opciones-->   
                          <tr v-for="AjusteNegativos  in arrayAjusteNegativos" :key="AjusteNegativos.id">
                              <td>
                                 
                                 <button type="button" class="btn btn-warning btn-sm"  @click="abrirModal('actualizar',AjusteNegativos)">
                                    <i class="icon-pencil"></i>    
                                 </button> &nbsp;
                                 <button v-if="AjusteNegativos.activo==1" type="button" class="btn btn-danger btn-sm" @click="eliminarAjusteNegativos(AjusteNegativos.id)" >
                                     <i class="icon-trash"></i>
                                 </button>
                                 <button v-else type="button" class="btn btn-info btn-sm" @click="activarAjusteNegativos(AjusteNegativos.id)" >
                                     <i class="icon-check"></i>
                                 </button>
                              
                             </td>
                             <td v-text="AjusteNegativos.nombre_usuario"></td>
                             <td v-text="AjusteNegativos.codigo"></td>
                             <td v-text="AjusteNegativos.linea"></td>
                             <td v-text="AjusteNegativos.nombreProd"></td>
                             <td v-text="AjusteNegativos.cantidad"></td>
                             <td v-text="AjusteNegativos.nombreTipo"></td>
                             <td v-text="AjusteNegativos.descripcion"></td>
                             <td v-text="AjusteNegativos.fecha"></td>
                        
                             <td>
                                 <div v-if="AjusteNegativos.activo==1">
                                     <span class="badge badge-success">Activo</span>
                                 </div>
                                 <div v-else>
                                     <span class="badge badge-warning">Desactivado</span>
                                 </div>
                                 
                             </td>
                          
                                
                           </tr>
                        </tbody>
                    </table>      
           
                   <nav>
                        <ul class="pagination">
                            <li class="page-item" v-if="pagination.current_page > 1">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1)">Ant</a>
                            </li>
                            <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active':'']">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(page)" v-text="page"></a>
                            </li>
                            <li class="page-item" v-if="pagination.current_page< pagination.last_page">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1)">Sig</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
            <!-- Fin ejemplo de tabla Listado -->
        </div>
        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" role="dialog" arial-labelledby="myModalLabel" id="registrar" aria-hidden="true" data-backdrop="static" data-key="false">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h4 class="modal-title">{{ tituloModal }} </h4>
                    <button  type="button" class="close" aria-label="Close" @click="cerrarModal('registrar')">
                        <span aria-hidden="true">x</span>
                    </button>
                    
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning" role="alert">
                        Todos los campos con (*) son requeridos
                    </div>
                    <form action=""  class="form-horizontal">

                                    <!-- tab para los envases del producto -->
                                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="pills-envase-primario-tab" data-toggle="pill" href="#pills-envase-primario" role="tab" aria-controls="pills-home" aria-selected="true"  @click="cambiarPestana('pills-envase-primario-tab')">Envase Primario</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="pills-envase-secundario-tab" data-toggle="pill" href="#pills-envase-secundario" role="tab" aria-controls="pills-profile" aria-selected="false"  @click="cambiarPestana('pills-envase-secundario-tab')">Envase Secundario</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="pills-envase-terciario-tab" data-toggle="pill" href="#pills-envase-terciario" role="tab" aria-controls="pills-contact" aria-selected="false"  @click="cambiarPestana('pills-envase-terciario-tab')">Envase Terciario</a>
                                    </li>
                                </ul>

                        <!-- insertar datos -->
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-envase-primario" role="tabpanel" aria-labelledby="pills-envase-primario-tab">
                                <strong>Envase Primario:</strong>
                                <div class="container">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">
                                    Producto
                                    <span v-if="ProductoLineaIngreso=='0'"  class="error">(*)</span>
                                </label>
                                <div class="col-md-9">
                                    
                                    <select name="" id="" v-model="ProductoLineaIngresoSeleccionado" class="form-control" @change="cambioDeEstado">
                                        <option v-bind:value="0" disabled>Seleccionar...</option>
                                        <option v-for="ProductoLineaIngreso in arrayProductoLineaIngreso" :key="ProductoLineaIngreso.id_ingreso" v-bind:value="ProductoLineaIngreso.id_ingreso" v-text="ProductoLineaIngreso.nombre+'-'+ProductoLineaIngreso.cantidad_dispenser_p +'-'+ProductoLineaIngreso.nombre_farmaceutica+'-'+ProductoLineaIngreso.nombre_linea+'-LOTE:'+ProductoLineaIngreso.lote+'-FI:'+ProductoLineaIngreso.fecha_ingreso+'-FV:'+ProductoLineaIngreso.fecha_vencimiento+'-Stock:'+ProductoLineaIngreso.stock_ingreso"></option>
                                    </select>
                                    <input type="text" v-model="sucursalSeleccionada" hidden>
                                    <input type="number"  v-model="cantidadProductoLineaIngreso" hidden>
                                    <input type="text"  v-model="codigo" hidden>
                                    <input type="text"  v-model="linea" hidden>
                                    <input type="text"  v-model="producto" hidden>
                                    <input type="text"  v-model="fecha" hidden>
                                    <input type="text"  v-model="id_sucursal" hidden>
                                    <input type="text" v-model="id_producto" hidden>

                                 
                                     </div>
                            </div>
                                   <div class="form-group row">
                                      <label class="col-md-3 form-control-label" for="text-input">Cantidad 
                                        <span v-if="cantidadS==''" class="error">(*)</span>
                                      </label>
                                        <div class="col-md-9">
                                         <input type="number" id="cantidad" name="cantidad" v-model="cantidadS" class="form-control" placeholder="Datos de stock" v-on:focus="selectAll" >
                                           <span v-if="cantidadS==''" class="error">Debe Ingresar una cantidad</span> 
                                        </div>
                                  </div>   

                           <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">
                                    Tipo
                                    <span   class="error">(*)</span>
                                </label>
                                <div class="col-md-9">
                                    <select name="" id="" v-model="TiposSeleccionado" class="form-control">
                                        <option value="0" disabled>Seleccionar...</option>
                                        <option v-for="Tipos in arrayTipos" :key="arrayTipos.id" :value="Tipos.id" v-text="Tipos.nombre"></option>
                                    </select>
                                    <span v-if="TiposSeleccionado==0" class="error">Debe seleccionar una opcion</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                      <label class="col-md-3 form-control-label" for="text-input">Descripción
                                        <span v-if="descripcion" class="error">(*)</span>
                                      </label>
                                        <div class="col-md-9">
                                            <textarea v-model="descripcion" class="form-control" id="descripcion" name="descripcion" rows="3" v-on:focus="selectAll"></textarea>
                                            <span v-if="descripcion===''" class="error">Debe Ingresar la Descripción</span>
                                      </div>
                                  </div> 
                            
                        </div>    
                            </div>
                            <div class="tab-pane fade" id="pills-envase-secundario" role="tabpanel" aria-labelledby="ppills-envase-secundario">
                                <strong>Envase Secundario:</strong>

                                <div class="container">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">
                                    Producto
                                    <span v-if="ProductoLineaIngreso=='0'"  class="error">(*)</span>
                                </label>
                                <div class="col-md-9">
                                    
                                    <select name="" id="" v-model="ProductoLineaIngresoSeleccionado" class="form-control" @change="cambioDeEstado">
                                        <option v-bind:value="0" disabled>Seleccionar...</option>
                                        <option v-for="ProductoLineaIngreso in arrayProductoLineaIngreso" :key="ProductoLineaIngreso.id_ingreso" v-bind:value="ProductoLineaIngreso.id_ingreso" v-text="ProductoLineaIngreso.nombre+'-'+ProductoLineaIngreso.cantidad_dispenser_p +'-'+ProductoLineaIngreso.nombre_farmaceutica+'-'+ProductoLineaIngreso.nombre_linea+'-LOTE:'+ProductoLineaIngreso.lote+'-FI:'+ProductoLineaIngreso.fecha_ingreso+'-FV:'+ProductoLineaIngreso.fecha_vencimiento+'-Stock:'+ProductoLineaIngreso.stock_ingreso"></option>
                                    </select>
                                    <input type="text" v-model="sucursalSeleccionada" hidden>
                                    <input type="number"  v-model="cantidadProductoLineaIngreso" hidden>
                                    <input type="text"  v-model="codigo" hidden>
                                    <input type="text"  v-model="linea" hidden>
                                    <input type="text"  v-model="producto" hidden>
                                    <input type="text"  v-model="fecha" hidden>
                                    <input type="text"  v-model="id_sucursal" hidden>
                                    <input type="text" v-model="id_producto" hidden>
                                   
                                 
                                     </div>
                            </div>
                                   <div class="form-group row">
                                      <label class="col-md-3 form-control-label" for="text-input">Cantidad 
                                        <span v-if="cantidadS==''" class="error">(*)</span>
                                      </label>
                                        <div class="col-md-9">
                                         <input type="number" id="cantidad" name="cantidad" v-model="cantidadS" class="form-control" placeholder="Datos de stock" v-on:focus="selectAll" >
                                           <span v-if="cantidadS==''" class="error">Debe Ingresar una cantidad</span> 
                                        </div>
                                  </div>   

                           <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">
                                    Tipo
                                    <span   class="error">(*)</span>
                                </label>
                                <div class="col-md-9">
                                    <select name="" id="" v-model="TiposSeleccionado" class="form-control">
                                        <option value="0" disabled>Seleccionar...</option>
                                        <option v-for="Tipos in arrayTipos" :key="arrayTipos.id" :value="Tipos.id" v-text="Tipos.nombre"></option>
                                    </select>
                                    <span v-if="TiposSeleccionado==0" class="error">Debe seleccionar una opcion</span>
                                </div>
                            </div>
                            <div class="form-group row">
                                      <label class="col-md-3 form-control-label" for="text-input">Descripción
                                        <span v-if="descripcion" class="error">(*)</span>
                                      </label>
                                        <div class="col-md-9">
                                            <textarea v-model="descripcion" class="form-control" id="descripcion" name="descripcion" rows="3" v-on:focus="selectAll"></textarea>
                                            <span v-if="descripcion===''" class="error">Debe Ingresar la Descripción</span>
                                      </div>
                                  </div> 
                            
                        </div>  
                                      
                            </div>
                            <div class="tab-pane fade " id="pills-envase-terciario" role="tabpanel" aria-labelledby="pills-envase-terciario">
                                <strong>Envase Terciario:</strong>
                                      
                            </div>
                        </div>        
 
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal('registrar')">Cerrar</button>
                    <button type="button" v-if="tipoAccion==1" class="btn btn-primary" @click="registrorAjusteNegativo()" :disabled="!sicompleto" >Guardar</button>
                    <button type="button" v-if="tipoAccion==2" class="btn btn-primary" @click="actualizarAjusteNegativo()">Actualizar</button>
                   
                    
                </div>
                </div>
                
            </div>
        </div>
        <!--fin del modal-->
    </main>
</template>

<script>
    import Swal from 'sweetalert2';
    import { error401 } from '../../errores';
     //Vue.use(VeeValidate);
     export default{
        data(){
            return{
                pagination:{
                    'total' :0,
                    'current_page':0,
                    'per_page':0,
                    'last_page':0,
                    'from':0,
                    'to':0
                },
                pestañaActiva: 'pills-envase-primario-tab',
    
     

                iniTab:0,
                tab1:1,
                tab2:2,
                tab3:3,
                tituloModal:'',
                arrayTipos:[],
                TiposSeleccionado:0,
                id_tipo:'',
                arrayProductoLineaIngreso:[],
                ProductoLineaIngresoSeleccionado:0,
                ProductoLineaIngresoSeleccionadoDos:0,
                ProductoLineaIngresoSeleccionadoTres:0,
                id_producto_linea:'',
                cantidadS:'',
                listarTipo:0,
                cantidadProductoLineaIngreso:'',
                descripcion:'',
                codigo:'',
                linea:'',
                producto:'',
                fecha:'',
                
                id_producto:'',
                arrayAjusteNegativos:[],
     
                buscar:'',
                idAjusteNegativos:0,
                offset:3,
                tipoAccion:1,
                id_sucursal:'',
                arraySucursal:[],
                sucursalSeleccionada:0,
                sucuralName:'',
                sucursalId:0,

             

            }
        },
    
      watch:{
        ProductoLineaIngresoSeleccionado:function(newValue){
            if (newValue > 0 ) {
               if (this.tipoAccion === 1) {
                this.cantidadS=0;
               } 
               console.log("++++"+this.arrayProductoLineaIngreso);
            let productoSeleccionado=this.arrayProductoLineaIngreso.find(element=>element.id_ingreso === newValue);
         console.log("***"+productoSeleccionado);
            if (productoSeleccionado) {
           this.cantidadProductoLineaIngreso=productoSeleccionado.stock_ingreso;
          this.codigo=productoSeleccionado.codigo_producto;
         this.linea=productoSeleccionado.nombre_linea;
         this.producto=productoSeleccionado.nombre;
        this.fecha=productoSeleccionado.fecha_ingreso;
         this.id_sucursal=productoSeleccionado.id_sucursal;
         this.id_producto=productoSeleccionado.id_producto;       
                } else {
    console.log("No matching element found in arrayProductoLineaIngreso.");
        }
            } else {
                this.cantidadS ='';
            }
         
        },
        

        cantidadS: function (valor) {
            if (valor > this.cantidadProductoLineaIngreso) {
                if (this.tipoAccion === 1) {
                this.cantidadS=0;
               } 
               
                Swal.fire(
                      'No puede ingresar un número mayor al stock actual',
                        'Haga click en Ok',
                        'error'
                )
                console.log("No se puede ingresar datos mayor que el stock actual");
            } else if (valor !== this.cantidadProductoLineaIngreso) {
                this.cantidadS = valor;
            }
        },
        buscar: function (valor){
            if (this.buscar !== '') {
              this.sucursalSeleccionada='';
            } 
        }
     
      },

       computed:{
           sicompleto(){
            let me=this;
            if (me.descripcion!='' && me.TiposSeleccionado!='' && me.cantidadS!='' && me.ProductoLineaIngresoSeleccionado)
                return true;
               else 
                return false;    
            
           },
           isActived:function(){
                return this.pagination.current_page;
            },
           
            pagesNumber:function(){
                if(!this.pagination.to){
                    return[];
                }
                var from = this.pagination.current_page - this.offset;
                if(from<1){
                    from=1;
                }
                var to = from +(this.offset * 2);
                if(to>= this.pagination.last_page){
                    to=this.pagination.last_page;
                }
                var pagesArray =[];
                while(from<=to){
                    pagesArray.push(from);
                    from++
                }
                return pagesArray;
            }, 
           
           
        },
      
       methods :{
        cambiarPestana(idPestana) {
      this.pestañaActiva = idPestana;
    
      // Agrega aquí la lógica adicional que necesites al cambiar la pestaña
    },
        sucursalFiltro(){

               let me=this;
                var url='/ajustes-negativo/listarSucursal';
                axios.get(url).then(function(response){
                    var respuesta=response.data;
                    me.arraySucursal=respuesta;
                    console.log( me.arraySucursal);
                })
                .catch(function(error){
                    error401(error);
                    console.log(error);
                });
            },
        
        
        ajustesNegativos(){
                let me=this;
                var url='/ajustes-negativo/listarTipo';
                axios.get(url).then(function(response){
                    var respuesta=response.data;
                    me.arrayTipos=respuesta;
                    console.log( me.arrayTipos);
                })
                .catch(function(error){
                    error401(error);
                    console.log(error);
                });
            },
          
            cambiodeEstado(valor){
                 let me=this;
                 const productoSeleccionado = me.arrayProductoLineaIngreso.find(element => element.id == this.ProductoLineaIngresoSeleccionado);
      

              }  ,
          
                
          ProductoLineaIngreso(){
                let me=this;
                console.log("   -  "+me.pestañaActiva);
                var url='/ajustes-negativo/listarProductoLineaIngreso?respuesta1=' +this.sucursalSeleccionada;
                console.log(url);
                axios.get(url).then(function(response){
                    var respuesta=response.data;
                    
                    me.arrayProductoLineaIngreso=respuesta;
        
                    console.log( me.arrayProductoLineaIngreso);
                })
                .catch(function(error){
                    error401(error);
                    console.log(error);
                });
            },
            ProductoLineaIngresoDos(){
                let me=this;
              
                var url='/ajustes-negativo/listarProductoLineaIngreso?respuesta1=' +this.sucursalSeleccionada;
                console.log(url);
                axios.get(url).then(function(response){
                    var respuesta=response.data;
                    
                    me.arrayProductoLineaIngreso=respuesta;
        
                    console.log( me.arrayProductoLineaIngreso);
                })
                .catch(function(error){
                    error401(error);
                    console.log(error);
                });
            },

        cambiarPagina(page){
               let me =this;
              me.pagination.current_page = page;
               me.listarAjusteNegativos(page);
           },


        abrirModal(accion,data= []){
            let me=this;
            let respuesta=me.arraySucursal.find(element=>element.id==me.sucursalSeleccionada);
              
            switch(accion){
                    case 'registrar':
                    {
                        me.tituloModal='Rejistro para Ajuste de negativos en la sucursal: '+respuesta.razon_social;
                        me.ProductoLineaIngresoSeleccionado=0;
                       
                        me.cantidadProductoLineaIngreso=''; 
                        me.TiposSeleccionado=0; 
                        me.cambiodeEstado='';
                        me.tipoAccion=1;
                        me.codigo='';
                        me.linea='';
                        me.producto='',
                        me.cantidadS='';
                        me.descripcion='';
                        me.fecha='';
                        me.id_sucursal='';
                        me.id_producto='';
                        me.classModal.openModal('registrar');
                        break;
                    }
                    case 'actualizar':
                        {   
                        me.tituloModal='Actualizacion Datos del Almacen';
                        me.TiposSeleccionado=data.id_tipo===null?0:data.id_tipo;
                        me.ProductoLineaIngresoSeleccionado=data.id_producto_linea===null?0:data.id_producto_linea;
                    
                        me.tipoAccion=2;
                        me.codigo=data.codigo;
                        me.linea=data.linea;
                        me.producto=data.nombreProd,
                        me.cantidadS=0;
                        me.descripcion=data.descripcion;
                        me.fecha=data.fecha;
                        me.idAjusteNegativos=data.id;
                        me.id_sucursal=data.id_sucursal;
                        me.id_producto=data.id_producto;
                        me.classModal.openModal('registrar');
                            break;
                        }
                 

                }
                
            },
            cerrarModal(accion){
                let me = this;
                me.classModal.closeModal(accion);
                me.ProductoLineaIngresoSeleccionado=0;
                me.TiposSeleccionado=0; 
                me.tipoAccion=1;
                        me.codigo='';
                        me.linea='';
                        me.producto='',
                        me.cantidadS='';
                        me.descripcion='';
                        me.fecha='';
                        me.id_sucursal='';
                      
                        me.id_producto='';
                           
            },
        
            registrorAjusteNegativo(){
                let me =  this;
                console.log(me.TiposSeleccionado+" "+me.ProductoLineaIngresoSeleccionado+" "+me.codigo+" "+me.linea+" "+
                me.producto+" "+me.cantidadProductoLineaIngreso+" "+me.id_sucursal);
                let suma = me.cantidadProductoLineaIngreso-me.cantidadS
                console.log(suma);
                if (me.codigo === "" || me.linea  === "" || me.producto ===  "" || me.cantidadS === "" || me.TiposSeleccionado === "" || me.descripcion === "" || me.fecha === "" ) {
                    Swal.fire(
                        'No puede ingresar valor nulos  o vacios',
                        'Haga click en Ok',
                        'warning'
                    )    
                }
                else {
                    axios.post('/ajustes-negativo/registrar',{
                   'id_tipo':me.TiposSeleccionado,
                   'id_producto_linea':me.ProductoLineaIngresoSeleccionado,
                   'codigo':me.codigo,
                   'linea':me.linea,
                   'producto':me.producto,
                   'cantidad':suma,
                   'descripcion':me.descripcion,
                   'fecha':me.fecha,
                   'activo':1,
                   'id_sucursal':me.id_sucursal,
                  
                   'id_producto':me.id_producto,
                 
            }).then(function(response){
                    me.cerrarModal('registrar');
                    Swal.fire(
                        'Ajuste de negativos Registrado exitosamente',
                        'Haga click en Ok',
                        'success'
                    )
                    
                 me.listarAjusteNegativos();
                 me.sucursalFiltro();
                }).catch(function(error){
                    error401(error);
                    console.log(error);
                });      
                }
            },
            actualizarAjusteNegativo(){
                let me =this;
                let suma = me.cantidadProductoLineaIngreso-me.cantidadS
                axios.put('/ajustes-negativo/actualizar',{
                    'id': me.idAjusteNegativos,
                   'id_tipo':me.TiposSeleccionado,
                   'id_producto_linea':me.ProductoLineaIngresoSeleccionado,
                  'codigo':me.codigo,
                   'linea':me.linea,
                  'producto':me.producto,
                  'cantidad':me.suma,
                   'descripcion':me.descripcion,
                  'fecha':me.fecha,                  
                  'id_sucursal':me.id_sucursal,
               
                  'id_producto':me.id_producto,
                
                }).then(function (response) {
                    me.listarAjusteNegativos();
                 me.sucursalFiltro();
                    Swal.fire(
                        'Actualizado Correctamente!',
                        'El registro a sido actualizado Correctamente',
                        'success'
                    )
                }).catch(function (error) {
                    error401(error);
                });
                me.cerrarModal('registrar'); 
            },
            //para listar db alm__ajuste_negativos
            listarAjusteNegativos(page){
               let me=this;
             
               if (me.sucursalSeleccionada==0 ) {
                
                var url='/ajustes-negativo?page='+page+'&buscar='+me.buscar;
                
                me.sucursalSeleccionada=0;
               }else{
                
                var url='/ajustes-negativo?page='+page+'&buscar='+me.sucursalSeleccionada;
                me.buscar='';
               }
              
               axios.get(url)
               .then(function(response){
                    var respuesta =  response.data;
                    me.pagination = respuesta.pagination;
                    me.arrayAjusteNegativos = respuesta.query_ajuste_negativos.data;
               }).catch(function (error) {
                    error401(error);
               });             
            },

            eliminarAjusteNegativos(idAjusteNegativos){
                let me=this;
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                title: 'Esta Seguro de Desactivar?',
                text: "Es una eliminacion logica",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, Desactivar',
                cancelButtonText: 'No, Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                     axios.put('/ajustes-negativo/desactivar',{
                        'id': idAjusteNegativos
                    }).then(function (response) {
                        me.listarAjusteNegativos();
                        swalWithBootstrapButtons.fire(
                            'Desactivado!',
                            'El registro a sido desactivado Correctamente',
                            'success'
                        )
                        me.listarAjusteNegativos();
                        
                    }).catch(function (error) {
                        error401(error);
                        console.log(error);
                    });
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    /* swalWithBootstrapButtons.fire(
                    'Cancelado!',
                    'El Registro no fue desactivado',
                    'error'
                    ) */
                }
                })
            },
            
            activarAjusteNegativos(idAjusteNegativos){
                let me=this;
                const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
                })
                swalWithBootstrapButtons.fire({
                title: 'Esta Seguro de Activar?',
                text: "Es una Activacion logica",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si, Activar',
                cancelButtonText: 'No, Cancelar',
                reverseButtons: true
                }).then((result) => {
                if (result.isConfirmed) {
                     axios.put('/ajustes-negativo/activar',{
                        'id': idAjusteNegativos
                    }).then(function (response) {
                        me.listarAjusteNegativos();
                        swalWithBootstrapButtons.fire(
                            'Activado!',
                            'El registro a sido Activado Correctamente',
                            'success'
                        )
                    }).catch(function (error) {
                        error401(error);
                        console.log(error);
                    });
                    
                    
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    /* swalWithBootstrapButtons.fire(
                    'Cancelado!',
                    'El Registro no fue Activado',
                    'error'
                    ) */
                }
                })
            },
            selectAll: function (event) {
                setTimeout(function () {
                    event.target.select()
                }, 0)
            },

       },
  
       mounted() {
        this.classModal = new _pl.Modals();
        this.classModal.addModal('registrar');
        this.listarAjusteNegativos(1);
        this.ajustesNegativos();
        this.ProductoLineaIngreso();
        this.ProductoLineaIngresoDos();
        this.cambiodeEstado();
        this.sucursalFiltro();
       
        
       }
     }
</script>
<style scoped>
.error{
    color: red;
    font-size: 10px;  
}
</style>