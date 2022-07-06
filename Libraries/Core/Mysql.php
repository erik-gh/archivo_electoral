<?php 
/**
* 
*/
class Mysql extends Conexion
{
	
	private $conexion;
	private $strquery;
	private $arrvalues;

	function __construct()
	{
		# code...
		$this->conexion = new Conexion();
		$this->conexion = $this->conexion->conect();
	}

	
	public function insert(string $query, array $arrvalues)
	{
		$this->strquery = $query;
		$this->arrValues = $arrvalues;

		$insert = $this->conexion->prepare($this->strquery);
		$resInsert = $insert->execute($this->arrValues);
		if ($resInsert) {
			# code...
			$lastInsert = $this->conexion->lastInsertId();
		}else{
			$lastInsert = 0;
		}

		return $lastInsert;
	}


	public function select(string $query)
	{
		$this->strquery = $query;
		
		$result = $this->conexion->prepare($this->strquery);
		$result->execute();
		$data = $result->fetch(PDO::FETCH_ASSOC);
		return $data;
	}


	public function select_all(string $query)
	{
		$this->strquery = $query;
		
		$result = $this->conexion->prepare($this->strquery);
		$result->execute();
		$data = $result->fetchall(PDO::FETCH_ASSOC);
		return $data;
	}


	public function update(string $query, array $arrvalues)
	{
		$this->strquery = $query;
		$this->arrValues = $arrvalues;

		$update = $this->conexion->prepare($this->strquery);
		$resExecute = $update->execute($this->arrValues);
		return $resExecute;
	}


	public function delete(string $query)
	{
		$this->strquery = $query;

		$result = $this->conexion->prepare($this->strquery);
		$delete = $result->execute();
		return $delete;
	}

}


 ?>