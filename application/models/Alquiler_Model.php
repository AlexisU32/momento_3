<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Alquiler_Model extends CI_Model {

	
    public function addUsers($data){
        if ($this->db->insert("users",$data)) {
            
            $txt = array("status" => true, "data" => 'Usuario registrado correctamente ');
            
        }else{

            $txt = array("status" => false, "data" => 'No se pudo registrar el usuario  ');
            
        }
        return $txt;

    }

    public function searchUser($data){
        $emails = $data->email;
        $clav = $data->password;

        if ($this->db->query("SELECT * FROM users WHERE email='$emails' AND password='$clav' ")->result()) {
            $txt = array("status" => true, "data" => 'El usuario si existe');
        }else{
            $txt = array("status" => false, "data" => 'El usuario no existe');
        }

        return $txt;
    }

    public function verificUser($data){
        $emails = $data->email;
        $clav = $data->password;

        if ($this->db->query("SELECT * FROM users WHERE email = '$emails' AND password = '$clav' ")->result()) {
            return true;
        }else{
            return false;
        }
    }

    public function addProperty($data){
        if ($this->db->insert("properties", $data)) {

            $txt = array("status" => true, "data" => 'Propiedad registrada correctamente ');
            
        }else{

            $txt = array("status" => false, "data" => 'No se pudo registrar la propiedad ');
    
        }
        return $txt;

    }

    public function getProperties(){
        $response = $this->db->query("SELECT * FROM properties")->result();
        return $response;
    }

    public function updateProperties($data){
        $email = $data->email;
        $title = $data->title;
        $type = $data->type;
        $addess = $data->addess;
        $rooms = $data->rooms;
        $price = $data->price;
        $area = $data->area;

        if ($this->db->query("UPDATE properties SET title = '${title}', type = '${type}', addess = '${addess}', rooms = '${rooms}', price = '${price}', area = '${area}' WHERE email = '${email}' ")) {
            $txt = array("status" => true, "data" => 'Propiedad editada correctamente ');
        }else{
            $txt = array("status" => false, "data" => 'Error al editar la propiedad ');
        }

        return $txt;
    }

    public function deleteProperties($data){
        $email = $data->email;

        if ($this->db->query("DELETE FROM properties WHERE email = '${email}' ")) {
            $txt = array('status' => true, 'response' => 'Propiedad eliminada correctamente ');
        }else{
            $txt = array('status' => false, 'response' => 'No se pudo eliminar la propiedad ');
        }
        return $txt;
    }

    public function getPropertiesOrder(){
        $response = $this->db->query("SELECT * FROM properties ORDER BY price ASC")->result();
        return $response;
    }

    public function getPropertiesOrder_user($data){

        $email = $data->email;

        $response = $this->db->query("SELECT * FROM properties WHERE email = '${email}' ORDER BY price ASC")->result();
        return $response;
    }




    
}