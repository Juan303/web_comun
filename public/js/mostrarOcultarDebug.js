$(document).ready(function (){
    $(".btn-ocultar-debug").click(function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr("href"),
            method: 'GET',
            success: function (data) {
                $("#barraDebug").addClass('d-none');
                $("#btnMostrarDebug").removeClass('d-none');
            }
        })
    });
    $(".btn-mostrar-debug").click(function(e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr("href"),
            method: 'GET',
            success: function (data) {
                $("#barraDebug").removeClass('d-none');
                $("#btnMostrarDebug").addClass('d-none');
            }
        })
    });
})
