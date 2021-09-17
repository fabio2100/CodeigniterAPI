<?php 
namespace App\Models;
use CodeIgniter\Model;

class CiudadesModel extends Model{
	protected $table = 'ciudades';
	protected $primaryKey = 'id';
	protected $allowedFields = ['nombre','pais'];

	protected $useSoftDeletes = true;

	public function getCiudades($id=null){
		if(is_null($id)){
			return $this -> findAll();
		}
	}
}

?>