<?php 

	/**
	* 
	*/
	class incidencia extends Controllers
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

		public function incidencia()
		{

			$data['page_tag']='Control de Incidencias';
			$data['page_title']='CONTROL DE INCIDENCIAS';
			$data['page_name']='Control';
			$data['page_function_js']='function_incidencia.js';
			$this->views->getView($this,'incidencia',$data);
		}


		public function getSelectProceso()
		{

			$htmlOptions = '<option value="">[ SELECCIONE PROCESO ]</option>';
			$arrData = $this->model->selectCboProceso();
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData) ; $i++) { 
					$htmlOptions .='<option value="'.$arrData[$i]['ID_PROCESO'].'" data="'.$arrData[$i]['ELECCION'].'"> '.$arrData[$i]['PROCESO']. ' ('.$arrData[$i]['DESCRIPCION']. ')</option>';
				}
			}
			echo $htmlOptions;
			die();
		}


		public function getSelectMaterial()
		{
			//dep($_POST); exit;
			if($_POST){
				$intIdProceso	= intval(strClean($_POST['idProceso']));

				$htmlOptions = '<option value="">[ SELECCIONE MATERIAL ]</option>';
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


		public function getSelectEtapa()
		{
			//dep($_POST); exit;
			if($_POST){
				$intIdProceso	= intval(strClean($_POST['idProceso']));
				$intIdMaterial	= intval(strClean($_POST['idMaterial']));

				
				$arrData = $this->model->selectCboEtapa($intIdProceso, $intIdMaterial);
				$htmlOptions = '<option value="">[ SELECCIONE ETAPA ]</option>';
				if(count($arrData) > 0){
					for ($i=0; $i < count($arrData) ; $i++) { 
						$htmlOptions .='<option value="'.$arrData[$i]['ID_ETAPA'].'"> '.$arrData[$i]['ETAPA'].'</option>';
					}
				}
				echo $htmlOptions;
				die();
			}
		}



		public function getIncidencias()
		{
			// dep($_POST); exit;
			if($_POST){
				$intIdProceso	= intval(strClean($_POST['idProceso']));
				$intIdMaterial	= intval(strClean($_POST['idMaterial']));
				$intIdEtapa		= intval(strClean($_POST['idEtapa']));

				
				$output = array();
				$requestIncidencia = $this->model->selectIncidencias($intIdProceso, $intIdMaterial, $intIdEtapa);
				
				for ($i=0; $i <  count($requestIncidencia); $i++) {

					# code...
					if($requestIncidencia[$i]['ESTADO'] == 1)
					{
						$requestIncidencia[$i]['ESTADO'] 	=	'<span class="label label-danger label-pill m-w-60">NO RESUELTO</span>';
					
					}else if($requestIncidencia[$i]['ESTADO'] == 2){
						$requestIncidencia[$i]['ESTADO'] 	=	'<span class="label label-warning label-pill m-w-60">EN PROCESO</span>';

					}else if($requestIncidencia[$i]['ESTADO'] == 3){
						$requestIncidencia[$i]['ESTADO'] 	=	'<span class="label label-success label-pill m-w-60">RESUELTO</span>';

					}
					
					$requestIncidencia[$i]['ORDEN'] 	= 	$i+1;
					$requestIncidencia[$i]['OPCIONES'] 	=	'<a class="btn btn-primary btn-xs" data-toggle="modal" href="#modal_incidencia" title="Editar" onclick="verIncidencia('.$requestIncidencia[$i]['ID_INCIDENCIACONTROL'].')">
													<i class="zmdi zmdi-edit zmdi-hc-fw"></i>
												</a>
                                				<a class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminarIncidecnia('.$requestIncidencia[$i]['ID_INCIDENCIACONTROL'].')">
                                					<i data-toggle="tooltip" title="Eiiminar"class="zmdi zmdi-delete zmdi-hc-fw"></i>
                                				</a>';
					
				}

				$output = array(
					/*"draw"				=>	intval($_POST["draw"]),
					"recordsTotal"		=> 	count($arrData),
					"recordsFiltered"	=>	count($arrData),*/
					"data"				=>	$requestIncidencia
				);
			}

			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
		}		


		public function getIncidencia($idIncidencia)
		{

			$intIdIncidencia = intval(strClean($idIncidencia));

			if ($intIdIncidencia > 0) {
				
				$arrData = $this->model->selectIncidencia($intIdIncidencia);

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


		public function delIncidencia($idIncidencia)
		{
			
				$intIdIncidencia 	= intval(strClean($idIncidencia));
				$requestDelete 	= $this->model->deleteIncidencia($intIdIncidencia);

				if ($requestDelete > 0) {
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Incidencias",
										"msg" 	=> "Incidencia Eliminado Correctamente.",
									];
				}else{
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Error al eliminar el Incidencia",
									];
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			
				die();
		}


		public function setIncidencia()
		{
			// dep($_POST); exit;
			if($_POST){
				if( empty($_POST['idIncidencia']) || empty($_POST['estado']) || empty($_POST['observacion1']) ){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{

					$intIdIncidencia	= intval(strClean($_POST['idIncidencia']));
					$intControl			= intval(strClean($_POST['controlIncidencia']));
					$intEstado			= intval(strClean($_POST['estado']));
					$strOnservacion1	= $_POST['observacion1'];
					$strOnservacion2	= $_POST['observacion2'];
					$intUserSession		= intval(strClean($_SESSION['idUser']));
					date_default_timezone_set('america/lima');
					$fecha = date("d/m/Y h:i:s a");

					if($intControl == 0){
						$requestProceso	= $this->model->insertIncidencia($intTipoProeso, $strCodProceso, $strNomProceso, $strFechaInicio, $strFechaFin, $intUserSession);

					}else{

						$observ = $this->model->selectIncidencia($intIdIncidencia);

						//echo $observ['OBSERVACION']; exit;
						if($observ['OBSERVACION'] == "" || $observ ==  null){
							$observacionFecha = $fecha.': '.$strOnservacion1;
							// echo 'no';
						}else{
							$observacionFecha = $strOnservacion1."\n".$fecha.': '.$strOnservacion2;
							// echo 'si';
						}

						$requestProceso	= $this->model->updateIncidencia($intIdIncidencia, $observacionFecha, $intEstado, $intUserSession);
					}


					if($requestProceso > 0){

						if($intControl == 0){
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Control de Incidencias",
											    "msg" 	=> "Datos Guardados Correctamente.",
											];
						}else{
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Control de Incidencias",
											    "msg" 	=> "Datos Actualizados Correctamente.",
											];
						}

					}else if($requestProceso == 'exist'){
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Alerta!",
										    "msg" 	=> "Incidencia ya se encuentra registrado.",
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