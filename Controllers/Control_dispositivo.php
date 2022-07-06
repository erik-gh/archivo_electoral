<?php 

	/**
	* 
	*/
	class Control_dispositivo extends Controllers
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


		public function control_dispositivo()
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
				// $intIdMaterial		= intval(strClean($_POST['idMaterial']));
				$intIdProceso		= intval(strClean($_POST['idProceso']));
				
				$arrData = $this->model->selectinpBarra($intIdProceso);

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
				//$strMaterial		= ($_POST['nommaterial'] != '') ? strClean($_POST['nommaterial']) : 'Los Documentos' ;
				
				// $intValor			= intval(strClean($_POST['valor']));

				$requestValidarMesa	= $this->model->validarMesaExiste($intIdProceso, $strMesa);

				if($requestValidarMesa == 0)
				{
						
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Control de Dispositivos USB",
										"msg" 	=> "Numero de Mesa no existe",
										"valor" => 0
									];
				}else{
						
					$requestValidarSoltec	= $this->model->validarMesaSoltec($intIdProceso, $intIdSolucion, $strMesa);
				
					if($requestValidarSoltec == 0)
					{
						$arrResponse = 	[
											"status"=> false,
											"title"	=> "Control de Dispositivos USB",
											"msg" 	=> "Numero de Mesa no pertenece a la Solucion tecnologica seleccionada",
											"valor" => 0
										];
					}else{


						$requestValidarOdpe	= $this->model->validarMesaOdpe($intIdProceso, $intIdodpe, $strMesa);

						if($requestValidarOdpe == 0)
						{
							$arrResponse = 	[
												"status"=> false,
												"title"	=> "Control de Dispositivos USB",
												"msg" 	=> "Numero de Mesa no pertenece a la ODPE seleccionada",
												"valor" => 0
											];
						}else{

							$requestValidarDepart	= $this->model->validarMesaDepart($intIdProceso, $strDepartamento, $strMesa);

							if($requestValidarDepart == 0)
							{
								$arrResponse = 	[
													"status"=> false,
													"title"	=> "Control de Dispositivos USB",
													"msg" 	=> "Numero de Mesa no pertenece al Departamento seleccionado",
													"valor" => 0
												];
							}else{

								$requestValidarProv	= $this->model->validarMesaProv($intIdProceso, $strProvincia, $strMesa);

								if($requestValidarProv == 0)
								{
									$arrResponse = 	[
														"status"=> false,
														"title"	=> "Control de Dispositivos USB",
														"msg" 	=> "Numero de Mesa no pertenece a la Provinecia seleccionada",
														"valor" => 0
													];
								}else{

									$requestValidarDist	= $this->model->validarMesaDist($intIdProceso, $strDistrito, $strMesa);

									if($requestValidarDist == 0)
									{
										$arrResponse = 	[
															"status"=> false,
															"title"	=> "Control de Dispositivos USB",
															"msg" 	=> "Numero de Mesa no pertenece al Distrito seleccionado",
															"valor" => 0
														];
									}else{
										
										$requestValidarIncid = $this->model->IncidenciaExiste($intIdMaterial, $intIdProceso, $intIdEtapa, $strMesa);
										
										if(!empty($requestValidarIncid))
										{
											$arrResponse = 	[
																"status"=> false,
																"title"	=> "Control de Dispositivos USB",
																"msg" 	=> "El numero de Mesa presenta una Incidencia en la Etapa de ".$strEtapa,
																"valor" => 2
																			
															];
										}else{
 											

											$requestMesaControl = $this->model->MesaExisteControl($intIdMaterial, $intIdProceso, $intIdEtapa, $strMesa, $intIdSolucion, $strCodigo, $intIdValidacion, $strCboUbigeo);
															//echo $requestMesaControl; exit;
											if(!empty($requestMesaControl)){
																
												$arrResponse = 	[
																	"status"=> false,
																	"title"	=> "Control de Dispositivos USB",
																	"msg" 	=> "El Dispositivo USB ya pasó la Etapa de ".$strEtapa,
																	"valor" => 0
																];
																

											}else{

													
												$requestActa = $this->model->insertDispositivo($intIdMaterial, $intIdProceso,  $intIdEtapa, $intIdSolucion, $intIdodpe, $strMesa, $strCodigo, $intIdValidacion, $intUserSession, $strCboUbigeo);
																	
												if($requestActa > 0){

													$arrResponse = 	[
																		"status"=> true,
																		"title"=> "Control de Dispositivos USB",
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
										
										}
										
									}
									
								}

							}
							
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
				$intIdMaterial		= intval(strClean($_POST['idMaterial']));
				$intIdProceso		= ($intIdFase != '' ) ? intval(strClean($_POST['idProceso'])) : 0;
				$intIdEtapa			= intval(strClean($_POST['idEtapa']));
				$intIdValidacion	= intval(strClean($_POST['validacion']));
				$strFase			= ($intIdFase != '') ? strClean($_POST['nomfase']) : '';
				$strMaterialDisp	= ($intIdFase != '') ? 'DISPOSITIVOS USB' : '';

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
									"title"			=> "Control de Dispositivos USB",
									"msg" 			=> "Datos por Fase.",
									"data"			=> $data,
									"nomFase"		=> $strFase,
									"nomDisp"		=> $strMaterialDisp
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
				$intIdMaterial		= intval(strClean($_POST['idMaterial']));
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
									"msg" 		=> "Datos por Odpe.",
									"data"		=> $data,
									"nomOdpe"	=> $strOdpe
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
				$intIdMaterial		= intval(strClean($_POST['idMaterial']));
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
				$intIdMaterial		= intval(strClean($_POST['idMaterial']));
				$intIdProceso		= intval(strClean($_POST['idProceso']));
				$intIdEtapa			= intval(strClean($_POST['idEtapa']));
				$intIdSolucion		= intval(strClean($_POST['idSolucion']));
				$intIdodpe			= intval(strClean($_POST['idOdpe']));
				$intIdValidacion	= intval(strClean($_POST['validacion']));
				$strOdpe			= ($intIdodpe != '') ? strClean($_POST['nomOdpe']) : '';

				$output = array();
				$requestFaltantes = $this->model->mesasFaltantes($intIdMaterial, $intIdProceso, $intIdEtapa, $intIdFase, $intIdSolucion, $intIdodpe, $intIdValidacion);
				//dep($requestFaltantes); exit;
				
				for ($i=0; $i <  count($requestFaltantes); $i++) { 
				# code...
					$requestFaltantes[$i]['ORDEN'] 	= 	$i+1;
				
				}

				$output = array(
					/*"draw"				=>	intval($_POST["draw"]),
					"recordsTotal"		=> 	count($arrData),
					"recordsFiltered"	=>	count($arrData),*/
					"data"				=>	$requestFaltantes
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



