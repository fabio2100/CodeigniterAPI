<?php
namespace App\Controllers;
use CodeIgniter\Controller;
use App\models\CiudadesModel;
//comentario
class Ciudades extends Controller{
	public function index(){
		$ciudades = new CiudadesModel();
		$data['ciudades'] = $ciudades->getCiudades();
		foreach ($ciudades->getCiudades() as $ciudad) {
			echo $ciudad['nombre'].'----'.$ciudad['pais']."<br>";
		}
	}
}


?>