<!DOCTYPE html>
<html lang="es">
<head>
  </head>
	<div class="panel-body" >
		<div class="row"> 
			<input type="hidden" class="form-control input-sm" id="idMaterial" value="6">
            <div class="col-md-12">
                <ul class="nav nav-tabs nav-tabs-custom m-b-15">
                  	<li class="active">
                    	<a href="#tab-recepcion_dispositivo" role="tab" data-toggle="tab" aria-expanded="true" onClick="cargaCbo('Recepcion')">
                      	<i class="zmdi zmdi-assignment-check"></i> RECEPCI&Oacute;N</a>
                  	</li>
               
                </ul>
                <div class="tab-content">
                  	<div role="tabpanel" class="tab-pane fade active in" id="tab-recepcion_dispositivo">
                    	<div class="row">
                      		<div class="col-md-5 col-sm-5">
                        		<div class="panel panel-default panel-table m-b-0">
                          			<div class="panel-heading">
                            			<h4 class="text-center text-danger font-12" id="titleProceso"><strong>RECEPCI&Oacute;N DE DISPOSITIVOS</strong></h4>
                          			</div>
                          			<div class="panel-body">
	                            		<div class="row">
		                              		<!-- <div class="col-lg-1"></div> -->
		                              		<div class="col-lg-12">
		                                		<form class="form-horizontal" id="sign_addRecepcionDispositivo" method="POST" autocomplete="off" action="javascript:void(0);">
				                                  	<input class="form-control" type="hidden" id="txtIDUsuario" name="txtIDUsuario">
				                                  	<input class="form-control" type="hidden" id="txtIdEtapaRecepcion" name="txtIdEtapaRecepcion" value="1">
				                                  	<input class="form-control" type="hidden" id="txtValidacionRecepcion" name="txtValidacionRecepcion" value="1">
				                                  	<input class="form-control" type="hidden" id="txtIdProecso" name="txtIdProecso">
								                  	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">FASE</label>
									                    <div class="col-sm-8 z-8">
									                      	<select class="form-control" name="cbofaseRecepcion" id="cbofaseRecepcion" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboSoltecDispositivo('Recepcion')" required>
									                      		<option value="">[ SELECCIONE UNA FASE ]</option>
	                                          					<option value="1">SUFRAGIO</option>
                            								</select>
									                    </div>
								                 	</div>

								                 	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">SOLUCI&Oacute;N TECNOL&Oacute;G.</label>
									                    <div class="col-sm-8 z-7">
									                      	<select class="form-control" name="cbosoltecRecepcion" id="cbosoltecRecepcion" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboOdpeDispositivo('Recepcion');" required>
									                      		<option value="">[ SELECCIONE UNA SOL. TECN. ]</option>
									                      		
                            								</select>
									                    </div>
								                 	</div>

								                 	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">ODPE</label>
									                    <div class="col-sm-8 z-6">
									                      	<select class="form-control" name="cboodpeRecepcion" id="cboodpeRecepcion" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboDepartamentoDispositivo('Recepcion');" required>
									                      		<option value="">[ SELECCIONE UNA ODPE ]</option>
                            								</select>
									                    </div>
								                 	</div>

								                 	<div id="divAgrupacionRecepcion">
								                 		<!-- <input class="form-control" type="text" id="txtdata" name="txtdata" value=""> -->
									                 	<div class="form-group form-group-sm">
										                    <label class="col-sm-4 control-label" for="form-control-1">AGRUP.  POLITICA</label>
										                    <div class="col-sm-8 z-5">
										                      	<select class="form-control" name="cboagrupacionRecepcion" id="cboagrupacionRecepcion" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboAgrupacionDispositivo('Recepcion');" required>
										                      		<option value="">[ SELECCIONE UNA AGRUP. POLITICA ]</option>
	                            								</select>
										                    </div>
									                 	</div>
									                 </div>

								                 	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">DEPARTAMENTO</label>
									                    <div class="col-sm-8 z-4">
									                      	<select class="form-control" name="cbodepartRecepcion" id="cbodepartRecepcion" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboProvinciaDispositivo('Recepcion');" required>
									                      		<option value="">[ SELECCIONE UN DEPARTAMENTO ]</option>
                            								</select>
									                    </div>
								                 	</div>

								                 	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">PROVINCIA</label>
									                    <div class="col-sm-8 z-3">
									                      	<select class="form-control" name="cboprovRecepcion" id="cboprovRecepcion" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboDistritoDispositivo('Recepcion')" required>
									                      		<option value="">[ SELECCIONE UNA PROVINCIA ]</option>
                            								</select>
									                    </div>
								                 	</div>
		                                      		
		                                      		<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">DISTRITO</label>
									                    <div class="col-sm-8 z-2">
									                      	<select class="form-control" name="cbodistRecepcion" id="cbodistRecepcion" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="setTipoDispositivo('Recepcion')" required>
									                      		<option value="">[ SELECCIONE UN DISTRITO ]</option>
                            								</select>
									                    </div>
								                 	</div>

								                  	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-14">C&Oacute;DIGO</label>
									                    <div class="col-sm-8">
									                      <input id="rotuloRecepcion" name="rotuloRecepcion" class="form-control" type="text" placeholder="C&oacute;digo de Barras del R&oacute;tulo" style="text-transform: uppercase;" disabled onKeyPress="inpRotulo('Recepcion');">
									                    </div>
								                  	</div>
													<!--<input type="hidden" id="idConsultaRecepcion">-->
								                  	<div class="form-group form-group-sm">
					                                    <div class="col-sm-12 text-right">
					                                      	<button class="btn bg-success btn-sm" id="btnResetInputRecepcion" type="button" style="display: none;" onclick="resetInput('Recepcion')"><i class="zmdi zmdi-minus-circle-outline zmdi-hc-fw m-r-5"></i><span> LIMPIAR</span></button>
					                                      	<a class="btn bg-danger btn-sm" href="#modal_incidencia"  id="btnIncidRecepcion"  data-toggle="modal" style="display: none;" onClick="modalIncidencia('Recepcion',1)"><i class="zmdi zmdi-info-outline zmdi-hc-fw m-r-5"></i><span> INCIDENCIA</span></a>
					                                    </div>
					                              	</div>


					                              	<!-- <div class="col-sm-offset-1 col-sm-10 text-center" id="msjRecepcionCedula"></div> -->
		                                   			<div  class="col-sm-offset-1 col-sm-11 text-center m-t-20">            
									                  	<div id="msj_Recepcion"></div> 
									              	</div>
		                                		</form>
		                              		</div>
		                              		<!-- <div class="col-lg-1"></div> -->
	                            		</div>
                          			</div>
                        		</div>
                      		</div>

                      		<div class="col-md-7 col-sm-7">
                        		<div class="panel panel-default panel-table m-b-0">
                          			<div class="panel-heading">
                            			<h4 class="text-center text-danger font-12"><strong>AVANCE GENERAL DE RECEPCI&Oacute;N</strong></h4>
                          			</div>
		                          	<div class="panel-body">
		                          		<h4 class="">AVANCE GENERAL POR FASE</h4>
		                            	<div class="table-responsive">
		                              		<div id="tbl_actaAvanceFaseRecepcion" class="dataTables_wrapper form-inline" role="grid">
		                              			FASE: <span id="nomFaseRecepcion"></span><br>
		                          				MATERIAL ELECTORAL: <span id="nomMaterialDisp"></span><br><br>
		                                  		<table id="tbl_dispositivoRecepcionAvanceFase" class="display table table-bordered table-hover" cellspacing="0" width="100%">
		                                        	<thead class="text-center font-table">
												        <tr class="text-primary">
												            <th class="text-center" width="20%">TOTAL MESAS</th>
												            <th class="text-center" width="20%">RECIBIDAS</th>
												            <th class="text-center" width="20%">POR RECIBIR</th>
												            <th class="text-center" width="20%">% RECIBIDOS</th>
												            <th class="text-center" width="20%">% POR RECIBIR</th>
												        </tr>
												    </thead>
												    <tbody>
												        <tr class="text-center font-table">
												            <td>0</td>
												            <td>0</td>
												            <td>0</td>
												            <td>0 %</td>
												            <td>0 %</td>
												        </tr>
												    </tbody>                     
		                                  		</table>
		                              		</div>
		                            	</div>

		                            	<h4 class="">AVANCE GENERAL POR ODPE</h4>
		                            	<div class="table-responsive">
		                            		<div class="clearfix">
			                                    <div class="pull-right">
			                                       <a class="btn btn-black btn-sm" data-dismiss="modal" id="recibidoRecepcion" data-toggle="modal" onclick=""><i class="zmdi zmdi-view-compact zmdi-hc-fw m-r-5"></i><span> RECIBIDOS</span></a>
			                                       <a class="btn btn-purple btn-sm" data-dismiss="modal" id="faltanteRecepcion" data-toggle="modal" onclick=""><i class="zmdi zmdi-view-dashboard zmdi-hc-fw m-r-5"></i><span> FALTANTES</span></a>
			                                       <span id="divAvanceAgrupRecepcion" style="display: none">
			                                       		<a class="btn btn-success btn-sm" data-dismiss="modal" id="agrupacionRecepcion" data-toggle="modal" onclick=""><i class="zmdi zmdi-view-dashboard zmdi-hc-fw m-r-5"></i><span> POR AGRUPACION</span></a>
			                                       </span>
			                                    </div>
			                                </div>
		                              		<div id="tbl_actaAvanceOdpeRecepcion" class="dataTables_wrapper form-inline" role="grid">
		                              			ODPE: <span id="nomOdpeRecepcion"></span><br><br>
		                                  		<table id="tbl_dispositivoRecepcionAvanceOdpe" class="display table table-bordered table-hover" cellspacing="0" width="100%">
		                                        	<thead class="text-center font-table">
												        <tr class="text-primary">
												            <th class="text-center" width="15%">SOL. TEC.</th>
												            <th class="text-center" width="17%">TOTAL DISPOSITIVOS</th>
												            <th class="text-center" width="17%">RECIBIDAS</th>
												            <th class="text-center" width="17%">POR RECIBIR</th>
												            <th class="text-center" width="17%">% RECIBIDOS</th>
												            <th class="text-center" width="17%">% POR RECIBIR</th>
												        </tr>
												    </thead>
												    <tbody>
												        <!--<tr class="text-center font-table">
												            <td>--</td>
												            <td>0</td>
												            <td>0</td>
												            <td>0</td>
												            <td>% 0</td>
												            <td>% 0</td>
												        </tr>-->
												    </tbody>                     
		                                  		</table>
		                              		</div>
		                            	</div>
		                          	</div>
                        		</div>
                      		</div>
                    	</div>
                  	</div>
                 
                </div>
              </div>
            </div>
  	</div>

  	<!-- Modal SOLUCION -->
    <div class="modal fade" id="modal_incidencia" role="dialog" data-keyboard="false" data-backdrop="static" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
              	<div class="modal-header">
              		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  		<span aria-hidden="true">
                    		<i class="zmdi zmdi-close"></i>
                  		</span>
                	</button>
                	<h4 class="modal-title text-center text-primary" id="titleIncidencia"></h4>
              	</div>
              	<div class="modal-body">
                	<div class="col-lg-1"></div>
                	<div class="col-lg-10">
                  		<form class="form-horizontal" id="sign_registerIncidencia" method="POST" autocomplete="off" >
                    		<input class="form-control" type="hidden" id="txtIDIncidencia" name="txtIDIncidencia">
                    		<input class="form-control" type="hidden" id="txtcontrolIncidencia" name="txtcontrolIncidencia" value="0">
                    		<div class="panel">
                      			<div class="panel-body">
                        			<div class="row">
                          				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            				<div class="form-group">
                              					<label>NRO MESA</label>
                              					<input type="text" class="form-control vld" name="txtMesaIncidencia" id="txtMesaIncidencia" required/>
                            				</div>
                          				</div>                      
                          				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"> 
                          					<div class="form-group">
										        <label>INCIDENCIA</label>           
										        <select class="form-control" name="cboIncidencia" id="cboIncidencia" data-dropup-auto="false" data-size="6" data-live-search="true" required>
										            	<option value="">[ SELECCIONE UNA INCIDENCIA ]</option>
	                            				</select>
	                            				<span id="errorincidencia" class="font-error"></span>
								            </div>
								            
								        </div>                
                        			</div>
			                        <div class="row clearfix m-t-30">
			                          	<div class="pull-right">
			                            	<button type="button" class="btn btn-outline-primary" id="agregarIncidencia"><i class="zmdi zmdi-check zmdi-hc-fw m-r-5"></i><span>Guardar</span></button>
			                            	<a class="btn btn-outline-danger" data-dismiss="modal" id="cancelIncidencia" onclick="cancelIncidencia()"><i class="zmdi zmdi-close zmdi-hc-fw m-r-5"></i><span>Cerrar</span></a>
			                          	</div>
			                        </div>
			                        <div class="row m-t-20">
			                        	<div class="form-group form-group-sm">
	                               			<div  class="col-sm-12 text-center">            
							                  	<div id="msj_Incidencia"></div> 
							              	</div>
										</div>
									</div>
                      			</div>
                    		</div>
                  		</form>
                	</div>
                	<div class="col-lg-1"></div>
              	</div>
              	<div class="modal-footer"></div>
            </div>
        </div>
    </div>

    <!-- Modal RESUEMEN MESAS ESCANEADAS-->
    <div class="modal fade" id="modal_resumenEscaneadas" role="dialog" data-keyboard="false" data-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
              	<div class="modal-header">
              		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  		<span aria-hidden="true">
                    		<i class="zmdi zmdi-close"></i>
                  		</span>
                	</button>
                	<h3 class="modal-title text-center text-primary" id="titleMaterialResumen1"></h3>
					<h4 class="modal-title text-center text-primary" id="titleResumen1"></h4>
              	</div>
              	<div class="modal-body">
              		<div class="col-md-12 col-sm-12">
                		<div class="table-responsive">
		                    <div id="tbl_actaMesas1" class="dataTables_wrapper form-inline" role="grid">
		                    	ODPE: <span id="nomOdpeEscaneadas"></span><br><br>
		                    	<table id="tableMesas1" class="display table table-bordered table-hover" cellspacing="0" width="100%">
		                    		<thead class="text-center font-table">
                                        <tr class="bg-primary">
                                            <th class="text-center" width="5%">N??</th>
                                            <th class="text-center" width="10%">SOL. TEC.</th>
                                            <th class="text-center" width="20%">DEPARTAMENTO</th>
                                            <th class="text-center" width="20%">PROVINCIA</th>
                                            <th class="text-center" width="20%">DISTRITO</th>
                                            <th class="text-center" width="10%">NRO. MESA</th>
                                            <th class="text-center" width="10%">NRO ELECTORES </th>
                                            <th class="text-center" width="10%">DISPOSITIVO</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center font-table">
                                          
                                    </tbody>
		                        </table>
		                    </div>
		                </div>
		        	</div>
              	</div>
              	<div class="modal-footer">
              		<button type="button" class="btn btn-danger m-t-30" data-dismiss="modal">Cerrar</button>
              	</div>
            </div>
        </div>
    </div>


    <!-- Modal RESUEMEN MESAS FALTANTES-->
    <div class="modal fade" id="modal_resumenFaltantes" role="dialog" data-keyboard="false" data-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
              	<div class="modal-header">
              		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  		<span aria-hidden="true">
                    		<i class="zmdi zmdi-close"></i>
                  		</span>
                	</button>
                	<h3 class="modal-title text-center text-primary" id="titleMaterialResumen2"></h3>
					<h4 class="modal-title text-center text-primary" id="titleResumen2"></h4>
              	</div>
              	<div class="modal-body">
              		<div class="col-md-12 col-sm-12">
                		<div class="table-responsive">
		                    <div id="tbl_actaMesas2" class="dataTables_wrapper form-inline" role="grid">
		                    	ODPE: <span id="nomOdpeFaltantes"></span><br><br>
		                    	<table id="tableMesas2" class="display table table-bordered table-hover" cellspacing="0" width="100%">
		                    		<thead class="text-center font-table">
                                        <tr class="bg-primary">
                                            <th class="text-center" width="5%">N??</th>
                                            <th class="text-center" width="10%">SOL. TEC.</th>
                                            <th class="text-center" width="20%">DEPARTAMENTO</th>
                                            <th class="text-center" width="20%">PROVINCIA</th>
                                            <th class="text-center" width="20%">DISTRITO</th>
                                            <th class="text-center" width="10%">NRO. MESA</th>
                                            <th class="text-center" width="10%">NRO ELECTORES </th>
                                            <th class="text-center" width="10%">DISPOSITIVO</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-center font-table">
                                          
                                    </tbody>
		                        </table>
		                    </div>
		                </div>
		        	</div>
              	</div>
              	<div class="modal-footer">
              		<button type="button" class="btn btn-danger m-t-30" data-dismiss="modal">Cerrar</button>
              	</div>
            </div>
        </div>
    </div>



        <!-- Modal RESUMEN AGRUPACION-->
    <div class="modal fade" id="modal_resumenAgrupacion" role="dialog" data-keyboard="false" data-backdrop="static" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
              	<div class="modal-header">
              		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  		<span aria-hidden="true">
                    		<i class="zmdi zmdi-close"></i>
                  		</span>
                	</button>
                	<h3 class="modal-title text-center text-primary" id="titleMaterialResumen2"></h3>
					<h4 class="modal-title text-center text-primary" id="titleResumen2"><b>AVANCE GENERAL POR AGRUPACION POLITICA</b></h4>
              	</div>
              	<div class="modal-body">
              		<div class="col-md-12 col-sm-12">
                		<div class="table-responsive">
                			
                			<div class="table-responsive">
                				<div id="tbl_dispositivoAvanceAgrupacion" class="dataTables_wrapper form-inline" role="grid">
                					
                				</div>
                			</div>

		                </div>
		        	</div>
              	</div>
              	<div class="modal-footer">
              		<button type="button" class="btn btn-danger m-t-30" data-dismiss="modal">Cerrar</button>
              	</div>
            </div>
        </div>
    </div>

<script src="<?= media();?>/functions/<?= $data['page_function_js'] ?>"></script>
<!--<script type="text/javascript" src="js/control_cedula.js"></script>-->
</html>