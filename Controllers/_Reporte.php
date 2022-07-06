<?php 

	/**
	* 
	*/
	class Reporte extends Controllers
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

		public function reporte()
		{

			$data['page_tag']='Reportes';
			$data['page_title']='REPORTES GENERALES';
			$data['page_name']='reportes';
			$data['page_function_js']='function_reporte.js';
			$this->views->getView($this,'reporte',$data);
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


		public function getAvanceGeneral()
		{
			// dep($_POST); exit;
			if($_POST){
				$intIdProceso	= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idProceso'])) : 0;
				$intIdSolucion	= intval(strClean($_POST['idSolucion']));
				
				$output = array();
				$requestAvanceGeneral = $this->model->reporteAvanceGeneral($intIdProceso, $intIdSolucion);

				
				
				for ($i=0; $i <  count($requestAvanceGeneral); $i++) {
					

					if($requestAvanceGeneral[$i]['SOLUCIONTECNOLOGICA'] == 'CON' || $requestAvanceGeneral[$i]['SOLUCIONTECNOLOGICA'] == ''){
						$contigencia = '';
						$dispositivo = '';
					}else{
						$contigencia = $requestAvanceGeneral[$i]['CONTINGENCIA'].' %';
						$dispositivo = $requestAvanceGeneral[$i]['DISPOSITIVOS'].' %';
					}

					# code...
					// $requestAvanceGeneral[$i]['ORDEN'] 	= 	$i+1;
					$requestAvanceGeneral[$i]['NOMBRE_ODPE']  = '<a onclick="verDetalle('.$requestAvanceGeneral[$i]['ID_ODPE'].')" style="cursor: pointer;"><b>'.$requestAvanceGeneral[$i]['NOMBRE_ODPE'].' ('.$requestAvanceGeneral[$i]['SOLUCIONTECNOLOGICA'].')</b></a>';
					$requestAvanceGeneral[$i]['META']  = '<b>'.$requestAvanceGeneral[$i]['META'].'</B>';
					$requestAvanceGeneral[$i]['CEDULA']  = $requestAvanceGeneral[$i]['CEDULA'].' %';
					$requestAvanceGeneral[$i]['LISTA']  = $requestAvanceGeneral[$i]['LISTA'].' %';
					$requestAvanceGeneral[$i]['DOCUMENTO']  = $requestAvanceGeneral[$i]['DOCUMENTO'].' %';
					$requestAvanceGeneral[$i]['RELACION']  = $requestAvanceGeneral[$i]['RELACION'].' %';
					$requestAvanceGeneral[$i]['CONTINGENCIA']  = $contigencia;
					$requestAvanceGeneral[$i]['EMPAREJAMIENTO']  = $requestAvanceGeneral[$i]['EMPAREJAMIENTO'].' %';
					$requestAvanceGeneral[$i]['DISPOSITIVOS']  = $dispositivo;

				}

				$output = array(
					/*"draw"				=>	intval($_POST["draw"]),
					"recordsTotal"		=> 	count($arrData),
					"recordsFiltered"	=>	count($arrData),*/
					"data"				=>	$requestAvanceGeneral
				);
			}

			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function getAvanceGeneralGrafica()
		{	
			//dep($_POST); exit;
			if($_POST){
				$intIdProceso	= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idProceso'])) : 0;
				$intIdSolucion	= intval(strClean($_POST['idSolucion']));

				$arrData = $this->model->reporteAvanceGeneralGrafica($intIdProceso, $intIdSolucion);

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
				
				die();
			}
		}


		public function getAvanceGeneralDetalle()
		{
			// dep($_POST); exit;
			if($_POST){
				$intIdProceso	= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idProceso'])) : 0;
				$intIdSolucion	= intval(strClean($_POST['idSolucion']));
				$intIdOdpe		= intval(strClean($_POST['idOdpe']));
				
				$output = array();
				$requestAvanceGeneralDetalle = $this->model->reporteAvanceGeneralDetalle($intIdProceso, $intIdSolucion, $intIdOdpe);
				// echo $requestAvanceGeneralDetalle; exit;
				$cont = 0;
		        $departamento = "";
		        $provincia = "";
		        $distrito = "";
		        $tableDetalle = "";
		        $tableDetalle .='<div class="text-blue-grey">
								    <h4><b>ODPE: '.$requestAvanceGeneralDetalle[0]['NOMBRE_ODPE'].'</b></h4>
								</div>
								<table id="tbl_rporteAvanceDetalle" class="display table table-bordered" cellspacing="0" width="100%">
										    <thead class="text-center font-table">
										        
										    </thead>
										    <tbody class="text-center font-table">';
				
				for ($i=0; $i < count($requestAvanceGeneralDetalle); $i++) {
					
					/*CAPTURO EL DEPARTAMENTO PARA EL QUIEBRE */
	                $departamento_ant = $departamento;
	                $departamento = $requestAvanceGeneralDetalle[$i]['DEPARTAMENTO_UBI'];

	                /*CAPTURO LA PROVINCIA PARA EL QUIEBRE */
	                $provincia_ant = $provincia;
	                $provincia = $requestAvanceGeneralDetalle[$i]['PROVINCIA_UBI'];
	                    
	                /*CAPTURO EL DISTRITO PARA EL QUIEBRE */
	                $distrito_ant = $distrito;
	                $distrito = $requestAvanceGeneralDetalle[$i]['DISTRITO_UBI']; 

	                if($departamento_ant != $departamento){

	                    /*  CABECERA DE DEPARTAMENTO*/
	                    $tableDetalle .= '  <tr>
	                                <th scope="col" class="bg-blue">
	                                    <div align="left" class="bg-blue">ODPE/ORC:</div>
	                                </th>';
	                    $tableDetalle .=  '     <td align="left" colspan="19" class="bg-blue"><b>'.$requestAvanceGeneralDetalle[$i]['NOMBRE_ODPE']. '</b></td>';
	                    $tableDetalle .= '  </tr>';

	                    $tableDetalle .= '  <tr>
	                                <th scope="col" class="bg-blue">
	                                    <div align="left" class="bg-blue">DEPARTAMENTO:</div>
	                                </th>';
	                    $tableDetalle .= '      <td align="left" colspan="19" class="bg-blue"><b>'.$requestAvanceGeneralDetalle[$i]['DEPARTAMENTO_UBI'].'</b></td>';
	                    $tableDetalle .= '  </tr>';
	                    $tableDetalle .= '  <tr>
	                                <td colspan="20">&nbsp;</td>
	                            </tr>';
	                    
	                    /*  FIN CABECERA DE DEPARTAMENTO*/
	                }


	                if($provincia_ant != $provincia){
	                    /*  CABECERA DE PROVINCIA*/ 
	                    $tableDetalle .= '  <tr class="bg-warning-white">
	                                <th scope="col">
	                                    <div align="left">PROVINCIA:</div>
	                                </th>
	                                <th class="text-center" rowspan="2" width="">META</th>
	                                <th class="text-center" colspan="3" width="">CEDULAS</th>
	                                <th class="text-center" colspan="5" width="">ACTA PADRON</th>
	                                <th class="text-center" colspan="2" width="12%">DISPOSITIVOS</th>';
	                    $tableDetalle .= '  </tr>';
	                    $tableDetalle .= '  <tr class="bg-gris">
	                                <td class="text-center" width=""><b>'.$requestAvanceGeneralDetalle[$i]['PROVINCIA_UBI'].'</b></td>
	                                <!--<th class="text-center" width="">TOTAL RECEP.</th>-->
	                                <th class="text-center" width="">RECEPCION</th>
	                                <!--<th class="text-center" width="">TOTAL CONTROL</th>-->
	                                <th class="text-center" width=""> CONTROL</th>
	                                <!--<th class="text-center" width="">TOTAL EMPAQUE</th>-->
	                                <th class="text-center" width=""> EMPAQUETADO</th>

	                                <!--<th class="text-center" width="">TOTAL LISTA ELECT.</th>-->
	                                <th class="text-center" width="">LISTA DE ELECT.</th>
	                                <!--<th class="text-center" width="">TOTAL RELACION ELECT.</th>-->
	                                <th class="text-center" width="">RELACION DE ELECT.</th>
	                                <!--<th class="text-center" width="">TOTAL DOC. ELECT</th>-->
	                                <th class="text-center" width="">DOC. ELECTORALES</th>
	                                <!--<th class="text-center" width="">TOTAL DOC. CONT..</th>-->
	                                <th class="text-center" width="">DOC. CONTINGENCIA.</th>
	                                <!--<th class="text-center" width="">TOTAL EMPAREJAMIENTO</th>-->
	                                <th class="text-center" width="">EMPAREJAMIENTO</th>

	                                <!--<th class="text-center" width="">TOTAL RECEP</th>-->
	                                <th class="text-center" width="">USBP</th>
	                                <th class="text-center" width="">USBC</th>';
	                    $tableDetalle .= '  </tr>';

	                }


	                	if($requestAvanceGeneralDetalle[$i]['ID_SOLUCION'] == 1 || $requestAvanceGeneralDetalle[$i]['ID_SOLUCION'] == ''){
							$contigencia  = '<td style="background-color: #F2F2F2"></td>';
							$dispositivo1 = '<td style="background-color: #F2F2F2"></td>';
							$dispositivo2 = '<td style="background-color: #F2F2F2"></td>';
						}else{
							$contigencia  = '<td>'.$requestAvanceGeneralDetalle[$i]['PORC_CONTINGENCIA'].'</td>';
							$dispositivo1 = '<td>'.$requestAvanceGeneralDetalle[$i]['PORC_DISPOSITIVOS1'].'</td>';
							$dispositivo2 = '<td>'.$requestAvanceGeneralDetalle[$i]['PORC_DISPOSITIVOS2'].'</td>';
						}


	                    $tableDetalle .= '  <tr>';
	                    $tableDetalle .= '      <td>'.$requestAvanceGeneralDetalle[$i]['DISTRITO_UBI'].'</td>';
	                    $tableDetalle .= '      <td>'.$requestAvanceGeneralDetalle[$i]['META'].'</td>';
	                    //$tableDetalle .= '      <td>'.$requestAvanceGeneralDetalle[$i]['CEDULA_RECEP'].'</td>';
	                    $tableDetalle .= '      <td>'.$requestAvanceGeneralDetalle[$i]['PORC_CED_RECEP'].' %</td>';
	                    //$tableDetalle .= '      <td>'.$requestAvanceGeneralDetalle[$i]['CEDULA_CONTROL'].'</td>';
	                    $tableDetalle .= '      <td>'.$requestAvanceGeneralDetalle[$i]['PORC_CED_CONTROL'].' %</td>';
	                   // $tableDetalle .= '      <td>'.$requestAvanceGeneralDetalle[$i]['CEDULA_EMPAQ'].'</td>';
	                    $tableDetalle .= '      <td>'.$requestAvanceGeneralDetalle[$i]['PORC_CED_EMPAQ'].' %</td>';
	                   // $tableDetalle .= '      <td>'.$requestAvanceGeneralDetalle[$i]['LISTA_RECEP'].'</td>';
	                    $tableDetalle .= '      <td>'.$requestAvanceGeneralDetalle[$i]['PORC_LISTA_RECEP'].' %</td>';
	                    //$tableDetalle .= '      <td>'.$requestAvanceGeneralDetalle[$i]['RELACION'].'</td>';
	                    $tableDetalle .= '      <td>'.$requestAvanceGeneralDetalle[$i]['PORC_RELACION'].' %</td>';
	                    //$tableDetalle .= '      <td>'.$requestAvanceGeneralDetalle[$i]['DOCUMENTO'].'</td>';
	                    $tableDetalle .= '      <td>'.$requestAvanceGeneralDetalle[$i]['PORC_DOCUMENTO'].' %</td>';
	                    //$tableDetalle .= '      <td>'.$requestAvanceGeneralDetalle[$i]['CONTINGENCIA'].'</td>';
	                    $tableDetalle .=       	$contigencia;
	                    //$tableDetalle .= '      <td>'.$requestAvanceGeneralDetalle[$i]['LISTA_EMP'].'</td>';
	                    $tableDetalle .= '      <td>'.$requestAvanceGeneralDetalle[$i]['PORC_LISTA_EMP'].' %</td>';
	                    //$tableDetalle .= '      <td>'.$requestAvanceGeneralDetalle[$i]['DISPOSITIVOS'].'</td>';
	                    $tableDetalle .= 		$dispositivo1;

	                    $tableDetalle .= 		$dispositivo2;
	                    $tableDetalle .= '  </tr>';

				}

				$tableDetalle .='		</tbody>
									</table>';

				$output = array(
					/*"draw"				=>	intval($_POST["draw"]),
					"recordsTotal"		=> 	count($arrData),
					"recordsFiltered"	=>	count($arrData),*/
					"data"				=>	$tableDetalle
				);

				
			}

			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
		}

		public function getAvanceGeneralGraficaOdpe()
		{	
			// dep($_POST); exit;
			if($_POST){
				$intIdProceso	= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idProceso'])) : 0;
				$intIdSolucion	= intval(strClean($_POST['idSolucion']));

				$arrData = $this->model->reporteAvanceGeneral($intIdProceso, $intIdSolucion);
				$cantidad = count($arrData);

				if(empty($arrData)){
					$arrResponse = 	[
						"status"=> false,
						"title"	=> "Error!",
						"msg" 	=> "Datos No Encontrados.",
					]; 
				}else{
					$arrResponse = 	[
						"status"	=> true,
						"data" 		=> $arrData,
						"cantidad"	=> $cantidad,
					]; 
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				
				die();
			}
		}


		public function getExportarGeneral()
		{
			// dep($_POST);exit;
			if($_POST){
				date_default_timezone_set('America/Lima');
	    		$fecha 			= date("d-m-Y");
	    		$fechaC 		= date("d/m/Y (h:i:s a)");
				/*$strFechaInicio	= strClean($_POST['fechaInicio']);
				$strFechaFin	= strClean($_POST['fechaFin']);*/

				$intIdProceso	= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idProceso'])) : 0;
				$intIdSolucion	= intval(strClean($_POST['idSolucion']));
				$strNomProceso	= strClean($_POST['nomProceso']);

				$requestAvanceGeneral = $this->model->reporteAvanceGeneral($intIdProceso, $intIdSolucion);
				// $count = count($requestAvanceGeneral);
				
				if(count($requestAvanceGeneral) > 0 ){

					if (PHP_SAPI == 'cli')
						die('Este archivo solo se puede ver desde un navegador web');
						
						require_once './Assets/lib/PHPExcel-1.8.2/Classes/PHPExcel.php';

						// Se crea el objeto PHPExcel
						$objPHPExcel = new PHPExcel();

						// Se asignan las propiedades del libro
						$objPHPExcel->getProperties()->setCreator(strtoupper ('SISCOMAC')) //Autor
											 ->setLastModifiedBy("Usuario") //Ultimo usuario que lo modificó
											 ->setTitle("Reporte de Avance General - ".strtoupper ('SISCOMAC'))
											 ->setSubject("Reporte de Avance General")
											 ->setDescription("Reporte de Avance General")
											 ->setKeywords("Reporte de Avance General - ".strtoupper ('SISCOMAC'))
											 ->setCategory("Reporte excel");

						$tituloReporte = "REPORTE AVANCE GENERAL DE MATERIALES  -  ".strtoupper ('SISCOMAC');
						$titulosColumnas = array('N°','ODPE / ORC',' TOTAL MESAS ', ' % CEDULAS  ', '% LISTA DE ELECTORES', '% DOC. ELECTORALES', '% REL. DE ELECTORES','% DOC. DE CONTINGENCIA', '% EMPAREJAMIENTO ', '% DISPOSITIVOS');

				    	#Combinacion de celdas Titulo General
						$objPHPExcel->setActiveSheetIndex(0)
								    ->mergeCells('C2:G2')
						            ->mergeCells('C3:G3')
						            ->mergeCells('C5:D5')
						            ->mergeCells('C6:D6');
										
						// Se agregan los titulos del reporte
						$objPHPExcel->setActiveSheetIndex(0)
				  					->setCellValue('C2', $strNomProceso)
		  					        ->setCellValue('C3', $tituloReporte)
		  					        ->setCellValue('A8', $titulosColumnas[0])
			          		  	  	->setCellValue('B8', $titulosColumnas[1])
			          		  	  	->setCellValue('C8', $titulosColumnas[2])
			                    	->setCellValue('D8', $titulosColumnas[3])
			                  		->setCellValue('E8', $titulosColumnas[4])
			                  		->setCellValue('F8', $titulosColumnas[5])
			          		  	  	->setCellValue('G8', $titulosColumnas[6])
			                  		->setCellValue('H8', $titulosColumnas[7])
			                    	->setCellValue('I8', $titulosColumnas[8])
			                    	->setCellValue('J8', $titulosColumnas[9]);

			            $objPHPExcel->setActiveSheetIndex(0)
		          			//->setCellValue('H13', $dias_lab)
		                  			->setCellValue('B5', 'GERENCIA:')
				                  	->setCellValue('C5', strtoupper('GGE'))
				                    ->setCellValue('F5', 'FECHA (ACTUALIZADO AL):')
				                    ->setCellValue('G5', $fechaC);

		               	//Se agregan los datos del Personal
						$i = 9;
						$c = 0;
						foreach ($requestAvanceGeneral as $value){
				      		$c = $c+1;

				         	$objPHPExcel->setActiveSheetIndex(0)
				                      	->setCellValue('A'.$i,  $c)
					                    ->setCellValue('B'.$i,  $value['NOMBRE_ODPE'])
					                    ->setCellValue('C'.$i,  $value['META'])
					                    ->setCellValue('D'.$i,  $value['CEDULA'])
					                    ->setCellValue('E'.$i,  $value['LISTA'])
					                    ->setCellValue('F'.$i,  $value['DOCUMENTO'])
					                    ->setCellValue('G'.$i,  $value['RELACION'])
					                    ->setCellValue('H'.$i,  $value['CONTINGENCIA'])
					                    ->setCellValue('I'.$i,  $value['EMPAREJAMIENTO'])
					                    ->setCellValue('J'.$i,  $value['DISPOSITIVOS']);
				                      	                      
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


				        $estiloInformacionEstado = new PHPExcel_Style();
					    $estiloInformacionEstado->applyFromArray(
					      	array(
					        	'font' => array(
					                'name'      => 'Calibri',
					                'bold'      => true,
					                'color'     => array(
					                'rgb'   => '3D3D3D'
					            )

					            ),
					            'fill'  => array(
					        //'type'    => PHPExcel_Style_Fill::FILL_SOLID,
					        
					      		),
					            'borders' => array(
					                'left'     => array(
					                    //'style' => PHPExcel_Style_Border::BORDER_THIN ,

					                )             
					            ),
					            'alignment' =>  array(
					              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					              'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					              'rotation'   => 0,
					              'wrap'       => TRUE
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


			         	$estiloTituloColumnasDias = array(
				            'font' => array(
				                'name'      => 'Calibri',
				                'bold'      => true,
				                'size'    => 11,
				                'color'     => array(
				                'rgb'   => '0C5C97'
				             )                         
				            ),
				            'fill'  => array(
				                //'type'    => PHPExcel_Style_Fill::FILL_SOLID,
				                //'color' => array('rgb' => '58D3F7')
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


			         	//Imagen en excel
				        /*$objDrawing = new PHPExcel_Worksheet_Drawing();
				        $objDrawing->setName('test_img');
				        $objDrawing->setDescription('test_img');
				        $objDrawing->setPath('./Assets/images/banner-onpe.png');
				    		$objDrawing->setCoordinates('D1');
				               
				        //setOffsetX works properly
				        $objDrawing->setOffsetX(5); 
				        $objDrawing->setOffsetY(5);                
				        //set width, height
				        $objDrawing->setWidth(480); 
				        $objDrawing->setHeight(100); 
				        $objDrawing->setWorksheet($objPHPExcel->getSheet(0));*/
				    	
				        $objPHPExcel->getActiveSheet()->getStyle('C2:G2')->applyFromArray($estiloTituloReporte);
						$objPHPExcel->getActiveSheet()->getStyle('C3:G3')->applyFromArray($estiloTituloReporte);
						$objPHPExcel->getActiveSheet()->getStyle('A8:J8')->applyFromArray($estiloTituloColumnas);		
						$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A9:J".($i-1));
						$objPHPExcel->getActiveSheet()->getStyle('B5:B6')->applyFromArray($estiloSubTitulo);
				    	$objPHPExcel->getActiveSheet()->getStyle('F5:F6')->applyFromArray($estiloSubTitulo);
						$objPHPExcel->getActiveSheet()->getStyle('L5:N5')->applyFromArray($estiloSubTitulo);
				    	$objPHPExcel->getActiveSheet()->getStyle('B1:B'.(count($requestAvanceGeneral)+13))->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );

				    	//Zoom de la hoja Excel
					    $objPHPExcel->getSheet(0)->getSheetView()->setZoomScale(80);


						for($i = 'A'; $i <= 'J'; $i++){
							$objPHPExcel->setActiveSheetIndex(0)			
								->getColumnDimension($i)->setAutoSize(TRUE);
						}


						// Se asigna el nombre a la hoja
						//$objPHPExcel->getActiveSheet()->setTitle('Reporte_Trabajadores');
						$objPHPExcel->getSheet(0)->setTitle('REPORTE_AVANCE_GENERAL');
						// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
						$objPHPExcel->setActiveSheetIndex(0);
						// Inmovilizar paneles 
						//$objPHPExcel->getActiveSheet(0)->freezePane('A4');

						$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,9);

						$excelName = "REPORTE_AVANCE_GENERAL_".strtoupper('SISCOMAC')."_".$fecha.".xlsx";
					    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					    $objWriter->save($excelName);
					    //echo $excelName;
					    $arrResponse = 	[
											"status"=> true,
											"title"	=> "REPORTES GENERALES",
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


		/*===== STEP 2 =====*/
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


		public function getSelectEtapa()
		{
			//dep($_POST); exit;
			if($_POST){
				$intIdProceso	= intval(strClean($_POST['idProceso']));
				$intIdMaterial	= intval(strClean($_POST['idMaterial']));

				$htmlOptions = '<option value="">[ SELECCIONE UNA ETAPA ]</option>';
				$arrData = $this->model->selectCboEtapa($intIdProceso, $intIdMaterial);
				if(count($arrData) > 0){
					for ($i=0; $i < count($arrData) ; $i++) { 
						$htmlOptions .='<option value="'.$arrData[$i]['ID_ETAPA'].'"> '.$arrData[$i]['ETAPA'].'</option>';
					}
				}
				echo $htmlOptions;
				die();
			}
		}


		public function getAvanceOdpe()
		{
			// dep($_POST); exit;
			if($_POST){
				$intIdProceso	= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idProceso'])) : 0;
				$intIdMaterial	= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idMaterial'])) : 0;
				$intIdEtapa		= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idEtapa'])) : 0;;
				
				$output = array();
				$requestAvanceOdpe = $this->model->reporteAvanceOdpe($intIdProceso, $intIdMaterial, $intIdEtapa);
				// echo  $requestAvanceOdpe; exit;
				
				for ($i=0; $i <  count($requestAvanceOdpe); $i++) {
					
					# code...
					// $requestAvanceOdpe[$i]['ORDEN'] 	= 	$i+1;
					$requestAvanceOdpe[$i]['TOTAL']  		= '<b>'.$requestAvanceOdpe[$i]['TOTAL'].'</B>';
					$requestAvanceOdpe[$i]['PORC_RECIBIDO'] = $requestAvanceOdpe[$i]['PORC_RECIBIDO'].' %';
					$requestAvanceOdpe[$i]['PORC_FALTANTE'] = $requestAvanceOdpe[$i]['PORC_FALTANTE'].' %';
				}

				$output = array(
					/*"draw"				=>	intval($_POST["draw"]),
					"recordsTotal"		=> 	count($arrData),
					"recordsFiltered"	=>	count($arrData),*/
					"data"				=>	$requestAvanceOdpe
				);
			}

			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
		}


		public function getExportarOdpe()
		{
			// dep($_POST);exit;
			if($_POST){
				date_default_timezone_set('America/Lima');
	    		$fecha 			= date("d-m-Y");
	    		$fechaC 		= date("d/m/Y (h:i:s a)");
				/*$strFechaInicio	= strClean($_POST['fechaInicio']);
				$strFechaFin	= strClean($_POST['fechaFin']);*/

				$intIdProceso	= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idProceso'])) : 0;
				$intIdMaterial	= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idMaterial'])) : 0;
				$intIdEtapa		= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idEtapa'])) : 0;;

				$strNomProceso	= strClean($_POST['nomProceso']);
				$strNomMaterial	= strClean($_POST['nomMaterial']);
				$strNomEtapa	= strClean($_POST['nomEtapa']);

				$requestAvanceOdpe = $this->model->reporteAvanceOdpe($intIdProceso, $intIdMaterial, $intIdEtapa);
				
				if(count($requestAvanceOdpe) > 0 ){

					if (PHP_SAPI == 'cli')
						die('Este archivo solo se puede ver desde un navegador web');
						
						require_once './Assets/lib/PHPExcel-1.8.2/Classes/PHPExcel.php';

						// Se crea el objeto PHPExcel
						$objPHPExcel = new PHPExcel();

						// Se asignan las propiedades del libro
						$objPHPExcel->getProperties()->setCreator(strtoupper ('SISCOMAC')) //Autor
											 ->setLastModifiedBy("Usuario") //Ultimo usuario que lo modificó
											 ->setTitle("Reporte de Avance General ODPE - ".strtoupper ('SISCOMAC'))
											 ->setSubject("Reporte de Avance General ODPE")
											 ->setDescription("Reporte de Avance General ODPE")
											 ->setKeywords("Reporte de Avance General ODPE - ".strtoupper ('SISCOMAC'))
											 ->setCategory("Reporte excel");

						$tituloReporte = "REPORTE AVANCE GENERAL DE MATERIALES POR ODPE -  ".strtoupper ('SISCOMAC');
						$titulosColumnas = array('N°','ODPE','SOL. TEC.', 'TOTAL MESAS', 'RECIBIDAS', 'POR RECIBIR', '% RECIBIDOS', '% POR RECIBIR');

				    	#Combinacion de celdas Titulo General
						$objPHPExcel->setActiveSheetIndex(0)
								    ->mergeCells('C2:G2')
						            ->mergeCells('C3:G3')
						            ->mergeCells('C5:D5')
						            ->mergeCells('C6:D6');
									
						// Se agregan los titulos del reporte
						$objPHPExcel->setActiveSheetIndex(0)
				  					->setCellValue('C2', $strNomProceso)
		  					        ->setCellValue('C3', $tituloReporte)
		  					        ->setCellValue('A8', $titulosColumnas[0])
			          		  	  	->setCellValue('B8', $titulosColumnas[1])
			          		  	  	->setCellValue('C8', $titulosColumnas[2])
			                    	->setCellValue('D8', $titulosColumnas[3])
			                  		->setCellValue('E8', $titulosColumnas[4])
			                  		->setCellValue('F8', $titulosColumnas[5])
			          		  	  	->setCellValue('G8', $titulosColumnas[6])
			                  		->setCellValue('H8', $titulosColumnas[7]);

			            $objPHPExcel->setActiveSheetIndex(0)
		          			//->setCellValue('H13', $dias_lab)
		                  			->setCellValue('B5', 'GERENCIA:')
				                  	->setCellValue('C5', strtoupper('GGE'))
				                  	->setCellValue('B6', 'MATERIAL:')
                  					->setCellValue('c6', strtoupper($strNomMaterial))
				                    ->setCellValue('F5', 'FECHA (ACTUALIZADO AL):')
				                    ->setCellValue('G5', $fechaC)
				                    ->setCellValue('F6', 'ETAPA:')
                    				->setCellValue('G6', strtoupper($strNomEtapa));

		               	//Se agregan los datos del Personal
						$i = 9;
						$c = 0;
						foreach ($requestAvanceOdpe as $value){
				      		$c = $c+1;

				         	$objPHPExcel->setActiveSheetIndex(0)
					                    ->setCellValue('A'.$i,  $c)
				                     	->setCellValue('B'.$i,  $value['NOMBRE_ODPE'])
				                      	->setCellValue('C'.$i,  $value['SOLUCIONTECNOLOGICA'])
				                      	->setCellValue('D'.$i,  $value['TOTAL'])
				                      	->setCellValue('E'.$i,  $value['RECIBIDO'])
				                      	->setCellValue('F'.$i,  $value['FALTANTE'])
				                      	->setCellValue('G'.$i,  $value['PORC_RECIBIDO'])
				                      	->setCellValue('H'.$i,  $value['PORC_FALTANTE']);
				                      	                      
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


				        $estiloInformacionEstado = new PHPExcel_Style();
					    $estiloInformacionEstado->applyFromArray(
					      	array(
					        	'font' => array(
					                'name'      => 'Calibri',
					                'bold'      => true,
					                'color'     => array(
					                'rgb'   => '3D3D3D'
					            )

					            ),
					            'fill'  => array(
					        //'type'    => PHPExcel_Style_Fill::FILL_SOLID,
					        
					      		),
					            'borders' => array(
					                'left'     => array(
					                    //'style' => PHPExcel_Style_Border::BORDER_THIN ,

					                )             
					            ),
					            'alignment' =>  array(
					              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					              'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					              'rotation'   => 0,
					              'wrap'       => TRUE
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


			         	$estiloTituloColumnasDias = array(
				            'font' => array(
				                'name'      => 'Calibri',
				                'bold'      => true,
				                'size'    => 11,
				                'color'     => array(
				                'rgb'   => '0C5C97'
				             )                         
				            ),
				            'fill'  => array(
				                //'type'    => PHPExcel_Style_Fill::FILL_SOLID,
				                //'color' => array('rgb' => '58D3F7')
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


			         	//Imagen en excel
				        /*$objDrawing = new PHPExcel_Worksheet_Drawing();
				        $objDrawing->setName('test_img');
				        $objDrawing->setDescription('test_img');
				        $objDrawing->setPath('./Assets/images/banner-onpe.png');
				    		$objDrawing->setCoordinates('D1');
				               
				        //setOffsetX works properly
				        $objDrawing->setOffsetX(5); 
				        $objDrawing->setOffsetY(5);                
				        //set width, height
				        $objDrawing->setWidth(480); 
				        $objDrawing->setHeight(100); 
				        $objDrawing->setWorksheet($objPHPExcel->getSheet(0));*/
				    	
				        $objPHPExcel->getActiveSheet()->getStyle('C2:G2')->applyFromArray($estiloTituloReporte);
						$objPHPExcel->getActiveSheet()->getStyle('C3:G3')->applyFromArray($estiloTituloReporte);
						$objPHPExcel->getActiveSheet()->getStyle('A8:J8')->applyFromArray($estiloTituloColumnas);		
						$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A9:J".($i-1));
						$objPHPExcel->getActiveSheet()->getStyle('B5:B6')->applyFromArray($estiloSubTitulo);
				    	$objPHPExcel->getActiveSheet()->getStyle('F5:F6')->applyFromArray($estiloSubTitulo);
						$objPHPExcel->getActiveSheet()->getStyle('L5:N5')->applyFromArray($estiloSubTitulo);
				    	$objPHPExcel->getActiveSheet()->getStyle('B1:B'.(count($requestAvanceOdpe)+13))->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );

				    	//Zoom de la hoja Excel
					    $objPHPExcel->getSheet(0)->getSheetView()->setZoomScale(80);


						for($i = 'A'; $i <= 'H'; $i++){
							$objPHPExcel->setActiveSheetIndex(0)			
								->getColumnDimension($i)->setAutoSize(TRUE);
						}


						// Se asigna el nombre a la hoja
						//$objPHPExcel->getActiveSheet()->setTitle('Reporte_Trabajadores');
						$objPHPExcel->getSheet(0)->setTitle('REPORTE_AVANCE_ODPE');
						// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
						$objPHPExcel->setActiveSheetIndex(0);
						// Inmovilizar paneles 
						//$objPHPExcel->getActiveSheet(0)->freezePane('A4');

						$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,9);

						$excelName = "REPORTE_AVANCE_GENERAL_ODPE_".strtoupper('SISCOMAC')."_".$fecha.".xlsx";
					    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					    $objWriter->save($excelName);
					    //echo $excelName;
					    $arrResponse = 	[
											"status"=> true,
											"title"	=> "REPORTES GENERALES",
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
			}

			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}


		/*===== STEP 3 =====*/
		public function getSelectOdpe()
		{
			//dep($_POST); exit;
			if($_POST){
				$intIdProceso	= intval(strClean($_POST['idProceso']));
				$intIdMaterial	= intval(strClean($_POST['idMaterial']));
				$intIdEtapa		= intval(strClean($_POST['idEtapa']));

				$htmlOptions = '<option value="">[ SELECCIONE UNA ODPE ]</option>';
				$arrData = $this->model->selectCboOdpe($intIdProceso, $intIdMaterial, $intIdEtapa);
				if(count($arrData) > 0){
					for ($i=0; $i < count($arrData) ; $i++) { 
						$htmlOptions .='<option value="'.$arrData[$i]['ID_ODPE'].'"> '.$arrData[$i]['NOMBRE_ODPE'].'</option>';
					}
				}
				echo $htmlOptions;
				die();
			}
		}


		public function getUsuarioMesa()
		{
			// dep($_POST); exit;
			if($_POST){
				$intIdProceso	= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idProceso'])) : 0;
				$intIdMaterial	= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idMaterial'])) : 0;
				$intIdEtapa		= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idEtapa'])) : 0;
				$intIdOdpe		= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idOdpe'])) : 0;

				$output = array();
				$requestUsuarioMesa = $this->model->reporteUsuarioMesa($intIdProceso, $intIdMaterial, $intIdEtapa, $intIdOdpe);
				// echo  $requestUsuarioMesa; exit;
				
				for ($i=0; $i <  count($requestUsuarioMesa); $i++) {
					
					# code...
					// $requestUsuarioMesa[$i]['ORDEN'] 	= 	$i+1;
					$requestUsuarioMesa[$i]['NRO_MESA']  		= '<b>'.$requestUsuarioMesa[$i]['NRO_MESA'].'</B>';
					
				}

				$output = array(
					/*"draw"				=>	intval($_POST["draw"]),
					"recordsTotal"		=> 	count($arrData),
					"recordsFiltered"	=>	count($arrData),*/
					"data"				=>	$requestUsuarioMesa
				);
			}

			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
		}



		public function getExportarUsuarioMesa()
		{
			// dep($_POST);exit;
			if($_POST){
				date_default_timezone_set('America/Lima');
	    		$fecha 			= date("d-m-Y");
	    		$fechaC 		= date("d/m/Y (h:i:s a)");
				/*$strFechaInicio	= strClean($_POST['fechaInicio']);
				$strFechaFin	= strClean($_POST['fechaFin']);*/

				$intIdProceso	= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idProceso'])) : 0;
				$intIdMaterial	= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idMaterial'])) : 0;
				$intIdEtapa		= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idEtapa'])) : 0;;
				$intIdOdpe		= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idOdpe'])) : 0;;

				$strNomProceso	= strClean($_POST['nomProceso']);
				$strNomMaterial	= strClean($_POST['nomMaterial']);
				$strNomEtapa	= strClean($_POST['nomEtapa']);
				$strNomOdpe		= strClean($_POST['nomOdpe']);

				$requestUsuarioMesa = $this->model->reporteUsuarioMesa($intIdProceso, $intIdMaterial, $intIdEtapa, $intIdOdpe);
				
				if(count($requestUsuarioMesa) > 0 ){

					if (PHP_SAPI == 'cli')
						die('Este archivo solo se puede ver desde un navegador web');
						
						require_once './Assets/lib/PHPExcel-1.8.2/Classes/PHPExcel.php';

						// Se crea el objeto PHPExcel
						$objPHPExcel = new PHPExcel();

						// Se asignan las propiedades del libro
						$objPHPExcel->getProperties()->setCreator(strtoupper ('SISCOMAC')) //Autor
											 ->setLastModifiedBy("Usuario") //Ultimo usuario que lo modificó
											 ->setTitle("Reporte de Control Mesa-Usuario - ".strtoupper ('SISCOMAC'))
											 ->setSubject("Reporte de Control Mesa-Usuario")
											 ->setDescription("Reporte de Control Mesa-Usuario")
											 ->setKeywords("Reporte de Control Mesa-Usuario - ".strtoupper ('SISCOMAC'))
											 ->setCategory("Reporte excel");

						$tituloReporte = "REPORTE DE CONTROL MESA - USUARIO";
						$titulosColumnas = array('N°','SOL. TEC.', 'DEPARTAMENTO ', 'PROVINCIA', 'DISTRITO', 'MESA', 'USUARIO', 'FECHA Y HORA');

				    	#Combinacion de celdas Titulo General
						$objPHPExcel->setActiveSheetIndex(0)
								    ->mergeCells('C2:G2')
						            ->mergeCells('C3:G3')
						            ->mergeCells('C5:D5')
						            ->mergeCells('C6:D6')
						            ->mergeCells('C7:D7');
									
						// Se agregan los titulos del reporte
						$objPHPExcel->setActiveSheetIndex(0)
				  					->setCellValue('C2', $strNomProceso)
		  					        ->setCellValue('C3', $tituloReporte)
		  					        ->setCellValue('A9', $titulosColumnas[0])
			          		  	  	->setCellValue('B9', $titulosColumnas[1])
			          		  	  	->setCellValue('C9', $titulosColumnas[2])
			                    	->setCellValue('D9', $titulosColumnas[3])
			                  		->setCellValue('E9', $titulosColumnas[4])
			                  		->setCellValue('F9', $titulosColumnas[5])
			          		  	  	->setCellValue('G9', $titulosColumnas[6])
			                  		->setCellValue('H9', $titulosColumnas[7]);

			            $objPHPExcel->setActiveSheetIndex(0)
		          			//->setCellValue('H13', $dias_lab)
		                  			->setCellValue('B5', 'GERENCIA:')
				                  	->setCellValue('C5', strtoupper('GGE'))
				                  	->setCellValue('B6', 'MATERIAL:')
                  					->setCellValue('c6', strtoupper($strNomMaterial))
				                    ->setCellValue('F5', 'FECHA (ACTUALIZADO AL):')
				                    ->setCellValue('G5', $fechaC)
				                    ->setCellValue('F6', 'ETAPA:')
                    				->setCellValue('G6', strtoupper($strNomEtapa))
                    				->setCellValue('B7', 'ODPE:')
                    				->setCellValue('C7', strtoupper($strNomOdpe)); 
                    				

		               	//Se agregan los datos del Personal
						$i = 10;
						$c = 0;
						foreach ($requestUsuarioMesa as $value){
				      		$c = $c+1;

				         	$objPHPExcel->setActiveSheetIndex(0)
					                    ->setCellValue('A'.$i,  $c)
				                     	->setCellValue('B'.$i,  $value['CODIGO_SOLUCION'])
				                      	->setCellValue('C'.$i,  $value['DEPARTAMENTO_UBI'])
				                      	->setCellValue('D'.$i,  $value['PROVINCIA_UBI'])
				                      	->setCellValue('E'.$i,  $value['DISTRITO_UBI'])
				                      	->setCellValue('F'.$i,  $value['NRO_MESA'])
				                      	->setCellValue('G'.$i,  $value['USUARIO'])
				                      	->setCellValue('H'.$i,  $value['FECHA_HORA']);
				                      	                      
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


				        $estiloInformacionEstado = new PHPExcel_Style();
					    $estiloInformacionEstado->applyFromArray(
					      	array(
					        	'font' => array(
					                'name'      => 'Calibri',
					                'bold'      => true,
					                'color'     => array(
					                'rgb'   => '3D3D3D'
					            )

					            ),
					            'fill'  => array(
					        //'type'    => PHPExcel_Style_Fill::FILL_SOLID,
					        
					      		),
					            'borders' => array(
					                'left'     => array(
					                    //'style' => PHPExcel_Style_Border::BORDER_THIN ,

					                )             
					            ),
					            'alignment' =>  array(
					              'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					              'vertical'   => PHPExcel_Style_Alignment::VERTICAL_CENTER,
					              'rotation'   => 0,
					              'wrap'       => TRUE
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


			         	$estiloTituloColumnasDias = array(
				            'font' => array(
				                'name'      => 'Calibri',
				                'bold'      => true,
				                'size'    => 11,
				                'color'     => array(
				                'rgb'   => '0C5C97'
				             )                         
				            ),
				            'fill'  => array(
				                //'type'    => PHPExcel_Style_Fill::FILL_SOLID,
				                //'color' => array('rgb' => '58D3F7')
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


			         	//Imagen en excel
				        /*$objDrawing = new PHPExcel_Worksheet_Drawing();
				        $objDrawing->setName('test_img');
				        $objDrawing->setDescription('test_img');
				        $objDrawing->setPath('./Assets/images/banner-onpe.png');
				    		$objDrawing->setCoordinates('D1');
				               
				        //setOffsetX works properly
				        $objDrawing->setOffsetX(5); 
				        $objDrawing->setOffsetY(5);                
				        //set width, height
				        $objDrawing->setWidth(480); 
				        $objDrawing->setHeight(100); 
				        $objDrawing->setWorksheet($objPHPExcel->getSheet(0));*/
				    	
				        $objPHPExcel->getActiveSheet()->getStyle('C2:G2')->applyFromArray($estiloTituloReporte);
						$objPHPExcel->getActiveSheet()->getStyle('C3:G3')->applyFromArray($estiloTituloReporte);
						$objPHPExcel->getActiveSheet()->getStyle('A9:J9')->applyFromArray($estiloTituloColumnas);		
						$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A10:J".($i-1));
						$objPHPExcel->getActiveSheet()->getStyle('B5:B7')->applyFromArray($estiloSubTitulo);
				    	$objPHPExcel->getActiveSheet()->getStyle('F5:F6')->applyFromArray($estiloSubTitulo);
						$objPHPExcel->getActiveSheet()->getStyle('L5:N5')->applyFromArray($estiloSubTitulo);
				    	$objPHPExcel->getActiveSheet()->getStyle('B1:B'.(count($requestUsuarioMesa)+13))->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );

				    	//Zoom de la hoja Excel
					    $objPHPExcel->getSheet(0)->getSheetView()->setZoomScale(80);


						for($i = 'A'; $i <= 'H'; $i++){
							$objPHPExcel->setActiveSheetIndex(0)			
								->getColumnDimension($i)->setAutoSize(TRUE);
						}


						// Se asigna el nombre a la hoja
						//$objPHPExcel->getActiveSheet()->setTitle('Reporte_Trabajadores');
						$objPHPExcel->getSheet(0)->setTitle('REPORTE_CONTROL_USUARIO');
						// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
						$objPHPExcel->setActiveSheetIndex(0);
						// Inmovilizar paneles 
						//$objPHPExcel->getActiveSheet(0)->freezePane('A4');

						$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,10);

						$excelName = "REPORTE_CONTROL_USUARIO_MESA_".strtoupper('SISCOMAC')."_".$fecha.".xlsx";
					    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
					    $objWriter->save($excelName);
					    //echo $excelName;
					    $arrResponse = 	[
											"status"=> true,
											"title"	=> "REPORTES GENERALES",
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
			}

			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();
		}

		
		/*===== STEP 4 =====*/
		public function getSelectRendimiento()
		{	
			// dep($_POST); exit;
			if($_POST){
				$intIdProceso		= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idProceso'])) : 0;
				$intIdMaterial		= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idMaterial'])) : 0;
				$intIdEtapa			= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idEtapa'])) : 0;
				$intIdValidacion	= ($_POST['idEtapa'] != 2) ? 1 : 2;

				$requestRendimiento = $this->model->reporteRendimiento($intIdProceso, $intIdMaterial, $intIdEtapa, $intIdValidacion);
				// dep ($requestRendimiento); exit;
				
				$tableRendimiento = '';

				$tableRendimiento .='<br><br><div id="container-rendimiento" style="min-width: 300px; height: 400px; margin: 0 auto"></div>';

				$tableRendimiento .='<script type="text/javascript">

										Highcharts.chart("container-rendimiento", {
										    chart: {
										        type: "column"
										    },
										    title: {
										        text: "RENDIMIENTO DE AVANCE POR DIA"
										    },
										    subtitle: {
										        text: "Fuente: SISCOMAC"
										    },
										    xAxis: {
										        type: "category",
										        labels: {
										            rotation: -45,
										            style: {
										                fontSize: "13px",
										                fontFamily: "Verdana, sans-serif"
										            }
										        }
										    },
										    yAxis: {
										        min: 0,
										        title: {
										            text: "MESAS (%)"
										        }
										    },
										    legend: {
										        enabled: true
										    },
										    tooltip: {
										        pointFormat: "% MESAS ESCANEADAS: <b>{point.y:.1f} %</b>"
										    },
										    series: [{
										        name: "% MESAS",
										        data: [';
										        		
										     			foreach ($requestRendimiento as $value) {
															# code...
				$tableRendimiento .=							'["F: '.$value['FECHA_CONTROL'].'",'.$value['PORC_AVANCE'].'],';
														}	
										
				$tableRendimiento .='			],
										        dataLabels: {
										            enabled: true,
										            rotation: -90,
										            color: "#FFFFFF",
										            align: "right",
										            format: "{point.y:.1f}", // one decimal
										            y: 10, // 10 pixels down from the top
										            style: {
										                fontSize: "13px",
										                fontFamily: "Verdana, sans-serif"
										            }
										        }
										    }]
										});
									</script>';


				for ($i=0; $i <  count($requestRendimiento); $i++) {

					# code...
					//$requestRendimiento[$i]['ORDEN'] 	= 	$i+1;
					// $requestRendimiento['FECHA_CONTROL'] = $requestRendimiento[$i]['CANTIDAD_AVANCE'];
					$requestRendimientoChart[$i]['FECHA'] 	= 	$requestRendimiento[$i]['FECHA_CONTROL'];
					$requestRendimientoChart[$i]['AVANCE']	=	$requestRendimiento[$i]['PORC_AVANCE'];
					
				}
				
				$output = array(
					/*"draw"				=>	intval($_POST["draw"]),
					"recordsTotal"		=> 	count($arrData),
					"recordsFiltered"	=>	count($arrData),*/
					"data"				=>	$tableRendimiento
				);

				echo json_encode($output,JSON_NUMERIC_CHECK);
				
				die();
			}
		}



		/*===== STEP 5 =====*/
		public function getSelectOdpeGrafica()
		{	
			// dep($_POST); exit;
			if($_POST){
				$intIdProceso	= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idProceso'])) : 0;
				$intIdMaterial	= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idMaterial'])) : 0;
				$intIdEtapa		= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idEtapa'])) : 0;
				$intIdOdpe		= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idOdpe'])) : 0;

				$arrData = $this->model->reporteOdpeGrafica($intIdProceso, $intIdMaterial, $intIdEtapa, $intIdOdpe);

				if(empty($arrData)){
					$arrResponse = 	[
						"status"=> false,
						"title"	=> "Error!",
						"msg" 	=> "Datos No Encontrados.",
					]; 
				}else{
					$arrResponse = 	[
						"status"	=> true,
						"cantidad" 	=> count($arrData),
						"data" 		=> $arrData,
					]; 
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
				
				die();
			}
		}



		/*===== STEP 6 =====*/
		public function getSelectSoltec()
		{
			//dep($_POST); exit;
			if($_POST){
				$intIdProceso	= intval(strClean($_POST['idProceso']));

				$htmlOptions = '<option value="">[  SELECCIONE UNA SOL. TEC. ]</option>';
				$arrData = $this->model->selectCboSoltec($intIdProceso);
				if(count($arrData) > 0){
					for ($i=0; $i < count($arrData) ; $i++) { 
						$htmlOptions .='<option value="'.$arrData[$i]['ID_SOLUCIONTECNOLOGICA'].'"> '.$arrData[$i]['SOLUCIONTECNOLOGICA'].'</option>';
					}
				}
				echo $htmlOptions;
				die();
			}
		}


		public function getSelectOdpeEst()
		{
			//dep($_POST); exit;
			if($_POST){
				$intIdProceso	= intval(strClean($_POST['idProceso']));
				$intIdSolucion	= intval(strClean($_POST['idSolucion']));

				$htmlOptions = '<option value="">[  SELECCIONE UNA ODPE ]</option>';
				$arrData = $this->model->selectCboOdpeEst($intIdProceso, $intIdSolucion);
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
				$intIdOdpe		= intval(strClean($_POST['idOdpe']));

				$htmlOptions = '<option value="">[  SELECCIONE UN DEPARTAMENTO ]</option>';
				$arrData = $this->model->selectCboDepartamento($intIdProceso, $intIdSolucion, $intIdOdpe);
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
				$intIdOdpe			= intval(strClean($_POST['idOdpe']));
				$strDepartamento	= strClean($_POST['departamento']);

				$htmlOptions = '<option value="">[  SELECCIONE UNA PROVINCIA ]</option>';
				$arrData = $this->model->selectCboProvincia($intIdProceso, $intIdSolucion, $intIdOdpe, $strDepartamento);
				// echo $arrData; exit;
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
				$intIdOdpe			= intval(strClean($_POST['idOdpe']));
				$strDepartamento	= strClean($_POST['departamento']);
				$strProvincia		= strClean($_POST['provincia']);

				$htmlOptions = '<option value="">[  SELECCIONE UN DISTRITO ]</option>';
				$arrData = $this->model->selectCboDistrito($intIdProceso, $intIdSolucion, $intIdOdpe, $strDepartamento, $strProvincia);
				// echo $arrData; exit;
				if(count($arrData) > 0){
					for ($i=0; $i < count($arrData) ; $i++) { 
						$htmlOptions .='<option value="'.$arrData[$i]['CODIGO'].'"> '.$arrData[$i]['DISTRITO_UBI'].'</option>';
					}
				}
				echo $htmlOptions;
				die();
			}
		}
		

		public function getEstadistico()
		{
			// dep($_POST); exit;
			if($_POST){
				// $intIdProceso	= ($_POST['idProceso'] != '') ? intval(strClean($_POST['idProceso'])) : 0;
				$intIdProceso		= intval(strClean($_POST['idProceso']));
				$intIdSolucion		= intval(strClean($_POST['idSolucion']));
				$intIdOdpe			= intval(strClean($_POST['idOdpe']));
				$strDepartamento	= strClean($_POST['departamento']);
				$strProvincia		= strClean($_POST['provincia']);
				$strDistrito		= strClean($_POST['distrito']);
				$intIdEleccion		= intval(strClean($_POST['idEleccion']));
				$strNomProceso		= strClean($_POST['nomProceso']);

				
				$output = array();
				$requestEstaditico = $this->model->reporteEstadistico($intIdProceso, $intIdSolucion, $intIdOdpe, $strDepartamento, $strProvincia, $strDistrito, $intIdEleccion);
				// echo $requestEstaditico;exit;
				
				$cont=0;
				$departamento="";
				$provincia="";
				$distrito="";
				// $locacion="";
		        $tableDetalle = "";
		        $tableDetalle .='	<div class="text-center text-danger">
								    	<h4><b>'.$strNomProceso.'</b></h4>
									</div><br><br>
									<table id="tableEstadistico" class="display table table-bordered" cellspacing="0" width="100%">
										<thead class="text-center font-table">
										        
										</thead>
										<tbody class="text-center font-table">';
				
				foreach ($requestEstaditico as $value) {
					/*CAPTURO EL DEPARTAMENTO PARA EL QUIEBRE */
	                $departamento_ant = $departamento;
	                $departamento = $value['DEPARTAMENTO_UBI'];

	                /*CAPTURO LA PROVINCIA PARA EL QUIEBRE */
	                $provincia_ant = $provincia;
	                $provincia = $value['PROVINCIA_UBI'];
	                    
	                /*CAPTURO EL DISTRITO PARA EL QUIEBRE */
	                $distrito_ant = $distrito;
	                $distrito = $value['DISTRITO_UBI'];

	                /*CAPTURO LA LOCACION PARA EL QUIEBRE */
					/*$locacion_ant = $locacion;
					$locacion = $value['CODIGO_LOCAL'];*/

	                if($departamento_ant != $departamento){

	                    /*  CABECERA DE DEPARTAMENTO*/
	                    $tableDetalle .= '  <tr>
	                                			<th scope="col" class="bg-blue">
	                                    			<div align="left" class="bg-blue">ODPE/ORC: </div>
	                                			</th>
	                                     		<td align="left" colspan="5" class="bg-blue"><b>'.$value['NOMBRE_ODPE']. '</b></td>
	                                       	</tr>
	                    					<tr>
	                                			<th scope="col" class="bg-blue">
	                                    			<div align="left" class="bg-blue">DEPARTAMENTO: </div>
	                                			</th>
	                                      		<td align="left" colspan="5" class="bg-blue"><b>'.$value['DEPARTAMENTO_UBI'].'</b></td>
	                                        </tr>
	                    					<tr>
	                                			<td colspan="20">&nbsp;</td>
	                            			</tr>';
	                    
	                    /*  FIN CABECERA DE DEPARTAMENTO*/
	                }


	                if($provincia_ant != $provincia){
	                    /*  CABECERA DE PROVINCIA*/ 

	                    $tableDetalle .= '	<tr>
								  				<th scope="col" bgcolor="#EEEEEE">
								  					<div align="left">PROVINCIA: </div>
								  				</th>
								  				<td align="left" colspan="5" bgcolor="#EEEEEE">'.$value['PROVINCIA_UBI'].'</td>
								  			</tr>';
	                }

	                if($distrito_ant != $distrito){
	                	/*  CABECERA DE DISTRITO*/	
						$tableDetalle .= '	<tr>
												<th scope="col" bgcolor="#EEEEEE" >
													<div align="left">DISTRITO: </div>
											  	</th>
								  				<td align="left" colspan="5" bgcolor="#EEEEEE" >'.$value['DISTRITO_UBI'].'</td>
								  			</tr>';
	                }

	                $tableDetalle .= '		<tr>
						  		  				<th scope="col">
								  					<div align="right">LOCAL:</div>
								  				</th>
								  				<td align="left" colspan="5">'.$value['NOMBRE_LOCAL'].'</td></tr>
											<tr>
								  			<th scope="col">
								  				<div align="right">DIRECCION:</div>
								  				</th>
								  				<td align="left" colspan="5">'.$value['DIRECCION_LOCAL'].'</td>
								  			</tr>
											<tr>
								  				<td>&nbsp;</td>
								  				<th scope="col">
								  					<div align="right">TOTAL DE MESAS:</div>
								  				</th>
								  				<td align="center">'.$value['TOTAL_MESAS'].'</td>
								  				<th scope="col">
								  					<div align="right">TOTAL DE ELECTORES:</div>
								  				</th>
								  				<td align="center">'.$value['TOTAL_ELECTORES'].'</td>
								  				<td></td>
								  			</tr>
								  			<tr>
										  		<th scope="col">
										  			<div align="right">MESAS:</div></th>
										  		<td colspan="5" align="left">';
												$porciones = explode(" ", $value['DETALLE']);
												$x=1;
 
					$tableDetalle .= '				<table border="1">
									  	  				<tr>'; 
									 		  			for ($i=0; $i < count($porciones) ; $i++) { 
									 		  				# code...
									 		  
					$tableDetalle .= '						<td style="padding: 4px;"> &nbsp; ' .$porciones[$i]. ' &nbsp; </td>';
											    			if($x==15){
					$tableDetalle .= '					</tr>
														<tr>';
																$x=0;
															}
												 	
												 			$x=$x+1; 
									           			}
										        
					$tableDetalle .= '					</tr>
					 								</table>
					 							</td>
								 
											</tr>
											<tr>
							     				<td colspan="6">&nbsp;</td>
						    				</tr>';
				}

				$tableDetalle .='		</tbody>
									</table>';

				$output = array(
					/*"draw"				=>	intval($_POST["draw"]),
					"recordsTotal"		=> 	count($arrData),
					"recordsFiltered"	=>	count($arrData),*/
					"data"				=>	$tableDetalle
				);

				 
			}

			echo json_encode($output,JSON_UNESCAPED_UNICODE);
			die();
		}



		/*===== STEP 7 =====*/
		public function getConsultaMesa()
		{
			// dep($_POST); exit;
			if($_POST){
				$intIdProceso	= intval(strClean($_POST['idProceso']));
				$strNroMesa		= strClean($_POST['nroMesa']);

				$output = array();
				$requestConsultaMesa = $this->model->reporteConsultaMesa($intIdProceso, $strNroMesa);
				// dep($arrData); exit;

				$tableDetalle = "";
				$tableDetalle .='	<style type="text/css">
									    .col9, .col10, .col11, .col12, .col13, .col14, .col15 , .col16 , .col17{
									        display: none;
									    }
									</style>
									<table id="tbl_consultaMesa" class="display table table-bordered" cellspacing="0" width="100%">
									    <thead class="text-center font-table">
									        <tr class="bg-primary">
									    		<th class="text-center" colspan="1">TIPO DE PAQUETE</th>
									            <th class="text-center" colspan="3">CEDULAS</th>
									            <th class="text-center" colspan="5">ACTA PADRON</th>
									            <th class="text-center" colspan="1">DISPOSITIVOS ELECTRONICOS USBC / USBP</th>
									    	</tr>
									    	<tr>
									            <th class="text-center" width="10%">NOMBRE</th>
									          	<th class="text-center" width="10%">RECEPCION</th>
									            <th class="text-center" width="10%">CONTROL DE CALIDAD</th>
									            <th class="text-center" width="10%">EMPAQUETADO</th>
									            <th class="text-center" width="10%">LISTA DE ELECT.</th>
									            <th class="text-center" width="10%">RELACION DE ELECT</th>
									            <th class="text-center" width="10%">DOCUMENTOS ELECT.</th>
									            <th class="text-center" width="10%">DOCUMENTOS DE CONT.</th>
									            <th class="text-center" width="10%">EMPAREJAMIENTO</th>
									            <th class="text-center" width="10%">RECEPCION</th>
									    	</tr>
									    </thead>
									    <tbody class="text-center font-table">';

				$c = 0;
				if(!empty($requestConsultaMesa)){
					foreach ($requestConsultaMesa as $value) {
						

						if($value['ID_SOLUCION'] == 1 || $value['ID_SOLUCION'] == ''){
							$contigencia = '<td class="text-center col'.$c++.'" rowspan="'.count($requestConsultaMesa).'" style="background-color: #F2F2F2"></td>';
							$dispositivo = '<td class="text-center" style="background-color: #F2F2F2"></td>';
						}else{
							$contigencia = '<td class="text-center col'.$c++.'" rowspan="'.count($requestConsultaMesa).'"><img src="./Assets/images/'.$value['CONTINGENCIA'].'.png" height="24"></td>';
							$dispositivo = '<td class="text-center"><img src="./Assets/images/'.$value['DISPOSITIVOS'].'.png" height="24"></td>';
						}

						# code...
						$tableDetalle .='  	<tr>
												<td class="text-center col'.$c++.'" rowspan="'.count($requestConsultaMesa).'">'.$value['TIPO_CEDULA'].'</td>
												<td class="text-center col'.$c++.'" rowspan="'.count($requestConsultaMesa).'"><img src="./Assets/images/'.$value['RECEPCION'].'.png" height="24"></td>
												<td class="text-center col'.$c++.'" rowspan="'.count($requestConsultaMesa).'"><img src="./Assets/images/'.$value['CONTROL'].'.png" height="24"></td>	
												<td class="text-center col'.$c++.'" rowspan="'.count($requestConsultaMesa).'"><img src="./Assets/images/'.$value['EMPAQUETADO'].'.png" height="24"></td>
												<td class="text-center col'.$c++.'" rowspan="'.count($requestConsultaMesa).'"><img src="./Assets/images/'.$value['LISTA_RECEP'].'.png" height="24"></td>
												<td class="text-center col'.$c++.'" rowspan="'.count($requestConsultaMesa).'"><img src="./Assets/images/'.$value['RELACION'].'.png" height="24"></td>
												<td class="text-center col'.$c++.'" rowspan="'.count($requestConsultaMesa).'"><img src="./Assets/images/'.$value['DOCUMENTOS'].'.png" height="24"></td>
												'.$contigencia.'
												<td class="text-center col'.$c++.'" rowspan="'.count($requestConsultaMesa).'"><img src="./Assets/images/'.$value['LISTA_EMP'].'.png" height="24"></td>
												'.$dispositivo.'
											</tr>';


					}
				}else{
					$tableDetalle .='  	<tr>
												<td class="text-center" colspan="10" >No se encontraron Datos</td>
										</tr>';
				}

				$tableDetalle .='		</tbody>
									</table>';

				$output = array(
					/*"draw"				=>	intval($_POST["draw"]),
					"recordsTotal"		=> 	count($arrData),
					"recordsFiltered"	=>	count($arrData),*/
					
					"consultaMesa"		=>  array( "detalle" => $requestConsultaMesa),"data"				=>	$tableDetalle,
				);

				echo json_encode($output,JSON_UNESCAPED_UNICODE);
				die();
			}
		}
		


		
		
	}

?>