<?php
function custom_register(){
    $campos=array(
        "name"=>__("Nombre Usuario","custom_plugin"),
        "first_name" => __("Nombre","custom_plugin"),
        "last_name" => __("Apellidos","custom_plugin"),
        "email" => __("Correo electrónico","custom_plugin"),
        "password" => __("Contraseña","custom_plugin"),
        "repeat_password" => __("Repite la contraseña","custom_plugin"),

    )
    ?>
    <div class='container_register'>
        <div class='card'>
        <div class='card_body card_body_custom'>
            <?php
                foreach($campos as $key => $valor){
            ?>
                <div class="input_label">
                <label id="<?php echo $key;?>_label" ><?php echo $valor;?></label>
                <?php if($key==="password" || $key==="repeat_password"){?>
                    <input type="password" from="<?php echo $key;?>_label" id="<?php echo $key;?>"/>
                    <span class="alert_danger_password"><?php echo __("Las contraseñas no coinciden!","custom_plugin");?></span>
                <?php 
                    }else{
                ?>
                        <input type="text" from="<?php echo $key;?>_label" id="<?php echo $key;?>"/>
                    <?php
                        if($key==="email"){
                    ?>
                        <span class="alert_danger"><?php echo __("Este email ya existe!","custom_plugin");?></span>
                <?php 
                        }
                    }
                ?>
                </div>
            <?php } ?>
        </div>
        <div class="card_footer card_footer_custom">
            <button type="button" class="btn btn_registrar">Registrarse</button>
            <span class="alerta_respuesta"></span>
        </div>
        </div>
    </div>
    <?php
}
add_shortcode('register_shortcode','custom_register');