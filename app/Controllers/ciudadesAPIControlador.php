<?php
namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\CiudadesModel;
//use \Config\Services as servicios;



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
        }
        return $this-> failNotFound('No hay ciudad asiganada con ese id');
        
    }

    //create -> ejecuta post
    public function create(){
      $model = new CiudadesModel();
      $reglas = ['nombre'=>'required|min_length[3]|is_unique[ciudades.nombre]'];
      if(!$this->validate($reglas)){
          return $this->failValidationError(implode($this->validator->getErrors()));
      }
      $data['nombre'] = $this -> request -> getVar('nombre');
      $data['pais'] = $this -> request -> getVar('pais');
      if($data['pais']==''){
          $data['pais']=NULL;
      }
      $model ->save($data);
      $response = [
          'status'=>201,
          'error'=>false,
          'message'=> "Ciudad creada correctamente",
          'data'=>$data
      ];
      return $this -> respondCreated($response); 
    }
    


    //put update
    public function update($id=null){
        $model = new CiudadesModel();
        $reglas = ['nombre'=>'required|min_length[3]|is_unique[ciudades.nombre]'];
        if(!$this -> validate($reglas)){
          return $this -> failValidationError(implode($this -> validator -> getErrors()));
        }
        $data = [
            'nombre' => $this -> request -> getVar('nombre'),
            'pais' => $this -> request -> getVar('pais')
        ];
        $res = $model -> update($id,$data);
        $response = [
            "status" => 200,
            "error" => null,
            "messages" => [
                'success'=>"Ciudad actualizada correctamente"
            ]
        ];
        return $this -> respond($res);
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
            return $this -> respondDeleted($response);
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


    public function pasaAMayus(){
      $model = new CiudadesModel();
      try {
        $data = $model -> findAll();
        foreach ($data as $ciudad) {
          $dataCity = $model -> where('id',$ciudad['id'])->first();
          $dataCity['nombre'] = strtoupper($dataCity['nombre']);
          $dataCity['pais'] = strtoupper($dataCity['pais']);
          $model -> update($ciudad['id'],$dataCity);
        }
        echo "paso el try";
      } catch (Exception $e) {
        echo $e->getLine() .'  '.$e->getMessage();
      }
    }
}


?>  