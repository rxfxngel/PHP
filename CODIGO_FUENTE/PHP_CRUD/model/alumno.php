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
