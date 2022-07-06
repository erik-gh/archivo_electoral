<?php 

	/**
	* 
	*/
	class Control_reserva extends Controllers
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


		public function control_reserva()
		{

			/*$data['page_tag']='PERFILES';
			$data['page_title']='SISTEMA DE FORMATOS - PERFILES';
			$data['page_name']='perfiles';
			$data['page_function_js']='function_perfil.js';
			$this->views->getView($this,'perfil',$data);*/
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


		public function getSelectConsulta()
		{
			//dep($_POST); exit;
			if($_POST){
				$intIdMaterial		= intval(strClean($_POST['idMaterial']));
				$intIdProceso		= intval(strClean($_POST['idProceso']));
				$intIdSolucion		= intval(strClean($_POST['idSolucion']));
				$intIdodpe			= intval(strClean($_POST['idOdpe']));
				$intIdAgrupacion	= intval(strClean($_POST['idAgrupacion']));
				$strDepartamento	= strClean($_POST['idDepartamento']);
				$strProvincia		= strClean($_POST['idProvincia']);
				$strDistrito		= strClean($_POST['idDistrito']);
				$intIdEleccion		= intval(strClean($_POST['idEleccion']));

				$htmlOptions = '<option value="">[ SELECCIONE TIPO DE C&Eacute;DULA ]</option>';
				$arrData = $this->model->selectCboCedula($intIdMaterial, $intIdProceso, $intIdSolucion, $intIdodpe, $intIdAgrupacion, $strDepartamento, $strProvincia, $strDistrito, $intIdEleccion);
				if(count($arrData) > 0){
					for ($i=0; $i < count($arrData) ; $i++) { 
						$htmlOptions .='<option value="'.$arrData[$i]['SUF_UBIGEO'].'"> '.$arrData[$i]['TIPO_CEDULA'].'</option>';
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
				$intIdSolucion		= intval(strClean($_POST['idSolucion']));
				$intIdodpe			= intval(strClean($_POST['idOdpe']));
				$intIdAgrupacion	= intval(strClean($_POST['idAgrupacion']));
				$strDepartamento	= strClean($_POST['idDepartamento']);
				$strProvincia		= strClean($_POST['idProvincia']);
				$strDistrito		= strClean($_POST['idDistrito']);
				$strConsulta		= strClean($_POST['consulta']);
				$intIdEleccion		= intval(strClean($_POST['idEleccion']));

				$arrData = $this->model->selectinpBarra($intIdMaterial, $intIdProceso, $intIdSolucion, $intIdodpe, $intIdAgrupacion, $strDepartamento, $strProvincia, $strDistrito, $strConsulta, $intIdEleccion);

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


		public function ordenEmpaquetado()
		{
			// dep($_POST); exit;
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
				$strConsulta		= strClean($_POST['consulta']);
				$intIdValidacion	= intval(strClean($_POST['validacion']));
				$intIdEleccion		= intval(strClean($_POST['idEleccion']));
				$strEtapa			= strClean($_POST['etapa']);
				$strCboUbigeo		= strClean($_POST['cboubigeo']);
				$nomdepartamento	= strClean($_POST['nomdepartamento']);
				$nomprovincia		= strClean($_POST['nomprovincia']);
				$nomdistrito		= strClean($_POST['nomdistrito']);

				$requestOrden = $this->model->ordenEmpaquetado($intIdMaterial, $intIdProceso, $intIdEtapa, $intIdFase, $intIdSolucion, $intIdodpe, $strDepartamento, $strProvincia, $strDistrito, $strConsulta, $intIdValidacion, $strCboUbigeo);

				$requestBarra = $this->model->selectinpBarra($intIdMaterial, $intIdProceso, $intIdSolucion, $intIdodpe, $intIdAgrupacion, $strDepartamento, $strProvincia, $strDistrito, $strConsulta, $intIdEleccion);

				$codReserva 	= $requestBarra['PREF_ROTULO'];
				$cantReserva 	= $requestBarra['SUF_ROTULO'];


				if(empty($requestOrden)){
					$rotuloNext 	= 	$codReserva.$cantReserva.'0001';
					$departamento 	=	$nomdepartamento;
					$provincia 		=	$nomprovincia;
					$distrito 		= 	$nomdistrito;
				}else{
					$rotuloNext 	= 	$codReserva.$cantReserva.$requestOrden['ROTULO'];
					$departamento 	=	$requestOrden['DEPARTAMENTO_UBI'];
					$provincia 		=	$requestOrden['PROVINCIA_UBI'];
					$distrito 		= 	$requestOrden['DISTRITO_UBI'];
				}


				$arrResponse = 	[
										"status"		=> true,
										"title"			=> "Control de Cedulas",
										"msg" 			=> "Orden Empaquetado",
										"mesa_next"		=> $rotuloNext,
										"departamento"	=> $departamento,
										"provincia"		=> $provincia,
										"distrito"		=> $distrito,
									];

				/*if(!empty($requestOrden))
				{
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Control de Cedulas",
										"msg" 	=> "Orden Empaquetado",
										"data"	=> $requestOrden,
									];
					
				}else{
					
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Control de Cedulas",
										"msg" 	=> "Distrito Completo",
									];
				}*/
				
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function validarMesa()
		{
			//dep($_POST); exit;
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
				/*$strMesa	 		= strClean($_POST['mesa']);
				$strElectores		= strClean($_POST['electores']);
				$strCUbigeo			= strClean($_POST['cUbigeo']);*/
				$strConsulta		= strClean($_POST['consulta']);
				$strEtapa			= strClean($_POST['etapa']);
				$strCboUbigeo		= strClean($_POST['cboubigeo']);
				$intIdValidacion	= intval(strClean($_POST['validacion']));
				$intUserSession		= intval(strClean($_SESSION['idUser']));
				// $intValor			= intval(strClean($_POST['valor']));
				$strUbigeo			= strClean($_POST['ubigeo']);
				$strRotulo			= strClean($_POST['rotulo']);

				//$strCboUbigeoSel = substr($_POST["cUbigeo"],0,2) == 14 && substr($_POST["cUbigeo"],2,2) == 01 ) ? substr($_POST["cUbigeo"],0,4) : substr($_POST["cUbigeo"],0,2);
				$arrData = $this->model->selectinpBarra($intIdMaterial, $intIdProceso, $intIdSolucion, $intIdodpe, $intIdAgrupacion, $strDepartamento, $strProvincia, $strDistrito, $strConsulta, $intIdEleccion);

				$preUbigeo  = substr($strUbigeo,0,strlen($arrData['PREF_UBIGEO']));     
                $strCUbigeo = substr($strUbigeo,strlen($arrData['PREF_UBIGEO']), 6);
                $sufUbigeo  = substr($strUbigeo,strlen($arrData['PREF_UBIGEO'])+6, strlen($arrData['SUF_UBIGEO']));

                $preRotulo  = substr($strRotulo,0,strlen($arrData['PREF_ROTULO']));     
                $cRotulo    = substr($strRotulo,strlen($arrData['PREF_ROTULO'])+strlen($arrData['SUF_ROTULO']), 4);
                $sufRotulo  = substr($strRotulo,strlen($arrData['PREF_ROTULO']), strlen($arrData['SUF_ROTULO']));

                //$UbigeoUnico = $arrData['PREF_UBIGEO'].$arrData['SUF_UBIGEO'];

                $strMesa       = substr($cRotulo, 0, 4);   
                //$strElectores  = substr($cRotulo, 6, 3);

                // echo 'UBIGEO: pref: '.$preUbigeo.' ubig: '.$strCUbigeo.' suf: '.$sufUbigeo.' ROTULO pref:'.$preRotulo.' rotulo: '.$cRotulo.' sufro: '.$sufRotulo.' MESA: Nro: '.$strMesa, exit;

                if(strlen($strUbigeo) != $arrData['DIG_UBIGEO'] ){
                	$arrResponse = 	[
										"status"	=> false,
										"title"		=> "Control de Cedulas",
										"msg" 		=> "Verificar la cantidad de Digitos del Ubigeo",
										"valor" 	=> 0,
										"NroMesa" 	=> $strMesa
											];
                }else{

                	if(strlen($preUbigeo) != strlen($arrData['PREF_UBIGEO']) || $preUbigeo != $arrData['PREF_UBIGEO'] ){
                	//if($strUbigeo != $UbigeoUnico ){
                		$arrResponse = 	[
											"status"	=> false,
											"title"		=> "Control de Cedulas",
											"msg" 		=> "El Codigo del Ubigeo no coincide",
											"valor" 	=> 0,
											"NroMesa" 	=> $strMesa
										];
                	}else{

                		/*if(strlen($sufUbigeo) != strlen($arrData['SUF_UBIGEO']) || $sufUbigeo != $arrData['SUF_UBIGEO']  ){
                			$arrResponse = 	[
												"status"=> false,
												"title"	=> "Control de Cedulas",
												"msg" 	=> "El Tipo de Consulta del Ubigeo no coincide",
												"valor" => 0,
												"NroMesa" 	=> $strMesa
											];
                		}else{*/

                			if( strlen($strRotulo) != $arrData['DIG_ROTULO'] ){
                				$arrResponse = 	[
													"status"	=> false,
													"title"		=> "Control de Cedulas",
													"msg" 		=> "Verificar la cantidad de Digitos del Rotulo",
													"valor" 	=> 0,
													"NroMesa" 	=> $strMesa
												];
                			}else{

                				if( strlen($preRotulo) != strlen($arrData['PREF_ROTULO']) || $preRotulo != $arrData['PREF_ROTULO'] ){
                					$arrResponse = 	[
														"status"	=> false,
														"title"		=> "Control de Cedulas",
														"msg" 		=> "El Codigo de Reserva no coincide",
														"valor" 	=> 0,
														"NroMesa" 	=> $strMesa
													];
                				}else{

                					if(strlen($sufRotulo) != strlen($arrData['SUF_ROTULO']) || $sufRotulo != $arrData['SUF_ROTULO']){
                						$arrResponse = 	[
															"status"	=> false,
															"title"		=> "Control de Cedulas",
															"msg" 		=> "El Codigo de Cantidad de Cedulas de Reserva no coincide",
															"valor" 	=> 0,
															"NroMesa" 	=> $strMesa
														];
                					}else{
                						// echo 'ok';exit;
										/*if($intIdEleccion == 1){
											if(substr($_POST["cboubigeo"],0,2) == 14 && substr($_POST["cboubigeo"],2,2) == 01 ) {

												$strCUbigeoE = str_pad(substr($_POST["cboubigeo"],0,4),6,'0');

											}else if(substr($_POST["cboubigeo"],0,2) >= 90){
												
												$strCUbigeoE = str_pad(substr($_POST["cboubigeo"],0,1),6,'0');
												$strCUbigeo  = '900000';

											} else {

												$strCUbigeoE = str_pad(substr($_POST["cboubigeo"],0,2),6,'0');
											} 
											
											$intValorE   = (substr($_POST["cboubigeo"],0,2) == 14 && substr($_POST["cboubigeo"],2,2) == 01 ) ? 1 : 2;
											// echo $strCUbigeoE .' '.$intValorE.' '.$strCUbigeo ; exit;
										}else{
											$strCUbigeo = $_POST["cboubigeo"];
										}

										if($strCUbigeoE != $strCUbigeo)
										{ 
											$arrResponse = 	[
																"status"	=> false,
																"title"		=> "Control de Cedulas",
																"msg" 		=> "Codigo de Ubigeo, no Corresponde a los Datos seleccionados",
																"valor" 	=> 0,
																"NroMesa" 	=> $strMesa
															];

										}else{*/
											
											/*$requestValidarUbig	= $this->model->validarUbigeoExiste($intIdProceso, $strCUbigeo, $intValorE);
											
											if($requestValidarUbig == 0)
											{
												$arrResponse = 	[
																	"status"	=> false,
																	"title"		=> "Control de Cedulas",
																	"msg" 		=> "Numero de Ubigeo No existe",
																	"valor" 	=> 0,
																	"NroMesa" 	=> $strMesa
																];
												
											}else{
												$requestValidarMesa	= $this->model->validarMesaExiste($intIdProceso, $strMesa);

												if($requestValidarMesa == 0)
												{
													
													$arrResponse = 	[
																		"status"	=> false,
																		"title"		=> "Control de Cedulas",
																		"msg" 		=> "Numero de Mesa no existe",
																		"valor" 	=> 0,
																		"NroMesa" 	=> $strMesa
																	];

												}else{
													
													$requestValidarSoltec	= $this->model->validarMesaSoltec($intIdProceso, $intIdSolucion, $strMesa);
											
													if($requestValidarSoltec == 0)
													{
														$arrResponse = 	[
																			"status"	=> false,
																			"title"		=> "Control de Cedulas",
																			"msg" 		=> "Numero de Mesa no pertenece a la Solucion tecnologica seleccionada",
																			"valor" 	=> 0,
																			"NroMesa" 	=> $strMesa
																		];
													}else{


														$requestValidarOdpe	= $this->model->validarMesaOdpe($intIdProceso, $intIdodpe, $strMesa);

														if($requestValidarOdpe == 0)
														{
															$arrResponse = 	[
																				"status"	=> false,
																				"title"		=> "Control de Cedulas",
																				"msg" 		=> "Numero de Mesa no pertenece a la ODPE seleccionada",
																				"valor" 	=> 0,
																				"NroMesa" 	=> $strMesa
																			];
														}else{*/

															/*$requestValidarDepart	= $this->model->validarMesaDepart($intIdProceso, $strDepartamento, $strMesa);

															if($requestValidarDepart == 0)
															{
																$arrResponse = 	[
																					"status"	=> false,
																					"title"		=> "Control de Cedulas",
																					"msg" 		=> "Numero de Mesa no pertenece al Departamento seleccionado",
																					"valor" 	=> 0,
																					"NroMesa" 	=> $strMesa
																				];
															}else{

																$requestValidarProv	= $this->model->validarMesaProv($intIdProceso, $strProvincia, $strMesa);

																if($requestValidarProv == 0)
																{
																	$arrResponse = 	[
																						"status"	=> false,
																						"title"		=> "Control de Cedulas",
																						"msg" 		=> "Numero de Mesa no pertenece a la Provinecia seleccionada",
																						"valor" 	=> 0,
																						"NroMesa" 	=> $strMesa
																					];
																}else{

																	$requestValidarDist	= $this->model->validarMesaDist($intIdProceso, $strDistrito, $strMesa);

																	if($requestValidarDist == 0)
																	{
																		$arrResponse = 	[
																							"status"	=> false,
																							"title"		=> "Control de Cedulas",
																							"msg" 		=> "Numero de Mesa no pertenece al Distrito seleccionado",
																							"valor" 	=> 0,
																							"NroMesa" 	=> $strMesa
																						];
																	}else{


																		$requestValidarElect	= $this->model->validarMesaElect($intIdProceso, $strElectores, $strMesa);
																

																		if($requestValidarElect == 0)
																		{
																			$arrResponse = 	[
																								"status"	=> false,
																								"title"		=> "Control de Cedulas",
																								"msg" 		=> "Numero de Electores no corresponde a la Mesa",
																								"valor" 	=> 0,
																								"NroMesa" 	=> $strMesa
																							];
																		}else{*/

																			/*if($intIdEleccion == 1){
																				if(substr($_POST["cboubigeo"],0,2) == 14 && substr($_POST["cboubigeo"],2,2) == 01 ) {
																					$strCUbigeoMU = substr($_POST["cboubigeo"],0,4);
																				}else{
																					$strCUbigeoMU = substr($_POST["cboubigeo"],0,2);
																				}
																				 
																				 if(substr($strCUbigeo,0,2) == 14 && substr($_POST["cboubigeo"],2,2) == 01 ){
																				 	$intValorMU   = 1;

																				 }else{

																				 	$intValorMU   = 1;
																				 }
																				
																			}else{
																				$strCUbigeoMU = $_POST["cboubigeo"];
																			}

																			$requestValidarUbigeo	= $this->model->validarMesaUbigeo($intIdProceso, $strCUbigeoMU, $strMesa, $intValorMU );
																			//echo $requestValidarUbigeo.' '.$intValorMU.'-----'.$strCUbigeoMU; exit;

																			if($requestValidarUbigeo == 0)
																			{
																				$arrResponse = 	[
																									"status"	=> false,
																									"title"		=> "Control de Cedulas",
																									"msg" 		=> "Numero de Ubigeo no corresponde a la Mesa",
																									"valor" 	=> 0,
																									"NroMesa" 	=> $strMesa
																								];
																			}else{*/
																				
																				$requestValidarIncid = $this->model->IncidenciaExiste($intIdMaterial, $intIdProceso, $intIdEtapa, $strMesa, $strConsulta, $strCboUbigeo);

																				if(!empty($requestValidarIncid))
																				{ 
																					$arrResponse = 	[
																										"status"	=> false,
																										"title"		=> "Control de Cedulas",
																										"msg" 		=> "El Paquete de Cedulas presenta una Incidencia en la Etapa de ".$strEtapa,
																										"valor" 	=> 2,
																										"NroMesa" 	=> $strMesa
																										
																									];
																				}else{
							 
																					if($intIdEtapa != 3){

																						if($intIdEtapa == 2){
																							$intIdetapaControl = 1;
																							$validacionControl = 1;
																							
																							$requestPasoEtapa = $this->model->MesaPasoEtapa($intIdMaterial, $intIdProceso, $intIdetapaControl, $strMesa, $intIdSolucion, $strConsulta, $validacionControl, $strCboUbigeo );
																							
																							if(empty($requestPasoEtapa))
																							{
																								$arrResponse = 	[
																													"status"	=> false,
																													"title"		=> "Control de Cedulas",
																													"msg" 		=> "El Paquete de Cedulas no ha pasado la etapa de Recepción",
																													"valor" 	=> 0,
																													"NroMesa" 	=> $strMesa
																												];
																								echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
																								return false;
																							}

																							$requestMesaControl = $this->model->MesaExisteControl($intIdMaterial, $intIdProceso, $intIdEtapa, $strMesa, $intIdSolucion, $strConsulta, $intIdValidacion, $strCboUbigeo);
																							if(!empty($requestMesaControl))
																							{

																								$arrResponse = 	[
																													"status"	=> false,
																													"title"		=> "Control de Cedulas",
																													"msg" 		=> "El Paquete de Cedulas no ha sido Validado",
																													"valor" 	=> 1,
																													"NroMesa" 	=> $strMesa
																												];
																								echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
																								return false;
																							}
																						}

																						$validacionExiste = ($intIdEtapa == 1) ? 1 : 2;

																						$requestMesaControl = $this->model->MesaExisteControl($intIdMaterial, $intIdProceso, $intIdEtapa, $strMesa, $intIdSolucion, $strConsulta, $validacionExiste, $strCboUbigeo);
																						//echo $requestMesaControl; exit;
																						if(!empty($requestMesaControl)){
																							
																							$arrResponse = 	[
																												"status"	=> false,
																												"title"		=> "Control de Cedulas",
																												"msg" 		=> "El Paquete de Cedulas ya pasó la Etapa de ".$strEtapa,
																												"valor" 	=> 0,
																												"NroMesa" 	=> $strMesa
																											];
																							

																						}else{
																							// echo 'insert';exit;
																							if($intIdValidacion == 1){
																								$requestCedula = $this->model->insertCedula($intIdMaterial, $intIdProceso,  $intIdEtapa, $intIdSolucion, $intIdodpe, $strMesa, $strConsulta, $intIdValidacion, $intUserSession, $strCboUbigeo);
																							
																							}else{
																								$requestCedula = $this->model->updateCedula($intIdMaterial, $intIdProceso, $intIdEtapa, $intIdSolucion, $intIdodpe, $strMesa, $strConsulta, $intIdValidacion, $strCboUbigeo);
																								
																							}

																							if($requestCedula > 0){

																								if($intIdValidacion == 1){
																									$arrResponse = 	[
																													    "status"	=> true,
																													    "title"		=> "Control de Cedulas",
																													    "msg" 		=> "Datos Guardados Correctamente.",
																													    "valor" 	=> 3,
																														"NroMesa" 	=> $strMesa
																													];
																								}else{
																									$arrResponse = 	[
																													    "status"	=> true,
																													    "title"		=> "Control de Cedulas",
																													    "msg" 		=> "Datos Actualizados Correctamente.",
																													    "valor" 	=> 4,
																														"NroMesa" 	=> $strMesa
																													];
																								}
																							}else{
																								$arrResponse = 	[
																												    "status"	=> false,
																												    "title"		=> "Error!",
																												    "msg" 		=> "No se puede conectarse a la Base Datos",
																													"NroMesa" 	=> $strMesa
																												];
																							}
																						}
																						
																					}else{
																						$intIdetapaControl = 2;
																						$validacionControl = 2;

																						$requestPasoEtapa = $this->model->MesaPasoEtapa($intIdMaterial, $intIdProceso, $intIdetapaControl, $strMesa, $intIdSolucion, $strConsulta, $validacionControl, $strCboUbigeo );
																							
																						if(empty($requestPasoEtapa))
																						{
																							$arrResponse = 	[
																												"status"	=> false,
																												"title"		=> "Control de Cedulas",
																												"msg" 		=> "El Paquete de Cedulas no ha pasado la etapa de Control de Calidad",
																												"valor" 	=> 0,
																												"NroMesa" 	=> $strMesa
																											];
																						}else{

																							$requestMesaControl = $this->model->MesaExisteControl($intIdMaterial, $intIdProceso, $intIdEtapa, $strMesa, $intIdSolucion, $strConsulta, $intIdValidacion, $strCboUbigeo);
																							if(!empty($requestMesaControl))
																							{

																								$arrResponse = 	[
																													"status"	=> false,
																													"title"		=> "Control de Cedulas",
																													"msg" 		=> "El Paquete de Cedulas ya pasó la Etapa de ".$strEtapa,
																													"valor" 	=> 0,
																													"NroMesa" 	=> $strMesa
																												];
																							}else{

																								$requestOrdenEmp = $this->model->ordenEmpaquetado($intIdMaterial, $intIdProceso, $intIdEtapa, $intIdFase, $intIdSolucion, $intIdodpe, $strDepartamento, $strProvincia, $strDistrito, $strConsulta, $intIdValidacion, $strCboUbigeo);

																								$rotuloNext = (empty($requestOrdenEmp)) ? '0001': $requestOrdenEmp['ROTULO'];

																								if( $strMesa == $rotuloNext)
																								{
																									$requestCedula = $this->model->insertCedula($intIdMaterial, $intIdProceso,  $intIdEtapa, $intIdSolucion, $intIdodpe, $strMesa, $strConsulta, $intIdValidacion, $intUserSession, $strCboUbigeo);

																									if($requestCedula > 0){
																										
																										$arrResponse = 	[
																													    "status"	=> true,
																													    "title"		=> "Control de Cedulas",
																													    "msg" 		=> "Datos Guardados Correctamente.",
																													    "valor" 	=> 3,
																														"NroMesa" 	=> $strMesa
																													];
																									}

																								}else{
																									
																									$arrResponse = 	[
																														"status"	=> false,
																														"title"		=> "Control de Cedulas",
																														"msg" 		=> "El Número de Mesa no coincide con la Solicitada.",
																														"valor" 	=> 0,
																														"NroMesa" 	=> $strMesa
																													];


																								}

																							}

																						}
																						
																					}

																				}

																			// }

																		// }
																	
																	// }
																	
															/*	}
																
															}*/

														// }
														
													// }
													
												// }
											// }
										//}

									}
								}
							}
						//}
					}
				}
			}

			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}
		

		public function validarCedula()
		{
			// dep($_POST); exit;
			if($_POST){
				$intIdProceso		= intval(strClean($_POST['idProceso']));
				$intIdMaterial		= intval(strClean($_POST['idMaterial']));
				$intIdEtapa			= intval(strClean($_POST['idEtapa']));
				$intIdSolucion		= intval(strClean($_POST['idSolucion']));
				$intIdodpe			= intval(strClean($_POST['idOdpe']));
				$strMesa	 		= strClean($_POST['mesa']);
				$strCUbigeo			= strClean($_POST['cUbigeo']);
				$strConsulta		= strClean($_POST['consulta']);
				$intIdValidacion	= intval(strClean($_POST['validacion']));


				$requestCedula = $this->model->updateCedula($intIdMaterial, $intIdProceso, $intIdEtapa, $intIdSolucion, $intIdodpe, $strMesa, $strConsulta, $intIdValidacion, $strCUbigeo);
				// echo $requestCedula.' --- '.$strCUbigeo; exit;
				if($requestCedula > 0)
				{
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Control de Cedulas",
										"msg" 	=> "Datos Actualizados Correctamente.",
									];
					
				}else{

					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Control de Cedulas",
										"msg" 	=> "No se puede conectarse a la Base Datos",
									];
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
				$intIdValidacion	= ($intIdEtapa == 2) ? 2 : 1;
				$strFase			= ($intIdFase != '') ? strClean($_POST['nomfase']) : '';

				$requestFase = $this->model->avanceFase($intIdMaterial, $intIdProceso, $intIdEtapa, $intIdFase, $intIdValidacion);
				// echo $requestFase; exit;

				$data='';

				foreach ($requestFase as $a) {

						$data 	.=	'<tr  class="text-center font-table">
	                					<td>'.$a['TIPO'].'</td>
	                					<td>'.$a['TOTAL_RESERVA'].'</td>
	                				</tr>';
				}	

				$arrResponse = 	[
									"status"	=> true,
									"title"		=> "Control de Cedulas!",
									"msg" 		=> "Datos por Fase.",
									"data"		=> $data,
									"nomFase"	=> $strFase
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
				$intIdValidacion	= ($intIdEtapa == 2) ? 2 : 1;
				$strOdpe			= ($intIdodpe != '') ? strClean($_POST['nomOdpe']) : '';

				$requestOdpe = $this->model->avanceOdpe($intIdMaterial, $intIdProceso, $intIdEtapa, $intIdFase, $intIdodpe, $intIdValidacion);
				// dep($requestOdpe); exit;
				$data='';

				foreach ($requestOdpe as $a) {

						$data 	.=	'<tr  class="text-center font-table">
	                					<td>'.$a['CODIGO_SOLUCION'].'</td>
	                					<td>'.$a['CANTIDAD'].'</td>
	                				</tr>';
				}	

				$arrResponse = 	[
									"status"	=> true,
									"title"		=> "Control de Acceso!",
									"msg" 		=> "Datos por ODPE.",
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
				$strConsulta		= strClean($_POST['consulta']);
				$intValor 			= ($strConsulta != '') ? 2 : 1;
				$intIdValidacion	= ($intIdEtapa == 2) ? 2 : 1;
				$strOdpe			= strClean($_POST['nomOdpe']);

				$output = array();
				$requestEscaneadas = $this->model->mesasEscaneadas($intIdMaterial, $intIdProceso, $intIdEtapa, $intIdFase, $intIdSolucion, $intIdodpe, $strConsulta, $intIdValidacion, $intValor);
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


		/*public function mesasFaltantes()
		{
			// dep($_POST); exit;
			if($_POST){
				$intIdFase			= intval(strClean($_POST['idFase']));
				$intIdMaterial		= intval(strClean($_POST['idMaterial']));
				$intIdProceso		= intval(strClean($_POST['idProceso']));
				$intIdEtapa			= intval(strClean($_POST['idEtapa']));
				$intIdSolucion		= intval(strClean($_POST['idSolucion']));
				$intIdodpe			= intval(strClean($_POST['idOdpe']));
				$strConsulta		= strClean($_POST['consulta']);
				$intValor 			= ($strConsulta != '') ? 2 : 1;
				$intIdValidacion	= ($intIdEtapa == 2) ? 2 : 1;
				$strOdpe			= strClean($_POST['nomOdpe']);

				$output = array();
				$requestEscaneadas = $this->model->mesasFaltantes($intIdMaterial, $intIdProceso, $intIdEtapa, $intIdFase, $intIdSolucion, $intIdodpe, $strConsulta, $intIdValidacion, $intValor);
				// dep($requestEscaneadas); exit;
				
				for ($i=0; $i <  count($requestEscaneadas); $i++) { 
				# code...
					$requestEscaneadas[$i]['ORDEN'] 	= 	$i+1;
				
				}

				$output = array(
					// "draw"				=>	intval($_POST["draw"]),
					// "recordsTotal"		=> 	count($arrData),
					// "recordsFiltered"	=>	count($arrData),
					"data"				=>	$requestEscaneadas
				);
			}
			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
		}*/



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
					
					/*$requestIdMesa = $this->model->selectIdMesa($intIdProceso, $strMesa) ;
					$intidSufragio = ($requestIdMesa['ID_SUFRAGIO'] != '') ? $requestIdMesa['ID_SUFRAGIO'] : 0;*/

					$requestIncidencia	= $this->model->insertIncidencia($intIdMaterial, $intIdProceso, $intIdEtapa, $intIdodpe, $intIdIncidencia, $strMesa, $intCantidad, $strConsulta, $strCUbigeo, $intUserSession);
					

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



