<?php 

	/**
	* 
	*/
	class Asistencia extends Controllers
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

		public function asistencia()
		{

			$data['page_tag']='Asistencia';
			$data['page_title']='CONTROL DE ACCESO - GGE';
			$data['page_name']='asistencia';
			$data['page_function_js']='function_asistencia.js';
			$this->views->getView($this,'asistencia',$data);
		}


		public function setAsistencia()
		{
			//dep($_POST); exit;
			if($_POST){
				if(empty($_POST['dni']) || empty($_POST['conrol'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$intControl			= intval(strClean($_POST['conrol']));
					$strDNI				= strClean($_POST['dni']);
					$intUserSession		= intval(strClean($_SESSION['idUser']));
					

					$requestPersonal	= $this->model->selectPersona($strDNI);
					//dep($requestPersonal); exit;
					if($requestPersonal == 'nexiste'){
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Alerta!",
										    "msg" 	=> "El DNI ".$strDNI.", no se encuentra Registrado en Sistema.",
										];

					}else{
						$intidPersonal 	= intval(strClean($requestPersonal['id_personal']));
						$intidCargo 	= intval(strClean($requestPersonal['id_cargo']));
						$intEstado 		= intval(strClean($requestPersonal['estado']));
						date_default_timezone_set('America/Lima');
						$strFecha 		= date("Y-m-d");

						if($intEstado == 2 || $intEstado == 3){
							$arrResponse = 	[
											    "status"=> false,
										    	"title"	=> "Alerta!",
										    	"msg" 	=> "El DNI ".$strDNI.", se encuentra temporalmente suspendido.",
											];
						}else{

							if($intControl == 1){

								$requestAsistencia	= $this->model->insertAsistencia($intidPersonal, $intidCargo, $strFecha, $intUserSession);

								if($requestAsistencia > 0){
									$requestDatos	= $this->model->selectAsistencia($strDNI, $intControl);
										$arrResponse = 	[
													    "status"=> true,
													    "title"	=> "Control de Acceso",
													    "msg" 	=> "Registro de Ingreso",
													    "ctrl" 	=> "ingreso",
													    "datos" => $requestDatos,
													];
								}else if($requestAsistencia == 'exist'){

									$arrResponse = 	[
												    "status"=> false,
											    	"title"	=> "Alerta!",
											    	"msg" 	=> "El DNI ".$strDNI.", Ya registró su Ingreso",
												];
								}

							}else{
								$requestDatos	= $this->model->selectAsistencia($strDNI, $intControl);
								$intIdAsistencia	= intval(strClean($requestDatos['id_asistencia']));
								
								if($intIdAsistencia != ''){

									$requestAsistenciaUpdate	= $this->model->updateAsistencia($intIdAsistencia, $strFecha, $intUserSession);

									if($requestAsistenciaUpdate > 0){
										$requestDatosSal	= $this->model->selectAsistenciaSalida($strDNI, $intControl);
										$arrResponse = 	[
													    "status"=> true,
													    "title"	=> "Control de Acceso",
													    "msg" 	=> "Registro de Salida",
													    "ctrl" 	=> "salida",
													    "datos" => $requestDatosSal,
													];
									}else{
										$arrResponse = 	[
												    "status"=> false,
											    	"title"	=> "Alerta!",
											    	"msg" 	=> "El DNI ".$strDNI.", Ya registró su Salida",
												];
									}


								}else{
									$arrResponse = 	[
											    "status"=> false,
										    	"title"	=> "Alerta!",
										    	"msg" 	=> "El DNI ".$strDNI.", No ha registrado su Ingreso",
											];
								}
							}
						}
					}
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function getCantidad()
		{
			$requestCantidad= $this->model->selectCantidad();
			
			date_default_timezone_set('America/Lima');
    		$fecha = date("d/m/Y");

			$tabla	='';
			$count 	= 1;
			foreach ($requestCantidad as $a) {
					$tabla .='	<tr>
									<td>' .($count++). '</td>
									<td><b>' .$a['abreviatura']. '<b/></td>
									<td>' .$a['cantidad']. '</td>
							 	</tr>';
			}	

			$arrResponse = 	[
								    	"status"=> true,
								    	"title"	=> "Control de Acceso!",
								    	"msg" 	=> "Personal por Gerencia.",
								    	"data"	=> $tabla,
								    	"fecha"	=> $fecha
									];

			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}


	}

?>