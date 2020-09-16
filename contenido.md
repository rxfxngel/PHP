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
## Metodo ejecutar consulta
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
## Modelo alumno
Creamos la clase alumno`PHP_CRUD/model/alumno.php` 
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
## Controlador Alumno
creamos el controlador `PHP_CRUD/controller/alumnoController.php` 
``` php
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

```
## Vista alumno

>Nota: :eyes: Descargamos la imagen svg, creamos la carpeta images dentro de la carpeta view y pegamos la imagen
>https://github.com/rxfxngel/PHP/blob/master/CODIGO_FUENTE/PHP_CRUD/view/images/cargando.svg
> `PHP_CRUD/view/images/cargando.svg`

Creamos la vista `PHP_CRUD/view/alumnoView.html` 
``` html
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">

    <style type="text/css">
    	html,body{
    		margin:0;
    		padding: 0;
    		width: 100%;
    		height: 100%;
    		overflow-x: hidden;
    	}
    </style>

	<script
  src="https://code.jquery.com/jquery-2.2.4.js"
  integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
  crossorigin="anonymous"></script>

   <script type="text/javascript">

   	var kernelData=[];
   	
   	$(function(){
   		console.log("hola");
   		construirTable();

   		$('#btnCerrar').on('click', function () {
	        $(".modal").css({"display":"none"});
	        limpiarFormulario();
	    });


   		

	    function validarDatos(){
	    	var NOMBRE;
	    	var APELLIDO;
	    	var GRADO;

	    	ID=$("#txtID").val();
	    	NOMBRE=$("#txtNOMBRE").val();
	    	APELLIDO=$("#txtAPELLIDO").val();
	    	GRADO=$("#txtGRADO").val();

	    	if (NOMBRE=="") {
	    		
	    		$("#txtNOMBRE").focus();
	    		return;
	    	}else if (APELLIDO=="") {
	    		
	    		$("#txtAPELLIDO").focus();
	    		return;
	    	}else if (GRADO=="") {
	    	
	    		$("#txtGRADO").focus();
	    		return;
	    	}

	    	cargandoFormulario(true);
	    	enviarDatos(ID,NOMBRE,APELLIDO,GRADO);

	    }

	    function enviarDatos(ID,NOMBRE,APELLIDO,GRADO){

	    	var OPCION=gOperacion;

	    	function afterCallBD(res){
	    		construirTable();
	    		
	    	}

	    	ajaxGenerico(true,"../controller/alumnoController.php", "JSON", {
	            ALUMNO:1,
	            OPCION:OPCION,
	            NOMBRE:NOMBRE,
	            APELLIDO:APELLIDO,
	            GRADO:GRADO,
	            ID:ID
	        }, function(res) {
	            afterCallBD(res);
	        });
	    }

	    $('#btnGuardar').on('click', function () {

	    	validarDatos();

	        //$(".modal").css({"display":"none"});
	    });

   		
   	});

   	function setearData(indice){
   		$("#txtID").val(kernelData[indice].ID);
   		$("#txtNOMBRE").val(kernelData[indice].NOMBRE);
   		$("#txtAPELLIDO").val(kernelData[indice].APELLIDO);
   		$("#txtGRADO").val(kernelData[indice].GRADO);
   	}

   	function editarRegistro(indice){
   		gOperacion="EDITAR";
   		setearData(indice);
   		$(".modal").css({"display":"block"});
   	}

   	function eliminarRegistro(indice){

      var opcion = confirm("Confirma eliminar a "+kernelData[indice].NOMBRE+" "+kernelData[indice].APELLIDO);

      if (opcion == false) {
        return;
      } 


   		$("#imgLoad").css({"visibility":"visible"});
   		$("#loadDelete").css({"visibility":"visible"});

   		function afterCallBD(res){
			construirTable();
    	}
   		var ID=kernelData[indice].ID;

   		ajaxGenerico(true,"../controller/alumnoController.php", "JSON", {
            ALUMNO:1,
            OPCION:'ELIMINAR',
            ID:ID
        }, function(res) {
            afterCallBD(res);
        });
   	}

   	function cargandoFormulario(bool){
		if (bool) {
			$("#cargandoFormulario").css({"display":"inline"});
		}else{
			$("#cargandoFormulario").css({"display":"none"});
		}
	}

   	function construirTable(){

   		function afterCallBD(data){
   			kernelData=data;
   			$("#contenido")[0].innerHTML=tablaHtml(data);
   			$(".modal").css({"display":"none"});
   			cargandoFormulario(false);
   			limpiarFormulario();
   		}

   		ajaxGenerico(true,"../controller/alumnoController.php", "JSON", {
            ALUMNO:1,
            OPCION:'LISTAR'
        }, function(res) {
            afterCallBD(res);
        });
   	}

   	function limpiarFormulario(){
   		$("#txtID").val("");
   		$("#txtNOMBRE").val("");
   		$("#txtAPELLIDO").val("");
   		$("#txtGRADO").val("");
   	}


	function add(){
		gOperacion="CREAR";
		$(".modal").css({"display":"block"});
	}


   	function tablaHtml(dataJson){

   		var html="";

   		html+="<div class='row'>";
   		html+="<div class='offset-md-3  col-md-6'>";


   		html+="<span class='badge badge-warning mt-2' style='font-size: 20px;''>ALUMNOS</span><img ID ='imgLoad' style='visibility:hidden;'  height='50' src='images/cargando.svg'><span ID='loadDelete' style='visibility:hidden;'> Eliminando</span><button class='btn btn-success mt-2 float-right' onclick='add()'><i class='material-icons'>add</i></button>";


   		html+="<table class='table mt-2 table-dark'>";
   		html+="<thead>";
   		html+="<tr>";
	   		html+="<th>ID";
	   		html+="</th>";
	   		html+="<th>NOMBRE";
	   		html+="</th>";
	   		html+="<th>APELLIDO";
	   		html+="</th>";
	   		html+="<th>GRADO";
	   		html+="</th>";
	   		html+="</th>";
	   		html+="<th>ACCIONES";
	   		html+="</th>";
   		html+="</tr>";
   		html+="</thead>";
   		html+="<tbody>";
   		for (var i = 0; i < dataJson.length; i++) {
   			html+="<tr>";

   			html+="<td>"+dataJson[i].ID;
	   		html+="</td>";
	   		html+="<td>"+dataJson[i].NOMBRE;
	   		html+="</td>";
	   		html+="<td>"+dataJson[i].APELLIDO;
	   		html+="</td>";
	   		html+="<td>"+dataJson[i].GRADO;
	   		html+="</td>";
	   		html+="<td><button class='btn btn-info' onclick='editarRegistro("+i+")'><i class='material-icons'>edit</i></button><button class='btn btn-danger' style='margin-left:10px' onclick='eliminarRegistro("+i+")'><i class='material-icons' )'>delete</i></button>";
	   		html+="</td>";

	   		html+="</tr>";
   		}
   		html+="</tbody>";

   		html+="</table>";

   		html+="</div>";
   		html+="</div>";

   		return html;
   	}

   	function ajaxGenerico(async, url, dataType, data, func) {
            $.ajax({
                async: async,
                dataType: dataType,
                type: "POST",
                url: url,
                data: data
            }).done(function (data) {
                func(data);
            }).fail(function (err) {
                func(err);
            });
        }
   </script>
<style type="text/css">

   	/* The Modal (background) */
	.modal {
	  display: none; /* Hidden by default */
	  position: fixed; /* Stay in place */
	  z-index: 1; /* Sit on top */
	  left: 0;
	  top: 0;
	  width: 100%; /* Full width */
	  height: 100%; /* Full height */
	  overflow: auto; /* Enable scroll if needed */
	  background-color: rgb(0,0,0); /* Fallback color */
	  background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	}

	/* Modal Content/Box */
	.modal-content {
	  background-color: #343a40;
	  margin: 10% auto; /* 15% from the top and centered */
	  padding: 20px;
	  border: 1px solid #888;
	  width: 500px; /* Could be more or less, depending on screen size */
	}

	
</style>

</head>
<body>

	<div ID="contenido"></div>


<div ID="myModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
  	<div style="width: 100%;"> <!-- Modal header -->
  		<span class="badge badge-warning" style="font-size: 20px;">ALUMNO</span>
    	<button ID="btnCerrar" class='btn btn-danger' style="float: right;" onclick='close()'><i class='material-icons'>close</i></button>
    </div>
    <div><!-- Modal content -->

		<input type="text" class="form-control mt-2" ID="txtID" placeholder="ID" readonly>
		<input type="text" class="form-control mt-2" ID="txtNOMBRE" placeholder="NOMBRE">
		<input type="text" class="form-control mt-2" ID="txtAPELLIDO" placeholder="APELLIDO">
		<input type="number" class="form-control mt-2" ID="txtGRADO" placeholder="GRADO">


    </div>
    <div style="width: 100%;"> <!-- Modal footer -->
    	<div ID="cargandoFormulario" style="display: none;">
    		<img height="50" src="images/cargando.svg"><span style="color: #FFF;">Grabando...</span>
    	</div>
    	<button ID="btnGuardar" class='btn btn-info mt-2' style="float: right;" ><i class='material-icons'>done</i></button>
    </div>
  </div>

</div>

</body>
</html>
```



