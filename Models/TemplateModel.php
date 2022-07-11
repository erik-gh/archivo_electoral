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
		$query = "	SELECT p.id,p.perfil, m.modulo, m.url, m.icono, m.id
                    FROM perfiles p
                    INNER JOIN perfil_modulos pm ON p.id = pm.id_perfil
                    INNER JOIN modulos m ON m.id = pm.id_modulo
                    WHERE p.id = '{$this->intIdPerfil}' AND m.estado = 1;";

		$request = $this->select_all($query);

		return $request;
	}
}


?>