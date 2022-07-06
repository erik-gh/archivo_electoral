<?php 

/**
* 
*/
class TemplateModel extends Mysql
{
	//CONSULTAS A LA BD, PARA RETORNAR AL CONTROLADOR 

	private $intIdPerfil;

	public function __construct()
	{
		# code...
		parent::__construct();

	}

	public function loginMenu(int $idPerfil)
	{
		
		$this->intIdPerfil 	= $idPerfil;
		$query = "	SELECT p.id_perfil,p.perfil, m.modulo, m.url, m.icono, m.id_modulo
                    FROM perfil p
                    INNER JOIN perfil_modulo pm ON p.id_perfil = pm.id_perfil
                    INNER JOIN modulo m ON m.id_modulo = pm.id_modulo
                    WHERE p.id_perfil = '{$this->intIdPerfil}'";

		$request = $this->select_all($query);

		return $request;
		 
	}

}


?>