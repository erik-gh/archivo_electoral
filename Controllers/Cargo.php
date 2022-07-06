<?php 

	/**
	* 
	*/
	class Cargo extends Controllers
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

		public function cargo()
		{

			$data['page_tag']='Pedidos y Cargos';
			$data['page_title']='PEDIDOS Y CARGOS';
			$data['page_name']='cargos';
			$data['page_function_js']='function_cargo.js';
			$this->views->getView($this,'cargo',$data);
		}


		public function setCargo()
		{
			//dep($_POST); exit;
			if($_POST){
				if(empty($_POST['cargo']) || empty($_POST['remuneracion'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$intIdCargo			= intval(strClean($_POST['Idcargo']));
					$intControl			= intval(strClean($_POST['controlCargo']));
					$strCargo			= strClean($_POST['cargo']);
					$intRemuneracion	= intval(strClean($_POST['remuneracion']));
					$intUserSession		= intval(strClean($_SESSION['idUser']));
					$intEstado			= intval(strClean($_POST['estado']));
					
					if($intControl == 0){
						$requestCargo	= $this->model->insertCargo($strCargo, $intRemuneracion, $intUserSession);
					}else{
						$requestCargo	= $this->model->updateCargo($intIdCargo, $strCargo, $intRemuneracion, $intUserSession, $intEstado);
					}

					if($requestCargo > 0){

						if($intControl == 0){
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Cargos",
											    "msg" 	=> "Datos Guardados Correctamente.",
											];
						}else{
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Cargos",
											    "msg" 	=> "Datos Actualizados Correctamente.",
											];
						}
					}else if($requestCargo == 'exist'){
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Alerta!",
										    "msg" 	=> "Ya se encuentra registrado este Cargo.",
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


		public function getCargos()
		{
			
			$output = array();
			$arrData = $this->model->selectCargos();
			//$filtro = ($_POST["search"]["value"]!= '') ? $arrData[1] : $arrData[2];
			for ($i=0; $i <  count($arrData[0]); $i++) { 
				# code...
				$arrData[0][$i]['orden'] 	= 	$i+1;
				$arrData[0][$i]['estado'] 	= 	$arrData[0][$i]['estado'] == 1 ? '<span class="label label-success label-pill m-w-60">ACTIVO</span>' : '<span class="label label-danger label-pill m-w-60">INACTIVO</span>';
				$arrData[0][$i]['opciones'] =	'<a class="btn btn-primary btn-xs" title="Editar" onclick="editarCargo('.$arrData[0][$i]['id_cargo'].')">
													<i class="zmdi zmdi-edit zmdi-hc-fw"></i>
												</a>
                                				<a class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminarCargo('.$arrData[0][$i]['id_cargo'].')">
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


		public function getCargo($idCargo)
		{

			$intIdCargo = intval(strClean($idCargo));

			if ($intIdCargo > 0) {
				
				$arrData = $this->model->selectCargo($intIdCargo);

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


		public function delCargo($idCargo)
		{
			
				$intIdCargo 	= intval(strClean($idCargo));
				$requestDelete 	= $this->model->deleteCargo($intIdCargo);

				if ($requestDelete > 0) {
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Cargos",
										"msg" 	=> "Cargo Eliminado Correctamente.",
									];

				}else if($requestDelete == 'exist'){
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Alerta!",
										"msg" 	=> "No se puede eliminar el Cargo, esta asociado a un Personal.",
									];
				}else{
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Error al eliminar el Cargo",
									];
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			
				die();
		}


		public function getSelectCargos()
		{
			$htmlOptions = '<option value="">[ Seleccione Cargo ]</option>';
			$arrData = $this->model->selectCboCargos();
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData) ; $i++) { 
					$htmlOptions .='<option value="'.$arrData[$i]['id_cargo'].'"> '.$arrData[$i]['cargo'].'</option>';
				}
			}
			echo $htmlOptions;
			die();
		}


		public function getexportCargo()
		{	
			
			date_default_timezone_set('America/Lima');
    		$fecha = date("d-m-Y");
    		$fechaC = date("d/m/Y (h:i:s a)");
			$requestReporte	= $this->model->selectReporteCargo();
			//dep($requestReporte); exit;

			if(count($requestReporte) > 0 ){

				if (PHP_SAPI == 'cli')
					die('Este archivo solo se puede ver desde un navegador web');
					
					require_once './Assets/lib/PHPExcel-1.8.2/Classes/PHPExcel.php';

					// Se crea el objeto PHPExcel
					$objPHPExcel = new PHPExcel();

					// Se asignan las propiedades del libro
					$objPHPExcel->getProperties()->setCreator(strtoupper ('PERSONAL')) //Autor
										 ->setLastModifiedBy("Usuario") //Ultimo usuario que lo modificó
										 ->setTitle("Reporte de Cargos - ".strtoupper ('GGE'))
										 ->setSubject("Reporte Cargos")
										 ->setDescription("Reporte de Cargos")
										 ->setKeywords("Reporte de Cargos - ".strtoupper ('GGE'))
										 ->setCategory("Reporte excel");

					$tituloReporte = "LISTADO DE CARGOS -  ".strtoupper ('GGE');
					$titulosColumnas = array('N°','NOMBRE CARGO','REMUNERACION ', 'ESTADO');

			    	#Combinacion de celdas Titulo General
					$objPHPExcel->setActiveSheetIndex(0)
							    ->mergeCells('B1:E1')
			            		->mergeCells('C3:D3')
			            		->mergeCells('C4:D4')
			            		->mergeCells('G3:I3');
									
					// Se agregan los titulos del reporte
					$objPHPExcel->setActiveSheetIndex(0)
			  					->setCellValue('B1',  $tituloReporte)
			  					->setCellValue('A7', $titulosColumnas[0])
			        			->setCellValue('B7', $titulosColumnas[1])
			        			->setCellValue('C7', $titulosColumnas[2])
			        			->setCellValue('D7', $titulosColumnas[3]);


		            $objPHPExcel->setActiveSheetIndex(0)
	                  	->setCellValue('B3', 'GERENCIA:')
	                  	->setCellValue('C3', strtoupper('GGE'))
	                  	->setCellValue('B4', 'DIRECCIÓN:')
	                  	->setCellValue('c4', strtoupper('CEPSA 1'))
	                    ->setCellValue('F3', 'FECHA:')
	                    ->setCellValue('G3', $fechaC);

	               	//Se agregan los datos del Personal
					$i = 8;
					$c = 0;
					foreach ($requestReporte as $value){
			      		$c = $c+1;

			         	$objPHPExcel->setActiveSheetIndex(0)
			                      	->setCellValue('A'.$i,  $c)
			                      	->setCellValue('B'.$i,  $value['cargo'])
			                      	->setCellValue('C'.$i,  $value['remuneracion']);

			            $estado = ($value['estado'] == 1) ? 'ACTIVO' : 'INACTIVO';
			            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$i, $estado );        
			                      	
			         	$i++;
			    	}


			    	$estiloTituloReporte = array(
			        	'font' => array(
				        	'name'      => 'Calibri',
			    	        'bold'      => true,
			        	    'italic'    => false,
			              	'strike'    => false,
			              	'size' 		  => 11,
			              	'underline' => 'single',
			              	'color'     => array(
			            		'rgb'   => '0C5C97'
			       			 )
			            ),
				        'fill' => array(
							//'type'	=> PHPExcel_Style_Fill::FILL_SOLID,
						),
			            'borders' => array(
			               	'allborders' => array(
			               	//'style' => PHPExcel_Style_Border::BORDER_NONE                    
			               	)
			            ), 
			            'alignment' =>  array(
			        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			        			'rotation'   => 0,
			        			'wrap'       => TRUE
			    		)
			        );


			        $estiloTituloColumnas = array(
			            'font' => array(
			                'name'      => 'Calibri',
			                'bold'      => true,
			                'size' 		=> 11,
			                'color'     => array(
			            		'rgb'   => '087630'
			       			 )                         
			            ),
			            'fill' 	=> array(
							//'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
						),
			            'borders' => array(
			            	'top'     => array(
			                //'style' => PHPExcel_Style_Border::BORDER_NONE ,

			                ),
			                'bottom'     => array(
			                    //'style' => PHPExcel_Style_Border::BORDER_NONE ,
			                )
			            ),
						'alignment' =>  array(
			        			'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			        			'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
			        			'rotation'   => 0,
			        			'wrap'       => TRUE
			    	));


			    	$estiloInformacion = new PHPExcel_Style();
					$estiloInformacion->applyFromArray(
						array(
			           		'font' => array(
			               	'name'      => 'Calibri',
			               	'color'     => array(
			            		'rgb'   => '3D3D3D'
			       			 )

			           	),
			           	'fill' 	=> array(
							//'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
							
						),
			           	'borders' => array(
			               	'left'     => array(
			                   	//'style' => PHPExcel_Style_Border::BORDER_THIN ,

			               	)             
			           	)
			        ));

				    $estiloSubTitulo = array(
		          		'font' => array(
			                'name'    => 'Calibri',
			                'bold'    => true,
			                'size'    => 11,
			                'color'   => array(
			                'rgb'   => '000000'
		             		)                         
		            	),
		          		'fill' 	=> array(
						//'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
						),
		            	'borders' => array(
		            		'top'     => array(
		                //'style' => PHPExcel_Style_Border::BORDER_NONE ,

		                	),
		                	'bottom'     => array(
		                    //'style' => PHPExcel_Style_Border::BORDER_NONE ,
		                	)
		            ));
   	

			        $objPHPExcel->getActiveSheet()->getStyle('B1:E1')->applyFromArray($estiloTituloReporte);
					$objPHPExcel->getActiveSheet()->getStyle('A7:D7')->applyFromArray($estiloTituloColumnas);	 
					$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A8:D".($i-1));
					$objPHPExcel->getActiveSheet()->getStyle('B3:B4')->applyFromArray($estiloSubTitulo);
			    	$objPHPExcel->getActiveSheet()->getStyle('F3:F4')->applyFromArray($estiloSubTitulo);
					$objPHPExcel->getActiveSheet()->getStyle('L3:N3')->applyFromArray($estiloSubTitulo);
			    	$objPHPExcel->getActiveSheet()->getStyle('B1:B'.(count($requestReporte)+7))->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );

			    	//Zoom de la hoja Excel
				    $objPHPExcel->getSheet(0)->getSheetView()->setZoomScale(80);


					for($i = 'A'; $i <= 'D'; $i++){
						$objPHPExcel->setActiveSheetIndex(0)			
							->getColumnDimension($i)->setAutoSize(TRUE);
					}


					// Se asigna el nombre a la hoja
					//$objPHPExcel->getActiveSheet()->setTitle('Reporte_Trabajadores');
					$objPHPExcel->getSheet(0)->setTitle('Reporte_Cargos');
					// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
					$objPHPExcel->setActiveSheetIndex(0);
					// Inmovilizar paneles 
					//$objPHPExcel->getActiveSheet(0)->freezePane('A4');

					$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,8);
					//$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(5,10);

					$excelName = "REPORTE_CARGO_".strtoupper('GGE')."_".$fecha.".xlsx";
				    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				    $objWriter->save($excelName);
				    //echo $excelName;
				    $arrResponse = 	[
										"status"=> true,
										"title"	=> "Reporte de Cargos",
										"msg" 	=> "Se descargo el Reporte correctamente",
										"data"	=>	$excelName,
									]; 

			}else{
				$arrResponse = 	[
										"status"=> false,
										"title"	=> "Alerta!",
										"msg" 	=> "No hay Datos para mostrar.",
									]; 
			}

			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function eliminarfile($id)
		{
			//echo $id;
			if (isset($id)) {
				if (file_exists($id)) {
					unlink($id);

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




	}

?>