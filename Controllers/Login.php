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
			$data['page_title']='ARCHIVO ELECTORAL <br><br> ARCHELECT © '.date('Y');
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
//					$strhash		= $this->model->hash_pwd($strUsuario);
//					$strPassword	= hash_encript_login($strhash['SALT'], $_POST['password']);
					$strPassword	= hash("SHA256", $_POST['password']);
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
						if($arrData['estado'] == 1){
							$_SESSION['idUser'] 		= $arrData['id'];
							$_SESSION['nameUser'] 		= $arrData['nombre'];
							$_SESSION['idPerfil'] 		= $arrData['id_perfil'];
							$_SESSION['resquest_pwd']	= $arrData['request_password'];
							$_SESSION['login']			= true;
							
							$requestModulos = $this->model->loginUserModulo($_SESSION['idPerfil']);
							$cont = 0;
							$_SESSION['module'][]= array();
							foreach ($requestModulos as $rowMod ) {
								$_SESSION['module'][$cont++] = $rowMod['url'];
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