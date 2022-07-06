<?php 

	/**
	* 
	*/
	class Personal extends Controllers
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


		public function personal()
		{

			$data['page_tag']='Personal';
			$data['page_title']='PERSONAL - GGE';
			$data['page_name']='personal';
			$data['page_function_js']='function_personal.js';
			$this->views->getView($this,'personal',$data);
		}


		public function setPersonal()
		{
			//dep($_POST); exit;
			if($_POST){
				if(empty($_POST['dni']) || empty($_POST['apellido']) || empty($_POST['nombre']) || empty($_POST['cargo']) || empty($_POST['gerencia'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$intIdPersonal	= intval(strClean($_POST['IdPersonal']));
					$intControl		= intval(strClean($_POST['controlPersonal']));
					$strDNI			= strClean($_POST['dni']);
					$strNombre		= strClean($_POST['apellido'].' '.$_POST['nombre']);
					$strNombreC		= strClean($_POST['nombreCompleto']);
					$intCargo		= intval(strClean($_POST['cargo']));
					$intGerencia	= intval(strClean($_POST['gerencia']));
					$strImagen		= strClean($_POST['imagen']);
					$intUserSession	= intval(strClean($_SESSION['idUser']));
					$intEstado		= intval(strClean($_POST['estado']));
					$intListaBlack	= intval(strClean($_POST['listblack']));
					
					if($intControl == 0){
						$requestPersonal	= $this->model->insertPersonal($strDNI, $strNombre, $intCargo, $intGerencia, $intUserSession, $strImagen);
					}else{
						if($intListaBlack == 3){
							$requestPersonal	= $this->model->updatePersonal($intIdPersonal, $strDNI, $strNombreC, $intCargo, $intGerencia, $intUserSession, $intListaBlack, $strImagen);
						}else{
							$requestPersonal	= $this->model->updatePersonal($intIdPersonal, $strDNI, $strNombreC, $intCargo, $intGerencia, $intUserSession, $intEstado, $strImagen);
						}
					}

					if($requestPersonal > 0){

						if($intControl == 0){
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Personal",
											    "msg" 	=> "Datos Guardados Correctamente.",
											];
						}else{
							$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Personal",
											    "msg" 	=> "Datos Actualizados Correctamente.",
											];
						}
					}else if($requestPersonal == 'exist'){
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Alerta!",
										    "msg" 	=> "El DNI ya se encuentra registrado.",
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


		public function getPersonal()
		{
			
			$output = array();
			$arrData = $this->model->selectPersonal();
			//$filtro = ($_POST["search"]["value"]!= '') ? $arrData[1] : $arrData[2];
			for ($i=0; $i <  count($arrData[0]); $i++) { 
				# code...
				$arrData[0][$i]['orden'] 	= 	$i+1;
				
				if($arrData[0][$i]['estado'] == 1){
					$arrData[0][$i]['estado'] = '<span class="label label-success label-pill m-w-60">ACTIVO</span>';
				}elseif ($arrData[0][$i]['estado'] == 2) {
					$arrData[0][$i]['estado'] = '<span class="label label-danger label-pill m-w-60">INACTIVO</span>';
				}else{
				 	$arrData[0][$i]['estado'] = '<span class="label label-default label-pill m-w-60">LISTA N</span>';
				}

				$arrData[0][$i]['opciones'] =	'<a class="btn btn-primary btn-xs" title="Editar" onclick="editarPersonal('.$arrData[0][$i]['id_personal'].')">
													<i class="zmdi zmdi-edit zmdi-hc-fw"></i>
												</a>
                                				<a class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminarPersonal('.$arrData[0][$i]['id_personal'].')">
                                					<i data-toggle="tooltip" title="Eiiminar" class="zmdi zmdi-delete zmdi-hc-fw"></i>
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


		public function getPersona($idPersonal)
		{

			$intIdPersonal = intval(strClean($idPersonal));

			if ($intIdPersonal > 0) {
				
				$arrData = $this->model->selectPersona($intIdPersonal);

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


		public function delPersonal($idPersonal)
		{
			
				$intIdPersonal 	= intval(strClean($idPersonal));
				$requestDelete 	= $this->model->deletePersonal($intIdPersonal);

				if ($requestDelete) {
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Personal",
										"msg" 	=> "Personal Eliminado Correctamente.",
									];
				}else{
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Error al eliminar el Personal",
									];
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			
				die();
		}


		public function plantillaExcel()
		{
			if (PHP_SAPI == 'cli')
				die('Este archivo solo se puede ver desde un navegador web');
				
				require_once './Assets/lib/PHPExcel-1.8.2/Classes/PHPExcel.php';

				// Se crea el objeto PHPExcel
				$objPHPExcel = new PHPExcel();

				// Se asignan las propiedades del libro
				$objPHPExcel->getProperties()->setCreator(strtoupper ('PESONAL')) //Autor
							 ->setLastModifiedBy("Usuario") //Ultimo usuario que lo modificó
							 ->setTitle("Plantilla de Ingreso de Persoanl-  ".strtoupper ('GGE'))
							 ->setSubject("Plantilla de Ingreso")
							 ->setDescription("Plantilla de Ingreso")
							 ->setKeywords("RPlantilla de Ingreso de Persoanl - ".strtoupper ('GGE'))
							 ->setCategory("Reporte excel");

				$tituloReporte = "LISTADO DE PERSONAL  -  ".strtoupper ('GGE');
				$titulosColumnas = array(' D.N.I. ',' APELLIDOS Y NOMBRES ', ' CARGO ', ' GERENCIA ', ' ESTADO ', ' Nº CARGO ', ' CARGO' );

				//Combinacion de celdas Titulo General
				$objPHPExcel->setActiveSheetIndex(0)
						    ->mergeCells('A1:P1');

				// Se agregan los titulos del reporte
				$objPHPExcel->setActiveSheetIndex(0)
  					        ->setCellValue('A1',  $tituloReporte)
  					        ->setCellValue('A2', $titulosColumnas[0])
          		  	  		->setCellValue('B2', $titulosColumnas[1])
          		  	  		->setCellValue('C2', $titulosColumnas[2])
                    		->setCellValue('D2', $titulosColumnas[3])
                    		->setCellValue('E2', $titulosColumnas[4])
                    		->setCellValue('O2', $titulosColumnas[5])
                    		->setCellValue('P2', $titulosColumnas[6]);

                $valoresEstado="1,2,3";
                for ($i=3; $i < 500; $i++) { 
                		$objValidation = $objPHPExcel->getActiveSheet()->getCell('E'.$i)->getDataValidation();
		                $objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
		                $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
		                $objValidation->setAllowBlank(false);
		                $objValidation->setShowInputMessage(true);
		                $objValidation->setShowErrorMessage(true);
		                $objValidation->setShowDropDown(true);
		                $objValidation->setErrorTitle('Error de entrada');
		                $objValidation->setError('El valor no está en la lista.');
		                $objValidation->setPromptTitle('Elegir de la lista');
		                $objValidation->setPrompt('1 - ACTIVO
					2 - INACTIVO
					3 - BACK LIST');
		                $objValidation->setFormula1('"'.$valoresEstado.'"');
                }

                $arrDataGerencia = $this->model->selectcboGerencias();
		       	
		        $valoresGerencia= '';
		        $gerencias 		= '';
		        for ($i=0; $i < count($arrDataGerencia); $i++) { 
		        	# code...
		        	$valoresGerencia .= $arrDataGerencia[$i]['id_gerencia'].',';
		        	$gerencias .= $arrDataGerencia[$i]['id_gerencia'].' - '.$arrDataGerencia[$i]['abreviatura'].',';
		        }

                $valoresGerencia= trim($valoresGerencia,',');
                $gerencias 		= trim($gerencias,',');
                $resultGerencias= str_replace(',', "\n", $gerencias);
                for ($i=3; $i < 500; $i++) { 
                		$objValidation = $objPHPExcel->getActiveSheet()->getCell('D'.$i)->getDataValidation();
		                $objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
		                $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
		                $objValidation->setAllowBlank(false);
		                $objValidation->setShowInputMessage(true);
		                $objValidation->setShowErrorMessage(true);
		                $objValidation->setShowDropDown(true);
		                $objValidation->setErrorTitle('Error de entrada');
		                $objValidation->setError('El valor no está en la lista.');
		                $objValidation->setPromptTitle('Elegir de la lista');
		                $objValidation->setPrompt($resultGerencias);
		                $objValidation->setFormula1('"'.$valoresGerencia.'"');
                }

         		$arrData = $this->model->selectcboCargos();
		       	
		        $valoresCargo= '';
		        for ($i=0; $i < count($arrData); $i++) { 
		        	# code...
		        	$valoresCargo .= $arrData[$i]['id_cargo'].',';
		        }
		        
		        $valoresCargo = trim($valoresCargo,',');
                for ($i=3; $i < 500; $i++) { 
                		$objValidation = $objPHPExcel->getActiveSheet()->getCell('C'.$i)->getDataValidation();
		                $objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_LIST );
		                $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
		                $objValidation->setAllowBlank(false);
		                $objValidation->setShowInputMessage(true);
		                $objValidation->setShowErrorMessage(true);
		                $objValidation->setShowDropDown(true);
		                $objValidation->setErrorTitle('Error de entrada');
		                $objValidation->setError('El valor no está en la lista.');
		                $objValidation->setPromptTitle('Elegir de la lista');
		                $objValidation->setPrompt('Elija un valor de la lista Cargo.');
		                $objValidation->setFormula1('"'.$valoresCargo.'"');
                }


                $i = 3;
				foreach ($arrData as $value){
			          $objPHPExcel->setActiveSheetIndex(0)
			                      ->setCellValue('O'.$i,  $value['id_cargo'])
			                      ->setCellValue('P'.$i,  $value['cargo']);
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
		    		)
				);
			
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
		        	)
		        );

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
	            	)
		        );

		        $estiloCode = array(
		          'font' => array(
		                'name'    => 'Calibri',
		                'bold'    => true,
		                'size'    => 1,
		                'color'   => array(
		                'rgb'   => 'FFFFFF'
		             )                         
		            ),
		        );
		        //CODE
		        $objPHPExcel->getSheet(0)->getStyle('Z200')->applyFromArray($estiloCode);

		        $objPHPExcel->getActiveSheet()->getStyle('A1:P1')->applyFromArray($estiloTituloReporte);
    			$objPHPExcel->getActiveSheet()->getStyle('A2:P2')->applyFromArray($estiloTituloColumnas);		
    			$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A3:P500");
        		$objPHPExcel->getActiveSheet()->getStyle('A1:A500')->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );
        		$objPHPExcel->getActiveSheet()->getRowDimension(1)->setRowHeight(35);
        		$objPHPExcel->getActiveSheet()->getRowDimension(2)->setRowHeight(30);
        		//CODE INCG
       			$objPHPExcel->getActiveSheet()->setCellValue('Z200',  md5('Personal@GGE'));
                //Zoom de la hoja Excel
      			$objPHPExcel->getSheet(0)->getSheetView()->setZoomScale(80);

      			for($i = 'A'; $i <= 'P'; $i++){
					$objPHPExcel->setActiveSheetIndex(0)			
						->getColumnDimension($i)->setAutoSize(TRUE);
				}

				// Se asigna el nombre a la hoja
				$objPHPExcel->getSheet(0)->setTitle('Plantilla_Personal');
				// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
				$objPHPExcel->setActiveSheetIndex(0);
				// Inmovilizar paneles 
				//$objPHPExcel->getActiveSheet(0)->freezePane('A4');
				$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,3);

				// Se manda el archivo al navegador web, con el nombre que se indica (Excel2007)
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename="PLANTILLA_PERSONAL_'.strtoupper('GGE').'.xlsx"');
				header('Cache-Control: max-age=0');

				$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				$objWriter->save('php://output');
				exit;
		}


		public function importarPersonal()
		{
			// dep($_POST);
			require_once './Assets/lib/PHPExcel-1.8.2/Classes/PHPExcel.php';

			if($_POST){
				if(empty($_FILES['archivo'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$archivo 	= $_FILES['archivo'];
					$tipo 		= $_FILES['archivo']['type'];
					$tamanio 	= $_FILES['archivo']['size'];
					$archivotmp = $_FILES['archivo']['tmp_name'];

					$lineas = file($archivotmp);
					$i=0;
					$extension = pathinfo($archivo['name'], PATHINFO_EXTENSION);

					if ($extension != 'xlsx'){
						$arrResponse = 	[
									    	"status"=> false,
									    	"title"	=> "Error!",
									    	"msg" 	=> "Solo se permite archivos con extension .xlsx.",
										];
					}else{
						if (isset($_FILES['archivo'])) {
							$inputFileType 	= PHPExcel_IOFactory::identify($archivotmp);
							$objReader 		= PHPExcel_IOFactory::createReader($inputFileType);
							$objPHPExcel 	= $objReader->load($archivotmp);
							$sheet 			= $objPHPExcel->getSheet(0); 
							$highestRow 	= $sheet->getHighestRow(); 
							$highestColumn 	= $sheet->getHighestColumn();

							if(($sheet->getCell("Z200")->getValue()) == md5('Personal@GGE')) {
								$arrData = $this->model->selectExcelPersonal();

								$valoresDNI = array();
						        for ($i=0; $i < count($arrData); $i++) { 

						        	$valoresDNI[] .= $arrData[$i]['dni'];
						        }

						        $cantidad = '';
								$validos = '';
								$repetidos= '';
								$formato= '';

								for ($row = 3; $row <= $highestRow; $row++){ 
									$A3 = $sheet->getCell("A".$row)->getValue();
									$B3 = $sheet->getCell("B".$row)->getValue();
									$C3 = $sheet->getCell("C".$row)->getValue();
									$D3 = $sheet->getCell("D".$row)->getValue();
									$E3 = $sheet->getCell("E".$row)->getValue();

									$strDNI			= strClean($A3);
									$strNombre		= strClean($B3);
									$intCargo		= intval(strClean($C3));
									$intGerencia	= intval(strClean($D3));
									$intUserSession	= intval(strClean($_SESSION['idUser']));
									$intEstado		= intval(strClean($E3));


									if( $A3 != '' ){
										$cantidad .= $A3.',';
										if(strlen(strClean($A3)) == 8){
											if(!in_array($A3, $valoresDNI)){
										        
												$validos .= $A3.',';
												//insertar datos
												$requestImportar = $this->model->importarPersonal($strDNI, $strNombre, $intCargo, $intGerencia, $intUserSession, $intEstado);
										        
										    }else{
										    	$repetidos .= $A3.',';
										    }
										}else{
											$formato .= $A3.',';
										}
									}
								}

								$cantidad 		= trim($cantidad,',');
								$arrayCantidad	= explode(',', $cantidad);
								$validos 		= trim($validos,',');
								$arrayValidos	= explode(',', $validos);
								$repetidos 		= trim($repetidos,',');
								$arrayRepetidos	= explode(',', $repetidos);
								$formato 		= trim($formato,',');
								$arrayFormato	= explode(',', $formato);

								$countCantidad 	= ($arrayCantidad[0] == '') ? '0': count($arrayCantidad);
								$countValidos 	= ($arrayValidos[0] == '') ? '0': count($arrayValidos);
								$countRepetidos = ($arrayRepetidos[0] == '') ? '0': count($arrayRepetidos);
								$countFormato 	= ($arrayFormato[0] == '') ? '0': count($arrayFormato);


								$table = '<table id="tbl_lista_cargaInfo" class="display table table-bordered table-hover" cellspacing="0" width="100%" border="1">
											<thead></thead>
											<tbody style="font-family:Arial, Helvetica, sans-serif; font-size:11px;" align="center" >';

	                            $table .='		<tr>
									  				<td class="bg-primary" width="15%">
														<div align="left" class="bg-primary"><b>TOTAL DE REGISTROS</b></div>
									  				</td>';
								$table .='  		<td align="left" colspan="5" class="bg-primary"><b>'.$countCantidad. '</b></td>		
												</tr>';
								//IMPORTADOS
								$table .='		<tr>
									  				<td bgcolor="#EEEEEE">
										  				<div align="left"><b>IMPORTADOS</b></div>
									   				</td>';
								$table .='			<td align="left" colspan="5" bgcolor="#EEEEEE"><b>'.$countValidos.'</b></td>
												</tr>';
								$table .='		<tr>
									  				<td>
									  					<div align="right"><b>DNI</b></div>
									  				</td>
									  				<td colspan="5" align="left">';
									  					$porciones = explode(",", $validos);
														$x=1;
	 
								$table .='				<table border="1">
										  	  				<tr>'; 
										 		  		for ($i=0; $i < count($porciones) ; $i++) { 
										 		  	
								$table .='						<td style="padding: 1px;"> &nbsp; ' .$porciones[$i]. ' &nbsp; 
																</td>';
												    		if($x==15){
								$table .='					</tr>';
								$table .='					<tr>';
														 		$x=0;
													 		}
													 		$x=$x+1; 
										           		}
											        
								$table .='					</tr>
														</table>';

								$table .='			</td>
									 
												</tr>';
								
								//YA REGISTRADOS
								$table .='		<tr>
									  				<td bgcolor="#EEEEEE">
										  				<div align="left"><b>REPETIDOS</b></div>
									   				</td>';
								$table .='			<td align="left" colspan="5" bgcolor="#EEEEEE"><b>'.$countRepetidos.'</b></td>
												</tr>';
								$table .='		<tr>
									  				<td>
									  					<div align="right"><b>DNI</b></div>
									  				</td>
									  				<td colspan="5" align="left">';
									  					$porciones = explode(",", $repetidos);
														$x=1;
	 
								$table .='				<table border="1">
										  	  				<tr>'; 
										 		  		for ($i=0; $i < count($porciones) ; $i++) { 
										 		  	
								$table .='						<td style="padding: 1px;"> &nbsp; ' .$porciones[$i]. ' &nbsp; 
																</td>';
												    		if($x==15){
								$table .='					</tr>';
								$table .='					<tr>';
														 		$x=0;
													 		}
													 		$x=$x+1; 
										           		}
											        
								$table .='					</tr>
														</table>';

								$table .='			</td>
									 
												</tr>';

								//YA FORMATO
								$table .='		<tr>
									  				<td bgcolor="#EEEEEE">
										  				<div align="left"><b>NO CUMPLE FORMATO</b></div>
									   				</td>';
								$table .='			<td align="left" colspan="5" bgcolor="#EEEEEE"><b>'.$countFormato.'</b></td>
												</tr>';
								$table .='		<tr>
									  				<td>
									  					<div align="right"><b>DNI</b></div>
									  				</td>
									  				<td colspan="5" align="left">';
									  					$porciones = explode(",", $formato);
														$x=1;
	 
								$table .='				<table border="1">
										  	  				<tr>'; 
										 		  		for ($i=0; $i < count($porciones) ; $i++) { 
										 		  	
								$table .='						<td style="padding: 1px;"> &nbsp; ' .$porciones[$i]. ' &nbsp; 
																</td>';
												    		if($x==15){
								$table .='					</tr>';
								$table .='					<tr>';
														 		$x=0;
													 		}
													 		$x=$x+1; 
										           		}
											        
								$table .='					</tr>
														</table>';

								$table .='			</td>
									 
												</tr>';

								
								
	                          	$table .='	</tbody>
	                          			  </table>';

	                          	
								$arrResponse = 	[
											    "status"=> true,
											    "title"	=> "Personal",
											    "msg" 	=> "Importación Exitosa",
											    "datos" => $table,
											];

							}else{
								$arrResponse = 	[
										    	"status"=> false,
										    	"title"	=> "Erro!",
										    	"msg" 	=> "El archivo que intenta importar no coincide con el generado por el Sistema",
											];
							}
						}
					}
				}

			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function cargaImagen()
		{

			if($_POST){
				if(empty($_FILES['archivo1'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$file 		= $_FILES["archivo1"];
				    $nombre 	= uniqid().'-'.$file["name"];
				    $tipo 		= $file["type"];
				    $ruta_provisional = $file["tmp_name"];
				    $size 		= $file["size"];
				    $dimensiones= getimagesize($ruta_provisional);
				    $width 		= $dimensiones[0];
				    $height 	= $dimensiones[1];
				    $carpeta 	= 'Assets/images/uploads/personal/';
				    $vista  	= media().'/images/uploads/personal/'.$nombre;
				    
				    if($nombre == ''){
				        $arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Ningun archivo seleccionado .",
									];

				    }else if($tipo!='image/jpg' && $tipo!='image/jpeg' && $tipo!='image/png' && $tipo!='image/gif'){
				        $arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "El archivo no es una imagen.",
									]; 

				    }else if ($size > 1024*1024){
				    	$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "El tamaño máximo permitido es un 1MB.",
									]; 

				    }else if ($width > 500 || $height > 500){
				    	$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "La anchura y la altura máxima permitida es 500px",
									]; 

					}else if($width < 60 || $height < 60){
						$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "La anchura y la altura mínima permitida es 60px",
									];

					}else{
						$src = $carpeta.$nombre;
	        			move_uploaded_file($ruta_provisional, $src);
	        			$data = "<img src='$vista' style='max-width:100% ; height:auto;'>";

	        			$arrResponse = 	[
										"status"=> true,
										"title"	=> "Personal",
										"msg" 	=> "Imagen subida correctamente",
										"data"	=>	$data,
										"name"	=>	$nombre,
									]; 
					
					}
				}
			}

			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function eliminarImagen($id)
		{
			//echo $id;
			if (isset($id)) {
				if (file_exists("Assets/images/uploads/personal/".$id)) {
					unlink("Assets/images/uploads/personal/".$id);

					$arrResponse = 	[
								    	"status"=> true,
								    	"title"	=> "Eliminado",
								    	"msg" 	=> "Imagen Eliminada.",
									]; 
				}
			}
			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();

		}


		public function personalExcel()
		{

			date_default_timezone_set('America/Lima');
    		$fecha = date("d-m-Y");
    		$fechaC = date("d/m/Y (h:i:s a)");
			$requestReporte	= $this->model->selectReportePersonal();
			//dep($requestReporte); exit;

			if(count($requestReporte) > 0 ){

				if (PHP_SAPI == 'cli')
					die('Este archivo solo se puede ver desde un navegador web');
					
					require_once './Assets/lib/PHPExcel-1.8.2/Classes/PHPExcel.php';

					// Se crea el objeto PHPExcel
					$objPHPExcel = new PHPExcel();

					// Se asignan las propiedades del libro
					$objPHPExcel->getProperties()->setCreator(strtoupper ('PESONAL')) //Autor
								 ->setLastModifiedBy("Usuario") //Ultimo usuario que lo modificó
								 ->setTitle("Reporte de Persoanl Registrado")
								 ->setSubject("Reporte de Persoanl")
								 ->setDescription("Reporte de Persoanl")
								 ->setKeywords("Reporte de Persoanl Registrado")
								 ->setCategory("Reporte excel");

					$tituloReporte = "LISTADO DE PERSONAL  -  ".strtoupper ('GGE');
					$titulosColumnas = array('Nº',' D.N.I. ',' APELLIDOS Y NOMBRES ', ' CARGO ', ' GERENCIA ', ' ESTADO' );

					#Combinacion de celdas Titulo General
					$objPHPExcel->setActiveSheetIndex(0)
								->mergeCells('B1:F1')
				            	->mergeCells('C3:D3')
				            	->mergeCells('C4:D4')
				            	->mergeCells('F3:H3');

					// Se agregan los titulos del reporte
					$objPHPExcel->setActiveSheetIndex(0)
	  					        ->setCellValue('B1',  $tituloReporte)
	  					        ->setCellValue('A7', $titulosColumnas[0])
	          		  	  		->setCellValue('B7', $titulosColumnas[1])
	          		  	  		->setCellValue('C7', $titulosColumnas[2])
	                    		->setCellValue('D7', $titulosColumnas[3])
	                    		->setCellValue('E7', $titulosColumnas[4])
	                    		->setCellValue('F7', $titulosColumnas[5]);

	                $objPHPExcel->setActiveSheetIndex(0)
		                  	->setCellValue('B3', 'GERENCIA:')
		                  	->setCellValue('C3', strtoupper('GGE'))
		                  	->setCellValue('B4', 'DIRECCIÓN:')
		                  	->setCellValue('c4', strtoupper('CEPSA 1'))
		                    ->setCellValue('E3', 'FECHA:')
		                    ->setCellValue('F3', $fechaC);
			       	
	                $i = 8;
	                $c = 0;
					foreach ($requestReporte as $value){
						$c = $c+1;
						$estado = ($value['estado'] == 1) ? 'ACTIVO': 'INACTIVO';
				        $objPHPExcel->setActiveSheetIndex(0)
				                    ->setCellValue('A'.$i,  $c)
				                    ->setCellValue('B'.$i,  $value['dni'])
				                    ->setCellValue('C'.$i,  $value['nombre'])
				                    ->setCellValue('D'.$i,  $value['cargo'])
				                    ->setCellValue('E'.$i,  $value['gerencia'])
				                    ->setCellValue('F'.$i,  $estado);
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
			    		)
					);
				
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
			        	)
			        );

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
		            	)
			        );

			        $estiloCode = array(
			          'font' => array(
			                'name'    => 'Calibri',
			                'bold'    => true,
			                'size'    => 1,
			                'color'   => array(
			                'rgb'   => 'FFFFFF'
			             )                         
			            ),
			        );
			        //CODE
			        // $objPHPExcel->getSheet(0)->getStyle('Z200')->applyFromArray($estiloCode);

			        $objPHPExcel->getActiveSheet()->getStyle('B1:F1')->applyFromArray($estiloTituloReporte);
					$objPHPExcel->getActiveSheet()->getStyle('A7:F7')->applyFromArray($estiloTituloColumnas);	 
					$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A8:F".($i-1));
					$objPHPExcel->getActiveSheet()->getStyle('B3:B4')->applyFromArray($estiloSubTitulo);
				    $objPHPExcel->getActiveSheet()->getStyle('E3:E4')->applyFromArray($estiloSubTitulo);
					$objPHPExcel->getActiveSheet()->getStyle('L3:N3')->applyFromArray($estiloSubTitulo);
				    $objPHPExcel->getActiveSheet()->getStyle('B1:B'.(count($requestReporte)+7))->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );

				    	//Zoom de la hoja Excel
					$objPHPExcel->getSheet(0)->getSheetView()->setZoomScale(80);


					for($i = 'A'; $i <= 'F'; $i++){
						$objPHPExcel->setActiveSheetIndex(0)			
								->getColumnDimension($i)->setAutoSize(TRUE);
					}


					// Se asigna el nombre a la hoja
					//$objPHPExcel->getActiveSheet()->setTitle('Reporte_Trabajadores');
					$objPHPExcel->getSheet(0)->setTitle('Reporte_Personal');
					// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
					$objPHPExcel->setActiveSheetIndex(0);
					// Inmovilizar paneles 
					//$objPHPExcel->getActiveSheet(0)->freezePane('A4');

					$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,8);
					//$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(5,10);

					$excelName = "REPORTE_PERSONAL_".strtoupper('GGE')."_".$fecha.".xlsx";
					$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					$objWriter->save($excelName);
					//echo $excelName;
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Reporte de Personal",
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


		public function getSelectGerencia()
		{
			$htmlOptions = '<option value="">[ Seleccione Gerencia ]</option>';
			$arrData = $this->model->selectcboGerencias();
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData) ; $i++) { 
					$htmlOptions .='<option value="'.$arrData[$i]['id_gerencia'].'"> '.$arrData[$i]['abreviatura'].'</option>';
				}
			}
			echo $htmlOptions;
			die();
		}


		/* FUNCTION PERSONAL - CONTRATO */
		public function getselectedPersonal()
		{
			//dep($_POST); exit;
			if($_POST){
				if(empty($_POST['dniPersonal']) || empty($_POST['idpedido'])){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$intIdPedido	= intval(strClean($_POST['idpedido']));
					$strDNI 		= strClean($_POST['dniPersonal']);
				
					$arrData = $this->model->selectedPersona($intIdPedido, $strDNI);

					if(empty($arrData)){
						$arrResponse = 	[
											"status"=> false,
											"title"	=> "Error!",
											"msg" 	=> "DNI No Encontrados y/o el Cargo no esta asociado al Pedido",
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