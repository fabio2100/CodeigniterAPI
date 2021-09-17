<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CiudadesModel;
use \Config\Services as servicios;



class CiudadesAPIControlador extends ResourceController{
    use ResponseTrait;

    //get all
    public function index(){
        $model = new CiudadesModel();

        $data['ciudades']=$model -> orderby('id') ->findAll();
        return $this ->  respond($data);
    }

    //get one 
    public function show($id=null){
        $model = new CiudadesModel();
        $data = $model -> where('id',$id)->first();
        if($data){
            return $this -> respond($data);
        }else{
            return $this-> failNotFound('No encontrado');
        }
    }

    //create -> ejecuta post
    public function create(){
        $model = new CiudadesModel();
        $validation = servicios::validation();
        if($validation -> setRules([
            'nombre'=>'required|min_length[3]|is_unique[ciudades.nombre]'
        ])
        ->withRequest($this -> request)
        ->run()){
            $data = [
                "nombre" => $this -> request -> getVar('nombre'),
                "pais" => $this -> request -> getVar('pais')
            ];
            
            $model -> insert($data);
            $response = [
                'status' => 201,
                'error' => null,
                'messages'=>[
                    'success'=>'Ciudad creada correctamente'
                ]
            ];
            return $this -> respondCreated($response);
        }else{
            return $this -> respondCreated(["mensaje"=>"no se pudo validar"]);
        };
        //$reglas = ['nombre'=>'required|min_length[3]is_unique[ciudades.nombre]'];
        //if(!$this->validate($reglas)){
        //    $response = [
		//		'status' => 500,
		//		'error' => true,
		//		'message' => $this->validator->getErrors(),
		//		'data' => []
		//	];
        //    return $this->respondCreated($response);
        //}else{
        //    return "paso las verificaciones";
        //}
    }
    


    //put update
    public function update($id=null){
        $model = new CiudadesModel();
        $data = [
            'nombre' => $this -> request -> getVar('nombre'),
            'pais' => $this -> request -> getVar('pais')
        ];
        $model -> update($id,$data);
        $response = [
            "status" => 200,
            "error" => null,
            "messages" => [
                'success'=>"Ciudad actualizada correctamente"
            ]
        ];
        return $this -> respond($response);
    }

    //delete 
    public function delete($id=null){
        $model = new CiudadesModel();
        try {
            $model -> delete(['id'=>$id]);
            $response = [
                "status" => 201,
                "error" => null,
                "messages" => [
                    'Sucess' => "Eliminada correctamente"
                ]
            ];
            return $this -> respond($response);
        } catch (Exception $e) {
            return $e -> getMessage();
        }
        
        
    }

    //mustra ciudades eliminadas 
    public function ciudadesEliminadas(){
        $model = new CiudadesModel();
        $data['ciudadesEliminadas']=$model -> onlyDeleted()->findAll();
        return $this -> respond($data);
    }
}


?>