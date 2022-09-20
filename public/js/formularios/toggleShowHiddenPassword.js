//Script para mostrar u ocultar las contraseñas
//El boton para hacerlo tiene que estar dentro del mismo div ".input-group" que el input en cuestion
$(document).ready(function(){
    $(".togglePassword").mousedown(function(){
        $(this).closest('.input-group').find('input').attr("type", 'text');
        $(this).toggleClass('bi-eye-slash bi-eye');
    })
    $(".togglePassword").mouseup(function(){
        $(this).closest('.input-group').find('input').attr("type", 'password');
        $(this).toggleClass('bi-eye bi-eye-slash');
    })
})
