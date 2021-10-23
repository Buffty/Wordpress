<?php
function getEmail(){
    $respuesta=array("code"=>"","message"=>"","data"=>array("status"=>""));
    $email=isset($_POST['email'])?$_POST['email']:"no_email";
    $user=get_user_by("email",$email);
    if($user->ID>0){
        $respuesta["code"]="exist_user";
        $respuesta["message"]="El usuario ya existe";
        $respuesta["data"]["status"]=400;
    }else{
        $respuesta["code"]="not_found_user";
        $respuesta["message"]="El usuario no existe";
        $respuesta["data"]["status"]=200;
    }
    return wp_send_json($respuesta,$respuesta["data"]["status"]);
}

function createUser(){
    $respuesta=array("code"=>"","message"=>"","data"=>array("status"=>""));
    $datos=isset($_POST['data'])?$_POST['data']:false;
    if($datos){
        $id_user=wp_create_user($datos["user_login"],$datos["password"],$datos["email"]);
        if(is_wp_error($id_user)){
            $respuesta["code"]="error_create_user";
            $respuesta["message"]="Fallo a la hora de crear el usuario";
            $respuesta["data"]["status"]=400;
        }else{
            wp_update_user(array("ID"=>$id_user,"first_name"=>$datos["first_name"],"last_name"=>$datos["last_name"]));
            $respuesta["code"]="success_create_user";
            $respuesta["message"]="Se ha creado el usuario correctamente";
            $respuesta["data"]["status"]=200;
        }
    }else{
        $respuesta["code"]="data_not_found";
        $respuesta["message"]="No se han pasado correctamente los datos.";
        $respuesta["data"]["status"]=400;
    }
    return wp_send_json($respuesta,$respuesta["data"]["status"]);
}

add_action('wp_ajax_CheckEmail','getEmail');
add_action('wp_ajax_RegistrarUsuario','createUser');