<!DOCTYPE html>
<html lang="es">
<head>
  </head>
	<div class="panel-body" >
		<div class="row"> 
			<input type="hidden" class="form-control input-sm" id="idMaterial" value="9">
            <div class="col-md-12">
                <ul class="nav nav-tabs nav-tabs-custom m-b-15">
                  	<li class="active">
                    	<a href="#tab-recepcion_reserva" role="tab" data-toggle="tab" aria-expanded="true" onClick="cargaCbo('Recepcion')">
                      	<i class="zmdi zmdi-assignment-check"></i> RECEPCI&Oacute;N</a>
                  	</li>
                  	<li class="">
                    	<a href="#tab-control_reserva" role="tab" data-toggle="tab" aria-expanded="false" onClick="cargaCbo('Control')">
                      	<i class="zmdi zmdi-tablet"></i> CONTROL DE CALIDAD</a>
                  	</li>
                  	<li class="">
                    	<a href="#tab-empaque_reserva" role="tab" data-toggle="tab" aria-expanded="false" onClick="cargaCbo('Empaque')">
                      	<i class="zmdi zmdi-view-module"></i> EMPAQUETADO</a>
                  	</li>
                </ul>
                <div class="tab-content">
                  	<div role="tabpanel" class="tab-pane fade active in" id="tab-recepcion_reserva">
                    	<div class="row">
                      		<div class="col-md-5 col-sm-5">
                        		<div class="panel panel-default panel-table m-b-0">
                          			<div class="panel-heading">
                            			<h4 class="text-center text-primary font-12" id="titleProceso"><strong>RECEPCI&Oacute;N DE C&Eacute;DULAS DE RESERVA</strong></h4>
                          			</div>
                          			<div class="panel-body">
	                            		<div class="row">
		                              		<!-- <div class="col-lg-1"></div> -->
		                              		<div class="col-lg-12">
		                                		<form class="form-horizontal" id="sign_addRecepcionReserva" method="POST" autocomplete="off" action="javascript:void(0);">
				                                  	<input class="form-control" type="hidden" id="txtIDUsuario" name="txtIDUsuario">
				                                  	<input class="form-control" type="hidden" id="txtIdEtapaRecepcion" name="txtIdEtapaRecepcion" value="1">
				                                  	<input class="form-control" type="hidden" id="txtValidacionRecepcion" name="txtValidacionRecepcion" value="1">
								                  	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">FASE</label>
									                    <div class="col-sm-8 z-8">
									                      	<select class="form-control" name="cbofaseRecepcion" id="cbofaseRecepcion" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboSoltecReserva('Recepcion');" required>
									                      		<option value="">[ SELECCIONE UNA FASE ]</option>
	                                          					<option value="1">SUFRAGIO</option>
                            								</select>
									                    </div>
								                 	</div>

								                 	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">SOLUCI&Oacute;N TECNOL&Oacute;G.</label>
									                    <div class="col-sm-8 z-7">
									                      	<select class="form-control" name="cbosoltecRecepcion" id="cbosoltecRecepcion" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboOdpeReserva('Recepcion');" required>
									                      		<option value="">[ SELECCIONE UNA SOL. TECN. ]</option>
                            								</select>
									                    </div>
								                 	</div>

								                 	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">ODPE</label>
									                    <div class="col-sm-8 z-6">
									                      	<select class="form-control" name="cboodpeRecepcion" id="cboodpeRecepcion" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboDepartamentoReserva('Recepcion');" required>
									                      		<option value="">[ SELECCIONE UNA ODPE ]</option>
                            								</select>
									                    </div>
								                 	</div>

								                 	<div id="divAgrupacionRecepcion">
								                 		<!-- <input class="form-control" type="text" id="txtdata" name="txtdata" value=""> -->
									                 	<div class="form-group form-group-sm">
										                    <label class="col-sm-4 control-label" for="form-control-1">AGRUP.  POLITICA</label>
										                    <div class="col-sm-8 z-6">
										                      	<select class="form-control" name="cboagrupacionRecepcion" id="cboagrupacionRecepcion" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboAgrupacionReserva('Recepcion');" required>
										                      		<option value="">[ SELECCIONE UNA AGRUP. POLITICA ]</option>
	                            								</select>
										                    </div>
									                 	</div>
									                 </div>

								                 	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">DEPARTAMENTO</label>
									                    <div class="col-sm-8 z-5">
									                      	<select class="form-control" name="cbodepartRecepcion" id="cbodepartRecepcion" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboProvinciaReserva('Recepcion');" required>
									                      		<option value="">[ SELECCIONE UN DEPARTAMENTO ]</option>
                            								</select>
									                    </div>
								                 	</div>

								                 	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">PROVINCIA</label>
									                    <div class="col-sm-8 z-4">
									                      	<select class="form-control" name="cboprovRecepcion" id="cboprovRecepcion" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboDistritoReserva('Recepcion')" required>
									                      		<option value="">[ SELECCIONE UNA PROVINCIA ]</option>
                            								</select>
									                    </div>
								                 	</div>
		                                      		
		                                      		<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">DISTRITO</label>
									                    <div class="col-sm-8 z-3">
									                      	<select class="form-control" name="cbodistRecepcion" id="cbodistRecepcion" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboConsultaReserva('Recepcion')" required>
									                      		<option value="">[ SELECCIONE UN DISTRITO ]</option>
                            								</select>
									                    </div>
								                 	</div>

								                 	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">TIPO DE C&Eacute;DULA</label>
									                    <div class="col-sm-8 z-2">
									                      	<select class="form-control" name="cboconsultaRecepcion" id="cboconsultaRecepcion" data-size="6" data-dropup-auto="false" data-live-search="true" onChange="selTipoReserva('Recepcion');" required>
									                      		<option value="">[ SELECCIONE TIPO DE C&Eacute;DULA ]</option>
                            								</select>
									                    </div>
								                 	</div>

								                 	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-14">UBIGEO</label>
									                    <div class="col-sm-8">
									                      <input id="ubigeoRecepcion" name="ubigeoRecepcion" class="form-control" type="text" placeholder="C&oacute;digo de Barras del Ubigeo" style="text-transform: uppercase;" disabled onKeyPress="inpUbigeo('Recepcion');">
									                    </div>
								                  	</div>

								                  	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-14">R&Oacute;TULO</label>
									                    <div class="col-sm-8">
									                      <input id="rotuloRecepcion" name="rotuloRecepcion" class="form-control" type="text" placeholder="C&oacute;digo de Barras del R&oacute;tulo" style="text-transform: uppercase;" disabled onKeyPress="inpRotulo('Recepcion');">
									                    </div>
								                  	</div>
													<input type="hidden" id="idConsultaRecepcion">
								                  	<div class="form-group form-group-sm">
					                                    <div class="col-sm-12 text-right">
					                                      	<button class="btn bg-success btn-sm" id="btnResetInputRecepcion" type="button" style="display: none;" onclick="resetInput('Recepcion')"><i class="zmdi zmdi-minus-circle-outline zmdi-hc-fw m-r-5"></i><span> LIMPIAR</span></button>
					                                      	<a class="btn bg-danger btn-sm" href="#modal_incidencia"  id="btnIncidRecepcion"  data-toggle="modal" style="display: none;"  onClick="modalIncidencia('Recepcion',1)"><i class="zmdi zmdi-primary-outline zmdi-hc-fw m-r-5"></i><span> INCIDENCIA</span></a>
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
                            			<h4 class="text-center text-primary font-12"><strong>AVANCE GENERAL DE RECEPCI&Oacute;N DE C&Eacute;DULAS DE RESERVA</strong></h4>
                          			</div>
		                          	<div class="panel-body">
		                          		<h4 class="">AVANCE GENERAL POR FASE</h4>
		                          		<div class="table-responsive">
		                          			<div class="pull-right">
			                                       <a class="btn btn-blue btn-sm" data-dismiss="modal" id="updateRecepcion"  onclick="cargaAvanceFase('Recepcion'); cargaAvanceOdpe('Recepcion')" disabled><i class="zmdi zmdi-refresh zmdi-hc-fw"></i><span></span></a>
			                                    </div>
		                          			<div id="tbl_reservaAvanceFaseRecepcion" class="dataTables_wrapper form-inline" role="grid">
		                          				FASE: <span id="nomFaseRecepcion"></span><br><br>
			                          			<table id="tbl_reservaRecepcionAvanceFase" class="display table table-bordered table-hover" cellspacing="0" width="100%">
			                          				<thead class="text-center font-table">
			                          					<tr class="text-primary">
			                          						<th class="text-center" width="15%"></th>
												            <th class="text-center" width="15%">RECIBIDAS</th>
												            
			                          					</tr>
			                          				</thead>
			                          				<tbody>
			                          					<tr class="text-center font-table">
			                          						<td>PAQUETES</td>
			                          						<td>0</td>
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
			                                       <!--<a class="btn btn-purple btn-sm" data-dismiss="modal" id="faltanteRecepcion" data-toggle="modal" onclick=""><i class="zmdi zmdi-view-dashboard zmdi-hc-fw m-r-5"></i><span> FALTANTES</span></a>-->
			                                    </div>
			                                </div>
		                              		<div id="tbl_reservaAvanceOdpeRecepcion" class="dataTables_wrapper form-inline" role="grid">
		                              			ODPE: <span id="nomOdpeRecepcion"></span><br><br>
		                                  		<table id="tbl_reservaRecepcionAvanceOdpe" class="display table table-bordered table-hover" cellspacing="0" width="100%">
		                                        	<thead class="text-center font-table">
												        <tr class="text-primary">
												            <th class="text-center" width="14%">SOL. TEC.</th>
												            <th class="text-center" width="14%">TOTAL PAQUETES</th>
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
                 
                  	<div role="tabpanel" class="tab-pane fade" id="tab-control_reserva"> 
                    	<div class="row">
                      		<div class="col-md-5 col-sm-5">
                        		<div class="panel panel-default panel-table m-b-0">
                          			<div class="panel-heading">
                            			<h4 class="text-center text-primary font-12" id="titleControl"><strong>CONTROL DE CALIDAD DE C&Eacute;DULAS DE RESERVA</strong></h4>
                          			</div>
                          			<div class="panel-body">
	                            		<div class="row">
		                              		<!-- <div class="col-lg-1"></div> -->
		                              		<div class="col-lg-12">
		                                		<form class="form-horizontal" id="sign_addControlReserva" method="POST" autocomplete="off" action="javascript:void(0);">
				                                  	<input class="form-control" type="hidden" id="txtIDUsuario" name="txtIDUsuario">
				                                  	<input class="form-control" type="hidden" id="txtIdEtapaControl" name="txtIdEtapaControl" value="2">
				                                  	<input class="form-control" type="hidden" id="txtValidacionControl" name="txtValidacionControl" value="1">
								                  	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">FASE</label>
									                    <div class="col-sm-8 z-8">
									                      	<select class="form-control" name="cbofaseControl" id="cbofaseControl" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboSoltecReserva('Control');" required>
									                      		<option value="">[ SELECCIONE UNA FASE ]</option>
	                                          					<option value="1">SUFRAGIO</option>
                            								</select>
									                    </div>
								                 	</div>

								                 	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">SOLUCI&Oacute;N TECNOL&Oacute;G.</label>
									                    <div class="col-sm-8 z-7">
									                      	<select class="form-control" name="cbosoltecControl" id="cbosoltecControl" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboOdpeReserva('Control');" required>
									                      		<option value="">[ SELECCIONE UNA SOL. TECN. ]</option>
                            								</select>
									                    </div>
								                 	</div>

								                 	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">ODPE</label>
									                    <div class="col-sm-8 z-6">
									                      	<select class="form-control" name="cboodpeControl" id="cboodpeControl" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboDepartamentoReserva('Control');" required>
									                      		<option value="">[ SELECCIONE UNA ODPE ]</option>
                            								</select>
									                    </div>
								                 	</div>

								                 	<div id="divAgrupacionControl">
								                 		<!-- <input class="form-control" type="text" id="txtdata" name="txtdata" value=""> -->
									                 	<div class="form-group form-group-sm">
										                    <label class="col-sm-4 control-label" for="form-control-1">AGRUP.  POLITICA</label>
										                    <div class="col-sm-8 z-6">
										                      	<select class="form-control" name="cboagrupacionControl" id="cboagrupacionControl" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboAgrupacionReserva('Control');" required>
										                      		<option value="">[ SELECCIONE UNA AGRUP. POLITICA ]</option>
	                            								</select>
										                    </div>
									                 	</div>
									                </div>

								                 	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">DEPARTAMENTO</label>
									                    <div class="col-sm-8 z-5">
									                      	<select class="form-control" name="cbodepartControl" id="cbodepartControl" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboProvinciaReserva('Control');" required>
									                      		<option value="">[ SELECCIONE UN DEPARTAMENTO ]</option>
                            								</select>
									                    </div>
								                 	</div>

								                 	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">PROVINCIA</label>
									                    <div class="col-sm-8 z-4">
									                      	<select class="form-control" name="cboprovControl" id="cboprovControl" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboDistritoReserva('Control')" required>
									                      		<option value="">[ SELECCIONE UNA PROVINCIA ]</option>
                            								</select>
									                    </div>
								                 	</div>
		                                      		
		                                      		<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">DISTRITO</label>
									                    <div class="col-sm-8 z-3">
									                      	<select class="form-control" name="cbodistControl" id="cbodistControl" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboConsultaReserva('Control')" required>
									                      		<option value="">[ SELECCIONE UN DISTRITO ]</option>
                            								</select>
									                    </div>
								                 	</div>

								                 	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">TIPO DE C&Eacute;DULA</label>
									                    <div class="col-sm-8 z-2">
									                      	<select class="form-control" name="cboconsultaControl" id="cboconsultaControl" data-size="6" data-live-search="true" data-dropup-auto="false" onChange="selTipoReserva('Control');" required>
									                      		<option value="">[ SELECCIONE TIPO DE C&Eacute;DULA ]</option>
                            								</select>
									                    </div>
								                 	</div>
								                 	<input type="hidden" id="idConsultaControl">
								                 	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-14">UBIGEO</label>
									                    <div class="col-sm-8">
									                      <input id="ubigeoControl" name="ubigeoControl" class="form-control" type="text" placeholder="C&oacute;digo de Barras del Ubigeo" style="text-transform: uppercase;" disabled onKeyPress="inpUbigeo('Control');">
									                    </div>
								                  	</div>

								                  	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-14">R&Oacute;TULO</label>
									                    <div class="col-sm-8">
									                      <input id="rotuloControl" name="rotuloControl" class="form-control" type="text" placeholder="C&oacute;digo de Barras del R&oacute;tulo" style="text-transform: uppercase;" disabled onKeyPress="inpRotulo('Control');">
									                    </div>
								                  	</div>

								                  	<div class="form-group form-group-sm">
					                                    <div class="col-sm-12 text-right">
					                                      	<button class="btn bg-success btn-sm" id="btnResetInputControl" type="button" style="display: none;" onclick="resetInput('Control')"><i class="zmdi zmdi-minus-circle-outline zmdi-hc-fw m-r-5"></i><span> LIMPIAR</span></button>
					                                      	<button class="btn bg-primary btn-sm" id="addControlReserva" type="button" style="display: none;" onclick="inpRotuloValidar('Control')"><span class="glyphicon glyphicon-ok"></span>&nbsp; Validar&nbsp;&nbsp;</button>
					                                      	<a class="btn bg-danger btn-sm" href="#modal_incidencia"  id="btnIncidControl"  data-toggle="modal" style="display: none;"  onClick="modalIncidencia('Control',2)"><i class="zmdi zmdi-primary-outline zmdi-hc-fw m-r-5"></i><span> INCIDENCIA</span></a>
					                                    </div>
					                              	</div>

					                              	<!-- <div class="col-sm-offset-1 col-sm-10 text-center" id="msjRecepcionCedula"></div> -->
		                                   			<div  class="col-sm-offset-1 col-sm-11 text-center m-t-20">            
									                  	<div id="msj_Control"></div> 
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
                            			<h4 class="text-center text-primary font-12"><strong>AVANCE GENERAL DEL CONTROL DE CALIDAD DE C&Eacute;DULAS DE RESERVA</strong></h4>
                          			</div>
		                          	<div class="panel-body">
		                          		<h4 class="">AVANCE GENERAL POR FASE</h4>
		                          		<div class="table-responsive">
		                          			<div class="pull-right">
			                                       <a class="btn btn-blue btn-sm" data-dismiss="modal" id="updateControl"  onclick="cargaAvanceFase('Control'); cargaAvanceOdpe('Control')" disabled><i class="zmdi zmdi-refresh zmdi-hc-fw"></i><span></span></a>
			                                    </div>
		                          			<div id="tbl_reservaAvanceFaseControl" class="dataTables_wrapper form-inline" role="grid">
		                          				FASE: <span id="nomFaseControl"></span><br><br>
			                          			<table id="tbl_reservaControlAvanceFase" class="display table table-bordered table-hover" cellspacing="0" width="100%">
			                          				<thead class="text-center font-table">
			                          					<tr class="text-primary">
			                          						<th class="text-center" width="15%"></th>
												            <th class="text-center" width="15%">RECIBIDAS</th>
			                          					</tr>
			                          				</thead>
			                          				<tbody>
			                          					<tr class="text-center font-table">
			                          						<td>PAQUETES</td>
			                          						<td>0</td>
			                          					</tr>
			                          				</tbody>                     
			                          			</table>
			                          		</div>
		                            	</div>

		                            	<h4 class="">AVANCE GENERAL POR ODPE</h4>
		                            	<div class="table-responsive">
		                            		<div class="clearfix">
			                                    <div class="pull-right">
			                                       <a class="btn btn-black btn-sm" data-dismiss="modal" id="recibidoControl" data-toggle="modal" onclick=""><i class="zmdi zmdi-view-compact zmdi-hc-fw m-r-5"></i><span> RECIBIDOS</span></a>
			                                       <!--<a class="btn btn-purple btn-sm" data-dismiss="modal" id="faltanteControl" data-toggle="modal" onclick=""><i class="zmdi zmdi-view-dashboard zmdi-hc-fw m-r-5"></i><span> FALTANTES</span></a>-->
			                                    </div>
			                                </div>
		                              		<div id="tbl_reservaAvanceOdpeControl" class="dataTables_wrapper form-inline" role="grid">
		                              			ODPE: <span id="nomOdpeControl"></span><br><br>
		                                  		<table id="tbl_reservaControlAvanceOdpe" class="display table table-bordered table-hover" cellspacing="0" width="100%">
		                                        	<thead class="text-center font-table">
												        <tr class="text-primary">
												            <th class="text-center" width="14%">SOL. TEC.</th>
												            <th class="text-center" width="14%">TOTAL PAQUETES</th>
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

                  	<div role="tabpanel" class="tab-pane fade" id="tab-empaque_reserva">
                    	<div class="row">
                      		<div class="col-md-5 col-sm-5">
                        		<div class="panel panel-default panel-table m-b-0">
                          			<div class="panel-heading">
                            			<h4 class="text-center text-primary font-12" id="titleEmpaque"><strong>EMPAQUETADO DE C&Eacute;DULAS DE RESERVA</strong></h4>
                          			</div>
                          			<div class="panel-body">
	                            		<div class="row">
		                              		<!-- <div class="col-lg-1"></div> -->
		                              		<div class="col-lg-12">
		                                		<form class="form-horizontal" id="sign_addEmpaqueReserva" method="POST" autocomplete="off" action="javascript:void(0);">
				                                  	<input class="form-control" type="hidden" id="txtIDUsuario" name="txtIDUsuario">
				                                  	<input class="form-control" type="hidden" id="txtIdEtapaEmpaque" name="txtIdEtapaEmpaque" value="3">
				                                  	<input class="form-control" type="hidden" id="txtValidacionEmpaque" name="txtValidacionEmpaque" value="1">
								                  	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">FASE</label>
									                    <div class="col-sm-8 z-8">
									                      	<select class="form-control" name="cbofaseEmpaque" id="cbofaseEmpaque" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboSoltecReserva('Empaque');" required>
									                      		<option value="">[ SELECCIONE UNA FASE ]</option>
	                                          					<option value="1">SUFRAGIO</option>
                            								</select>
									                    </div>
								                 	</div>

								                 	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">SOLUCI&Oacute;N TECNOL&Oacute;G.</label>
									                    <div class="col-sm-8 z-7">
									                      	<select class="form-control" name="cbosoltecEmpaque" id="cbosoltecEmpaque" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboOdpeReserva('Empaque');" required>
									                      		<option value="">[ SELECCIONE UNA SOL. TECN. ]</option>
                            								</select>
									                    </div>
								                 	</div>

								                 	<div id="divAgrupacionEmpaque">
								                 		<!-- <input class="form-control" type="text" id="txtdata" name="txtdata" value=""> -->
									                 	<div class="form-group form-group-sm">
										                    <label class="col-sm-4 control-label" for="form-control-1">AGRUP.  POLITICA</label>
										                    <div class="col-sm-8 z-6">
										                      	<select class="form-control" name="cboagrupacionEmpaque" id="cboagrupacionEmpaque" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboAgrupacionReserva('Empaque');" required>
										                      		<option value="">[ SELECCIONE UNA AGRUP. POLITICA ]</option>
	                            								</select>
										                    </div>
									                 	</div>
									                 </div>

								                 	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">ODPE</label>
									                    <div class="col-sm-8 z-6">
									                      	<select class="form-control" name="cboodpeEmpaque" id="cboodpeEmpaque" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboDepartamentoReserva('Empaque');" required>
									                      		<option value="">[ SELECCIONE UNA ODPE ]</option>
                            								</select>
									                    </div>
								                 	</div>

								                 	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">DEPARTAMENTO</label>
									                    <div class="col-sm-8 z-5">
									                      	<select class="form-control" name="cbodepartEmpaque" id="cbodepartEmpaque" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboProvinciaReserva('Empaque');" required>
									                      		<option value="">[ SELECCIONE UN DEPARTAMENTO ]</option>
                            								</select>
									                    </div>
								                 	</div>

								                 	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">PROVINCIA</label>
									                    <div class="col-sm-8 z-4">
									                      	<select class="form-control" name="cboprovEmpaque" id="cboprovEmpaque" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboDistritoReserva('Empaque')" required>
									                      		<option value="">[ SELECCIONE UNA PROVINCIA ]</option>
                            								</select>
									                    </div>
								                 	</div>
		                                      		
		                                      		<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-1">DISTRITO</label>
									                    <div class="col-sm-8 z-3">
									                      	<select class="form-control" name="cbodistEmpaque" id="cbodistEmpaque" data-dropup-auto="false" data-size="6" data-live-search="true" onChange="cboConsultaReserva('Empaque')" required>
									                      		<option value="">[ SELECCIONE UN DISTRITO ]</option>
                            								</select>
									                    </div>
								                 	</div>
													 <div id="divConsultaEmpaque">
														<div class="form-group form-group-sm">
															<label class="col-sm-4 control-label" for="form-control-1">TIPO DE C&Eacute;DULA</label>
															<div class="col-sm-8 z-2">
																<select class="form-control" name="cboconsultaEmpaque" id="cboconsultaEmpaque" data-size="6" data-live-search="true" data-dropup-auto="false" onChange="selTipoReserva('Empaque');" required>
																	<option value="">[ SELECCIONE TIPO DE C&Eacute;DULA ]</option>
																</select>
															</div>
														</div>
													</div>
								                 	<input type="hidden" id="idConsultaEmpaque">
								                 	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-14">UBIGEO</label>
									                    <div class="col-sm-8">
									                      <input id="ubigeoEmpaque" name="ubigeoEmpaque" class="form-control" type="text" placeholder="C&oacute;digo de Barras del Ubigeo" style="text-transform: uppercase;" disabled onKeyPress="inpUbigeo('Empaque');">
									                    </div>
								                  	</div>

								                  	<div class="form-group form-group-sm">
									                    <label class="col-sm-4 control-label" for="form-control-14">R&Oacute;TULO</label>
									                    <div class="col-sm-8">
									                      <input id="rotuloEmpaque" name="rotuloEmpaque" class="form-control" type="text" placeholder="C&oacute;digo de Barras del R&oacute;tulo" style="text-transform: uppercase;" disabled onKeyPress="inpRotulo('Empaque');">
									                    </div>
								                  	</div>

								                  	<div class="col-sm-offset-1 col-sm-11 text-center m-t-20"> 
								                  		<div id="msj_mesa_next"></div>
								                  	</div>

								                  	<div class="form-group form-group-sm">
					                                    <div class="col-sm-12 text-right">
					                                      	<button class="btn bg-success btn-sm" id="btnResetInputEmpaque" type="button" style="display: none;" onclick="resetInput('Empaque')"><i class="zmdi zmdi-minus-circle-outline zmdi-hc-fw m-r-5"></i><span> LIMPIAR</span></button>
					                                      	<a class="btn bg-danger btn-sm" href="#modal_incidencia"  id="btnIncidEmpaque"  data-toggle="modal" style="display: none;"  onClick="modalIncidencia('Empaque',3)"><i class="zmdi zmdi-primary-outline zmdi-hc-fw m-r-5"></i><span> INCIDENCIA</span></a>
					                                    </div>
					                              	</div>

					                              	<!-- <div class="col-sm-offset-1 col-sm-10 text-center" id="msjRecepcionCedula"></div> -->
		                                   			<div  class="col-sm-offset-1 col-sm-11 text-center m-t-20">            
									                  	<div id="msj_Empaque"></div> 
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
                            			<h4 class="text-center text-primary font-12"><strong>AVANCE GENERAL DEL EMPAQUETADO DE C&Eacute;DULAS DE RESERVA</strong></h4>
                          			</div>
		                          	<div class="panel-body">
		                          		<h4 class="">AVANCE GENERAL POR FASE</h4>
		                          		<div class="table-responsive">
		                          			<div class="pull-right">
			                                       <a class="btn btn-blue btn-sm" data-dismiss="modal" id="updateEmpaque"  onclick="cargaAvanceFase('Empaque'); cargaAvanceOdpe('Empaque')" disabled><i class="zmdi zmdi-refresh zmdi-hc-fw"></i><span></span></a>
			                                    </div>
		                          			<div id="tbl_reservaAvanceFaseEmpaque" class="dataTables_wrapper form-inline" role="grid">
		                          				FASE: <span id="nomFaseEmpaque"></span><br><br>
			                          			<table id="tbl_reservaEmpaqueAvanceFase" class="display table table-bordered table-hover" cellspacing="0" width="100%">
			                          				<thead class="text-center font-table">
			                          					<tr class="text-primary">
			                          						<th class="text-center" width="15%"></th>
												            <th class="text-center" width="15%">RECIBIDAS</th>
			                          					</tr>
			                          				</thead>
			                          				<tbody>
			                          					<tr class="text-center font-table">
			                          						<td>PAQUETES</td>
			                          						<td>0</td>
			                          					</tr>
			                          				</tbody>                     
			                          			</table>
			                          		</div>
		                            	</div>

		                            	<h4 class="">AVANCE GENERAL POR ODPE</h4>
		                            	<div class="table-responsive">
		                            		<div class="clearfix">
			                                    <div class="pull-right">
			                                       <a class="btn btn-black btn-sm" data-dismiss="modal" id="recibidoEmpaque" data-toggle="modal" onclick=""><i class="zmdi zmdi-view-compact zmdi-hc-fw m-r-5"></i><span> RECIBIDOS</span></a>
			                                       <!--<a class="btn btn-purple btn-sm" data-dismiss="modal" id="faltanteEmpaque" data-toggle="modal" onclick=""><i class="zmdi zmdi-view-dashboard zmdi-hc-fw m-r-5"></i><span> FALTANTES</span></a>-->
			                                    </div>
			                                </div>
		                              		<div id="tbl_reservaAvanceOdpeEmpaque" class="dataTables_wrapper form-inline" role="grid">
		                              			ODPE: <span id="nomOdpeEmpaque"></span><br><br>
		                                  		<table id="tbl_reservaEmpaqueAvanceOdpe" class="display table table-bordered table-hover" cellspacing="0" width="100%">
		                                        	<thead class="text-center font-table">
												        <tr class="text-primary">
												            <th class="text-center" width="14%">SOL. TEC.</th>
												            <th class="text-center" width="14%">TOTAL PAQUETES</th>
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
                                            <th class="text-center" width="5%">Nº</th>
                                            <th class="text-center" width="10%">SOL. TEC.</th>
                                            <th class="text-center" width="20%">DEPARTAMENTO</th>
                                            <th class="text-center" width="20%">PROVINCIA</th>
                                            <th class="text-center" width="20%">DISTRITO</th>
                                            <th class="text-center" width="10%">NRO. MESA</th>
                                            <th class="text-center" width="10%">NRO ELECTORES </th>
                                            <th class="text-center" width="10%">CONSULTA</th>
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
                                            <th class="text-center" width="5%">Nº</th>
                                            <th class="text-center" width="10%">SOL. TEC.</th>
                                            <th class="text-center" width="20%">DEPARTAMENTO</th>
                                            <th class="text-center" width="20%">PROVINCIA</th>
                                            <th class="text-center" width="20%">DISTRITO</th>
                                            <th class="text-center" width="10%">NRO. MESA</th>
                                            <th class="text-center" width="10%">NRO ELECTORES </th>
                                            <th class="text-center" width="10%">TIPO DE PAQUETE</th>
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



<script src="<?= media();?>/functions/<?= $data['page_function_js'] ?>"></script>
<!--<script type="text/javascript" src="js/control_reserva.js"></script>-->
</html>