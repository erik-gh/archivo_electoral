<?php 

	/**
	* 
	*/
	class Parametro extends Controllers
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

		public function parametro()
		{
			$data['page_tag']='Configuracion de Parametros';
			$data['page_title']='CONFIGURACION DE PARAMETROS DE PROCESO - C&Oacute;DIGOS';
			$data['page_name']='parametro';
			$data['page_function_js']='function_parametro.js';
			$this->views->getView($this,'parametro',$data);
		}



		/* ===== STEP 1 ===== */
		public function getSelectProceso($accion)
		{

			$intIdAccion = $accion;
			$htmlOptions = '<option value="">[ Seleccione Proceso ]</option>';
			$arrData = $this->model->selectCboProceso($intIdAccion);
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData) ; $i++) { 
					$htmlOptions .='<option value="'.$arrData[$i]['ID_PROCESO'].'"> '.$arrData[$i]['PROCESO']. ' ('.$arrData[$i]['DESCRIPCION']. ')</option>';
				}
			}
			echo $htmlOptions;
			die();
		}


		public function getSelectSolucion()
		{

			$htmlOptions = '';
			$arrData = $this->model->getSelectSolucion();
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData) ; $i++) { 
					$htmlOptions .='<option value="'.$arrData[$i]['ID_SOLUCIONTECNOLOGICA'].'"> '.$arrData[$i]['SOLUCIONTECNOLOGICA'].'</option>';
				}
			}
			echo $htmlOptions;
			die();
		}


		public function getSelectEtapa()
		{

			$htmlOptions = '';
			$arrData = $this->model->selectCboEtapa();
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData) ; $i++) { 
					$htmlOptions .='<option value="'.$arrData[$i]['ID_ETAPA'].'"> '.$arrData[$i]['ETAPA'].'</option>';
				}
			}
			echo $htmlOptions;
			die();
		}


		public function getCargaSolucion($idProceso)
		{

			$intIdProceso = intval(strClean($idProceso));

			if ($intIdProceso > 0) {
				
				$arrData = $this->model->selectCargaSolucion($intIdProceso);
				//dep($arrData);exit;
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


		public function getCargaEtapa($idProceso)
		{

			$intIdProceso = intval(strClean($idProceso));

			if ($intIdProceso > 0) {
				
				$arrData = $this->model->selectCargaEtapa($intIdProceso);
				//dep($arrData);exit;
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


		public function setCrearProceso()
		{
			if($_POST){
				if(empty($_POST['proceso']) || empty($_POST['soluciones']) || empty($_POST['etapas'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$intControl			= intval(strClean($_POST['controlProceso']));
					$intIdProceso		= intval(strClean($_POST['proceso']));
					$intidSoluciones	= $_POST['soluciones'];
					$intiEtapas			= $_POST['etapas'];
					
					$requestDeleteSolucion = $this->model->deleteSolucionProceso($intIdProceso);
					$requestDeleteEtapa  = $this->model->deleteEtapaProceso($intIdProceso);

					foreach($intidSoluciones as $rowSolucion){
						$requestSolucion	= $this->model->insertSolucionProceso($intIdProceso, $rowSolucion);
					}

					foreach($intiEtapas as $rowEtapa){
						$requestEtapa	= $this->model->insertEtapaProceso($intIdProceso, $rowEtapa);
					}

					if($requestSolucion > 0 && $requestEtapa > 0){

						if($intControl == 0){
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Creación de Parametros",
											    "msg" 	=> "Datos Guardados Correctamente.",
											];
						}else{
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Creación de Parametros",
											    "msg" 	=> "Datos Actualizados Correctamente.",
											];
						}
						
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




		/* ===== STEP 2 ===== */
		public function getConsultas()
		{
			
			$htmlCheck = '';
			$arrData = $this->model->getSelectConsultas();
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData) ; $i++) { 
					$htmlCheck .=	'<tr  class="itemConsulta">
                	<td><label class="custom-control custom-control-primary custom-checkbox active">
                           		<input type="checkbox" class="custom-control-input" id="chkConsulta'.$arrData[$i]['ID_CONSULTA'].'" value="'.$arrData[$i]['ID_CONSULTA'].'" name="custom" onclick="checkEnable('.$arrData[$i]['ID_CONSULTA'].');">
                                <span class="custom-control-indicator"></span>
                            </label>
                        </td>
                	<td>'.$arrData[$i]['CONSULTA'].'</td>
                	<td> <input class="" type="text" size ="5" disabled id="nropaquete'.$arrData[$i]['ID_CONSULTA'].'" name="nropaquete'.$arrData[$i]['ID_CONSULTA'].'" onkeypress=SoloNum() maxlength="2" required> </td>
                	<td> <input class="" type="text" size ="5" disabled id="nrocartel'.$arrData[$i]['ID_CONSULTA'].'" name="nrocartel'.$arrData[$i]['ID_CONSULTA'].'" onkeypress=SoloNum() maxlength="2" required> </td>
                	</tr>';
				}
			}
			echo $htmlCheck;
			die();
		}


		public function getCargaConsulta($idProceso)
		{

			$intIdProceso = intval(strClean($idProceso));

			if ($intIdProceso > 0) {
				
				$arrData = $this->model->selectCargaConsulta($intIdProceso);
				//dep($arrData);exit;
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


		public function setConsultaProceso()
		{
			//dep($_POST); exit;
			if($_POST){
				if(empty($_POST['proceso'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{

					$intControl		= 0;
					$intIdProceso	= intval(strClean($_POST['proceso']));
					$consultas		= json_decode($_POST['consultas']);
					//$intEstado	= intval(strClean($_POST['estado']));
					
					$requestDeleteSolucion = $this->model->deleteConsultaProceso($intIdProceso);
					foreach ($consultas as $a ) {
						$indIdConsulta 	= intval(strClean($a->idConsulta));
						$intPaquetes	= intval(strClean($a->cantPaquete));
						$intCarteles 	= intval(strClean($a->cantCartel));
							
						$requestConsulta	= $this->model->insertConsultaProceso($intIdProceso, $indIdConsulta, $intPaquetes, $intCarteles);

					}


						if($requestConsulta > 0){

							if($intControl == 0){
								$arrResponse = 	[
												    "status"=> true,
												    "title"	=> "Configuración de Consultas",
												    "msg" 	=> "Datos Guardados Correctamente.",
												];
							}else{
								$arrResponse = 	[
												    "status"=> true,
												    "title"	=> "Configuración de Consultas",
												    "msg" 	=> "Datos Actualizados Correctamente.",
												];
							}
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




		/* ===== STEP 3 ===== */
		public function getCedulaProceso($idProceso)
		{
			
			$htmlCheck = '';
			$intIdProceso = intval(strClean($idProceso));
			$arrData = $this->model->getSelectCedulaProceso($intIdProceso);
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData) ; $i++) { 
					for ($y=0; $y < $arrData[$i]['CANTIDAD_PAQUETES'] ; $y++) {
                	
                	$htmlCheck .= '	<tr  class="itemCedula">
                        				<td>'.$arrData[$i]['CONSULTA'].'
			                                <input type="hidden" id="idConsulta" value="'.$arrData[$i]['ID_CONSULTA'].'"/>
			                                <input type="hidden" id="idvalue" value="'.$arrData[$i]['ID_CONSULTA'].$y.'"/>
			                                <input type="hidden" id="orden" value="'.$y.'"/></td>
                        				<td> <input class="form-control" type="text" size ="15" id="tipo'.$arrData[$i]['ID_CONSULTA'].$y.'" name="tipo'.$arrData[$i]['ID_CONSULTA'].$y.'" required> </td>
										<td> <input class="form-control" type="text" size ="5" id="totalDigUbigeo'.$arrData[$i]['ID_CONSULTA'].$y.'" name="totalDigUbigeo'.$arrData[$i]['ID_CONSULTA'].$y.'" onkeypress=SoloNum() maxlength="2" required> </td>
                        				<td> <input class="form-control" type="text" size ="5" id="prefUbigeo'.$arrData[$i]['ID_CONSULTA'].$y.'" name="prefUbigeo'.$arrData[$i]['ID_CONSULTA'].$y.'" required> </td>
                        				<td> <input class="form-control" type="text" size ="5" id="sufUbigeo'.$arrData[$i]['ID_CONSULTA'].$y.'" name="sufUbigeo'.$arrData[$i]['ID_CONSULTA'].$y.'" required> </td>
                       					<td> <input class="form-control" type="text" size ="5" id="totalDigRotulo'.$arrData[$i]['ID_CONSULTA'].$y.'" name="totalDigRotulo'.$arrData[$i]['ID_CONSULTA'].$y.'" onkeypress=SoloNum() maxlength="2" required> </td>
                        				<td> <input class="form-control" type="text" size ="5" id="prefRotulo'.$arrData[$i]['ID_CONSULTA'].$y.'" name="prefRotulo'.$arrData[$i]['ID_CONSULTA'].$y.'" required> </td>
                        				 <td> <input class="form-control" type="text" size ="5" id="sufRotulo'.$arrData[$i]['ID_CONSULTA'].$y.'" name="sufRotulo'.$arrData[$i]['ID_CONSULTA'].$y.'" required> </td>
                   						</tr>';
                   	}
				}
			}
			echo $htmlCheck;
			
			die();
		}


		public function getCargaCedula($idProceso)
		{

			$intIdProceso = intval(strClean($idProceso));

			if ($intIdProceso > 0) {
				
				$arrData = $this->model->selectCargaCedula($intIdProceso);
				//dep($arrData);exit;
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


		public function setCedulaProceso()
		{
			//dep($_POST); exit;
			if($_POST){
				if(empty($_POST['proceso'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{

					$intControl		= 0;
					$intIdProceso	= intval(strClean($_POST['proceso']));
					$codCedula		= json_decode($_POST['codCedula']);
					//$intEstado	= intval(strClean($_POST['estado']));
					
					$requestDeleteCedula = $this->model->deleteCedulaProceso($intIdProceso);
					foreach ($codCedula as $a ) {
						$intIdConsulta 	= intval(strClean($a->idConsulta));
						$strTipo		= strClean($a->tipo);
						$intDigUbigeo 	= intval(strClean($a->digUbigeo));
						$strPrefUbigeo	= strClean($a->prefUbigeo);
						$strSufUbigeo 	= strClean($a->sufUbigeo);
						$intDigRotulo	= intval(strClean($a->digRotulo));
						$strPrefRotulo 	= strClean($a->prefRotulo);
						$strSufRotulo	= strClean($a->sufRotulo);
						$intOrden	 	= intval(strClean($a->orden));
							
						$requestCodCedula	= $this->model->insertCedulaProceso($intIdProceso, $intIdConsulta, $strTipo, $intDigUbigeo, $strPrefUbigeo, $strSufUbigeo, $intDigRotulo, $strPrefRotulo, $strSufRotulo, $intOrden);

					}


						if($requestCodCedula > 0){

							if($intControl == 0){
								$arrResponse = 	[
												    "status"=> true,
												    "title"	=> "Configuración de Códigos de Cedula",
												    "msg" 	=> "Datos Guardados Correctamente.",
												];
							}else{
								$arrResponse = 	[
												    "status"=> true,
												    "title"	=> "Configuración de Códigos de Cedula",
												    "msg" 	=> "Datos Actualizados Correctamente.",
												];
							}
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




		/* ===== STEP 4 ===== */
		public function getActaProceso()
		{
			
			$htmlCheck = '';
			$arrData = $this->model->getSelectActaProceso();
			if(count($arrData) > 0){
				$c=1;
				for ($i=0; $i < count($arrData) ; $i++) { 
					
					$htmlCheck .= '	<tr  class="itemActa">
				                       	<td>'.$c++.'</td>
				                        <td>'.$arrData[$i]['MATERIAL'].'
				                                <input type="hidden" id="idMaterial" value="'.$arrData[$i]['ID_MATERIAL'].'"/></td></td>
				                        <td> <input class="form-control" type="text" size ="5" id="cantidadDig'.$arrData[$i]['ID_MATERIAL'].'" name="cantidadDig'.$arrData[$i]['ID_MATERIAL'].'" onkeyup=longitudActa('.$arrData[$i]['ID_MATERIAL'].') onkeypress=Numbers() maxlength="2" required> </td>
				                        <td> <input class="form-control" type="text" size ="5" id="cantidadCod'.$arrData[$i]['ID_MATERIAL'].'" name="cantidadCod'.$arrData[$i]['ID_MATERIAL'].'" onkeyup=longitudActa('.$arrData[$i]['ID_MATERIAL'].') required> </td>
				                        <td> <input class="form-control" type="text" size ="5" id="cantidadResto'.$arrData[$i]['ID_MATERIAL'].'" name="cantidadResto'.$arrData[$i]['ID_MATERIAL'].'" value="0" onkeyup=longitudActa('.$arrData[$i]['ID_MATERIAL'].'_'.') required disabled> </td>
			                    	</tr>';

				}
			}
			echo $htmlCheck;
			
			die();
		}


		public function getCargaActa($idProceso)
		{

			$intIdProceso = intval(strClean($idProceso));

			if ($intIdProceso > 0) {
				
				$arrData = $this->model->selectCargaActa($intIdProceso);
				//dep($arrData);exit;
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


		public function setActaProceso()
		{
			//dep($_POST); exit;
			if($_POST){
				if(empty($_POST['proceso'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{

					$intControl		= 0;
					$intIdProceso	= intval(strClean($_POST['proceso']));
					$codActa		= json_decode($_POST['codActa']);
					//$intEstado	= intval(strClean($_POST['estado']));
					
					$requestDeleteActa = $this->model->deleteActaProceso($intIdProceso);
					foreach ($codActa as $a ) {
						$intIdMaterial 	= intval(strClean($a->idMaterial));
						$intDigito		= intval(strClean($a->digitos));
						$strCodigo 		= strClean($a->codigo);
						
						$requestCodActa	= $this->model->insertActaProceso($intIdProceso, $intIdMaterial, $intDigito, $strCodigo);

					}


						if($requestCodActa > 0){

							if($intControl == 0){
								$arrResponse = 	[
												    "status"=> true,
												    "title"	=> "Configuración de Códigos de Acta Padrón",
												    "msg" 	=> "Datos Guardados Correctamente.",
												];
							}else{
								$arrResponse = 	[
												    "status"=> true,
												    "title"	=> "Configuración de Códigos de Acta Padrón",
												    "msg" 	=> "Datos Actualizados Correctamente.",
												];
							}
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




		/* ===== STEP 5 ===== */
		public function getDispositivoProceso()
		{
			
			$htmlCheck = '';
			$arrData = $this->model->getSelectDispositivoProceso();
			if(count($arrData) > 0){
				$c=1;
				for ($i=0; $i < count($arrData) ; $i++) { 
					$tipo = $arrData[$i]['ID_TIPO'];
					$htmlCheck .= '	<tr  class="itemDispositivo">
										<td>'.$c++.'</td>
                        				<td>'.$arrData[$i]['DESCRIPCION'].'
                                			<input type="hidden" id="idMaterial" value="'.$arrData[$i]['ID_MATERIAL'].'"/>
                                			<input type="hidden" id="idvalue" value="'.$tipo.'"/></td>
                        				<td> <input class="form-control" type="text" size ="5" id="cantidadDig'.$arrData[$i]['ID_MATERIAL'].$tipo.'" name="cantidadDig'.$arrData[$i]['ID_MATERIAL'].$tipo.'" onkeyup=longitudDispositivo('.$arrData[$i]['ID_MATERIAL'].$tipo.') onkeypress=Numbers() maxlength="2" required> </td>
                       					<td> <input class="form-control" type="text" size ="5" id="cantidadPre'.$arrData[$i]['ID_MATERIAL'].$tipo.'" name="cantidadPre'.$arrData[$i]['ID_MATERIAL'].$tipo.'" onkeyup=longitudDispositivo('.$arrData[$i]['ID_MATERIAL'].$tipo.') required> </td>
                        				<td> <input class="form-control" type="text" size ="5" id="cantidadCod'.$arrData[$i]['ID_MATERIAL'].$tipo.'" name="cantidadCod'.$arrData[$i]['ID_MATERIAL'].$tipo.'" onkeyup=longitudDispositivo('.$arrData[$i]['ID_MATERIAL'].$tipo.') required> </td>
                        				<td> <input class="form-control" type="text" size ="5" id="cantidadResto'.$arrData[$i]['ID_MATERIAL'].$tipo.'" name="cantidadResto'.$arrData[$i]['ID_MATERIAL'].$tipo.'" value="0" required disabled> </td>
                    				</tr>';

				}
			}
			echo $htmlCheck;
			
			die();
		}


		public function getCargaDispositivo($idProceso)
		{

			$intIdProceso = intval(strClean($idProceso));

			if ($intIdProceso > 0) {
				
				$arrData = $this->model->selectCargaDispositivo($intIdProceso);
				//dep($arrData);exit;
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


		public function setDispositivoProceso()
		{
			dep($_POST); exit;
			if($_POST){
				if(empty($_POST['proceso'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{

					$intControl		= 0;
					$intIdProceso	= intval(strClean($_POST['proceso']));
					$codDispositivo	= json_decode($_POST['codDispositivo']);
					//$intEstado	= intval(strClean($_POST['estado']));
					
					$requestDeleteActa = $this->model->deleteDispositivoProceso($intIdProceso);
					foreach ($codDispositivo as $a ) {
						$intIdMaterial 	= intval(strClean($a->idMaterial));
						$intDigitos 	= intval(strClean($a->digitos));
						$strPrefijo		= strClean($a->prefijo);
						$strCodigo 		= strClean($a->codigo);
						$intTipo 		= intval(strClean($a->tipo));
						
						$requestCodDispositivo	= $this->model->insertDispositivoProceso($intIdProceso, $intIdMaterial, $intDigitos, $strPrefijo, $strCodigo, $intTipo);

					}


						if($requestCodDispositivo > 0){

							if($intControl == 0){
								$arrResponse = 	[
												    "status"=> true,
												    "title"	=> "Configuración de Códigos de Dispositivos",
												    "msg" 	=> "Datos Guardados Correctamente.",
												];
							}else{
								$arrResponse = 	[
												    "status"=> true,
												    "title"	=> "Configuración de Códigos de Dispositivos",
												    "msg" 	=> "Datos Actualizados Correctamente.",
												];
							}
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




		/* ===== STEP 6 ===== */
		public function getReservaProceso($idProceso)
		{
			
			$htmlCheck = '';
			$intIdProceso = intval(strClean($idProceso));
			$arrData = $this->model->getSelectCedulaProceso($intIdProceso);
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData) ; $i++) { 
					for ($y=0; $y < $arrData[$i]['CANTIDAD_PAQUETES'] ; $y++) {
                	
                	$htmlCheck .= '	<tr  class="itemReserva">
                						<td>'.$arrData[$i]['CONSULTA'].'
                                			<input type="hidden" id="idConsultaRes" value="'.$arrData[$i]['ID_CONSULTA'].'"/>
                                			<input type="hidden" id="idvalueRes" value="'.$arrData[$i]['ID_CONSULTA'].$y.'"/>
                                			<input type="hidden" id="orden" value="'.$y.'"/></td>
                                		<td> <input class="form-control" type="text" size ="15" id="tipoRes'.$arrData[$i]['ID_CONSULTA'].$y.'" name="tipoRes'.$arrData[$i]['ID_CONSULTA'].$y.'" required> </td>
                                		<td> <input class="form-control" type="text" size ="5" id="totalDigResUbigeo'.$arrData[$i]['ID_CONSULTA'].$y.'" name="totalDigResUbigeo'.$arrData[$i]['ID_CONSULTA'].$y.'" onkeypress=Numbers() maxlength="2" required> </td>
                                		<td> <input class="form-control" type="text" size ="5" id="prefResUbigeo'.$arrData[$i]['ID_CONSULTA'].$y.'" name="prefResUbigeo'.$arrData[$i]['ID_CONSULTA'].$y.'" required> </td>
                                		<td> <input class="form-control" type="text" size ="5" id="sufResUbigeo'.$arrData[$i]['ID_CONSULTA'].$y.'" name="sufResUbigeo'.$arrData[$i]['ID_CONSULTA'].$y.'" required> </td>
                                		<td> <input class="form-control" type="text" size ="5" id="totalDigResRotulo'.$arrData[$i]['ID_CONSULTA'].$y.'" name="totalDigResRotulo'.$arrData[$i]['ID_CONSULTA'].$y.'" onkeypress=Numbers() maxlength="2" required> </td>
                                		<td> <input class="form-control" type="text" size ="5" id="prefResRotulo'.$arrData[$i]['ID_CONSULTA'].$y.'" name="prefResRotulo'.$arrData[$i]['ID_CONSULTA'].$y.'" required> </td>
                                		<td> <input class="form-control" type="text" size ="5" id="sufResRotulo'.$arrData[$i]['ID_CONSULTA'].$y.'" name="sufResRotulo'.$arrData[$i]['ID_CONSULTA'].$y.'" required> </td>
                                		<td> <input class="form-control" type="text" size ="5" id="codResConsulta'.$arrData[$i]['ID_CONSULTA'].$y.'" name="codResConsulta'.$arrData[$i]['ID_CONSULTA'].$y.'" required> </td>
                                	</tr>';
                   	}
				}
			}
			echo $htmlCheck;
			
			die();
		}


		public function getCargareserva($idProceso)
		{

			$intIdProceso = intval(strClean($idProceso));

			if ($intIdProceso > 0) {
				
				$arrData = $this->model->selectCargaReserva($intIdProceso);
				//dep($arrData);exit;
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


		public function setreservaProceso()
		{
			//dep($_POST); exit;
			if($_POST){
				if(empty($_POST['proceso'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{

					$intControl		= 0;
					$intIdProceso	= intval(strClean($_POST['proceso']));
					$codReserva		= json_decode($_POST['codReserva']);
					//$intEstado	= intval(strClean($_POST['estado']));
					
					$requestDeleteCedula = $this->model->deleteReservaProceso($intIdProceso);
					foreach ($codReserva as $a ) {
						$intIdConsulta 	= intval(strClean($a->idConsulta));
						$strTipo		= strClean($a->tipo);
						$intDigUbigeo 	= intval(strClean($a->digResUbigeo));
						$strPrefUbigeo	= strClean($a->prefResUbigeo);
						$strSufUbigeo 	= strClean($a->sufResUbigeo);
						$intDigRotulo	= intval(strClean($a->digResRotulo));
						$strPrefRotulo 	= strClean($a->prefResRotulo);
						$strSufRotulo	= strClean($a->sufResRotulo);
						$strCodReserva	= strClean($a->codResConsulta);
						$intOrden	 	= intval(strClean($a->orden));
							
						$requestCodReserva	= $this->model->insertReservaProceso($intIdProceso, $intIdConsulta, $strTipo, $intDigUbigeo, $strPrefUbigeo, $strSufUbigeo, $intDigRotulo, $strPrefRotulo, $strSufRotulo, $strCodReserva, $intOrden);

					}


						if($requestCodReserva > 0){

							if($intControl == 0){
								$arrResponse = 	[
												    "status"=> true,
												    "title"	=> "Configuración de Códigos de Cedula de Reserva",
												    "msg" 	=> "Datos Guardados Correctamente.",
												];
							}else{
								$arrResponse = 	[
												    "status"=> true,
												    "title"	=> "Configuración de Códigos de Cedula de Reserva",
												    "msg" 	=> "Datos Actualizados Correctamente.",
												];
							}
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