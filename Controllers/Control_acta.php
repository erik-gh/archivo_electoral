
<?php 

	/**
	* 
	*/
	class Control_acta extends Controllers
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


		public function control_acta()
		{

			/*$data['page_tag']='PERFILES';
			$data['page_title']='SISTEMA DE FORMATOS - PERFILES';
			$data['page_name']='perfiles';
			$data['page_function_js']='function_perfil.js';
			$this->views->getView($this,'perfil',$data);*/
		}


		public function getSelectMaterial()
		{
			//dep($_POST); exit;
			if($_POST){
				$intIdProceso	= intval(strClean($_POST['idProceso']));

				$htmlOptions = '<option value="">[ SELECCIONE UN MATERIAL ]</option>';
				$arrData = $this->model->selectCboMaterial($intIdProceso);
				if(count($arrData) > 0){
					for ($i=0; $i < count($arrData) ; $i++) { 
						$htmlOptions .='<option value="'.$arrData[$i]['ID_MATERIAL'].'"> '.$arrData[$i]['MATERIAL'].'</option>';
					}
				}
				echo $htmlOptions;
				die();
			}
		}



		public function getSelectSolucion()
		{
			//dep($_POST); exit;
			if($_POST){
				$intIdProceso	= intval(strClean($_POST['idProceso']));

				$htmlOptions = '<option value="">[ SELECCIONE UNA SOL. TECN. ]</option>';
				$arrData = $this->model->selectCboSolucion($intIdProceso);
				if(count($arrData) > 0){
					for ($i=0; $i < count($arrData) ; $i++) { 
						$htmlOptions .='<option value="'.$arrData[$i]['ID_SOLUCIONTECNOLOGICA'].'"> '.$arrData[$i]['SOLUCIONTECNOLOGICA'].'</option>';
					}
				}
				echo $htmlOptions;
				die();
			}
		}


		public function getSelectOdpe()
		{
			//dep($_POST); exit;
			if($_POST){
				$intIdProceso	= intval(strClean($_POST['idProceso']));
				$intIdSolucion	= intval(strClean($_POST['idSolucion']));

				$htmlOptions = '<option value="">[ SELECCIONE UNA ODPE ]</option>';
				$arrData = $this->model->selectCboOdpe($intIdProceso, $intIdSolucion);
				if(count($arrData) > 0){
					for ($i=0; $i < count($arrData) ; $i++) { 
						$htmlOptions .='<option value="'.$arrData[$i]['ID_ODPE'].'"> '.$arrData[$i]['NOMBRE_ODPE'].'</option>';
					}
				}
				echo $htmlOptions;
				die();
			}
		}


		public function getSelectDepartamento()
		{
			//dep($_POST); exit;
			if($_POST){
				$intIdProceso	= intval(strClean($_POST['idProceso']));
				$intIdSolucion	= intval(strClean($_POST['idSolucion']));
				$intIdodpe		= intval(strClean($_POST['idOdpe']));
				$intIdEleccion	= intval(strClean($_POST['idEleccion']));

				
				$arrData = $this->model->selectCboDepartamento($intIdProceso, $intIdSolucion, $intIdodpe, $intIdEleccion);
				$htmlOptions = '<option value="">[ SELECCIONE '.$arrData[0]['SELECTOR'].' ]</option>';
				if(count($arrData) > 0){
					for ($i=0; $i < count($arrData) ; $i++) { 
						$htmlOptions .='<option value="'.$arrData[$i]['CODIGO'].'"> '.$arrData[$i]['DESCRIPCION'].'</option>';
					}
				}
				echo $htmlOptions;
				die();
			}
		}


		public function getSelectAgrupacion()
		{
			//dep($_POST); exit;
			if($_POST){
				$intIdProceso		= intval(strClean($_POST['idProceso']));
				$intIdSolucion		= intval(strClean($_POST['idSolucion']));
				$intIdodpe			= intval(strClean($_POST['idOdpe']));
				$intIdAgrupacion	= intval(strClean($_POST['idAgrupacion']));
				$intIdEleccion		= intval(strClean($_POST['idEleccion']));

				$htmlOptions = '<option value="">[ SELECCIONE UN DEPARTAMENTO ]</option>';
				$arrData = $this->model->selectCboAgrupacion($intIdProceso, $intIdSolucion, $intIdodpe, $intIdAgrupacion, $intIdEleccion);
				if(count($arrData) > 0){
					for ($i=0; $i < count($arrData) ; $i++) { 
						$htmlOptions .='<option value="'.$arrData[$i]['CODIGO'].'"> '.$arrData[$i]['DEPARTAMENTO_UBI'].'</option>';
					}
				}
				echo $htmlOptions;
				die();
			}
		}


		public function getSelectProvincia()
		{
			//dep($_POST); exit;
			if($_POST){
				$intIdProceso		= intval(strClean($_POST['idProceso']));
				$intIdSolucion		= intval(strClean($_POST['idSolucion']));
				$intIdodpe			= intval(strClean($_POST['idOdpe']));
				$intIdAgrupacion	= intval(strClean($_POST['idAgrupacion']));
				$strDepartamento	= strClean($_POST['idDepartamento']);
				$intIdEleccion		= intval(strClean($_POST['idEleccion']));

				$htmlOptions = '<option value="">[ SELECCIONE UNA PROVINCIA ]</option>';
				$arrData = $this->model->selectCboProvincia($intIdProceso, $intIdSolucion, $intIdodpe, $intIdAgrupacion, $strDepartamento, $intIdEleccion);
				if(count($arrData) > 0){
					for ($i=0; $i < count($arrData) ; $i++) { 
						$htmlOptions .='<option value="'.$arrData[$i]['CODIGO'].'"> '.$arrData[$i]['PROVINCIA_UBI'].'</option>';
					}
				}
				echo $htmlOptions;
				die();
			}
		}


		public function getSelectDistrito()
		{
			//dep($_POST); exit;
			if($_POST){
				$intIdProceso		= intval(strClean($_POST['idProceso']));
				$intIdSolucion		= intval(strClean($_POST['idSolucion']));
				$intIdodpe			= intval(strClean($_POST['idOdpe']));
				$intIdAgrupacion	= intval(strClean($_POST['idAgrupacion']));
				$strDepartamento	= strClean($_POST['idDepartamento']);
				$strProvincia		= strClean($_POST['idProvincia']);
				$intIdEleccion		= intval(strClean($_POST['idEleccion']));

				$htmlOptions = '<option value="">[ SELECCIONE UN DISTRITO ]</option>';
				$arrData = $this->model->selectCboDistrito($intIdProceso, $intIdSolucion, $intIdodpe, $intIdAgrupacion, $strDepartamento, $strProvincia, $intIdEleccion);
				if(count($arrData) > 0){
					for ($i=0; $i < count($arrData) ; $i++) { 
						$htmlOptions .='<option value="'.$arrData[$i]['CODIGO'].'"> '.$arrData[$i]['DISTRITO_UBI'].'</option>';
					}
				}
				echo $htmlOptions;
				die();
			}
		}


		public function getBarra()
		{
			// dep($_POST); exit;
			if($_POST){
				$intIdMaterial		= intval(strClean($_POST['idMaterial']));
				$intIdProceso		= intval(strClean($_POST['idProceso']));
				
				$arrData = $this->model->selectinpBarra($intIdMaterial, $intIdProceso);

				$arrResponse = 	[
									"status"	=> true,
									"title"		=> "Codigo de barras",
									"msg" 		=> "Datos correctos.",
									"data"		=> $arrData,
								];

			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}



		public function getBarraEmparejamiento()
		{
			// dep($_POST); exit;
			if($_POST){
				$intIdProceso		= intval(strClean($_POST['idProceso']));
				
				$arrData = $this->model->selectinpBarraEmparejamiento($intIdProceso);

				$arrResponse = 	[
									"status"	=> true,
									"title"		=> "Codigo de barras",
									"msg" 		=> "Datos correctos.",
									"data"		=> $arrData,
								];

			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function ordenEmparejamiento()
		{
			//dep($_POST); exit;
			if($_POST){
				$intIdMaterial		= intval(strClean($_POST['idMaterial']));
				$intIdProceso		= intval(strClean($_POST['idProceso']));
				$intIdFase			= intval(strClean($_POST['idFase']));
				$intIdEtapa			= intval(strClean($_POST['idEtapa']));
				$intIdSolucion		= intval(strClean($_POST['idSolucion']));
				$intIdodpe			= intval(strClean($_POST['idOdpe']));
				$intIdAgrupacion	= intval(strClean($_POST['idAgrupacion']));
				$strDepartamento	= strClean($_POST['idDepartamento']);
				$strProvincia		= strClean($_POST['idProvincia']);
				$strDistrito		= strClean($_POST['idDistrito']);
				$intIdValidacion	= intval(strClean($_POST['validacion']));
				$intIdEleccion		= intval(strClean($_POST['idEleccion']));

				if($intIdEleccion == 1){
				
					$requestOrden = $this->model->ordenEmparejamiento($intIdMaterial, $intIdProceso, $intIdEtapa, $intIdFase, $intIdSolucion, $intIdodpe, $strDepartamento, $strProvincia, $strDistrito, $intIdValidacion);
				
				}else{

					$requestOrden = $this->model->ordenEmparejamientoEI($intIdMaterial, $intIdProceso, $intIdEtapa, $intIdFase, $intIdSolucion, $intIdodpe, $strDepartamento, $strProvincia, $strDistrito, $intIdValidacion);
					// dep($requestOrden); exit;
				}

				if(!empty($requestOrden))
				{
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Control de Acta Padrón",
										"msg" 	=> "Orden Empaquetado",
										"data"	=> $requestOrden,
									];
					
				}else{
					
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Control de Acta Padrón",
										"msg" 	=> "Distrito Completo",
									];
				}
				
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function validarMesa()
		{
			// dep($_POST); exit;
			if($_POST){
				$intIdProceso		= intval(strClean($_POST['idProceso']));
				$intIdMaterial		= intval(strClean($_POST['idMaterial']));
				$intIdEtapa			= intval(strClean($_POST['idEtapa']));
				$intIdFase			= intval(strClean($_POST['idFase']));
				$intIdSolucion		= intval(strClean($_POST['idSolucion']));
				$intIdodpe			= intval(strClean($_POST['idOdpe']));
				$intIdAgrupacion	= intval(strClean($_POST['idAgrupacion']));
				$strDepartamento	= strClean($_POST['idDepartamento']);
				$strProvincia		= strClean($_POST['idProvincia']);
				$strDistrito		= strClean($_POST['idDistrito']);
				$intIdEleccion		= intval(strClean($_POST['idEleccion']));
				$strMesa	 		= strClean($_POST['mesa']);
				$strCodigo			= strClean($_POST['codigo']);
				$strEtapa			= strClean($_POST['etapa']);
				$strCboUbigeo		= strClean($_POST['cboubigeo']);
				$intIdValidacion	= intval(strClean($_POST['validacion']));
				$intUserSession		= intval(strClean($_SESSION['idUser']));
				$strMaterial		= ($_POST['nommaterial'] != '') ? strClean($_POST['nommaterial']) : 'Los Documentos' ;
				
				// $intValor			= intval(strClean($_POST['valor']));

				$requestValidarMesa	= $this->model->validarMesaExiste($intIdProceso, $strMesa);

				if($requestValidarMesa == 0)
				{
						
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Control de Acta Padrón",
										"msg" 	=> "Numero de Mesa no existe",
										"valor" => 0
									];
				}else{
						
					$requestValidarSoltec	= $this->model->validarMesaSoltec($intIdProceso, $intIdSolucion, $strMesa);
				
					if($requestValidarSoltec == 0)
					{
						$arrResponse = 	[
											"status"=> false,
											"title"	=> "Control de Acta Padrón",
											"msg" 	=> "Numero de Mesa no pertenece a la Solucion tecnologica seleccionada",
											"valor" => 0
										];
					}else{


						$requestValidarOdpe	= $this->model->validarMesaOdpe($intIdProceso, $intIdodpe, $strMesa);

						if($requestValidarOdpe == 0)
						{
							$arrResponse = 	[
												"status"=> false,
												"title"	=> "Control de Acta Padrón",
												"msg" 	=> "Numero de Mesa no pertenece a la ODPE seleccionada",
												"valor" => 0
											];
						}else{

							if($intIdEleccion == 2){

								$requestValidarAgrupacion	= $this->model->validarMesaAgrupacion($intIdProceso, $intIdAgrupacion, $strMesa);
								
								if($requestValidarAgrupacion == 0){
									$arrResponse = 	[
														"status"	=> false,
														"title"		=> "Control de Cedulas",
														"msg" 		=> "Numero de Mesa no pertenece a la Agrupación Política seleccionada",
														"valor" 	=> 0,
														"NroMesa" 	=> $strMesa
													];
									echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
									return false;
								}

							}

							/*$requestValidarDepart	= $this->model->validarMesaDepart($intIdProceso, $strDepartamento, $strMesa);

							if($requestValidarDepart == 0)
							{
								$arrResponse = 	[
													"status"=> false,
													"title"	=> "Control de Acta Padrón",
													"msg" 	=> "Numero de Mesa no pertenece al Departamento seleccionado",
													"valor" => 0
												];
							}else{*/

								$requestValidarProv	= $this->model->validarMesaProv($intIdProceso, $strDepartamento, $strProvincia, $strMesa);

								if($requestValidarProv == 0)
								{
									$arrResponse = 	[
														"status"=> false,
														"title"	=> "Control de Acta Padrón",
														"msg" 	=> "Numero de Mesa no pertenece a la Provinecia seleccionada",
														"valor" => 0
													];
								}else{

									$requestValidarDist	= $this->model->validarMesaDist($intIdProceso, $strDepartamento, $strProvincia, $strDistrito, $strMesa);

									if($requestValidarDist == 0)
									{
										$arrResponse = 	[
															"status"=> false,
															"title"	=> "Control de Acta Padrón",
															"msg" 	=> "Numero de Mesa no pertenece al Distrito seleccionado",
															"valor" => 0
														];
									}else{
										
										$requestValidarIncid = $this->model->IncidenciaExiste($intIdMaterial, $intIdProceso, $intIdEtapa, $strMesa);

										if(!empty($requestValidarIncid))
										{
											$arrResponse = 	[
																"status"=> false,
																"title"	=> "Control de Acta Padrón",
																"msg" 	=> $strMaterial." presenta una Incidencia en la Etapa de ".$strEtapa,
																"valor" => 2
																			
															];
										}else{
 											
											if($intIdEtapa != 4){

												$requestMesaControl = $this->model->MesaExisteControl($intIdMaterial, $intIdProceso, $intIdEtapa, $strMesa, $intIdSolucion, $intIdValidacion, $strCboUbigeo);
															//echo $requestMesaControl; exit;
												if(!empty($requestMesaControl)){
																
													$arrResponse = 	[
																		"status"=> false,
																		"title"	=> "Control de Acta Padrón",
																		"msg" 	=> "El Documento Electoral ya pasó la Etapa de ".$strEtapa,
																		"valor" => 0
																	];
																

												}else{

													
													$requestActa = $this->model->insertActa($intIdMaterial, $intIdProceso,  $intIdEtapa, $intIdSolucion, $intIdodpe, $strMesa, $intIdValidacion, $intUserSession, $strCboUbigeo);
																	
													if($requestActa > 0){

														$arrResponse = 	[
																			"status"=> true,
																			"title"=> "Control de Acta Padrón",
																			"msg" 	=> "Datos Guardados Correctamente.",
																			"valor" => 3
																		];
																	
													}else{
														$arrResponse = 	[
																			"status"=> false,
																			"title"	=> "Error!",
																			"msg" 	=> "No se puede conectarse a la Base Datos",
																		];
													}
												}
															
											}else{	

												$intIdMaterialDoc	= intval(strClean($_POST['idMaterialDoc']));
												$intIdetapaControl 	= 1;

												$requestPasoEtapaLista = $this->model->MesaPasoEtapa($intIdMaterial, $intIdProceso, $intIdetapaControl, $strMesa, $intIdSolucion, $intIdValidacion, $strCboUbigeo );
																
												if(empty($requestPasoEtapaLista))
												{
													$arrResponse = 	[
																		"status"=> false,
																		"title"	=> "Control de Acta Padrón",
																		"msg" 	=> "La Lista de Electores no ha pasado la etapa de Recepcion.",
																		"valor" => 0
																	];
												}else{

													$requestPasoEtapaDoc = $this->model->MesaPasoEtapa($intIdMaterialDoc, $intIdProceso, $intIdetapaControl, $strMesa, $intIdSolucion, $intIdValidacion, $strCboUbigeo );

													if(empty($requestPasoEtapaDoc))
													{
														$arrResponse = 	[
																			"status"=> false,
																			"title"	=> "Control de Acta Padrón",
																			"msg" 	=> "El Documento Electoral no ha pasado la etapa de Recepcion.",
																			"valor" => 0
																		];
													}else{


														$requestMesaControl = $this->model->MesaExisteControl($intIdMaterial, $intIdProceso, $intIdEtapa, $strMesa, $intIdSolucion, $intIdValidacion, $strCboUbigeo);
														if(!empty($requestMesaControl))
														{

															$arrResponse = 	[
																				"status"=> false,
																				"title"	=> "Control de Acta Padrón",
																				"msg" 	=> "El Documento Electoral ya pasó la Etapa de ".$strEtapa,
																				"valor" => 0
																			];
														}else{

															if($intIdEleccion == 1){
				
																$requestOrdenEmp = $this->model->ordenEmparejamiento($intIdMaterial, $intIdProceso, $intIdEtapa, $intIdFase, $intIdSolucion, $intIdodpe, $strDepartamento, $strProvincia, $strDistrito, $intIdValidacion);

															}else{
											
																$requestOrdenEmp = $this->model->ordenEmparejamientoEI($intIdMaterial, $intIdProceso, $intIdEtapa, $intIdFase, $intIdSolucion, $intIdodpe, $strDepartamento, $strProvincia, $strDistrito, $intIdValidacion);
											
															}


															if( $strMesa == $requestOrdenEmp['NRO_MESA'])
															{
																$requestActa = $this->model->insertActa($intIdMaterial, $intIdProceso,  $intIdEtapa, $intIdSolucion, $intIdodpe, $strMesa, $intIdValidacion, $intUserSession, $strCboUbigeo);

																if($requestActa > 0){
																			
																	$arrResponse = 	[
																						"status"=> true,
																						"title"	=> "Control de Acta Padrón",
																						"msg" 	=> "Datos Guardados Correctamente.",
																						"valor" => 3
																					];
																	}

															}else{
																		
																$arrResponse = 	[
																					"status"=> false,
																					"title"	=> "Control de Acta Padrón",
																					"msg" 	=> "El Número de Mesa no coincide con la Solicitada.",
																					"valor" => 0
																				];

															}

														}

													}
												}
															
											}
										
										}
										
									}
									
								}

							//}
							
						}
						
					}
				}

			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}
		

		public function getAvanceFase()
		{
			// dep($_POST); exit;
			if($_POST){
				$intIdFase			= intval(strClean($_POST['idFase']));
				$intIdMaterial		= (isset($_POST['idMaterial'])) ? intval(strClean($_POST['idMaterial'])) : 2 ;
				$intIdProceso		= ($intIdFase != '' ) ? intval(strClean($_POST['idProceso'])) : 0;
				$intIdEtapa			= intval(strClean($_POST['idEtapa']));
				$intIdValidacion	= intval(strClean($_POST['validacion']));
				$strFase			= ($intIdFase != '') ? strClean($_POST['nomfase']) : '';
				$strMaterial		= ($intIdFase != '') ? strClean($_POST['nommaterial']) : '';
				$strMaterialEmp		= ($intIdFase != '') ? 'EMPAREJAMIENTO' : '';

				$requestFase = $this->model->avanceFase($intIdMaterial, $intIdProceso, $intIdEtapa, $intIdFase, $intIdValidacion);
				// echo $requestFase; exit;
				$data='';

				foreach ($requestFase as $a) {

						$data 	.=	'<tr  class="text-center font-table">
	                					<td>'.$a['TOTAL'].'</td>
	                					<td>'.$a['RECIBIDOS'].'</td>
	                					<td>'.$a['FALTANTES'].'</td>
	                					<td>'.$a['PORC_RECIBIDOS'].' %</td>
	                					<td>'.$a['PORC_FALTANTES'].' %</td>
	                				</tr>';
				}	

				$arrResponse = 	[
									"status"		=> true,
									"title"			=> "Control de Acta Padrón!",
									"msg" 			=> "Datos por Fase.",
									"data"			=> $data,
									"nomFase"		=> $strFase,
									"nomMaterial"	=> $strMaterial,
									"nomEmp"		=> $strMaterialEmp
								];
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function getAvanceOdpe()
		{ 
			//dep($_POST); exit;
			if($_POST){
				$intIdFase			= intval(strClean($_POST['idFase']));
				$intIdMaterial		= (isset($_POST['idMaterial'])) ? intval(strClean($_POST['idMaterial'])) : 2 ;
				$intIdProceso		= ($intIdFase != '' ) ? intval(strClean($_POST['idProceso'])) : 0;
				$intIdEtapa			= intval(strClean($_POST['idEtapa']));
				$intIdodpe			= intval(strClean($_POST['idOdpe']));
				$intIdSolucion		= intval(strClean($_POST['idSolucion']));
				$intIdValidacion	= ($intIdEtapa == 2) ? 2 : 1;
				$strOdpe			= ($intIdodpe != '') ? strClean($_POST['nomOdpe']) : '';

				$requestOdpe = $this->model->avanceOdpe($intIdMaterial, $intIdProceso, $intIdEtapa, $intIdFase, $intIdodpe, $intIdSolucion, $intIdValidacion);
				// dep($requestOdpe); exit;
				$data='';

				foreach ($requestOdpe as $a) {

						$data 	.=	'<tr  class="text-center font-table">
	                					<td>'.$a['CODIGO_SOLUCION'].'</td>
	                					<td>'.$a['TOTAL'].'</td>
	                					<td>'.$a['RECIBIDOS'].'</td>
	                					<td>'.$a['FALTANTES'].'</td>
	                					<td>'.$a['PORC_RECIBIDOS'].' %</td>
	                					<td>'.$a['PORC_FALTANTES'].' %</td>
	                				</tr>';
				}	

				$arrResponse = 	[
									"status"	=> true,
									"title"		=> "Control de Acceso!",
									"msg" 		=> "Datos por Gerencia.",
									"data"		=> $data,
									"nomOdpe"	=> $strOdpe
								];
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}
		

		public function getAvanceAgrupacion()
		{
			// dep($_POST); exit;
			if($_POST){
				$intIdFase			= intval(strClean($_POST['idFase']));
				$intIdMaterial		= intval(strClean($_POST['idMaterial']));
				$intIdProceso		= ($intIdFase != '' ) ? intval(strClean($_POST['idProceso'])) : 0;
				$intIdEtapa			= intval(strClean($_POST['idEtapa']));
				$intIdodpe			= intval(strClean($_POST['idOdpe']));
				$intIdValidacion	= ($intIdEtapa == 2) ? 2 : 1;
				$strOdpe			= ($intIdodpe != '') ? strClean($_POST['nomOdpe']) : '';
				$strEtapa			= strClean($_POST['nomEtapa']);

				$requestAgrupacion = $this->model->avanceAgrupacion($intIdMaterial, $intIdProceso, $intIdEtapa, $intIdFase, $intIdodpe, $intIdValidacion);
				// dep($requestAgrupacion); exit;
				$strEtapa = "'".$strEtapa."'";
				
				$data='';

				foreach ($requestAgrupacion as $a) {
						$PorcCompleto = ($a['PORCENTAJE_RECIBIDOS'] == 100.00) ? 'bg-blue' : '' ;
						$data 	.=	'<tr  class="text-center font-table">
	                					<td>'.$a['AGRUPACION_POLITCA'].'</td>
	                					<td><a onclick="verTotalAgrup('.$a['ID_AGRUPACION'].','."'".$a['AGRUPACION_POLITCA']."'".','.$strEtapa.',1)" style="cursor: pointer;"><b>'.$a['TOTAL'].'</b></a></td>
	                					<td>'.$a['TOTAL_PAQUETE'].'</td>
	                					<td><a onclick="verTotalAgrup('.$a['ID_AGRUPACION'].','."'".$a['AGRUPACION_POLITCA']."'".','.$strEtapa.',2)" style="cursor: pointer;"><b>'.$a['PAQUETES_RECIBIDOS'].'</b></a></td>
	                					<td><a onclick="verTotalAgrup('.$a['ID_AGRUPACION'].','."'".$a['AGRUPACION_POLITCA']."'".','.$strEtapa.',3)" style="cursor: pointer;"><b>'.$a['PAQUETES_FALTANTES'].'</b></a></td>
	                					<td class="'.$PorcCompleto.'">'.$a['PORCENTAJE_RECIBIDOS'].' %</td>
	                					<td>'.$a['PORCENTAJE_FALTANTES'].' %</td>
	                				</tr>';
				}	

				$arrResponse = 	[
									"status"	=> true,
									"title"		=> "Control de Cedulas!",
									"msg" 		=> "Datos por Partido Político.",
									"data"		=> $data,
									"nomOdpe"	=> $strOdpe
								];
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function getTotalAgrupacion()
		{
			// dep($_POST); exit;

			if($_POST){
				$intIdFase			= intval(strClean($_POST['idFase']));
				$intIdProceso		= ($intIdFase != '' ) ? intval(strClean($_POST['idProceso'])) : 0;
				$intIdMaterial		= intval(strClean($_POST['idMaterial']));
				$intIdEtapa			= intval(strClean($_POST['idEtapa']));
				$intIdSolucion		= intval(strClean($_POST['idSolucion']));
				$intIdodpe			= intval(strClean($_POST['idOdpe']));
				$intIdAgrupacion	= intval(strClean($_POST['idAgrupacion']));
				$intIdValidacion	= ($intIdEtapa == 2) ? 2 : 1;
				$intIdValor			= intval(strClean($_POST['idValor']));
				$strOdpe			= ($intIdodpe != '') ? strClean($_POST['nomOdpe']) : '';
				$strAgrupacion		= strClean($_POST['nomAgrupacion']);
				
				if($intIdValor == 1){
		
					$requestAgrupacion = $this->model->mesasAgrupacion($intIdProceso, $intIdFase, $intIdodpe, $intIdSolucion, $intIdAgrupacion);
					$nomAgrupacion = "LISTA DE MESAS DEL PARTIDO POLITICO <br>".$strAgrupacion;

				}else if ($intIdValor == 2){
					
					$requestAgrupacion = $this->model->mesasEscAgrupacion($intIdProceso, $intIdFase, $intIdodpe, $intIdSolucion, $intIdAgrupacion, $intIdMaterial, $intIdEtapa, $intIdValidacion);
					$nomAgrupacion = "LISTA DE MESAS ESCANEADAS DEL PARTIDO POLITICO <br>".$strAgrupacion;

				}else{

					$requestAgrupacion = $this->model->mesasFaltAgrupacion($intIdProceso, $intIdFase, $intIdodpe, $intIdSolucion, $intIdAgrupacion, $intIdMaterial, $intIdEtapa, $intIdValidacion);
					$nomAgrupacion = "LISTA DE MESAS FALTANTES DEL PARTIDO POLITICO <br>".$strAgrupacion;
				}
				// dep($requestAgrupacion); exit;
				$data='			<tr>';
				$x=1;
				foreach ($requestAgrupacion as $a) {

					$data 	.=	'	<td style="padding: 4px;">&nbsp; '.$a['NRO_MESA'].'('.$a['NRO_ELECTORES'].') &nbsp;</td>';
										if($x==5){
					
					$data 	.=	'</tr>
								<tr>';
											$x=0;
										}
										$x=$x+1; 
				}

				$data .= '					</tr>';
				
				$arrResponse = 	[
									"status"	=> true,
									"title"		=> "Control de Cedulas!",
									"msg" 		=> "Datos por Partido Político.",
									"data"		=> $data,
									"nomOdpe"	=> $strOdpe,
									"cantidadMesa" => count($requestAgrupacion),
									"nomAgrupacion"	=> $nomAgrupacion
								];
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

		
		public function mesasEscaneadas()
		{
			// dep($_POST); exit;
			if($_POST){
				$intIdFase			= intval(strClean($_POST['idFase']));
				$intIdMaterial		= (isset($_POST['idMaterial'])) ? intval(strClean($_POST['idMaterial'])) : 2 ;
				$intIdProceso		= intval(strClean($_POST['idProceso']));
				$intIdEtapa			= intval(strClean($_POST['idEtapa']));
				$intIdSolucion		= intval(strClean($_POST['idSolucion']));
				$intIdodpe			= intval(strClean($_POST['idOdpe']));
				$intIdValidacion	= intval(strClean($_POST['validacion']));
				$strOdpe			= ($intIdodpe != '') ? strClean($_POST['nomOdpe']) : '';

				$output = array();
				$requestEscaneadas = $this->model->mesasEscaneadas($intIdMaterial, $intIdProceso, $intIdEtapa, $intIdFase, $intIdSolucion, $intIdodpe, $intIdValidacion);
				// dep($requestEscaneadas); exit;
				
				for ($i=0; $i <  count($requestEscaneadas); $i++) { 
				# code...
					$requestEscaneadas[$i]['ORDEN'] 	= 	$i+1;
				
				}

				$output = array(
					/*"draw"				=>	intval($_POST["draw"]),
					"recordsTotal"		=> 	count($arrData),
					"recordsFiltered"	=>	count($arrData),*/
					"data"				=>	$requestEscaneadas
				);
			}
			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function mesasFaltantes()
		{
			// dep($_POST); exit;
			if($_POST){
				$intIdFase			= intval(strClean($_POST['idFase']));
				$intIdMaterial		= (isset($_POST['idMaterial'])) ? intval(strClean($_POST['idMaterial'])) : 2 ;
				$intIdProceso		= intval(strClean($_POST['idProceso']));
				$intIdEtapa			= intval(strClean($_POST['idEtapa']));
				$intIdSolucion		= intval(strClean($_POST['idSolucion']));
				$intIdodpe			= intval(strClean($_POST['idOdpe']));
				$intIdValidacion	= intval(strClean($_POST['validacion']));
				$strOdpe			= ($intIdodpe != '') ? strClean($_POST['nomOdpe']) : '';

				$output = array();
				$requestEscaneadas = $this->model->mesasFaltantes($intIdMaterial, $intIdProceso, $intIdEtapa, $intIdFase, $intIdSolucion, $intIdodpe, $intIdValidacion);
				//dep($requestEscaneadas); exit;
				
				for ($i=0; $i <  count($requestEscaneadas); $i++) { 
				# code...
					$requestEscaneadas[$i]['ORDEN'] 	= 	$i+1;
				
				}

				$output = array(
					/*"draw"				=>	intval($_POST["draw"]),
					"recordsTotal"		=> 	count($arrData),
					"recordsFiltered"	=>	count($arrData),*/
					"data"				=>	$requestEscaneadas
				);
			}
			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
		}



		public function getSelectIncidencia()
		{
			// dep($_POST); exit;
			if($_POST){
				$intIdEtapa	= intval(strClean($_POST['idEtapa']));

				$htmlOptions = '<option value="">[ SELECCIONE UNA INCIDENCIA ]</option>';
				$arrData = $this->model->selectCboIncidencia($intIdEtapa);
				if(count($arrData) > 0){
					for ($i=0; $i < count($arrData) ; $i++) { 
						$htmlOptions .='<option value="'.$arrData[$i]['ID_INCIDENCIA'].'"> '.$arrData[$i]['INCIDENCIA'].'</option>';
					}
				}
				echo $htmlOptions;
				die();
			}
		}


		public function setIncidencia()
		{
			// dep($_POST); exit;
			if($_POST){
				if(empty($_POST['idIncidencia']) || empty($_POST['mesa'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$intIdMaterial		= intval(strClean($_POST['idMaterial']));
					$intIdProceso		= intval(strClean($_POST['idProceso']));
					$intIdEtapa			= intval(strClean($_POST['idEtapa']));
					$intIdodpe			= intval(strClean($_POST['idOdpe']));
					$intIdIncidencia	= intval(strClean($_POST['idIncidencia']));
					$strMesa			= strClean($_POST['mesa']);
					$intCantidad		= (isset($_POST['cantidad'])) ? intval(strClean($_POST['cantidad'])) : 0 ;
					$strConsulta		= (isset($_POST['consulta'])) ? strClean($_POST['consulta']) : '' ;
					$strCUbigeo			= strClean($_POST['cUbigeo']);
					$intUserSession		= intval(strClean($_SESSION['idUser']));
					
					$requestIdMesa = $this->model->selectIdMesa($intIdProceso, $strMesa) ;
					$intidSufragio = ($requestIdMesa['ID_SUFRAGIO'] != '') ? $requestIdMesa['ID_SUFRAGIO'] : 0;

					$requestIncidencia	= $this->model->insertIncidencia($intIdMaterial, $intIdProceso, $intIdEtapa, $intIdodpe, $intIdIncidencia, $strMesa, $intCantidad, $strConsulta, $strCUbigeo, $intUserSession, $intidSufragio);
					

					if($requestIncidencia == 1){

						
						$arrResponse = 	[
											"status"=> true,
											"title"	=> "Control Incidencia",
											"msg" 	=> "Datos Guardados Correctamente.",
										];
						
					}else if($requestIncidencia == 2){
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Alerta!",
										    "msg" 	=> "El Número de Mesa ya registra esta incidencia.",
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


	}

?>



