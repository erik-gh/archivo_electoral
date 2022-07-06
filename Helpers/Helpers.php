<?php 
	
	

	function base_url()
	{
		return BASE_URL;
	}


	function media()
	{
		return BASE_URL."/Assets";
	}


	function headAdmin($data="")
	{
		$view_head = "Views/Template/head_admin.php";
		return require_once($view_head);
	}


	function headerAdmin($data="")
	{
		$view_header = "Views/Template/header_admin.php";
		return require_once($view_header);
	}


	function sidebarAdmin($data="")
	{
		$view_sidebar = "Views/Template/siderbar_admin.php";
		return require_once($view_sidebar);
	}


	function footerAdmin($data="")
	{
		$view_footer = "Views/Template/footer_admin.php";
		return require_once($view_footer);
	}


	function dep($data)
	{
		$format  =  print_r('<pre>');
		$format .=  print_r($data);
		$format .=  print_r('</pre>');
		return $format;
	}


	function strClean($strCadena)
	{
		$string = preg_replace(['/\s+/','/^\s|\s$/'],[' ',''], $strCadena);
		$string = trim($string);
		$string = stripslashes($string);
		$string =  str_replace("<script>", "", $string);
		$string =  str_replace("</script>", "", $string);
		$string =  str_replace("<script src>", "", $string);
		$string =  str_replace("<script type=>", "", $string);
		$string =  str_replace("SELECT * FROM", "", $string);
		$string =  str_replace("DELETE FROM", "", $string);
		$string =  str_replace("INSERT INTO", "", $string);
		$string =  str_replace("SELECT COUNT(*) FROM", "", $string);
		$string =  str_replace("DROP TABLE", "", $string);
		$string =  str_replace("OR = '1'='1'", "", $string);
		$string =  str_replace('OR = "1"="1"', "", $string);
		$string =  str_replace('OR = `1`=`1`', "", $string);
		$string =  str_replace("IS NULL; --", "", $string);
		$string =  str_replace("IS NULL; ..", "", $string);
		$string =  str_replace("LIKE '", "", $string);
		$string =  str_replace('LIKE "', "", $string);
		$string =  str_replace("LIKE `", "", $string);
		$string =  str_replace("OR 'a'='a", "", $string);
		$string =  str_replace('OR "a"="a', "", $string);
		$string =  str_replace("OR `a`=`a", "", $string);
		$string =  str_replace("OR `a`=`a", "", $string);
		$string =  str_replace("--", "", $string);
		$string =  str_replace("^", "", $string);
		$string =  str_replace("[", "", $string);
		$string =  str_replace("]", "", $string);
		$string =  str_replace("==", "", $string);
		return $string;
	}


	function pasGenerator($length = 10)
	{
		$pass="";
		$longitudPass = $length;
		$cadena = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
		$longitudCadena = strlen($cadena);

		for ($i=1; $i <= $longitudPass; $i++) { 
			# code...
			$pos = rand(0,$longitudCadena-1);
			$pass .= substr($cadena, $pos, 1);
		}
		return $pass;
	}


	function token()
	{
		$r1 = bin2hex(random_bytes(10));
		$r2 = bin2hex(random_bytes(10));
		$r3 = bin2hex(random_bytes(10));
		$r4 = bin2hex(random_bytes(10));
		$token = $r1.'-'.$r2.'-'.$r3.'-'.$r4;
		return $token;
	}


	function formaMoney($cantidad)
	{
		$cantidad = number_format($cantidad,2,SPD,SPM);
		return $cantidad;
	}


	function salt(){
		$salt_length=10;
		return substr(md5(uniqid(rand(), true)), 0, $salt_length);
	}


	function hash_encript($clave){
		$salt_length=10;
		$salt = salt();
		$password = $salt . substr(sha1($salt .$clave), 0, -$salt_length);
		return $password;
	}


	function hash_encript_login($salt, $clave){
		
		$salt_length=10;
		$password = $salt . substr(sha1($salt .$clave), 0, -$salt_length);
		return $password;
		
	}



 ?>