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
                    <button type="button" class="btn btn-secondary" @click="abrirModal('registrar')" >
                        <i class="icon-plus"></i>&nbsp;Nuevo
                    </button>
                </div>
                <div class="card-body">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" id="texto" name="texto" class="form-control" placeholder="Texto a buscar">
                                <button type="submit" class="btn btn-primary" @click="listarAjusteNegativos(1)"><i class="fa fa-search" ></i> Buscar</button>
                           
                                    
                            </div>
                        </div>
                    </div>
          
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
                            <div v-if="AjusteNegativos">
                                <td>
                                    <h4>sdadas</h4>
                                    <button type="button" class="btn btn-warning btn-sm"  @click="abrirModal('actualizar',ajusteNegaticos)">
                                       <i class="icon-pencil"></i>    
                                    </button> &nbsp;
                                    <button v-if="ajusteNegaticos.activo==1" type="button" class="btn btn-danger btn-sm" @click="eliminarAjusteNegaticos(ajusteNegaticos.id)" >
                                        <i class="icon-trash"></i>
                                    </button>
                                    <button v-else type="button" class="btn btn-info btn-sm" @click="activarAjusteNegaticos(ajusteNegaticos.id)" >
                                        <i class="icon-check"></i>
                                    </button>
                                </td>
                                <td v-text="ajusteNegaticos.nombre_usuario"></td>
                                <td v-text="ajusteNegaticos.codigo"></td>
                                <td v-text="ajusteNegaticos.linea"></td>
                                <td v-text="ajusteNegaticos.nombreProd"></td>
                                <td v-text="ajusteNegaticos.cantidad"></td>
                                <td v-text="ajusteNegaticos.nombreTipo"></td>
                                <td v-text="ajusteNegaticos.descripcion"></td>
                                <td v-text="ajusteNegaticos.fecha"></td>
                                <td v-if="ajusteNegaticos.activo=1">
                                    <span> class="badge "></span>
                                </td>
                                <td v-else=""></td>
                            </div>
                            <div v-else="">
                                <h4 style="text-align: center;"> Sin datos...</h4>
                            </div>
                            
                           </tr>
                        </tbody>
                    </table>
                    <nav>
                        <ul class="pagination">
                            <li class="page-item">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1)">Ant</a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1)">Ant</a>
                            </li>
                            <li class="page-item">
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
                    <h4 class="modal-title">{{ tituloModal }}</h4>
                    <button  type="button" class="close" aria-label="Close" @click="cerrarModal('registrar')">
                        <span aria-hidden="true">x</span>
                    </button>
                    
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning" role="alert">
                        Todos los campos con (*) son requeridos
                    </div>
                    <form action=""  class="form-horizontal">
                        <!-- insertar datos -->
                        <div class="container">
                            <div class="form-group row">
                                <label class="col-md-3 form-control-label" for="text-input">
                                    Producto
                                    <span v-if="ProductoLineaIngreso=='0'"  class="error">(*)</span>
                                </label>
                                <div class="col-md-9">
                                    
                                    <select name="" id="" v-model="ProductoLineaIngresoSeleccionado" class="form-control" @change="cambioDeEstado">
                                        <option v-bind:value="0" disabled>Seleccionar...</option>
                                        <option v-for="ProductoLineaIngreso in arrayProductoLineaIngreso" :key="ProductoLineaIngreso.id" v-bind:value="ProductoLineaIngreso.id" v-text="'cod:'+ProductoLineaIngreso.codigoProducto+' Nom:'+ProductoLineaIngreso.name +' codInTer:'+ProductoLineaIngreso.codigointernacional+' Lote:'+ProductoLineaIngreso.lote+' FIng:'+ProductoLineaIngreso.fechaIngreso+' Suc:'+ProductoLineaIngreso.nombreSucursal+' Stock:'+ProductoLineaIngreso.cantidad"></option>
                                    </select>
                                    <input type="number"  v-model="cantidadProductoLineaIngreso" hidden>
                                    <input type="text"  v-model="codigo" hidden>
                                    <input type="text"  v-model="linea" hidden>
                                    <input type="text"  v-model="producto" hidden>
                                    <input type="text"  v-model="fecha" hidden>
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
                       
                    </form>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" @click="cerrarModal('registrar')">Cerrar</button>
                    <button type="button"  class="btn btn-primary" @click="registrorAjusteNegativo()" >Guardar</button>
                    <button type="button" class="btn btn-primary" >Actualizar</button>
                   
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
                tituloModal:'',
                arrayTipos:[],
                TiposSeleccionado:0,
                arrayProductoLineaIngreso:[],
                ProductoLineaIngresoSeleccionado:0,
                cantidadS:'',
                listarTipo:0,
                cantidadProductoLineaIngreso:'',
                descripcion:'',
                codigo:'',
                linea:'',
                producto:'',
                fecha:'',
                arrayAjusteNegativos:[],
            }
        },
      watch:{
        ProductoLineaIngresoSeleccionado:function(newValue){
            if (newValue > 0 ) {
               
                this.cantidadS=0;
            let productoSeleccionado=this.arrayProductoLineaIngreso.find(element=>element.id === newValue);
          if (productoSeleccionado) {
            this.cantidadProductoLineaIngreso=productoSeleccionado.cantidad;
             this.codigo=productoSeleccionado.codigoProducto;
           this.linea=productoSeleccionado.linea;
          this.producto=productoSeleccionado.name;
          this.fecha=productoSeleccionado.fechaIngreso;
            console.log( productoSeleccionado.cantidad);
                } else {
    console.log("No matching element found in arrayProductoLineaIngreso.");
        }
            } else {
                this.cantidadS ='';
            }
         
        },
        

        cantidadS: function (valor) {
            if (valor > this.cantidadProductoLineaIngreso) {
                this.cantidadS = 0;
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
            return this.pagination.currrent_page;
           },
           /** 
            pagesNumber:function(){
            if(!this.pagination.to){
                return[];
            }
            var from = this.pagination.current_page - this.offset;
            if(from>1){
                from=1;
            }
            var to = from +(this.offset * 2);
            if (to >= this.pagination.last_page) {
                to=this.pagination.last_page;
            }
            var pagesArray =[];
            while(from<=to){
                pagesArray.push(from);
                from++;
            }
            return pagesArray;
           },  
           */
           
        },
      
       methods :{
        
        
        
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
                var url='/ajustes-negativo/listarProductoLineaIngreso';
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
      //  cambiarPagina(page){
      //          let me =this;
      //          me.pagination.current_page = page;
      //          me.listarAlmacenes(page);
      //      },


        abrirModal(accion,data= []){
            let me=this;
                switch(accion){
                    case 'registrar':
                    {
                        me.tituloModal='Ajuste de negativos'
                        me.ProductoLineaIngreso=0;   
                        me.TiposSeleccionado=0; 
                        me.cambiodeEstado='';
                        me.codigo='';
                        me.linea='';
                        me.producto='',
                        me.cantidadS='';
                        me.descripcion='';
                        me.fecha='';
                        me.classModal.openModal('registrar');
                        break;
                    }
                    case 'actualizar':
                        {
                            me.classModal.openModal('registrar');
                        }
                 

                }
                
            },
            cerrarModal(accion){
                let me = this;
                me.classModal.closeModal(accion);
                me.ProductoLineaIngreso=0;   
                me.TiposSeleccionado=0; 
                me.cambiodeEstado='';
                me.codigo='';
                me.linea='';
                me.producto='',
                me.cantidadS='';
                me.descripcion='';
                me.fecha='';
                           
            },
        
            registrorAjusteNegativo(){
                let me =  this;
                if (me.codigo === "" || me.linea  === "" || me.producto ===  "" || me.cantidadS === "" || me.TiposSeleccionado === "" || me.descripcion === "" || me.fecha === ""  ) {
                    Swal.fire(
                        'No puede ingresar valor nulos  o vacios',
                        'Haga click en Ok',
                        'warning'
                    )    
                }
                else {
                    axios.post('/ajustes-negativo/registrar',{
                   'codigo':me.codigo,
                   'linea':me.linea,
                   'producto':me.producto,
                   'cantidad':me.cantidadS,
                   'tipo':me.TiposSeleccionado,
                   'descripcion':me.descripcion,
                   'fecha':me.fecha,
                   'activo':1,
                  
            }).then(function(response){
                    me.cerrarModal('registrar');
                    Swal.fire(
                        'Ajuste de negativos Registrado exitosamente',
                        'Haga click en Ok',
                        'success'
                    )
                }).catch(function(error){
                    error401(error);
                    console.log(error);
                });      
                }
            },
            //para listar db alm__ajuste_negativos
            listarAjusteNegativos(page){
               let me=this;
               var url='/ajustes-negativo?page='+page+'&buscar='+me.buscar;
               axios.get(url)
               .then(function(response){
                    var respuesta =  response.data;
                    me.pagination = respuesta.pagination;
                    me.arrayAjusteNegaticos = respuesta.query_ajuste_negativos.data;
               }).catch(function (error) {
                    error401(error);
               });             
            }

       },
  
       mounted() {
        this.classModal = new _pl.Modals();
        this.classModal.addModal('registrar');
        this.ajustesNegativos();
        this.ProductoLineaIngreso();
        this.cambiodeEstado();
        
       }
     }
</script>
<style scoped>
.error{
    color: red;
    font-size: 10px;  
}
</style>