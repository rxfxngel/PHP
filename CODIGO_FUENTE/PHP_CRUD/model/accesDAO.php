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
