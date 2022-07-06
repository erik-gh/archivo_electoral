<?php 

	/**
	* 
	*/
	class Contrato extends Controllers
	{
		
		public function __construct()
		{
			# code...
			session_start();
			if(empty($_SESSION['login'])){
				header('Location: '.base_url().'/login');
			}
			parent::__construct();
			
		}

		public function contrato()
		{

			$data['page_tag']='Registro de Contratos';
			$data['page_title']='REGISTRO DE CONTRATOS';
			$data['page_name']='contrato';
			$data['page_function_js']='function_contrato.js';
			$this->views->getView($this,'contrato',$data);
		}


		/*===== VONTRATOS ======*/
		public function setContrato()
		{
			//dep($_POST); exit;
			if($_POST){
				if(empty($_POST['pedido']) || empty($_POST['IdPersonal']) || empty($_POST['nroContrato']) || empty($_POST['ruc']) || empty($_POST['fechaInicio']) || empty($_POST['fechaFin']) || empty($_POST['local']) || empty($_POST['jefe']) || empty($_POST['verificacion']) || empty($_POST['nacimiento']) || empty($_POST['sexo']) || empty($_POST['direccion']) || empty($_POST['ubigeo']) || empty($_POST['celular']) ){
					
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$intIdContrato		= intval(strClean($_POST['IdContrato']));
					$intControl			= intval(strClean($_POST['controlContrato']));
					$intPedido			= intval(strClean($_POST['pedido']));
					$intIdPersonal		= intval(strClean($_POST['IdPersonal']));
					$strNroContrato		= strClean($_POST['nroContrato']);
					$intRuc				= intval(strClean($_POST['ruc']));
					$strFechaInicio		= strClean($_POST['fechaInicio']);
					$strFechaFin		= strClean($_POST['fechaFin']);
					$intProceso			= intval(strClean($_POST['proceso']));
					$intLocal			= intval(strClean($_POST['local']));
					$strJefe			= strClean($_POST['jefe']);
					$intVerificacion	= intval(strClean($_POST['verificacion']));
					$strNacimiento		= strClean($_POST['nacimiento']);
					$intSexo			= intval(strClean($_POST['sexo']));
					$strDireccion		= strClean($_POST['direccion']);
					$intUbigeo			= intval(strClean($_POST['ubigeo']));
					$intCelular			= intval(strClean($_POST['celular']));
					$intTelefono		= intval(strClean($_POST['telefono']));
					$intProcesoUpd		= intval(strClean($_POST['procesoUpd']));
					$intUserSession		= intval(strClean($_SESSION['idUser']));
					//$intEstado			= intval(strClean($_POST['estado']));
					
					if($intControl == 0){
						$requestContrato	= $this->model->insertContrato($intPedido, $intIdPersonal, $strNroContrato, $intRuc, $strFechaInicio, $strFechaFin, $intProceso, $intLocal, $strJefe, $intVerificacion, $strNacimiento, $intSexo, $strDireccion, $intUbigeo, $intCelular, $intTelefono, $intUserSession);
					}else{
						$requestContrato	= $this->model->updateContrato($intIdContrato, $intPedido, $intIdPersonal, $strNroContrato, $intRuc, $strFechaInicio, $strFechaFin, $intProcesoUpd, $intLocal, $strJefe, $intVerificacion, $strNacimiento, $intSexo, $strDireccion, $intUbigeo, $intCelular, $intTelefono, $intUserSession);
					}

					if($requestContrato > 0){

						if($intControl == 0){
							$arrResponse = 	[
											    "status"	=> true,
											    "title"		=> "Contratos",
											    "msg" 		=> "Datos Guardados Correctamente.",
											    "idContrato"=> $requestContrato,
											];
						}else{
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Contratos",
											    "msg" 	=> "Datos Actualizados Correctamente.",
											];
						}
					}else if($requestContrato == 'exist'){
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Alerta!",
										    "msg" 	=> "El DNI y/o Nro. de Contrato ya se encuentra registrado.",
										];
					}else{
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Error!",
										    "msg" 	=> "No se puede conectarse a la Base Datos",
										];
					}
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function getContratos()
		{

			$output = array();
			$arrData = $this->model->selectContratos();
			// dep($arrData); exit;
			// $filtro = ($_POST["search"]["value"]!= '') ? $arrData[1] : $arrData[2];
			for ($i=0; $i <  count($arrData[0]); $i++) { 
				# code...
				$arrData[0][$i]['orden'] 	= 	$i+1;
				$arrData[0][$i]['estado_contrato'] 	= 	$arrData[0][$i]['estado_contrato'] == 1 ? '<span class="label label-success label-pill m-w-60">ACTIVO</span>' : '<span class="label label-danger label-pill m-w-60">INACTIVO</span>';

				$arrData[0][$i]['opciones'] =	'<a class="btn btn-info btn-xs" title="Ver Reporte" onclick="verContrato('.$arrData[0][$i]['id_contrato'].')">
                                					<i data-toggle="tooltip" title="Ver Reporte"class="zmdi zmdi-info zmdi-hc-fw"></i>
                                				</a>
                                				<a data-toggle="modal" href="#modal_registro" class="btn btn-primary btn-xs" title="Editar" onclick="editarContrato('.$arrData[0][$i]['id_contrato'].')">
													<i class="zmdi zmdi-edit zmdi-hc-fw"></i>
												</a>
                                				<a class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminarContrato('.$arrData[0][$i]['id_contrato'].')">
                                					<i data-toggle="tooltip" title="Eiiminar"class="zmdi zmdi-delete zmdi-hc-fw"></i>
                                				</a>';
			}

			$output = array(
				"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=> 	$arrData[2]['row'],
				"recordsFiltered"	=>	$arrData[1]['row'],
				"data"				=>	$arrData[0]
			);
			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
			// dep($arrData[0][0]['estado']);
		}


		public function getContrato($idContrato)
		{

			$intIdContrato = intval(strClean($idContrato));

			if ($intIdContrato > 0) {
				
				$arrData = $this->model->selectContrato($intIdContrato);
				//dep($arrData); exit;
				if(empty($arrData)){
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Datos No Encontrados.",
									]; 
				}else{
					$arrResponse = 	[
										"status"=> true,
										"data" 	=> $arrData,
									]; 
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}


		public function delContrato($idContrato)
		{
			
				$intIdContrato 	= intval(strClean($idContrato));
				$requestDelete 	= $this->model->deleteContrato($intIdContrato);

				if ($requestDelete > 0) {
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Contratos",
										"msg" 	=> "Contrato Eliminado Correctamente.",
									];

				}else{
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Error al eliminar el Contrato",
									];
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			
				die();
		}


		public function getContratoPDF($idContrato)
		{
			
			$intIdContrato = intval(strClean($idContrato));

			if ($intIdContrato > 0) {
			
				$arrData = $this->model->selectContratoReport($intIdContrato);
				$arrDataFormAcad = $this->model->selectFormAcad($intIdContrato);
				$arrDataCursoEspec = $this->model->selectCursoEspec($intIdContrato);
				$arrDataExperiencia = $this->model->selectExperiencia($intIdContrato);
				//dep($arrData);  exit;
				/* echo $arrData['id_pedido'];*/
				if(empty($arrData)){
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Datos No Encontrados.",
									]; 
				}else{
					require_once './Assets/vendor/autoload.php';

					$mpdf = new \Mpdf\Mpdf([
						'tempDir' => __DIR__ . '/custom/temp/dir/path',
						//MARGENES
						/*'margin_top' => 0,
						'margin_left' => 30,
						'margin_right' => 10,
						'mirrorMargins' => true*/
						'pagenumPrefix' => 'Página ',
					    'pagenumSuffix' => ' / ',
					    /*'nbpgPrefix' => ' out of ',
					    'nbpgSuffix' => ' pages'*/

					]);

					$head = '<!DOCTYPE html>
								<html lang="es">
									<head>    		
									    <style type="text/css">
									    	.font-13{
									    		font-size: 13px;
									    	}

									    	.font-11{
									    		font-size: 11px;
									    		font-family: Arial, Helvetica, sans-serif;
									    	}

									    	.img-thumbnail {
											  border: 1px solid #FFF;
											  border-radius: 4px;
											  //padding: 5px;
											  width: 90px;
											  // margin-left: 20px;
											  float:right;
											  z-index:1000;
											}

											.columna1 {
											  width:33%;
											  float:left;
											  border: 1px solid #FFF;
											  //height:94px;
											  
											}

											.columna2 {
												width:33%;
												float:left;
												border: 1px solid #FFF;
												//height:94px;
												//text-align: center;
												//margin-left:60px;
											}

											.columna3 {
											  width:33%;
											  float:left;
											  border: 1px solid #FFF;
											  //height:94px;
											  //margin-left:30px;
											}


											.columna4 {
												width:66%;
												float:left;
												border: 1px solid #FFF;
												//height:94px;
												//text-align: center;
												//margin-left:60px;
											}

											.columna5 {
											  width:49%;
											  float:left;
											  border: 1px solid #FFF;
											  //height:94px;
											  //margin-left:30px;
											}

											.columna6 {
											  width:100%;
											  float:left;
											  //border: 1px solid #00;
											  //height:94px;
											  //margin-left:30px;
											}

											.centrado{
												text-align: center;
												font-size:16px;
											  	font-weight: bold;
											  	font-family: Arial, Helvetica, sans-serif;
											}


											.sub-titulo{
												font-size:12px;
											  	font-family: Arial, Helvetica, sans-serif;
											  	text-align: center;
											  	font-weight: bold;
											  	margin-bottom: 15px;
											}

											.td-table{
												font-size:11px;
											  	font-family: Arial, Helvetica, sans-serif;
											  	text-align: center;
											  	padding:6px 0px 6px 0px
											}
											
											.margen-header {
								                height:110px;
								                border: 1px solid #FFF;
								            }

								            .textInfo {
											  	width:50%;
											  	//border: 1px solid #7D7B7B;
											  	display: inline-block;
											  	padding: 1px;
											  	margin-top:-16px;
											  	margin-left:150px;
											  	margin-bottom:5px;
											  	//text-align: center;
											  	float: right;
											}

											.textInfo1 {
											  	width:100%;
											  	//border: 1px solid #7D7B7B;
											  	display: inline-block;
											  	padding: 1px;
											  	margin-top:-15px;
											  	margin-left:160px;
											  	margin-bottom:5px;
											  	float: left;
											}

											.div-inline{
												width:100%;
												border-bottom: 1px solid #7D7B7B;
												padding: 10px;
												margin-bottom:20px;
											}

											footer {
											  font-size: 11px;
											  position: absolute;
											  bottom: 60;
											  width: 88%;
											  height: 40px;
											  
											}

										 </style>
						   			</head>
						   			<body>';
					$html=		'		<div class="container">
											<div class="margen-header">
												<div>
												   	<div class="columna1"><div class="textoColumna3"></div></div>
													<div class="columna2"><br><div class="centrado">FICHA DE CONTRATO</div></div>
													<div class="columna3"><img src="./Assets/images/uploads/personal/'.$arrData['imagen'].'" alt="imagen" class="img-thumbnail"></div>
												</div>
											</div>
											<div class="row">
											<div class="paneles">
								                <div class="panel-body">
								                	<div class="row">
														<form class="font-11" role="form">
															<div class="sub-titulo">DATOS DE CONTRATO</div>
															<div class="form-groupe">
																<div class="columna1">
																	<b>Nº PEDIDO:</b>
																	<div class="textInfo">'.$arrData['pedido'].'</div>
																</div>
																<div class="columna2">
																	<b>Nº MEMORANDUM:</b>
																	<div class="textInfo">'.$arrData['memorandum'].'</div>
																</div>
																<div class="columna3">
																	<b>Nº  INFORME:</b>
																	<div class="textInfo">'.$arrData['informe'].'</div>
																</div>
								                            </div>
								                            <div class="form-groupe">
																<div class="columna1">
																   	<b>FECHA PEDIDO:</b>
									                                <div class="textInfo">'.$arrData['fecha_pedido'].'</div>
									                            </div>
								                            </div>
								                            <div class="div-inline"></div>

								                            <div class="form-groupe">
								                            	<div class="columna6">
																	<b>Nº DNI:</b>
																	<div class="textInfo1">'.$arrData['dni'].'</div>
																</div>
															</div>
								                            <div class="form-groupe">
																<div class="columna6">
																	<b>APELLIDOS Y NOMBRES: </b>
																	<div class="textInfo1">'.$arrData['nombre'].'</div>
																</div>
								                            </div>
								                            <div class="form-groupe">
								                            	<div class="columna6">
																	<b>OBJETO DE CONTRATO:</b>
																	<div class="textInfo1">'.$arrData['cargo'].'</div>
																</div>
								                            </div>
								                            <div class="form-groupe">
																<div class="columna6">
																	<b>Nº RUC:</b>
																	<div class="textInfo1">'.$arrData['ruc'].'</div>
																</div>
															</div>
								                            <div class="form-groupe">
																<div class="columna6">
																	<b>Nº CONTRATO:</b>
																	<div class="textInfo1">'.$arrData['nro_contrato'].'</div>
																</div>
								                            </div>
								                            <div class="form-groupe">
																<div class="columna6">
																	<b>HONORARIOS (S/):</b>
																	<div class="textInfo1">'.$arrData['remuneracion'].'</div>
																</div>
								                            </div>
								                            <div class="form-groupe">
																<div class="columna6">
																	<b>FECHA INICIO CONTRATO:</b>
																	<div class="textInfo1">'.$arrData['fecha_inicio'].'</div>
																</div>
								                            </div>
								                            <div class="form-groupe">
																<div class="columna6">
																	<b>FECHA FIN CONTRATO:</b>
																	<div class="textInfo1">'.$arrData['fecha_fin'].'</div>
																</div>
								                            </div>
								                            <div class="form-groupe">
																<div class="columna6">
																	<b>LOCAL DE SERVICIOS:</b>
																	<div class="textInfo1">'.$arrData['nombre_local'].'</div>
																</div>
								                            </div>
								                            <div class="form-groupe">
																<div class="columna6">
																	<b>JEFE DIRECTO:</b>
																	<div class="textInfo1">'.$arrData['nombre_jefe'].'</div>
																</div>
								                            </div>
								                            <div class="form-groupe">
																<div class="columna6">
																	<b>ESTADO VERIFCADO:</b>
																	<div class="textInfo1">'.$arrData['verificacion'].'</div>
																</div>
								                            </div>
								                            <div class="sub-titulo">DATOS DE PERSONALES</div>
								                            <div class="form-groupe">
																<div class="columna6">
																	<b>FECHA NACIMIENTO:</b>
																	<div class="textInfo1">'.$arrData['fecha_nacimiento'].'</div>
																</div>
								                            </div>
								                            <div class="form-groupe">
																<div class="columna6">
																	<b>SEXO:</b>
																	<div class="textInfo1">'.$arrData['sexo'].'</div>
																</div>
								                            </div>
								                            <div class="form-groupe">
																<div class="columna6">
																	<b>DIRECCION:</b>
																	<div class="textInfo1">'.$arrData['direccion'].'</div>
																</div>
								                            </div>
								                            <div class="form-groupe">
																<div class="columna6">
																	<b>DEPARTAMENTO:</b>
																	<div class="textInfo1">'.$arrData['depart_ubi'].'</div>
																</div>
								                            </div>
								                            <div class="form-groupe">
																<div class="columna6">
																	<b>PROVINCIA:</b>
																	<div class="textInfo1">'.$arrData['prov_ubi'].'</div>
																</div>
								                            </div>
								                            <div class="form-groupe">
																<div class="columna6">
																	<b>DISTRITO:</b>
																	<div class="textInfo1">'.$arrData['dist_ubi'].'</div>
																</div>
								                            </div>
								                            <div class="form-groupe">
																<div class="columna6">
																	<b>CELULAR:</b>
																	<div class="textInfo1">'.$arrData['celular'].'</div>
																</div>
								                            </div>
								                            <div class="form-groupe">
																<div class="columna6">
																	<b>TELEFONO FIJO:</b>
																	<div class="textInfo1">'.$arrData['telefono'].'</div>
																</div>
								                            </div>
								        				</form>
								        			</div>
								        		</div>
								        	</div>
										</div>';

					$html2=	'			<div class="row">
											<div class="paneles">
								                <div class="panel-body">
								                	<div class="row">
														<form class="font-11" role="form">
															<div class="sub-titulo">FORMACIÓN ACADÉMICA</div>
															<div class="form-group">
									                            <div class="paneles">
									                            	<table class="table" border="1">
									                            		<thead>
																			<tr>
																				<th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="5%">Nº</th>
									                                            <th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="15%">TIPO DE ESTUDIOS</th>
									                                            <th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="15%">NIVEL DE ESTUDIOS</th>
									                                            <th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="20%">ESPECIALIDAD</th>
									                                            <th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="25%">CENTRO DE ESTUDIOS</th>
									                                            <th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="10%">FECHA DE OBTENCION</th>
									                                          
																			</tr>
																		</thead>
																		<tbody>';
																		$c = 1;
																		foreach ($arrDataFormAcad as $value){
					$html2.=	'											<tr>
																				<td class="td-table">'.$c++.'</td>
																				<td class="td-table">'.$value['grado_estudio'].'</td>
																				<td class="td-table">'.$value['nivel_estudio'].'</td>
																				<td class="td-table">'.$value['especialidad'].'</td>
																				<td class="td-table">'.$value['centro_estudio'].'</td>
																				<td class="td-table">'.$value['fecha_obtencion'].'</td>
										                                    </tr>';
										                                }

					$html2.=	'					                	</tbody>
									                            	</table>
																</div>
															</div>
															<br><br>
															<div class="sub-titulo">CURSOS Y/O ESPECIALIZACION</div>
															<div class="form-group">
									                            <div class="paneles">
									                            	<table class="table" border="1">
									                            		<thead>
																			<tr>
																				<th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="5%">Nº</th>
									                                            <th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="15%">TIPO DE ESTUDIOS</th>
									                                            <th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="25%">DESCRIPCION</th>
									                                            <th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="25%">CENTRO DE ESTUDIOS</th>
									                                            <th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="10%">FECHA INICIO</th>
									                                            <th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="10%">FECHA FIN</th>
									                                            <th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="10%">HORAS LECTIVAS</th>
									                                          
																			</tr>
																		</thead>
																		<tbody>';
																		$c = 1;
																		foreach ($arrDataCursoEspec as $value){
					$html2.=	'											<tr>
																				<td class="td-table">'.$c++.'</td>
																				<td class="td-table">'.$value['especializacion'].'</td>
																				<td class="td-table">'.$value['descripcion'].'</td>
																				<td class="td-table">'.$value['centro_estudioCurso'].'</td>
																				<td class="td-table">'.$value['fecha_inicioCurso'].'</td>
																				<td class="td-table">'.$value['fecha_finCurso'].'</td>
																				<td class="td-table">'.$value['horas_lectivas'].' HRS</td>
										                                    </tr>';
										                                }

					$html2.=	'					                	</tbody>
									                            	</table>
																</div>
															</div>
															<br><br>
															<div class="sub-titulo">EXPERIENCIA LABORAL</div>
															<div class="form-group">
									                            <div class="paneles">
									                            	<table class="table" border="1">
									                            		<thead>
																			<tr>
																				<th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="5%">Nº</th>
									                                            <th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="10%">TIPO DE EXPERIENCIA</th>
									                                            <th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="10%">ENTIDAD</th>
									                                            <th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="15%">NOMBRE DE LA ENTIDAD</th>
									                                            <th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="10%">AREA DE TRABAJO</th>
									                                            <th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="15%">CARGO</th>
									                                            <th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="10%">FECHA INICIO</th>
									                                            <th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="10%">FECHA FIN</th>
									                                            <th style="vertical-align : middle; text-align:center; background: #464444; padding:8px 0px 8px 0px; color:#FFF; font-size: 9px" width="15%">TIEMPO</th>
									                                          
																			</tr>
																		</thead>
																		<tbody>';
																		$c = 1;
																		foreach ($arrDataExperiencia as $value){
					$html2.=	'											<tr>
																				<td class="td-table">'.$c++.'</td>
																				<td class="td-table">'.$value['tipo_experiencia'].'</td>
																				<td class="td-table">'.$value['tipo_entidad'].'</td>
																				<td class="td-table">'.$value['entidad'].'</td>
																				<td class="td-table">'.$value['area_entidad'].'</td>
																				<td class="td-table">'.$value['cargo_entidad'].'</td>
																				<td class="td-table">'.$value['fecha_inicioExp'].'</td>
																				<td class="td-table">'.$value['fecha_finExp'].'</td>
																				<td class="td-table">'.$value['tiempo'].' HRS</td>
										                                    </tr>';
										                                }

					$html2.=	'					                	</tbody>
									                            	</table>
																</div>
															</div>
								        				</form>
								        			</div>
								        		</div>
								        	</div>
										</div>
									</body>
									<footer>
										<div class="form-groupe">
											<div class="columna6">
												<b>REGISTRADO POR:</b>
												<div class="textInfo1">'.$arrData['apellido_usuario'].' '.$arrData['nombre_usuario'].'</div>
											</div>
										</div>
										<div class="form-groupe">
											<div class="columna6">
												<b>FECHA REGISTRO:</b>
												<div class="textInfo1">'.$arrData['date_create'].'</div>
											</div>
										</div>
										
									</footer>';



					$mpdf->allow_charset_conversion = true;
					$mpdf->charset_in = 'UTF-8';
					$stylesheet = file_get_contents('./Assets/css/bootstrap.min.css');

					$mpdf->SetHTMLHeader('
					
					');

					$mpdf->AliasNbPages();
					$mpdf->setFooter('{PAGENO}{nb}');

					$mpdf->WriteHTML($stylesheet,\Mpdf\HTMLParserMode::HEADER_CSS);
					$mpdf -> WriteHTML($head, \Mpdf\HTMLParserMode::DEFAULT_MODE);
					$mpdf->WriteHTML($html,\Mpdf\HTMLParserMode::HTML_BODY);
					$mpdf->AddPage();
					$mpdf->WriteHTML($html2,\Mpdf\HTMLParserMode::HTML_BODY);
					// $mpdf->WriteHTML('');
					$dwl = 'pdf_'.uniqid();
					$mpdf->Output($dwl.'.pdf','F');
					//echo $dwl;
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Reporte de Contrato",
										"msg" 	=> "Se descargo el Reporte correctamente",
										"data"	=>	$dwl,
									]; 
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				die();
			}
		}


		public function eliminarfile($id)
		{
			
			if (isset($id)) {
				if (file_exists('./'.$id)) {
					unlink('./'.$id);

					$arrResponse = 	[
								    	"status"=> true,
								    	"title"	=> "Eliminado",
								    	"msg" 	=> "Archivo Eliminado.",
									]; 
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();

		}



		/*===== CONTRATO FORMACION ACADEMICA ======*/
		public function setFormAcad()
		{
			//dep($_POST); exit;
			if($_POST){
				if(empty($_POST['IdContrato']) || empty($_POST['tipoEstudio']) || empty($_POST['fechaEstudio'])){
					
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$intIdFormAcad		= intval(strClean($_POST['idFormAcad']));
					$intControl			= intval(strClean($_POST['controlFormAcad']));
					$intContrato		= intval(strClean($_POST['IdContrato']));
					$intIdTipo			= intval(strClean($_POST['tipoEstudio']));
					$intIdNivel			= intval(strClean($_POST['nivelEstudio']));
					$strEspecilidad		= strClean($_POST['especialidad']);
					$strCentroEstudio	= strClean($_POST['centroEstudio']);
					$strFechaEstudio 	= strClean($_POST['fechaEstudio']);
					$intUserSession		= intval(strClean($_SESSION['idUser']));
					//$intEstado		= intval(strClean($_POST['estado']));
					
					if($intControl == 0){
						$FormAcad	= $this->model->insertFormAcad($intContrato, $intIdTipo, $intIdNivel, $strEspecilidad, $strCentroEstudio, $strFechaEstudio, $intUserSession);
					}else{
						$FormAcad	= $this->model->updateFormAcad($intIdFormAcad, $intContrato, $intIdTipo, $intIdNivel, $strEspecilidad, $strCentroEstudio, $strFechaEstudio, $intUserSession);
					}

					if($FormAcad > 0){

						if($intControl == 0){
							$arrResponse = 	[
											    "status"	=> true,
											    "title"		=> "Formacion Academica",
											    "msg" 		=> "Datos Guardados Correctamente.",
											    "mdl"		=> "show"
											];
						}else{
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Formacion Academica",
											    "msg" 	=> "Datos Actualizados Correctamente.",
											    "mdl"	=> "hide"
											];
						}
					}else if($FormAcad == 'exist'){
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Alerta!",
										    "msg" 	=> "Ya se registro este Item FA.",
										];
					}else{
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Error!",
										    "msg" 	=> "No se puede conectarse a la Base Datos",
										];
					}
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function getFormAcad()
		{
			//dep($_POST); exit;
			
			$output = array();
			$intIdContrato	= intval(strClean($_POST['idContrato']));
			$arrData = $this->model->selectFormAcad($intIdContrato);
			//dep($arrData); exit;
			//$filtro = ($_POST["search"]["value"]!= '') ? $arrData[1] : $arrData[2];
			for ($i=0; $i <  count($arrData); $i++) { 
				# code...
				$arrData[$i]['orden'] 	= 	$i+1;
				$arrData[$i]['estado_formacion'] 	= 	$arrData[$i]['estado_formacion'] == 1 ? '<span class="label label-success label-pill m-w-60">ACTIVO</span>' : '<span class="label label-danger label-pill m-w-60">INACTIVO</span>';
				$arrData[$i]['nivel_estudio'] 	= 	$arrData[$i]['nivel_estudio'] != null ? $arrData[$i]['nivel_estudio'] : '-';
				$arrData[$i]['especialidad'] 	= 	$arrData[$i]['especialidad'] != '' ? $arrData[$i]['especialidad'] : '-';
				$arrData[$i]['centro_estudio'] 	= 	$arrData[$i]['centro_estudio'] != '' ? $arrData[$i]['centro_estudio'] : '-';
				
				$arrData[$i]['opciones'] =	'<a data-toggle="modal" href="#modal_FormAcad" class="btn btn-primary btn-xs" title="Editar" onclick="editarFormAcad('.$arrData[$i]['id_formacion'].')">
													<i class="zmdi zmdi-edit zmdi-hc-fw"></i>
												</a>
                                				<a class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminarFormAcad('.$arrData[$i]['id_formacion'].')">
                                					<i data-toggle="tooltip" title="Eiiminar"class="zmdi zmdi-delete zmdi-hc-fw"></i>
                                				</a>';
			}

			$output = array(
				//"draw"				=>	intval($_POST["draw"]),
				//"recordsTotal"		=> 	$arrData[2]['row'],
				//"recordsFiltered"	=>	$arrData[1]['row'],
				"data"				=>	$arrData
			);
			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
			// dep($arrData[0][0]['estado']);
		}


		public function getFormAcadId($idFormAcad)
		{

			$intIdFormAcad = intval(strClean($idFormAcad));

			if ($intIdFormAcad > 0) {
				
				$arrData = $this->model->selectFormAcadId($intIdFormAcad);
				//dep($arrData); exit;
				if(empty($arrData)){
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Datos No Encontrados.",
									]; 
				}else{
					$arrResponse = 	[
										"status"=> true,
										"data" 	=> $arrData,
									]; 
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}

		
		public function delFormAcad($idFormAcad)
		{
			
				$intIdFormAcad 	= intval(strClean($idFormAcad));
				$requestDelete 	= $this->model->deleteFormAcad($intIdFormAcad);

				if ($requestDelete > 0) {
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Formacion Academica",
										"msg" 	=> "Formacion Academica Eliminada Correctamente.",
									];

				}else{
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Error al eliminar la Formacion Academica",
									];
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			
				die();
		}


		/*===== CONTRATO CURSO Y/O ESPECIALIZACION ======*/
		public function setCursoEspec()
		{
			// dep($_POST); exit;
			if($_POST){
				if(empty($_POST['IdContrato']) || empty($_POST['cursoTipo']) || empty($_POST['cursoDescrip']) || empty($_POST['cursoCentroEstudio']) || empty($_POST['cursoFechaInicio']) || empty($_POST['cursoFechaFin']) || empty($_POST['cursoHoras'])){
					
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$intIdCursoEspec		= intval(strClean($_POST['idCursoEspec']));
					$intControl				= intval(strClean($_POST['controlCursoEspec']));
					$intContrato			= intval(strClean($_POST['IdContrato']));
					$intIdCursoTipo			= intval(strClean($_POST['cursoTipo']));
					$strCursoDescrip		= strClean($_POST['cursoDescrip']);
					$strCursoCentroEstudio	= strClean($_POST['cursoCentroEstudio']);
					$strCursoFechaInicio	= strClean($_POST['cursoFechaInicio']);
					$strCursoFechaFin		= strClean($_POST['cursoFechaFin']);
					$strCursoHoras			= intval(strClean($_POST['cursoHoras']));
					$intUserSession			= intval(strClean($_SESSION['idUser']));
					//$intEstado		= intval(strClean($_POST['estado']));
					
					if($intControl == 0){
						$requestCurso	= $this->model->insertCursoEspec($intContrato, $intIdCursoTipo, $strCursoDescrip, $strCursoCentroEstudio, $strCursoFechaInicio, $strCursoFechaFin, $strCursoHoras, $intUserSession);
					}else{
						$requestCurso	= $this->model->updateCursoEspec($intIdCursoEspec, $intContrato, $intIdCursoTipo, $strCursoDescrip, $strCursoCentroEstudio, $strCursoFechaInicio, $strCursoFechaFin, $strCursoHoras, $intUserSession);
					}

					if($requestCurso > 0){

						if($intControl == 0){
							$arrResponse = 	[
											    "status"	=> true,
											    "title"		=> "Cursos y/o Especializacion",
											    "msg" 		=> "Datos Guardados Correctamente.",
											    "mdl"		=> "show",
											];
						}else{
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Cursos y/o Especializacion",
											    "msg" 	=> "Datos Actualizados Correctamente.",
											    "mdl"		=> "hide",
											];
						}
					}else if($requestCurso == 'exist'){
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Alerta!",
										    "msg" 	=> "Ya se registro este Item Curso.",
										];
					}else{
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Error!",
										    "msg" 	=> "No se puede conectarse a la Base Datos",
										];
					}
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function getCursoEspec()
		{
			//dep($_POST); exit;
			$output = array();
			$intIdContrato	= intval(strClean($_POST['idContrato']));
			$arrData = $this->model->selectCursoEspec($intIdContrato);
			//dep($arrData); exit;
			//$filtro = ($_POST["search"]["value"]!= '') ? $arrData[1] : $arrData[2];
			for ($i=0; $i <  count($arrData); $i++) { 
				# code...
				$arrData[$i]['orden'] 	= 	$i+1;
				$arrData[$i]['estado_curso'] 	= 	$arrData[$i]['estado_curso'] == 1 ? '<span class="label label-success label-pill m-w-60">ACTIVO</span>' : '<span class="label label-danger label-pill m-w-60">INACTIVO</span>';
				$arrData[$i]['tipo_estudio'] = $arrData[$i]['id_especializacion'] == 1 ? 'PROGRAMA DE ESPECIALIZACION' : 'CURSO' ;
				
				$arrData[$i]['opciones'] =	'<a data-toggle="modal" href="#modal_CursoEspec" class="btn btn-primary btn-xs" title="Editar" onclick="editarCursoEspec('.$arrData[$i]['id_curso'].')">
													<i class="zmdi zmdi-edit zmdi-hc-fw"></i>
												</a>
                                				<a class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminarCursoEspec('.$arrData[$i]['id_curso'].')">
                                					<i data-toggle="tooltip" title="Eiiminar"class="zmdi zmdi-delete zmdi-hc-fw"></i>
                                				</a>';
			}

			$output = array(
				//"draw"				=>	intval($_POST["draw"]),
				//"recordsTotal"		=> 	$arrData[2]['row'],
				//"recordsFiltered"	=>	$arrData[1]['row'],
				"data"				=>	$arrData
			);
			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
			// dep($arrData[0][0]['estado']);
		}


		public function getCursoEspecId($idCursoEspec)
		{

			$intIdCursoEspec = intval(strClean($idCursoEspec));

			if ($intIdCursoEspec > 0) {
				
				$arrData = $this->model->selectCursoEspecId($intIdCursoEspec);
				//dep($arrData); exit;
				if(empty($arrData)){
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Datos No Encontrados.",
									]; 
				}else{
					$arrResponse = 	[
										"status"=> true,
										"data" 	=> $arrData,
									]; 
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}


		public function delCursoEspec($idCursoEspec)
		{
			
				$intIdCursoEspec 	= intval(strClean($idCursoEspec));
				$requestDelete 	= $this->model->deleteCursoEspec($intIdCursoEspec);

				if ($requestDelete > 0) {
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Cursos y/o Especializacion",
										"msg" 	=> "Cursos y/o Especializacion Eliminado Correctamente.",
									];

				}else{
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Error al eliminar la Formacion Academica",
									];
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			
				die();
		}



		/*===== CONTRATO EXPERIENCIA ======*/
		public function setExperiencia()
		{
			//dep($_POST); exit;
			if($_POST){
				if(empty($_POST['IdContrato']) || empty($_POST['experienciaTipo']) || empty($_POST['experienciaTipoEntidad']) || empty($_POST['experienciaEntidad']) || empty($_POST['experienciaArea']) || empty($_POST['experienciaCargo']) || empty($_POST['experienciaFechaInicio']) || empty($_POST['experienciaFechaFin'])){
					
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$intIdExperiencia			= intval(strClean($_POST['idExperiencia']));
					$intControl					= intval(strClean($_POST['controlExperiencia']));
					$intContrato				= intval(strClean($_POST['IdContrato']));
					$intExperienciaTipo			= intval(strClean($_POST['experienciaTipo']));
					$intExperienciaTipoEntidad	= intval(strClean($_POST['experienciaTipoEntidad']));
					$strExperienciaEntidad		= strClean($_POST['experienciaEntidad']);
					$strExperienciaArea			= strClean($_POST['experienciaArea']);
					$strExperienciaCargo		= strClean($_POST['experienciaCargo']);
					$strExperienciaFechaInicio	= strClean($_POST['experienciaFechaInicio']);
					$strExperienciaFechaFin		= strClean($_POST['experienciaFechaFin']);
					$strTiempo					= strClean($_POST['experienciaTiempoLaboral']);
					$intTiempoDias				= intval(strClean($_POST['experienciaTiempoDias']));
					$intUserSession				= intval(strClean($_SESSION['idUser']));
					//$intEstado				= intval(strClean($_POST['estado']));
					
					if($intControl == 0){
						$requestCurso	= $this->model->insertExperiencia($intContrato, $intExperienciaTipo, $intExperienciaTipoEntidad, $strExperienciaEntidad, $strExperienciaArea, $strExperienciaCargo, $strExperienciaFechaInicio, $strExperienciaFechaFin, $strTiempo, $intTiempoDias, $intUserSession);
					}else{
						$requestCurso	= $this->model->updateExperiencia($intIdExperiencia, $intContrato, $intExperienciaTipo, $intExperienciaTipoEntidad, $strExperienciaEntidad, $strExperienciaArea, $strExperienciaCargo, $strExperienciaFechaInicio, $strExperienciaFechaFin, $strTiempo, $intTiempoDias, $intUserSession);
					}

					if($requestCurso > 0){

						if($intControl == 0){
							$arrResponse = 	[
											    "status"	=> true,
											    "title"		=> "Experiencia Laboral",
											    "msg" 		=> "Datos Guardados Correctamente.",
											    "mdl"		=> "show",
											];
						}else{
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Experiencia Laboral",
											    "msg" 	=> "Datos Actualizados Correctamente.",
											    "mdl"	=> "hide",
											];
						}
					}else if($requestCurso == 'exist'){
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Alerta!",
										    "msg" 	=> "YA se registro un Item en este lapso de tiempo",
										];
					}else{
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Error!",
										    "msg" 	=> "No se puede conectarse a la Base Datos",
										];
					}
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function getExperiencia()
		{
			//dep($_POST); exit;
			$output = array();
			$intIdContrato	= intval(strClean($_POST['idContrato']));
			$arrData = $this->model->selectExperiencia($intIdContrato);
			//dep($arrData); exit;
			//$filtro = ($_POST["search"]["value"]!= '') ? $arrData[1] : $arrData[2];
			for ($i=0; $i <  count($arrData); $i++) { 
				# code...
				$arrData[$i]['orden'] 	= 	$i+1;
				$arrData[$i]['estado_experiencia'] 	= 	$arrData[$i]['estado_experiencia'] == 1 ? '<span class="label label-success label-pill m-w-60">ACTIVO</span>' : '<span class="label label-danger label-pill m-w-60">INACTIVO</span>';
				$arrData[$i]['id_tipo'] = $arrData[$i]['id_tipo'] == 1 ? 'GENERAL' : 'ESPECIFICA' ;
				$arrData[$i]['id_tipoEntidad'] = $arrData[$i]['id_tipoEntidad'] == 1 ? 'PUBLICO' : 'PRIVADO' ;
				

				$arrData[$i]['opciones'] =	'<a data-toggle="modal" href="#modal_Experiencia" class="btn btn-primary btn-xs" title="Editar" onclick="editarExperiencia('.$arrData[$i]['id_experiencia'].')">
													<i class="zmdi zmdi-edit zmdi-hc-fw"></i>
												</a>
                                				<a class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminarExperiencia('.$arrData[$i]['id_experiencia'].')">
                                					<i data-toggle="tooltip" title="Eiiminar"class="zmdi zmdi-delete zmdi-hc-fw"></i>
                                				</a>';
			}

			$output = array(
				//"draw"				=>	intval($_POST["draw"]),
				//"recordsTotal"		=> 	$arrData[2]['row'],
				//"recordsFiltered"	=>	$arrData[1]['row'],
				"data"				=>	$arrData
			);
			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
			// dep($arrData[0][0]['estado']);
		}


		public function getExperienciaId($idExperiencia)
		{

			$intIdExperiencia = intval(strClean($idExperiencia));

			if ($intIdExperiencia > 0) {
				
				$arrData = $this->model->selectExperienciaId($intIdExperiencia);
				//dep($arrData); exit;
				if(empty($arrData)){
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Datos No Encontrados.",
									]; 
				}else{
					$arrResponse = 	[
										"status"=> true,
										"data" 	=> $arrData,
									]; 
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}


		public function delExperiencia($idExperiencia)
		{
			
				$intIdExperiencia 	= intval(strClean($idExperiencia));
				$requestDelete 		= $this->model->deleteExperiencia($intIdExperiencia);

				if ($requestDelete > 0) {
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Experiencia Laboral",
										"msg" 	=> "Experiencia Laboral Eliminado Correctamente.",
									];

				}else{
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Error al eliminar la Formacion Academica",
									];
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			
				die();
		}


		public function getCountExperiencia($idContrato)
		{

			$intIdContrato = intval(strClean($idContrato));

			if ($intIdContrato > 0) {
				
				$arrData = $this->model->countExperiencia($intIdContrato);
				//dep($arrData); exit;
				if(empty($arrData)){
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Datos No Encontrados.",
									]; 
				}else{
					$arrResponse = 	[
										"status"=> true,
										"data" 	=> $arrData,
									]; 
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}



		/* FUNCION PROCESO - CONTRATO*/
		public function getSelectProceso() 
		{

			$arrData = $this->model->selectCboProceso();
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function getSelectLocal() 
		{

			$arrData = $this->model->selectCbolocal();
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function getSelectDepartamento() 
		{

			$arrData = $this->model->selectCboDepartamento();
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function getSelectProvincia() 
		{

			if($_POST){
				if(empty($_POST['codDepart'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$strCodDepart	= strClean($_POST['codDepart']);
				
					$arrData = $this->model->selectCboProvincia($strCodDepart);

					if(empty($arrData)){
						$arrResponse = 	[
											"status"=> false,
											"title"	=> "Error!",
											"msg" 	=> "Datos no encontrados",
										]; 
					}else{
						$arrResponse = 	[
											"status"=> true,
											"data" 	=> $arrData,
										]; 
					}
				}
			}

			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function getSelectDistrito()
		{
			if($_POST){
				if(empty($_POST['codDepart']) || empty($_POST['codProv']) ){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$strCodDepart	= strClean($_POST['codDepart']);
					$strCodProv		= strClean($_POST['codProv']);
				
					$arrData = $this->model->selectCboDistrito($strCodDepart, $strCodProv);

					if(empty($arrData)){
						$arrResponse = 	[
											"status"=> false,
											"title"	=> "Error!",
											"msg" 	=> "Datos no encontrados",
										]; 
					}else{
						$arrResponse = 	[
											"status"=> true,
											"data" 	=> $arrData,
										]; 
					}
				}
			}

			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function getSelectGrado() 
		{

			$arrData = $this->model->selectCboGrado();
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function getSelectNivel() 
		{

			if($_POST){
				if(empty($_POST['idGrado'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$intIdNivel	= intval(strClean($_POST['idGrado']));
				
					$arrData = $this->model->selectCboNivel($intIdNivel);

					if(empty($arrData)){
						$arrResponse = 	[
											"status"=> false,
											"title"	=> "Error!",
											"msg" 	=> "Datos no encontrados",
										]; 
					}else{
						$arrResponse = 	[
											"status"=> true,
											"data" 	=> $arrData,
										]; 
					}
				}
			}

			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

		
	}

?>