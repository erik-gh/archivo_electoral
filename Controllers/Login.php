<?php 

	/**
	* 
	*/
	class Login extends Controllers
	{
		
		public function __construct()
		{
			# code...
			session_start();
			if(isset($_SESSION['login'])){
				header('Location: '.base_url().'/dashboard');
			}
			parent::__construct();

		}

		public function login()
		{

			$data['page_tag']='INICIAR SESIÓN!';
			$data['page_title']='SISTEMA DE CONTROL DE MATERIALES CRITICOS <br><br> SISCOMAC © '.date('Y');
			$data['page_name']='login';
			$data['page_function_js']='function_login.js';
			$this->views->getView($this, 'login', $data);
		}


		public function loginUser()
		{	
			//dep($_POST); exit;
			if($_POST){
				if(empty($_POST['username']) || empty($_POST['password'])){
					$arrResponse = 	[
								    	"status" => false,
								    	"msg" => "Error! Verificar Datos.",
									]; 
				}else{

					$strUsuario		= strClean($_POST['username']);
					$strhash		= $this->model->hash_pwd($strUsuario);
					$strPassword	= hash_encript_login($strhash['SALT'], $_POST['password']);
					//$strPassword	= hash("SHA256", $_POST['password']);
					$requestUser	= $this->model->loginUser($strUsuario, $strPassword);

					if($requestUser == 'user'){
						$arrResponse = 	[
								    		"status" => false,
								    		"msg" => "<strong>Error!</strong> Usuario no existe.",
										]; 
					}else if(empty($requestUser)){
						$arrResponse = 	[
								    		"status" => false,
								    		"msg" => "<strong>Error!</strong> Contraseña Incorrecta.",
										]; 
					}else{
						$arrData = $requestUser;
						if($arrData['ESTADO'] == 1){
							$_SESSION['idUser'] 		= $arrData['ID_USUARIO'];
							$_SESSION['nameUser'] 		= $arrData['NOMBRE'];
							$_SESSION['idPerfil'] 		= $arrData['ID_PERFIL'];
							$_SESSION['resquest_pwd']	= $arrData['REQUEST_PASSWORD'];
							$_SESSION['login']			= true;
							
							$requestModulos = $this->model->loginUserModulo($_SESSION['idPerfil']);
							$cont = 0;
							$_SESSION['module'][]= array();
							foreach ($requestModulos as $rowMod ) {
								$_SESSION['module'][$cont++] = $rowMod['URL'];
							}
							
							$arrResponse = 	[
										    	"status" => true,
										    	"msg" => "ok",
											]; 
						}else{
							$arrResponse = 	[
										    	"status" => false,
										    	"msg" => "<strong>Error!</strong> Usuario Inactivo.",
											]; 
						}
					}

				}
			}

			echo json_encode($arrResponse,JSON_UNESCAPED_UNICODE);
		}

	}

?>