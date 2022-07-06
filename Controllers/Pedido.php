<?php 

	/**
	* 
	*/
	class Pedido extends Controllers
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

		public function pedido()
		{

			/*$data['page_tag']='Cargos';
			$data['page_title']='PEDIDOS Y CARGOS';
			$data['page_name']='cargos';
			$data['page_function_js']='function_cargo.js';
			$this->views->getView($this,'cargo',$data);*/
		}


		public function setPedido()
		{

			//dep($_POST); exit;
			if($_POST){
				if(empty($_POST['pedido']) || empty($_POST['memorandum']) || empty($_POST['informe']) || empty($_POST['fechaPedido']) ){
					$arrResponse = 	[
								    	"status"=> false,
								    	"title"	=> "Error!",
								    	"msg" 	=> "Verificar Datos.",
									]; 
				}else{
					$intIdPedido		= intval(strClean($_POST['IDPedido']));
					$intControl			= intval(strClean($_POST['controlPedido']));
					$intPedido			= intval(strClean($_POST['pedido']));
					$intMemorandum		= intval(strClean($_POST['memorandum']));
					$intInforme			= intval(strClean($_POST['informe']));
					$strFechaPedido		= strClean($_POST['fechaPedido']);
					$strObservacion		= strClean($_POST['observacion']);
					$intUserSession		= intval(strClean($_SESSION['idUser']));
					$cargos				= json_decode($_POST['cargos']);
					//$intEstado			= intval(strClean($_POST['estado']));
					
					if($intControl == 0){
						$requestPedido	= $this->model->insertPedido($intPedido, $intMemorandum, $intInforme, $strFechaPedido, $intUserSession);

					}else{
						
						$requestDelete 		= $this->model->deleteDetPedido($intIdPedido);
						$requestPedidoUdp	= $this->model->updatePedido($intIdPedido, $intPedido, $intMemorandum, $intInforme, $strFechaPedido, $strObservacion, $intUserSession);
						$requestPedido 		= ($requestPedidoUdp == 1) ? $intIdPedido : '-';	
					}

					if($requestPedido > 0){

						foreach ($cargos as $a ) {
							$intPedidoDetalle 	= intval(strClean($requestPedido));
							$intCargo 			= intval(strClean($a->IdCargo));
							$intCantCargo 		= intval(strClean($a->cantCargo));
							
							$requestDetPedido	= $this->model->insertDetPedido($intPedidoDetalle, $intCargo, $intCantCargo);
							if($strObservacion != ''){
								$requestDetPedidoHis= $this->model->insertDetPedidoH($intPedidoDetalle, $intCargo, $intCantCargo, $strObservacion, $intUserSession);
							}
							

						}


						if($requestDetPedido > 0){

							if($intControl == 0){
								$arrResponse = 	[
												    "status"=> true,
												    "title"	=> "Pedidos",
												    "msg" 	=> "Datos Guardados Correctamente.",
												];
							}else{
								$arrResponse = 	[
												    "status"=> true,
												    "title"	=> "Pedidos",
												    "msg" 	=> "Datos Actualizados Correctamente.",
												];
							}
						}
					}else if($requestPedido == 'exist'){
						$arrResponse = 	[
										    "status"=> false,
										    "title"	=> "Alerta!",
										    "msg" 	=> "Ya se encuentra registrado este Nro. de Pedido.",
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


		public function getPedidos()
		{
			
			$output = array();
			$arrData = $this->model->selectPedidos();
			//$filtro = ($_POST["search"]["value"]!= '') ? $arrData[1] : $arrData[2];
			for ($i=0; $i <  count($arrData[0]); $i++) { 
				# code...
				$arrData[0][$i]['orden'] 	= 	$i+1;
				//$arrData[0][$i]['estado'] 	= 	$arrData[0][$i]['estado'] == 1 ? '<span class="label label-success label-pill m-w-60">ACTIVO</span>' : '<span class="label label-danger label-pill m-w-60">INACTIVO</span>';
				$arrData[0][$i]['opciones'] =	'<a data-toggle="modal" href="#modal_cargoPedido" class="btn btn-success btn-xs" onclick="verPedido('.$arrData[0][$i]['id_pedido'].')"><i data-toggle="tooltip" title="Cargos" class="zmdi zmdi-eye zmdi-hc-fw"></i></a>
												<a class="btn btn-primary btn-xs" title="Editar" onclick="editarPedido('.$arrData[0][$i]['id_pedido'].')">
													<i class="zmdi zmdi-edit zmdi-hc-fw"></i>
												</a>
                                				<a class="btn btn-danger btn-xs" title="Eliminar" onclick="eliminarPedido('.$arrData[0][$i]['id_pedido'].')">
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


		public function getPedido($idPedido)
		{

			$intIdPedido = intval(strClean($idPedido));

			if ($intIdPedido > 0) {
				
				$arrData = $this->model->selectPedido($intIdPedido);

				//$pedido = array();

				$id_pedido = 0;
				$id_cargo = 0;

				$pedidoIndex = -1;
				$parametroIndex = -1;

				foreach ($arrData as $row){
					if($id_pedido != $row['id_pedido']){
						$pedidoIndex++;
						$parametroIndex = -1;

						$id_pedido = $row['id_pedido'];

						$pedido['id_pedido'] 	= $row['id_pedido'];
						$pedido['pedido'] 		= $row['pedido'];
						$pedido['memorandum'] 	= $row['memorandum'];
						$pedido['informe'] 		= $row['informe'];
						$pedido['fechaPedido'] 	= $row['fecha_pedido'];
						$pedido['parametros']	= array();
					}

					if($id_cargo != $row['id_cargo']){
						$parametroIndex++;
						$id_cargo = $row['id_cargo'];
						$pedido['parametros'][$parametroIndex]['idCargo'] = $row['id_cargo'];
						$pedido['parametros'][$parametroIndex]['cantidad'] = $row['cantidad'];
						$pedido['parametros'][$parametroIndex]['cargo'] = $row['cargo'];

					}   
				}

				//dep($pedido); exit;
				if(empty($arrData)){
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Datos No Encontrados.",
									]; 
				}else{
					$arrResponse = 	[
										"status"=> true,
										"data" 	=> $pedido,
									]; 
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}


		public function delPedido($idPedido)
		{
			
				$intIdPedido 	= intval(strClean($idPedido));
				$requestDelete 	= $this->model->deletePedido($intIdPedido);

				if ($requestDelete > 0) {
					$arrResponse = 	[
										"status"=> true,
										"title"	=> "Pedidos",
										"msg" 	=> "Pedido Eliminado Correctamente.",
									];

				}else{
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "Error al eliminar el Pedido",
									];
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			
				die();
		}


		public function getListCargos()
		{
			$htmlOptions = '';
			$arrData = $this->model->listCargos();
			if(count($arrData) > 0){
				for ($i=0; $i < count($arrData) ; $i++) { 
					//$htmlOptions .='<option value="'.$arrData[$i]['id_cargo'].'"> '.$arrData[$i]['cargo'].'</option>';

					$htmlOptions .='<tr  class="item">';
					$htmlOptions .='	<td class="text-center">
											<label class="custom-control custom-control-primary custom-checkbox active">
			                           			<input type="checkbox" class="custom-control-input" id="chkCargo'.$arrData[$i]['id_cargo'].'" value="'.$arrData[$i]['id_cargo'].'" name="custom" onclick="checkEnable('.$arrData[$i]['id_cargo'].');">
			                                	<span class="custom-control-indicator"></span>
			                            	</label>
			                        	</td>';
			        $htmlOptions .= '  	<td>'.$arrData[$i]['cargo'].'</td>';
                	$htmlOptions .= '  	<td class="text-center"> <input class="form-control nroCant" type="text" size ="5" disabled id="nroCantidad'.$arrData[$i]['id_cargo'].'" name="nroCantidad'.$arrData[$i]['id_cargo'].'" onkeypress=SoloNum() maxlength="4" required> </td>';
                	$htmlOptions .= '</tr>';
					
				}
			}else{
				$htmlOptions = 'No exiten Datos';
			}
			echo $htmlOptions;
			die();
		}


		public function getPedidoH($idPedido)
		{

			$intIdPedido = intval(strClean($idPedido));

			if ($intIdPedido > 0) {
				
				$arrData = $this->model->selectPedidoH($intIdPedido);
				//dep($arrData); exit;
				//$pedido = array();

				$id_pedido = 0;
				$id_cargo = 0;
				$id_fecha = '';

				$pedidoIndex = -1;
				$parametroIndex = -1;
				$cargos = -1;

				foreach ($arrData as $row){
					if($id_pedido != $row['id_pedido']){
						$pedidoIndex++;
						$parametroIndex = -1;

						$id_pedido = $row['id_pedido'];

						$pedido['id_pedido'] 	= $row['id_pedido'];
						$pedido['pedido'] 		= $row['pedido'];
						$pedido['memorandum'] 	= $row['memorandum'];
						$pedido['informe'] 		= $row['informe'];
						//$pedido['observacion'] 	= $row['observacion'];
						//$pedido['fecha'] 		= $row['date_create'];
						$pedido['fechas']	= array();
					}

					
					if($id_fecha != $row['date_create']){
						$parametroIndex++;
						$cargos = -1;
						$id_fecha = $row['date_create'];

						$pedido['fechas'][$parametroIndex]['fecha']			= $row['date_create'];
						$pedido['fechas'][$parametroIndex]['observacion']	= $row['observacion'];
						//$pedido['parametros'][$parametroIndex]['cargo']			= $row['cargo'];
						$pedido['fechas'][$parametroIndex]['cargos']	= array();
					}


					if($id_cargo != $row['id_cargo']){
						$cargos++;
						$id_cargo = $row['id_cargo'];
						$pedido['fechas'][$parametroIndex]['cargos'][$cargos]['idCargo']		= $row['id_cargo'];
						$pedido['fechas'][$parametroIndex]['cargos'][$cargos]['cantidad']		= $row['cantidad'];
						$pedido['fechas'][$parametroIndex]['cargos'][$cargos]['cargo']			= $row['cargo'];

					}  
				}

				//dep($pedido); exit;
				if(empty($arrData)){
					$arrResponse = 	[
										"status"=> false,
										"title"	=> "Error!",
										"msg" 	=> "No existen Cambios.",
									]; 
				}else{
					$arrResponse = 	[
										"status"=> true,
										"data" 	=> $pedido,
									]; 
				}
				echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
			}
			die();
		}


		/* FUNCTION PEDIDO - CONTRATO */
		public function getSelectPedido()
		{
			$arrData = $this->model->selectCboPedido();
			echo json_encode($arrData,JSON_UNESCAPED_UNICODE);
			die();
		}


		



		/*public function getexportPedido()
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

		}*/




	}

?>