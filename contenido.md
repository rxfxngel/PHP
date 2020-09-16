# :elephant: CRUD PHP con Mysql :dolphin:

## Carpetas
- creamos nuestra carpeta del proyecto `PHP_CRUD`
- creamos tres carpetas `PHP_CRUD/model` `PHP_CRUD/view` `PHP_CRUD/controller` modelo-vista-controllador
## Conexion a la base de datos
Creamos la clase abstracta conexion `PHP_CRUD/model/conexion.php` para definir los parametros y metodos para la conexion a la base de datos

``` php
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

```
