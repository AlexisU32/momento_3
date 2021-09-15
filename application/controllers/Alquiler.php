<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alquiler extends CI_Controller {

    // Endpoint base http://localhost:8080/Momento_3/Alquiler/
	public function index()
	{
		echo "Endpoint principal ";
    }

    // ---------------------------------------------  inicio de sesión: Verifica si el usuario existe
    // http://localhost:8080/Momento_3/Alquiler/sing_in
    public function sing_in(){

        header('Access-Control-Allow_Origin: *');
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === "GET") {

            $json = file_get_contents('php://input');
            $data = json_decode($json);

            //var_dump($data);
            if (!empty($data->email) && !empty($data->password)) {
                
                if (preg_match("/^[a-zA-Z0-9\._-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/",$data->email)) {
                    
                    if (strlen($data->password) >= 8 && strlen($data->password) <= 16) {

                        header('content-type: aplication/json');
                        $response = $this->Alquiler_Model->searchUser($data);
                        echo json_encode($response);

                    }else{

                        header('content-type: aplication/json');
                        $response = array('status' => false, 'response' => 'El password debe contener entre 8 y 16 caracteres');
                        echo json_encode($response);

                    }

                }else{

                    header('content-type: aplication/json');
                    $response = array('status' => false, 'response' => 'El correo no es valido');
                    echo json_encode($response);
    
                }


            }else{

                header('content-type: aplication/json');
                $response = array('status' => false, 'response' => 'Debe llenar todos los campos');
                echo json_encode($response);
        
            }

        }else{

            header('content-type: aplication/json');
            $response = array('status' => false, 'response' => 'False');
            echo json_encode($response);

        }

    }

    // --------------------------------   Registro: Hace el registro del usuario. Debe solicitar los siguientes campos
    // http://localhost:8080/Momento_3/Alquiler/sing_up
    public function sing_up(){

        // Para agregar se usa el metodo POST

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'POST') {
            // Se procede a obtener los datos que provienen en formato Json
            $json = file_get_contents('php://input');
            // Se comvierte los datos que llegan en un formato json a uno que se entienda en PHP
            $data = json_decode($json);

            if (!empty($data->name) && !empty($data->lastname) && !empty($data->email) && !empty($data->type_id) && !empty($data->identification) && !empty($data->password)) { // Verifica si el campo está vacio
                if (strlen($data->name) >= 40) {

                    header('content-type: aplication/json');
                    $response = array('status' => false, 'response' => 'El campo es demaciado largo ');
                    echo json_encode($response);
                
                }else{

                    if (preg_match("/^[a-z]+$/i",$data->name) && preg_match("/^[a-z]+$/i",$data->lastname)) { // Verifica que no contenga caracteres especiales
                       
                        if (preg_match("/^[a-zA-Z0-9\._-]+@[a-zA-Z0-9-]{2,}[.][a-zA-Z]{2,4}$/",$data->email)) {
                            if ($data->type_id == "CC" || $data->type_id == "PAS" ) {
                                
                                if ($data->type_id == "PAS") {
                                    if (strlen($data->identification) >= 10) {

                                        header('content-type: aplication/json');
                                        $response = array('status' => false, 'response' => 'La identificación no puede contener más de 10 caracteres');
                                        echo json_encode($response);

                                    }else{
                                        if (strlen($data->password) >= 8 && strlen($data->password) <= 16) {
                                            
                                            if (!$this->Alquiler_Model->verificUser($data)) {
                                                header('content-type: aplication/json');
                                                $response = $this->Alquiler_Model->addUsers($data);
                                                echo json_encode($response);
                                            }else{
                                                header('content-type: aplication/json');
                                                $response = array('status' => false, 'response' => 'El usuario ya está registrado');
                                                echo json_encode($response);
                                            }


                                        }else{

                                            header('content-type: aplication/json');
                                            $response = array('status' => false, 'response' => 'El password debe contener entre 8 y 16 caracteres');
                                            echo json_encode($response);
                                            
                                        }

                                    }
                                }

                                if ($data->type_id == "CC" ) {
                                    if (is_numeric($data->identification)) {
                                        if (strlen($data->password) >= 8 && strlen($data->password) <= 16) {
                                            
                                            if (!$this->Alquiler_Model->verificUser($data)) {
                                                header('content-type: aplication/json');
                                                $response = $this->Alquiler_Model->addUsers($data);
                                                echo json_encode($response);
                                            }else{
                                                header('content-type: aplication/json');
                                                $response = array('status' => false, 'response' => 'El usuario ya está registrado');
                                                echo json_encode($response);
                                            }

                                        }else{

                                            header('content-type: aplication/json');
                                            $response = array('status' => false, 'response' => 'El password debe contener entre 8 y 16 caracteres');
                                            echo json_encode($response);

                                        }


                                    }else{

                                        header('content-type: aplication/json');
                                        $response = array('status' => false, 'response' => 'Debe ingresar número en la CC');
                                        echo json_encode($response);

                                    }
                                }

                            }else{

                                header('content-type: aplication/json');
                                $response = array('status' => false, 'response' => 'El tipo de id no es valido, son CC ó PAS');
                                echo json_encode($response);
                                
                            }
                        }else{

                            header('content-type: aplication/json');
                            $response = array('status' => false, 'response' => 'El correo no es valido');
                            echo json_encode($response);
                
                        }
                    }else{

                        header('content-type: aplication/json');
                        $response = array('status' => false, 'response' => 'No puede ingresar caracteres especiales');
                        echo json_encode($response);
        
                    }
                } 
            }else{
                header('content-type: aplication/json');
                $response = array('status' => false, 'response' => 'Debe llenar todos los campos');
                echo json_encode($response);
            }

            //var_dump($data);

            // Va a funcionar en JSON 
           // header('content-type: aplication/json');
        }else{

            header('content-type: aplication/json');
            $response = array('status' => false, 'response' => 'False');
            echo json_encode($response);
            
        }

    }


    // CRUD -- Permite agregar, eliminar, editar y eliminar los inmuebles o propiedades, pero solo de un
    // usuario en específico.

    // ---------------------------------------------------------- addProperty ----------------------------------------------------------
    // http://localhost:8080/Momento_3/Alquiler/addProperty
    public function addProperty(){

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'POST') {

            $json = file_get_contents('php://input');
            $data = json_decode($json);

            if (!empty($data->email) && !empty($data->password) && !empty($data->title) && !empty($data->type) && !empty($data->addess) && !empty($data->rooms) && !empty($data->price) && !empty($data->area)) {
                
                if (strlen($data->email) >= 30) {

                    header('content-type: aplication/json');
                    $response = array('status' => false, 'response' => 'El correo es demaciado largo');
                    echo json_encode($response);
                    
                }else{

                    if ($this->Alquiler_Model->verificUser($data)) {

                        $res = $this->Alquiler_Model->addProperty($data);

                        header('content-type: aplication/json');
                        echo json_encode($res);
                        
                    }else{
                        header('content-type: aplication/json');
                        $response = array('status' => false, 'response' => 'Los datos del usuario no estan registrados');
                        echo json_encode($response);
                    }

                }


            }else{

                header('content-type: aplication/json');
                $response = array('status' => false, 'response' => 'Debe llenar todos los campos');
                echo json_encode($response);

            }

        }else{

            header('content-type: aplication/json');
            $response = array('response' => 'Bad request');
            echo json_encode($response);

        }

    } 

    // ---------------------------------------------------------- getProperties ---------------------------------------------
    // http://localhost:8080/Momento_3/Alquiler/getProperties
    public function getProperties(){

        header("Access-Control-Allow_Origin: *");
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {

            $response = $this->Alquiler_Model->getProperties();

            header('content-type: aplication/json');
            $respon = array('status' => true, 'response' => $response);
            echo json_encode($respon);


            
        }else{

            header('content-type: aplication/json');
            $response = array('response' => 'Bad request');
            echo json_encode($response);
        
        }

    }

    // ---------------------------------------------------------- editProperty ----------------------------------------------------------
    public function editProperty(){

        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'POST') {

            $json = file_get_contents('php://input');
            $data = json_decode($json);

            if (!empty($data->email) && !empty($data->password) && !empty($data->title) && !empty($data->type) && !empty($data->addess) && !empty($data->rooms) && !empty($data->price) && !empty($data->area)) {
                
                if (strlen($data->email) >= 30) {

                    header('content-type: aplication/json');
                    $response = array('status' => false, 'response' => 'El correo es demaciado largo');
                    echo json_encode($response);
                    
                }else{

                    if ($this->Alquiler_Model->verificUser($data)) {

                        $res = $this->Alquiler_Model->updateProperties($data);

                        header('content-type: aplication/json');
                        echo json_encode($res);
                        
                    }else{
                        header('content-type: aplication/json');
                        $response = array('status' => false, 'response' => 'Los datos del usuario no estan registrados');
                        echo json_encode($response);
                    }

                }


            }else{

                header('content-type: aplication/json');
                $response = array('status' => false, 'response' => 'Debe llenar todos los campos');
                echo json_encode($response);

            }

        }else{

            header('content-type: aplication/json');
            $response = array('response' => 'Bad request');
            echo json_encode($response);

        }

    }

    // ---------------------------------------------------------- deleteProperty ----------------------------------------------------------
    public function deleteProperty(){

        $method = $_SERVER['REQUEST_METHOD'];
        if ($method === 'DELETE') {
            
            $json = file_get_contents('php://input');

            $data = json_decode($json);

            if (!empty($data->email)) {
                
                $res = $this->Alquiler_Model->deleteProperties($data);
                header('content-type: aplication/json');
                echo json_encode($res);

            }else{

                header('content-type: aplication/json');
                $response = array('status' => false, 'response' => 'Debe llenar todos los campos');
                echo json_encode($response);

            }

        }else{

            header('content-type: aplication/json');
            $response = array('response' => 'Bad request');
            echo json_encode($response);

        }

    }

    // ------------------------------------------ listProperties -- Obtiene las propiedades de todos los usuarios.
    public function listProperties(){

        header("Access-Control-Allow_Origin: *");
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {

            $response = $this->Alquiler_Model->getProperties();

            header('content-type: aplication/json');
            $respon = array('status' => true, 'response' => $response);
            echo json_encode($respon);


            
        }else{

            header('content-type: aplication/json');
            $response = array('response' => 'Bad request');
            echo json_encode($response);
        
        }

    }

    // getSortedProperties -- Obtiene las propiedades de todos los usuarios, pero en orden de
    // precio.
    public function getSortedProperties(){

        header("Access-Control-Allow_Origin: *");
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'GET') {

            $response = $this->Alquiler_Model->getPropertiesOrder();

            header('content-type: aplication/json');
            $respon = array('status' => true, 'response' => $response);
            echo json_encode($respon);


            
        }else{

            header('content-type: aplication/json');
            $response = array('response' => 'Bad request');
            echo json_encode($response);
        
        }


    }

    // getSortedUserProperties -- Obtiene las propiedades, pero de un usuario en específico y
    // ordenadas por precio.
    public function getSortedUserProperties(){

        header("Access-Control-Allow_Origin: *");
        $method = $_SERVER['REQUEST_METHOD'];

        if ($method === 'POST') {

            $json = file_get_contents('php://input');
            $data = json_decode($json);

            if ($this->Alquiler_Model->verificUser($data)) {
                
                $response = $this->Alquiler_Model->getPropertiesOrder_user($data);

                header('content-type: aplication/json');
                $respon = array('status' => true, 'response' => $response);
                echo json_encode($respon);

            }else{

                header('content-type: aplication/json');
                $response = array('status' => false, 'response' => 'Los datos del usuario no estan registrados');
                echo json_encode($response);

            }
            
        }else{

            header('content-type: aplication/json');
            $response = array('response' => 'Bad request');
            echo json_encode($response);
        
        }

    }



}