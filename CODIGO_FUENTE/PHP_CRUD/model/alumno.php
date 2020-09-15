<?php
	require_once 'accesDAO.php';

	class alumno extends accesDAO{
		private $id;
		private $nombre;
		private $apellido;
		private $grado;

		function __construct($id,$nombre,$apellido,$grado){
			parent::__construct();
			$this->id=$id;
			$this->nombre=$nombre;
			$this->apellido=$apellido;
			$this->grado=$grado;

		}

		//metodos get
		function get_id(){return $this->id;}
		function get_nombre(){return $this->nombre;}
		function get_apellido(){return $this->apellido;}
		function get_grado(){return $this->grado;}
		//metodos set
		function set_id($id){$this->id=$id;}
		function set_nombre($nombre){$this->nombre=$nombre;}
		function set_apellido($apellido){$this->apellido=$apellido;}
		function set_grado($grado){$this->grado=$grado;}

		// create
		function crearAlumno(){
			$comandoSql="insert into alumno (nombre,apellido,grado) values('".$this->nombre."','".$this->apellido."','".$this->grado."');";
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
			$comandoSql="update alumno set nombre='".$this->nombre."' , apellido='".$this->apellido."', grado='".$this->grado."' where id='".$this->id."';";
			$this->ejecutarConsulta($comandoSql);
			echo "actualizado exitosamente!";
		}	
		//delete

		function eliminarAlumno(){
			$comandoSql="delete from alumno where id='".$this->id."';";
			$this->ejecutarConsulta($comandoSql);
			echo "eliminado exitosamente!";
		}	
	}
