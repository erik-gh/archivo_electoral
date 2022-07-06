<?php 

	/**
	* 
	*/
	class General extends Controllers
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

		public function general()
		{

			$data['page_tag']='Configuracion General';
			$data['page_title']='CONFIGURACION GENERAL';
			$data['page_name']='general';
			$data['page_function_js']='function_general.js';
			$this->views->getView($this,'general',$data);
		}

		/* ===== PORCESO ===== */
		public function getSelectTipoProceso()
		{

			$htmlOptions = '<option value="">[ Seleccione Tipo Proceso ]</option>';
			$arrData = $this->model->selectCboTipoProceso();
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData) ; $i++) { 
					$htmlOptions .='<option value="'.$arrData[$i]['ID_TIPO'].'"> '.$arrData[$i]['TIPO_PROCESO'].'</option>';
				}
			}
			echo $htmlOptions;
			die();
		}


		public function getProcesos()
		{
			
			$output = array();
			$arrData = $this->model->selectProcesos(); //dep($arrData); exit;
			//$filtro = ($_POST["search"]["value"]!= '') ? $arrData[1] : $arrData[2];
			for ($i=0; $i <  count($arrData); $i++) { 
				# code...
				$arrData[$i]['orden'] 	= 	$i+1;
				$arrData[$i]['ESTADO'] 	= 	$arrData[$i]['ESTADO'] == 1 ? '<span class="label label-success label-pill m-w-60">ACTIVO</span>' : '<span class="label label-danger label-pill m-w-60">INACTIVO</span>';
				$arrData[$i]['opciones'] =	'<a class="btn btn-primary btn-xs" title="Editar" onclick="editarProceso('.$arrData[$i]['ID_PROCESO'].')">
													<i class="zmdi zmdi-edit zmdi-hc-fw"></i>
												</a>
                                				<a class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminarProceso('.$arrData[$i]['ID_PROCESO'].')">
                                					<i data-toggle="tooltip" title="Eiiminar"class="zmdi zmdi-delete zmdi-hc-fw"></i>
                                				</a>';
			}

			$output = array(
				/*"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=> 	count($arrData),
				"recordsFiltered"	=>	count($arrData),*/
				"data"				=>	$arrData
			);
			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
			// dep($arrData[0][0]['estado']);
		}


		public function setProceso()
		{
			//dep($_POST); exit;
			if($_POST){
				if(empty($_POST['tipoProceso']) || empty($_POST['codProceso']) || empty($_POST['nomProceso']) || empty($_POST['fechaInicio']) || empty($_POST['fechaFin'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{

					$intIdProceso	= intval(strClean($_POST['IdProceso']));
					$intControl		= intval(strClean($_POST['controlProceso']));
					$intTipoProeso	= intval(strClean($_POST['tipoProceso']));
					$strCodProceso	= strClean($_POST['codProceso']);
					$strNomProceso	= strClean($_POST['nomProceso']);
					$strFechaInicio	= strClean($_POST['fechaInicio']);
					$strFechaFin	= strClean($_POST['fechaFin']);
					$intUserSession	= intval(strClean($_SESSION['idUser']));
					$intEstado		= intval(strClean($_POST['estado']));


					if($intControl == 0){
						$requestProceso	= $this->model->insertProceso($intTipoProeso, $strCodProceso, $strNomProceso, $strFechaInicio, $strFechaFin, $intUserSession);

					}else{
						$requestProceso	= $this->model->updateProceso($intIdProceso, $intTipoProeso, $strCodProceso, $strNomProceso, $strFechaInicio, $strFechaFin, $intUserSession, $intEstado);
					}


					if($requestProceso > 0){

						if($intControl == 0){
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Procesos",
											    "msg" 	=> "Datos Guardados Correctamente.",
											];
						}else{
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Procesos",
											    "msg" 	=> "Datos Actualizados Correctamente.",
											];
						}

					}else if($requestProceso == 'exist'){
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Alerta!",
										    "msg" 	=> "El Codigo y/o Nombre de Proceso ya se encuentra registrado.",
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


		public function getProceso($idProceso)
		{

			$intIdProceso = intval(strClean($idProceso));

			if ($intIdProceso > 0) {
				
				$arrData = $this->model->selectProceso($intIdProceso);

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


		public function delProceso($idProceso)
		{

				$intIdProceso 	= intval(strClean($idProceso));
				$requestDelete 	= $this->model->deleteProceso($intIdProceso);

				if ($requestDelete) {
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Procesos",
										"msg" 	=> "Proceso Eliminado Correctamente.",
									];
				}else{
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Error al eliminar el Proceso",
									];
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			
				die();
		}


		/* ===== CONUSLTA ===== */
		public function getConsultas()
		{
			
			$output = array();
			$arrData = $this->model->selectConsultas(); //dep($arrData); exit;
			//$filtro = ($_POST["search"]["value"]!= '') ? $arrData[1] : $arrData[2];
			for ($i=0; $i <  count($arrData); $i++) { 
				# code...
				$arrData[$i]['orden'] 	= 	$i+1;
				$arrData[$i]['ESTADO'] 	= 	$arrData[$i]['ESTADO'] == 1 ? '<span class="label label-success label-pill m-w-60">ACTIVO</span>' : '<span class="label label-danger label-pill m-w-60">INACTIVO</span>';
				$arrData[$i]['opciones'] =	'<a class="btn btn-primary btn-xs" title="Editar" onclick="editarConsulta('.$arrData[$i]['ID_CONSULTA'].')">
													<i class="zmdi zmdi-edit zmdi-hc-fw"></i>
												</a>
                                				<a class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminarConsulta('.$arrData[$i]['ID_CONSULTA'].')">
                                					<i data-toggle="tooltip" title="Eiiminar"class="zmdi zmdi-delete zmdi-hc-fw"></i>
                                				</a>';
			}

			$output = array(
				/*"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=> 	count($arrData),
				"recordsFiltered"	=>	count($arrData),*/
				"data"				=>	$arrData
			);
			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
			// dep($arrData[0][0]['estado']);
		}
		

		public function setConsulta()
		{
		 	//dep($_POST); exit;
		 	if($_POST){
				if( empty($_POST['consulta']) || empty($_POST['descripcion']) ){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{

					$intIdConsulta	= intval(strClean($_POST['IdConsulta']));
					$intControl		= intval(strClean($_POST['controlConsulta']));
					$strConsulta	= strClean($_POST['consulta']);
					$strDescripcion	= strClean($_POST['descripcion']);
					$intUserSession	= intval(strClean($_SESSION['idUser']));
					$intEstado		= intval(strClean($_POST['estado']));


					if($intControl == 0){
						$requestConsulta	= $this->model->insertConsulta($strConsulta, $strDescripcion, $intUserSession);
					}else{
						$requestConsulta	= $this->model->updateConsulta($intIdConsulta, $strConsulta, $strDescripcion, $intUserSession, $intEstado);
					}


					if($requestConsulta > 0){

						if($intControl == 0){
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Consultas",
											    "msg" 	=> "Datos Guardados Correctamente.",
											];
						}else{
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Consultas",
											    "msg" 	=> "Datos Actualizados Correctamente.",
											];
						}

					}else if($requestConsulta == 'exist'){
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Alerta!",
										    "msg" 	=> "La Consulta Electoral ya se encuentra registrado.",
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


		public function getConsulta($idConsulta)
		{

			$intIdConsulta = intval(strClean($idConsulta));

			if ($intIdConsulta > 0) {
				
				$arrData = $this->model->selectConsulta($intIdConsulta);

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


		public function delConsulta($idConsulta)
		{

				$intIdConsulta 	= intval(strClean($idConsulta));
				$requestDelete 	= $this->model->deleteConsulta($intIdConsulta);

				if ($requestDelete) {
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Consultas",
										"msg" 	=> "Consulta Eliminado Correctamente.",
									];
				}else{
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Error al eliminar el Consulta",
									];
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			
				die();
		}



		/* ===== ETAPA ===== */
		public function getEtapas()
		{
			
			$output = array();
			$arrData = $this->model->selectEtapas(); //dep($arrData); exit;
			//$filtro = ($_POST["search"]["value"]!= '') ? $arrData[1] : $arrData[2];
			for ($i=0; $i <  count($arrData); $i++) { 
				# code...
				$arrData[$i]['orden'] 	= 	$i+1;
				$arrData[$i]['ESTADO'] 	= 	$arrData[$i]['ESTADO'] == 1 ? '<span class="label label-success label-pill m-w-60">ACTIVO</span>' : '<span class="label label-danger label-pill m-w-60">INACTIVO</span>';
				$arrData[$i]['opciones'] =	'<a data-toggle="modal" href="#modal_etapa" class="btn btn-primary btn-xs" title="Editar" onclick="editarEtapa('.$arrData[$i]['ID_ETAPA'].')">
													<i class="zmdi zmdi-edit zmdi-hc-fw"></i>
												</a>';
			}

			$output = array(
				/*"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=> 	count($arrData),
				"recordsFiltered"	=>	count($arrData),*/
				"data"				=>	$arrData
			);
			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
			// dep($arrData[0][0]['estado']);
		}


		public function setEtapa()
		{
		 	//dep($_POST); exit;
		 	if($_POST){
				if( empty($_POST['descripcion']) ){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{

					$intIdEtapa		= intval(strClean($_POST['IdEtapa']));
					$intControl		= intval(strClean($_POST['controlEtapa']));
					$strDescripcion	= strClean($_POST['descripcion']);
					$intUserSession	= intval(strClean($_SESSION['idUser']));
					$intEstado		= intval(strClean($_POST['estado']));


					if($intControl == 0){
						$requestEtapa	= $this->model->insertEtapa($strDescripcion, $intUserSession);
					}else{
						$requestEtapa	= $this->model->updateEtapa($intIdEtapa, $strDescripcion, $intUserSession, $intEstado);
					}


					if($requestEtapa > 0){

						if($intControl == 0){
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Etapas",
											    "msg" 	=> "Datos Guardados Correctamente.",
											];
						}else{
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Etapas",
											    "msg" 	=> "Datos Actualizados Correctamente.",
											];
						}

					}else if($requestEtapa == 'exist'){
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Alerta!",
										    "msg" 	=> "Descripcion de Etapa ya se encuentra registrado.",
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


		public function getEtapa($idEtapa)
		{

			$intIdEtapa = intval(strClean($idEtapa));

			if ($intIdEtapa > 0) {
				
				$arrData = $this->model->selectEtapa($intIdEtapa);

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


		/* ===== SOLUCION TECNOLOGICA ===== */
		public function getSoluciones()
		{
			
			$output = array();
			$arrData = $this->model->selecSoluciones(); //dep($arrData); exit;
			//$filtro = ($_POST["search"]["value"]!= '') ? $arrData[1] : $arrData[2];
			for ($i=0; $i <  count($arrData); $i++) { 
				# code...
				$arrData[$i]['orden'] 	= 	$i+1;
				$arrData[$i]['ESTADO'] 	= 	$arrData[$i]['ESTADO'] == 1 ? '<span class="label label-success label-pill m-w-60">ACTIVO</span>' : '<span class="label label-danger label-pill m-w-60">INACTIVO</span>';
				$arrData[$i]['opciones'] =	'<a class="btn btn-primary btn-xs" title="Editar" onclick="editarSolucion('.$arrData[$i]['ID_SOLUCIONTECNOLOGICA'].')">
													<i class="zmdi zmdi-edit zmdi-hc-fw"></i>
												</a>
                                				<a class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminarSolucion('.$arrData[$i]['ID_SOLUCIONTECNOLOGICA'].')">
                                					<i data-toggle="tooltip" title="Eiiminar"class="zmdi zmdi-delete zmdi-hc-fw"></i>
                                				</a>';
			}

			$output = array(
				/*"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=> 	count($arrData),
				"recordsFiltered"	=>	count($arrData),*/
				"data"				=>	$arrData
			);
			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
			// dep($arrData[0][0]['estado']);
		}


		public function setSolucion()
		{
		 	// dep($_POST); exit;
		 	if($_POST){
				if( empty($_POST['descripcion']) ){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{

					$intIdSolucion	= intval(strClean($_POST['IdSolucion']));
					$intControl		= intval(strClean($_POST['controlSolucion']));
					$strSolucion	= strClean($_POST['solucion']);
					$strDescripcion	= strClean($_POST['descripcion']);
					$intUserSession	= intval(strClean($_SESSION['idUser']));
					$intEstado		= intval(strClean($_POST['estado']));


					if($intControl == 0){
						$requestSolucion	= $this->model->insertSolucion($strSolucion, $strDescripcion, $intUserSession);
					}else{
						$requestSolucion	= $this->model->updateSolucion($intIdSolucion, $strSolucion, $strDescripcion, $intUserSession, $intEstado);
					}


					if($requestSolucion > 0){

						if($intControl == 0){
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Solucion Tecnologica",
											    "msg" 	=> "Datos Guardados Correctamente.",
											];
						}else{
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Solucion Tecnologica",
											    "msg" 	=> "Datos Actualizados Correctamente.",
											];
						}

					}else if($requestSolucion == 'exist'){
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Alerta!",
										    "msg" 	=> "Solucion Tecnologica ya se encuentra registrada.",
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


		public function getSolucion($idSolucion)
		{

			$intIdSolucion = intval(strClean($idSolucion));

			if ($intIdSolucion > 0) {
				
				$arrData = $this->model->selectSolucion($intIdSolucion);

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


		public function delSolucion($idSolucion)
		{

				$intIdSolucion 	= intval(strClean($idSolucion));
				$requestDelete 	= $this->model->deleteSolucion($intIdSolucion);

				if ($requestDelete) {
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Soluciones",
										"msg" 	=> "Solución Tecnoñógica Eliminado Correctamente.",
									];
				}else{
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Error al eliminar el Solución Tecnoñógica",
									];
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			
				die();
		}


		/* ===== MATERIAL ===== */
		public function getMateriales()
		{
			
			$output = array();
			$arrData = $this->model->selecMateriales(); //dep($arrData); exit;
			//$filtro = ($_POST["search"]["value"]!= '') ? $arrData[1] : $arrData[2];
			for ($i=0; $i <  count($arrData); $i++) { 
				# code...
				$arrData[$i]['orden'] 	= 	$i+1;
				$arrData[$i]['ESTADO'] 	= 	$arrData[$i]['ESTADO'] == 1 ? '<span class="label label-success label-pill m-w-60">ACTIVO</span>' : '<span class="label label-danger label-pill m-w-60">INACTIVO</span>';
				$arrData[$i]['opciones'] =	'<a data-toggle="modal" href="#modal_material" class="btn btn-primary btn-xs" title="Editar" onclick="editarMaterial('.$arrData[$i]['ID_MATERIAL'].')">
													<i class="zmdi zmdi-edit zmdi-hc-fw"></i>
												</a>';
			}

			$output = array(
				/*"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=> 	count($arrData),
				"recordsFiltered"	=>	count($arrData),*/
				"data"				=>	$arrData
			);
			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
			// dep($arrData[0][0]['estado']);
		}


		public function setMaterial()
		{
		 	//dep($_POST); exit;
		 	if($_POST){
				if( empty($_POST['descripcion']) ){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{

					$intIdMaterial	= intval(strClean($_POST['IdMaterial']));
					$intControl		= intval(strClean($_POST['controlMaterial']));
					$strDescripcion	= strClean($_POST['descripcion']);
					$intUserSession	= intval(strClean($_SESSION['idUser']));
					$intEstado		= intval(strClean($_POST['estado']));


					if($intControl == 0){
						$requestMaterial	= $this->model->insertMaterial($strDescripcion, $intUserSession);
					}else{
						$requestMaterial	= $this->model->updateMaterial($intIdMaterial, $strDescripcion, $intUserSession, $intEstado);
					}


					if($requestMaterial > 0){

						if($intControl == 0){
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Material Electoral",
											    "msg" 	=> "Datos Guardados Correctamente.",
											];
						}else{
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Material Electoral",
											    "msg" 	=> "Datos Actualizados Correctamente.",
											];
						}

					}else if($requestMaterial == 'exist'){
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Alerta!",
										    "msg" 	=> "Descripcion de Material Electoral ya se encuentra registrado.",
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


		public function getMaterial($idMaterial)
		{

			$intIdMaterial = intval(strClean($idMaterial));

			if ($intIdMaterial > 0) {
				
				$arrData = $this->model->selectMaterial($intIdMaterial);

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



		/* ===== INCIDENCIA ===== */
		public function getIncidencias()
		{
			
			$output = array();
			$arrData = $this->model->selectincidencias(); //dep($arrData); exit;
			//$filtro = ($_POST["search"]["value"]!= '') ? $arrData[1] : $arrData[2];
			for ($i=0; $i <  count($arrData); $i++) { 
				# code...
				$arrData[$i]['orden'] 	= 	$i+1;
				$arrData[$i]['ESTADO'] 	= 	$arrData[$i]['ESTADO'] == 1 ? '<span class="label label-success label-pill m-w-60">ACTIVO</span>' : '<span class="label label-danger label-pill m-w-60">INACTIVO</span>';
				$arrData[$i]['opciones'] =	'<a class="btn btn-primary btn-xs" title="Editar" onclick="editarIncidencia('.$arrData[$i]['ID_INCIDENCIA'].')">
													<i class="zmdi zmdi-edit zmdi-hc-fw"></i>
												</a>
                                				<a class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminarIncidencia('.$arrData[$i]['ID_INCIDENCIA'].')">
                                					<i data-toggle="tooltip" title="Eiiminar"class="zmdi zmdi-delete zmdi-hc-fw"></i>
                                				</a>';
			}

			$output = array(
				/*"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=> 	count($arrData),
				"recordsFiltered"	=>	count($arrData),*/
				"data"				=>	$arrData
			);
			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
			// dep($arrData[0][0]['estado']);
		}
		

		public function setincidencia()
		{
		 	// dep($_POST); exit;
		 	if($_POST){
				if( empty($_POST['incidencia']) || empty($_POST['descripcion']) ){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{

					$intIdIncidencia	= intval(strClean($_POST['IdIncidencia']));
					$intControl			= intval(strClean($_POST['controlIncidencia']));
					$strIncidencia		= strClean($_POST['incidencia']);
					$strDescripcion		= strClean($_POST['descripcion']);
					$intUserSession		= intval(strClean($_SESSION['idUser']));
					$intEstado			= intval(strClean($_POST['estado']));


					if($intControl == 0){
						$requestIncidencia	= $this->model->insertIncidencia($strIncidencia, $strDescripcion, $intUserSession);
					}else{
						$requestIncidencia	= $this->model->updateIncidencia($intIdIncidencia, $strIncidencia, $strDescripcion, $intUserSession, $intEstado);
					}


					if($requestIncidencia > 0){

						if($intControl == 0){
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Incidencias",
											    "msg" 	=> "Datos Guardados Correctamente.",
											];
						}else{
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Incidencias",
											    "msg" 	=> "Datos Actualizados Correctamente.",
											];
						}

					}else if($requestIncidencia == 'exist'){
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Alerta!",
										    "msg" 	=> "La Incidencia ya se encuentra registrado.",
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

				if ($requestDelete) {
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Incidencias",
										"msg" 	=> "Consulta Eliminado Correctamente.",
									];
				}else{
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Error al eliminar el Consulta",
									];
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			
				die();
		}



		/* ====== ASIGNAR ===== */
		public function getSelectEtapa()
		{

			$htmlOptions = '<option value="">[ Seleccione Etapa ]</option>';
			$arrData = $this->model->selectCboEtapa();
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData) ; $i++) { 
					$htmlOptions .='<option value="'.$arrData[$i]['ID_ETAPA'].'"> '.$arrData[$i]['ETAPA'].'</option>';
				}
			}
			echo $htmlOptions;
			die();
		}


		public function setAsignar()
		{
			if($_POST){
				if(empty($_POST['incidencias']) || empty($_POST['etapa'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$intControl			= intval(strClean($_POST['controlAsignar']));
					$intIdEtapa			= intval(strClean($_POST['etapa']));
					$intidincidencias	= $_POST['incidencias'];
					
					$requestDelete = $this->model->deleteAsignar($intIdEtapa);
					foreach($intidincidencias as $row){

						$requestAsignar	= $this->model->insertAsignar($intIdEtapa, $row);
					
					}

					if($requestAsignar > 0){

						if($intControl == 0){
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Asignar Incidecnias",
											    "msg" 	=> "Datos Guardados Correctamente.",
											];
						}else{
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Asignar Incidecnias",
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


		public function getSelectIncidencias()
		{
			$htmlOptions = '';
			$arrData = $this->model->selectCboIncidencias();
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData) ; $i++) { 
					$htmlOptions .='<option value="'.$arrData[$i]['ID_INCIDENCIA'].'"> '.$arrData[$i]['INCIDENCIA'].'</option>';
				}
			}
			echo $htmlOptions;
			die();
		}


		public function getIncidenciasAsignados()
		{
			
			$output = array();
			$arrData = $this->model->selectincidenciasAsignar(); //dep($arrData); exit;
			//$filtro = ($_POST["search"]["value"]!= '') ? $arrData[1] : $arrData[2];
			for ($i=0; $i <  count($arrData); $i++) { 
				$incidencia =  explode(";", $arrData[$i]['INCIDENCIAS']);
                $row_incidencia = count($incidencia);
             	$arrData[$i]['LISTA_INCIDENCIAS'] = '';

             	for ($y=0; $y < $row_incidencia; $y++) { 
                	$arrData[$i]['LISTA_INCIDENCIAS'] .= ($y+1).'.- <span>'.$incidencia[$y].'</span><br> ';
               	}

				$arrData[$i]['orden'] 	 	= 	$i+1;
				$arrData[$i]['INCIDENCIAS'] = '<span>'.$arrData[$i]['INCIDENCIAS'].'</span>,';
				$arrData[$i]['opciones'] 	= '<a class="btn btn-primary btn-xs" title="Editar" onclick="editarAsignar('.$arrData[$i]['ID_ETAPA'].')">
													<i class="zmdi zmdi-edit zmdi-hc-fw"></i>
												</a>
												<a class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminarAsignar('.$arrData[$i]['ID_ETAPA'].')">
                                					<i data-toggle="tooltip" title="Eiiminar"class="zmdi zmdi-delete zmdi-hc-fw"></i>
                                				</a>';
			}

			$output = array("data" => $arrData);
			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
			// dep($arrData[0][0]['estado']);
		}


		public function getAsignar($idEtapa)
		{

			$intIdEtapa = intval(strClean($idEtapa));

			if ($intIdEtapa > 0) {
				
				$arrData = $this->model->selectAsignar($intIdEtapa);

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


		public function delAsignar($idEtapa)
		{
			
				$intIdEtapa 	= intval(strClean($idEtapa));
				$requestDelete  = $this->model->deleteAsignar($intIdEtapa);

				if ($requestDelete > 0) {
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Asignar Incidencias",
										"msg" 	=> "Etapa Eliminada Correctamente.",
									];

				}else{
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Error al eliminar la Etapa",
									];
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				die();
		}



		/* ===== DISPOSITIVOS USB ===== */
		public function getDispositivos()
		{
			
			$output = array();
			$arrData = $this->model->selecDispositivos(); //dep($arrData); exit;
			//$filtro = ($_POST["search"]["value"]!= '') ? $arrData[1] : $arrData[2];
			for ($i=0; $i <  count($arrData); $i++) { 
				# code...
				$arrData[$i]['orden'] 	= 	$i+1;
				$arrData[$i]['ESTADO'] 	= 	$arrData[$i]['ESTADO'] == 1 ? '<span class="label label-success label-pill m-w-60">ACTIVO</span>' : '<span class="label label-danger label-pill m-w-60">INACTIVO</span>';
				$arrData[$i]['opciones'] =	'<a class="btn btn-primary btn-xs" title="Editar" onclick="editarDispositivo('.$arrData[$i]['ID_TIPO'].')">
													<i class="zmdi zmdi-edit zmdi-hc-fw"></i>
												</a>
                                				<a class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminarDispositivo('.$arrData[$i]['ID_TIPO'].')">
                                					<i data-toggle="tooltip" title="Eiiminar"class="zmdi zmdi-delete zmdi-hc-fw"></i>
                                				</a>';
			}

			$output = array(
				/*"draw"				=>	intval($_POST["draw"]),
				"recordsTotal"		=> 	count($arrData),
				"recordsFiltered"	=>	count($arrData),*/
				"data"				=>	$arrData
			);
			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
			// dep($arrData[0][0]['estado']);
		}


		public function setDispositivo()
		{
		 	// dep($_POST); exit;
		 	if($_POST){
				if( empty($_POST['descripcion']) ){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{

					$intIdDispositivo	= intval(strClean($_POST['IdDispositivo']));
					$intControl			= intval(strClean($_POST['controlDispositivo']));
					$strDescripcion		= strClean($_POST['descripcion']);
					$intUserSession		= intval(strClean($_SESSION['idUser']));
					$intEstado			= intval(strClean($_POST['estado']));


					if($intControl == 0){
						$requestDispositivo	= $this->model->insertDispositivo($strDescripcion, $intUserSession);
					}else{
						$requestDispositivo	= $this->model->updateDispositivo($intIdDispositivo, $strDescripcion, $intUserSession, $intEstado);
					}


					if($requestDispositivo > 0){

						if($intControl == 0){
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Dispositivo USB",
											    "msg" 	=> "Datos Guardados Correctamente.",
											];
						}else{
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Dispositivo USB",
											    "msg" 	=> "Datos Actualizados Correctamente.",
											];
						}

					}else if($requestDispositivo == 'exist'){
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Alerta!",
										    "msg" 	=> "Dispositivo USB ya se encuentra registrada.",
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


		public function getDispositivo($idDispositivo)
		{

			$intIdDispositivo = intval(strClean($idDispositivo));

			if ($intIdDispositivo > 0) {
				
				$arrData = $this->model->selectDispositivo($intIdDispositivo);

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


		public function delDispositivo($idDispositivo)
		{

				$intIdDispositivo 	= intval(strClean($idDispositivo));
				$requestDelete 	= $this->model->deleteDispositivo($intIdDispositivo);

				if ($requestDelete) {
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Dispositivos USB",
										"msg" 	=> "Dispositivos USB Eliminado Correctamente.",
									];
				}else{
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Error al eliminar el Dispositivos USB",
									];
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			
				die();
		}
		
	}

?>