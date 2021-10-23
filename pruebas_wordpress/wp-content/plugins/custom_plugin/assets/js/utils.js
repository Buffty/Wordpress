jQuery(function ($) {

    if($("#email").length>0){
        $("#email").focusout(function(){
            let email = $("#email").val();
            $.ajax({
                url: ajax_public.ajax_url,
                type: "post",
                data: {"action":"CheckEmail","email":email},
                success: function(respuesta){
                    $(".alert_danger").css({"display":"none"});
                },
                error: function(respuesta,message,response){
                    if(respuesta.status===400){
                        $(".alert_danger").css({"display":"block"});
                    }
                }
            });
        });
           
    }
    if($("#password").length>0){
        $("#password").focusout(function(){
            let password=$(this).val();
            let repeat_password=$("#repeat_password").val();
            if(password!==repeat_password){
                $(".alert_danger_password").css({"display":"block"});
            }else{
                $(".alert_danger_password").css({"display":"none"});
            }
        });
    }
    if($("#repeat_password").length>0){
        $("#repeat_password").focusout(function(){
            let repeat_password=$(this).val();
            let password=$("#password").val();
            if(password!==repeat_password){
                $(".alert_danger_password").css({"display":"block"});
            }else{
                $(".alert_danger_password").css({"display":"none"});
            }
        }); 
    }
    if($(".btn_registrar").length>0){
        $(".btn_registrar").on("click",function(){
            let name = $("#name").val();
            let first_name = $("#first_name").val();
            let last_name = $("#last_name").val();
            let email = $("#email").val();
            let password = $("#password").val();
            let repeat_password = $("#repeat_password").val();
            if($(".alert_danger").css("display")=="none" && $(".alert_danger_password").css("display")=="none"){
                if(name!=="" && first_name!=="" && last_name!=="" && email!=="" && password!=="" && repeat_password!==""){
                    let datos ={"user_login":name,"nombre":first_name,"apellidos":last_name,"email":email,"password":password};
                    $.ajax({
                        url: ajax_public.ajax_url,
                        type: "post",
                        data: {"action":"RegistrarUsuario","data":datos},
                        success: function(respuesta){
                            $(".alerta_respuesta").html("Registrado correctamente!");
                            $(".alerta_respuesta").css({"display":"block","color":"green"});
                            setTimeout(function(){
                                window.location.reload(true);
                            },1500);
                        },
                        error: function(respuesta,message,response){
                            if(respuesta.status===400){
                                $(".alerta_respuesta").html("Porfavor, revisa los campos");
                                $(".alerta_respuesta").css({"display":"block","color":"red"});
                            }
                        }
                    })
                }
            }
        });
    }
});