<?php 

	/**
	* 
	*/
	class ReportAsistencia extends Controllers
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


		public function reportAsistencia()
		{

			$data['page_tag']='Reporte de Acceso';
			$data['page_title']='REPORTE DE CONTROL DE ACCESO - GGE';
			$data['page_name']='reporte';
			$data['page_function_js']='function_reportAsistencia.js';
			$this->views->getView($this,'reportAsistencia',$data);
		}


		public function getreporteAsistencia()
		{
			// dep($_POST); exit;

			$strDNI			= strClean($_POST['dni']);
			$strFechaInicio	= strClean($_POST['fechaInicio']);
			$strFechaFin	= strClean($_POST['fechaFin']);

			$requestDias	= $this->model->selectDias($strFechaInicio, $strFechaFin);
			//dep($requestDias);exit;
			$dias =array();
			foreach ($requestDias as $a) {
				# code...
				$dias[] ="MAX(CASE WHEN asistencia.fecha = '".$a['fecha']."' THEN CONCAT('R','<br>',TIME_FORMAT(asistencia.hora_ingreso, '%h %i %s %p'),'<br>', IF(asistencia.hora_salida = '00:00:00', '--:--:--', TIME_FORMAT(asistencia.hora_SALIDA, '%h %i %s %p')))  END) AS '".$a['fecha']."'";
			}

			$select =  (count($requestDias)>0) ? ', '.implode(",", $dias) : '';
			$requestReporte	= $this->model->selectReporte($strDNI, $select);

			$Ndias 	= array('DOMINGO', 'LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO');

			$tabla	='	<table id="tbl_lista_reportAsistencia" class="display table table-bordered table-hover" cellspacing="0" width="100%">
    						<thead class="text-center font-table">
						        <tr class="bg-primary">
						            <th class="text-center" rowspan="3" >Nº</th>
						            <th class="text-center" rowspan="3" >D.N.I</th>
						            <th class="text-center" rowspan="3" >COLABORADOR</th>
						            <th class="text-center" rowspan="3" >CARGO</th>
						            <th class="text-center" rowspan="3" >GERENCIA</th>
						            <th class="text-center" rowspan="3" >ESTADO</th>
						            <th class="text-center" colspan="'.count($requestDias).'" >DIAS CALENDARIO</th>
								</tr>
        						<tr class="bg-primary"> ';

                    foreach ($requestDias as $value) { 
			$tabla	.='				<th class="text-center">'.$Ndias[date('w',strtotime($value['fecha']))].'</th>'; 
                    }
            
            $tabla	.='			</tr>
        						<tr class="bg-primary">';
					foreach ($requestDias as $value) { 
			$tabla	.='				<th class="text-center">'.date('d/m/Y',strtotime($value['fecha'])).'</th>'; 
                    }
            $tabla	.='			</tr>
						    </thead>
						    <tbody class="text-center font-table">';
			$c=1;
					foreach ($requestReporte as $value) {
						$value['estado'] 	= 	$value['estado'] == 1 ? '<span class="label label-success label-pill m-w-60">ACTIVO</span>' : '<span class="label label-danger label-pill m-w-60">INACTIVO</span>';
			$tabla	.='			<tr>				
									<td>'.$c++.'</td>
									<td>'.$value['dni'].'</td>
									<td>'.$value['nombre'].'</td>
									<td>'.$value['cargo'].'</td>
									<td>'.$value['abreviatura'].'</td>
									<td>'.$value['estado'].'</td>';
						foreach ($requestDias as $a) { 
                         	$clase = ($value[$a['fecha']] != '') ? 'alert alert-outline-success' : 'alert alert-outline-danger';
                         	$estado = ($value[$a['fecha']] != '') ? $value[$a['fecha']] : 'NR';
            $tabla	.='				<td class="'.$clase.'"><b>'.$estado.'</b></td>';
                     	}

            $tabla	.='			</tr>';

					}

			$tabla	.='		</tbody>
						</table>';
			

			if(empty($requestReporte)){
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Alerta!",
										"msg" 	=> "Datos No Encontrados.",
									]; 
			}else{
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Reporte Asistencia",
										"msg" 	=> "Reporte realizado correctamente",
										"data"	=>	$tabla,
									]; 
			}


			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			die();

		}


		public function getexportAsistencia()
		{
			//dep($_POST);exit;
			date_default_timezone_set('America/Lima');
    		$fecha 			= date("d-m-Y");
    		$fechaC 		= date("d/m/Y");
			$strDNI			= strClean($_POST['dni']);
			$strFechaInicio	= strClean($_POST['fechaInicio']);
			$strFechaFin	= strClean($_POST['fechaFin']);

			$requestDias	= $this->model->selectDias($strFechaInicio, $strFechaFin);
			//dep($requestDias);exit;
			$dias =array();
			foreach ($requestDias as $a) {
				# code...
				$dias[] ="MAX(CASE WHEN asistencia.fecha = '".$a['fecha']."' THEN CONCAT('R','<br>',TIME_FORMAT(asistencia.hora_ingreso, '%h %i %s %p'),'<br>', IF(asistencia.hora_salida = '00:00:00', '--:--:--', TIME_FORMAT(asistencia.hora_SALIDA, '%h %i %s %p')))  END) AS '".$a['fecha']."'";
			}

			$select =  (count($requestDias)>0) ? ', '.implode(",", $dias) : '';
			$requestReporte	= $this->model->selectReporte($strDNI, $select);

			$Ndias 	= array('DOMINGO', 'LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO');

			if(count($requestReporte) > 0 ){

				if (PHP_SAPI == 'cli')
					die('Este archivo solo se puede ver desde un navegador web');
					
					require_once './Assets/lib/PHPExcel-1.8.2/Classes/PHPExcel.php';

					// Se crea el objeto PHPExcel
					$objPHPExcel = new PHPExcel();

					// Se asignan las propiedades del libro
					$objPHPExcel->getProperties()->setCreator(strtoupper ('PERSONAL')) //Autor
										 ->setLastModifiedBy("Usuario") //Ultimo usuario que lo modificó
										 ->setTitle("Reporte de Control de Acceso - ".strtoupper ('GGE'))
										 ->setSubject("Reporte Control de Acceso")
										 ->setDescription("Reporte de Control de Acceso")
										 ->setKeywords("Reporte de Control de Acceso - ".strtoupper ('GGE'))
										 ->setCategory("Reporte excel");

					$tituloReporte = "LISTADO DE CONTROL DE ACCESO  -  ".strtoupper ('GGE');
					$titulosColumnas = array('N°','DNI','COLABORADOR', 'CARGO', 'GERENCIA');
			    	$dias_lab= 'DIAS CALENDARIO';

			    	#Combinacion de celdas Titulo General
					$objPHPExcel->setActiveSheetIndex(0)
							    ->mergeCells('D1:F1')
			            		->mergeCells('C3:D3')
			            		->mergeCells('C4:D4')
			            		->mergeCells('F7:U7');
									
					// Se agregan los titulos del reporte
					$objPHPExcel->setActiveSheetIndex(0)
			  					->setCellValue('D1',  $tituloReporte)
			  					->setCellValue('A7', $titulosColumnas[0])
			        			->setCellValue('B7', $titulosColumnas[1])
			        			->setCellValue('C7', $titulosColumnas[2])
			                    ->setCellValue('D7', $titulosColumnas[3])
			                  	->setCellValue('E7', $titulosColumnas[4]);

			        $rowNumber5 = 8; 
	            	$col5 = 'F';

	            	foreach ($requestDias as $value5) {  
	                  //$objPHPExcel->getActiveSheet()->setCellValue($col6.$rowNumber6,$cell6);  
	                	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($col5.$rowNumber5,$Ndias[date('w',strtotime($value5['fecha']))]);  
	                	$col5++;  
	            	}

	            	$rowNumber6 = 9; 
		            $col6 = 'F'; 
		            foreach ($requestDias as $value6) {  
		            	//$objPHPExcel->getActiveSheet()->setCellValue($col6.$rowNumber6,$cell6);  
		            	$objPHPExcel->setActiveSheetIndex(0)->setCellValue($col6.$rowNumber6,date('d/m/Y',strtotime($value5['fecha'])));  
		            	$col6++;  
		            }

		            $objPHPExcel->setActiveSheetIndex(0)
	          			//->setCellValue('H13', $dias_lab)
	                  	->setCellValue('B3', 'GERENCIA:')
	                  	->setCellValue('C3', strtoupper('GGE'))
	                  	->setCellValue('B4', 'DIRECCIÓN:')
	                  	->setCellValue('c4', strtoupper('CEPSA'))
	                    ->setCellValue('F3', 'FECHA:')
	                    ->setCellValue('G3', $fechaC)
	                    ->setCellValue('F7', $dias_lab);

	               	//Se agregan los datos del Personal
					$i = 10;
					$c = 0;
					foreach ($requestReporte as $value){
			      		$c = $c+1;

			         	$objPHPExcel->setActiveSheetIndex(0)
			                      	->setCellValue('A'.$i,  $c)
			                      	->setCellValue('B'.$i,  $value['dni'])
			                      	->setCellValue('C'.$i,  $value['nombre'])
			                      	->setCellValue('D'.$i,  $value['cargo'])
			                      	->setCellValue('E'.$i,  $value['abreviatura']);
			                      	                      
			                      	$col7 = 'F'; 
			                      	foreach ($requestDias as $value7) { 
			                        	$estado = ($value[$value7['fecha']] != '') ? $value[$value7['fecha']] : 'NR';
			                            $data = str_replace("<br>", "\n", $estado);
			                            $objPHPExcel->setActiveSheetIndex(0)->setCellValue($col7.$i, $data );  
			                            $col7++;
			                      	}  
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
			    	

			        $objPHPExcel->getActiveSheet()->getStyle('D1:F1')->applyFromArray($estiloTituloReporte);
					$objPHPExcel->getActiveSheet()->getStyle('A7:J7')->applyFromArray($estiloTituloColumnas);	
			   		$objPHPExcel->getActiveSheet()->getStyle('F8:'.$col5.'8')->applyFromArray($estiloTituloColumnasDias); 	
			    	$objPHPExcel->getActiveSheet()->getStyle('F9:'.$col6.'9')->applyFromArray($estiloTituloColumnasDias);   
					$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacion, "A10:E".($i-1));
			    	$objPHPExcel->getActiveSheet()->setSharedStyle($estiloInformacionEstado, "E10:Z".($i-1));
					$objPHPExcel->getActiveSheet()->getStyle('B3:B4')->applyFromArray($estiloSubTitulo);
			    	$objPHPExcel->getActiveSheet()->getStyle('F3:F4')->applyFromArray($estiloSubTitulo);
					$objPHPExcel->getActiveSheet()->getStyle('L3:N3')->applyFromArray($estiloSubTitulo);
			    	$objPHPExcel->getActiveSheet()->getStyle('B1:B'.(count($requestReporte)+7))->getNumberFormat()->setFormatCode( PHPExcel_Style_NumberFormat::FORMAT_TEXT );

			    	//Zoom de la hoja Excel
				    $objPHPExcel->getSheet(0)->getSheetView()->setZoomScale(80);


					for($i = 'A'; $i <= 'Z'; $i++){
						$objPHPExcel->setActiveSheetIndex(0)			
							->getColumnDimension($i)->setAutoSize(TRUE);
					}


					// Se asigna el nombre a la hoja
					//$objPHPExcel->getActiveSheet()->setTitle('Reporte_Trabajadores');
					$objPHPExcel->getSheet(0)->setTitle('Reporte_Control_Acceso');
					// Se activa la hoja para que sea la que se muestre cuando el archivo se abre
					$objPHPExcel->setActiveSheetIndex(0);
					// Inmovilizar paneles 
					//$objPHPExcel->getActiveSheet(0)->freezePane('A4');

					$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(0,10);
					$objPHPExcel->getActiveSheet(0)->freezePaneByColumnAndRow(5,10);

					$excelName = "REPORTE_CONTROL_DE_ACCESO_".strtoupper('GGE')."_".$fecha.".xlsx";
				    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
				    $objWriter->save($excelName);
				    //echo $excelName;
				    $arrResponse = 	[
										"status"=> true,
										"title"	=> "Reporte de Asistencia",
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