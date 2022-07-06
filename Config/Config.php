<?php 

	// const BASE_URL = 'http://10.50.20.132/SISCOMACV2_EI2022';
	const BASE_URL = 'http://localhost/SISCOMACV2_EI2022';

	// ZONA HORARIA
	date_default_timezone_set('America/Lima');

	// DATOS DE LA BASE DE DATOS

/*	const DB_HOST 		= "localhost/XE";
	const DB_USER 		= "EI2022_SISCOMAC";
	const DB_PASSWORD 	= "EI2022_SISCOMAC";
	const DB_CHARSET 	= "charset=utf8";*/

//    const DB_HOST 		= "10.50.20.132";
	const DB_HOST 		= "localhost/XE";
    const DB_USER 		= "EI2022";
    const DB_PASSWORD 	= "EI2022";
    const DB_CHARSET 	= "charset=utf8";

	//DELIMITADOR DECIMAL Y MILES EJ 24,500.77
	const SPD = ".";
	const SPM = ",";

	// SIMBOLO DE LA MONEDA
	const SMONEY = 'S/ ';

	// NOMBRE DEL SISTE;A
	const NAMESYSTEM 	= "CONTROL DE MATERIALES CRITICOS";

?>