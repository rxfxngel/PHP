<?php

abstract class conexion{
	const user='root';//usuario de la bd
	const pass='';//contraseña de la bd
	const host='localhost';
	const dbname='colegio';//nombre de la bd
	private $cnx;
	function __construct(){
		try {
			$this->cnx= new PDO('mysql:host='.self::host.';dbname='.self::dbname,self::user,self::pass);
		} catch (Exception $e) {
			echo $e->getMessage();
			die();
		}
	}

	function get_cnx(){
		return $this->cnx;
	}

	function set_cnx($valor){
		$this->cnx=$valor;
	}

	abstract function ejecutarConsulta($consulta);
}