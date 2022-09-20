//Funciones para el crud
//==================BORRAR REGISTRO
function borrar_registro(tabla){
    $('.btn-borrar-registro').click(function(){
        var action = $(this).data('action');
        $("#btnEliminar").attr("data-action", action);
        $("#borrarItemModal").modal('show');
    })
    $('#btnEliminar').click(function (e){
        e.preventDefault();
        $.ajax({
            url: $(this).data("action"),
            method: 'GET',
            success: function (data) {
                $("#borrarItemModal").modal('hide');
                tabla.ajax.reload(null, false);
            }
        })
    })
}
//==================ACTIVAR/DESACTIVAR REGISTRO
function activar_desactivar_registro(tabla){
    $(".activar-desactivar-form").submit(function (e){
        e.preventDefault();
        $.ajax({
            url: $(this).attr("action"),
            method: 'POST',
            data: $(this).serialize(),
            success: function(data){
                tabla.ajax.reload(null, false);
            }
        })
    })
}
//==================ENVIO MAIL RECUPERAR PASS
function envio_mail_recuperar_pass(tabla){
    $(".btn-envio-mail-recuperar-pass").click(function (e){
        e.preventDefault();
        $.ajax({
            url: $(this).data("action"),
            method: 'GET',
            success: function(data){
                alert("mail enviado");
                tabla.ajax.reload(null, false);
            }
        })
    })
}
//==================ENVIO MAIL VERIFICAR MAIL
function envio_mail_verificar_mail(tabla){
    $(".btn-envio-mail-verificar-mail").click(function (e){
        e.preventDefault();
        $.ajax({
            url: $(this).data("action"),
            method: 'GET',
            success: function(data){
                alert("mail de verificación enviado");
                tabla.ajax.reload(null, false);
            }
        })
    })
}

//============= BUSCADORES EN LAS COLUMNAS DE LAS TABLAS
function buscar_por_columnas(tabla){
    $("#"+tabla).find('thead tr').clone(true).appendTo( $("#"+tabla).find('thead') );
    $("#"+tabla).find('thead tr:eq(1) th').each( function (i) {
        $(this).html('');
        if($(this).data('filtrable')) {
            $(this).html('<input type="text" />');
            $('input', this).on('keyup change', function () {
                if ($("#"+tabla).column(i).search() !== this.value) {
                    $("#"+tabla).column(i).search(this.value).draw();
                }
            });
        }
    });
    return tabla;
}

