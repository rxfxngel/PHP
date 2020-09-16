<?php

include_once '../model/alumno.php';

if (isset($_POST["ALUMNO"])) {
	$OPCION="";
	$ID="";	
	$NOMBRE="";
	$APELLIDO="";
	$GRADO="";


	if(isset($_POST["OPCION"])){$OPCION=$_POST["OPCION"];}
	if(isset($_POST["ID"])){$ID=$_POST["ID"];}
	if(isset($_POST["NOMBRE"])){$NOMBRE=$_POST["NOMBRE"];}
	if(isset($_POST["APELLIDO"])){$APELLIDO=$_POST["APELLIDO"];}
	if(isset($_POST["GRADO"])){$GRADO=$_POST["GRADO"];}

	$alumno = new alumno($ID,$NOMBRE,$APELLIDO,$GRADO);

	if ($OPCION=="LISTAR") {
		$alumno->listarAlumno();
	}else if($OPCION=="CREAR"){
		$alumno->crearAlumno();
	}else if($OPCION=="EDITAR"){
		$alumno->actualizarAlumno();
	}else if($OPCION=="ELIMINAR"){
		$alumno->eliminarAlumno();
	}

}
