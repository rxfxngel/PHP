<?php

include_once '../model/alumno.php';

if (isset($_POST["ALUMNO"])) {
	$opcion="";
	$id="";	
	$nombre="";
	$apellido="";
	$grado="";


	if(isset($_POST["opcion"])){$opcion=$_POST["opcion"];}
	if(isset($_POST["id"])){$id=$_POST["id"];}
	if(isset($_POST["nombre"])){$nombre=$_POST["nombre"];}
	if(isset($_POST["apellido"])){$apellido=$_POST["apellido"];}
	if(isset($_POST["grado"])){$grado=$_POST["grado"];}

	$alumno = new alumno($id,$nombre,$apellido,$grado);

	if ($opcion=="LISTAR") {
		$alumno->listarAlumno();
	}else if($opcion=="CREAR"){
		$alumno->crearAlumno();
	}else if($opcion=="EDITAR"){
		$alumno->actualizarAlumno();
	}else if($opcion=="ELIMINAR"){
		$alumno->eliminarAlumno();
	}

}
