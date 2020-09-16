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
Creamos la clase accesDAO `PHP_CRUD/model/accesDAO.php` e implementamos el metodo ejecutar consulta

``` php

<?php
require_once 'conexion.php';
class accesDAO extends conexion{
	private $resultado;

	function ejecutarConsulta($consulta){
		$this->resultado=$this->get_cnx()->prepare($consulta);
		$this->resultado->execute();
		$this->set_cnx(null);
		unset($consulta);

		$i=0;
		$data=[];

		while ($row = $this->resultado->fetch(PDO::FETCH_ASSOC)) {
			$data[$i]=$row;
			$i++;
		}
		echo json_encode($data);
	}
}

```
Creamos la clase alumno
``` php
<?php
	require_once 'accesDAO.php';

	class alumno extends accesDAO{
		private $ID;
		private $NOMBRE;
		private $APELLIDO;
		private $GRADO;

		function __construct($ID,$NOMBRE,$APELLIDO,$GRADO){
			parent::__construct();
			$this->ID=$ID;
			$this->NOMBRE=$NOMBRE;
			$this->APELLIDO=$APELLIDO;
			$this->GRADO=$GRADO;

		}

		//metodos get
		function get_id(){return $this->ID;}
		function get_nombre(){return $this->NOMBRE;}
		function get_apellido(){return $this->APELLIDO;}
		function get_grado(){return $this->GRADO;}
		//metodos set
		function set_id($ID){$this->ID=$ID;}
		function set_nombre($NOMBRE){$this->NOMBRE=$NOMBRE;}
		function set_apellido($APELLIDO){$this->APELLIDO=$APELLIDO;}
		function set_grado($GRADO){$this->GRADO=$GRADO;}

		// create
		function crearAlumno(){
			$comandoSql="insert into alumno (NOMBRE,APELLIDO,GRADO) values('".$this->NOMBRE."','".$this->APELLIDO."','".$this->GRADO."');";
			$this->ejecutarConsulta($comandoSql);
			echo "creado exitosamente!";
		}
		//read
		function listarAlumno(){
			$comandoSql="select * from alumno;";
			$this->ejecutarConsulta($comandoSql);
		}

		//update
		function actualizarAlumno(){
			$comandoSql="update alumno set NOMBRE='".$this->NOMBRE."' , APELLIDO='".$this->APELLIDO."', GRADO='".$this->GRADO."' where ID='".$this->ID."';";
			$this->ejecutarConsulta($comandoSql);
			echo "actualizado exitosamente!";
		}	
		//delete

		function eliminarAlumno(){
			$comandoSql="delete from alumno where ID='".$this->ID."';";
			$this->ejecutarConsulta($comandoSql);
			echo "eliminado exitosamente!";
		}	
	}
```
