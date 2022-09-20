@extends('admin.templates.template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3>Usuarios</h3>
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-12">
                <a href="{{ route('admin.usuarios.crear') }}" class="btn btn-success">+ Crear Usuario</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Noticias
                    </div>
                    <div class="card-body">
                        <table id="tablaUsuarios" class="table dataTable table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th data-filtrable="1">Nombre</th>
                                <th data-filtrable="1">E-mail</th>
                                <th>Registrado</th>
                                <th>Correo Verificado</th>
                                <th>Acciones</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <table class="table table-bordered w-25">
                            <tr class="table-secondary">
                                <td>Registro desactivado</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section ("scripts")
    <script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.19/features/conditionalPaging/dataTables.conditionalPaging.js"></script>
    <script>
        $(document).ready(function (){
            //Funcion para hacer un buscador en una columna, solo se aplicará a aquellas que tenga el atriburo "data-filtrable = 1"
            var tabla = $("#tablaUsuarios");
            $(tabla).find('thead tr').clone(true).appendTo( $(tabla).find('thead') );
            $(tabla).find('thead tr:eq(1) th').each( function (i) {
                $(this).html('');
                if($(this).data('filtrable')) {
                    $(this).html('<input type="text" />');
                    $('input', this).on('keyup change', function () {
                        if (tabla.column(i).search() !== this.value) {
                            tabla.column(i).search(this.value).draw();
                        }
                    });
                }
            });
            //===================OPCIONES DATATABLE
            tabla = $(".dataTable").DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                dom: 'lfBrtp',
                buttons: [
                    'pdf',
                    'csv',
                    'print'
                ],
                ajax: "{{route('admin.usuarios.listar')}}",
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name',
                    },
                    {
                        data: 'email',
                        name: 'email',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        type: 'datetime',
                        displayFormat: 'M/D/YYYY',
                    },
                    {
                        data: 'email_verified_at',
                        name: 'email_verified_at',
                        type: 'datetime',
                        displayFormat: 'M/D/YYYY',
                    },
                    {
                        data: 'acciones',
                        name: 'Acciones',
                        orderable: false,
                        searchable: false
                    }
                ]

            });
            //FUNCIONES PARA LOS BOTONES PARA QUE FUNCIONEN POR AJAX (Se tienen que cargar al dibujar la tabla)
            tabla.on('draw', function () {
                borrar_registro();
                activar_desactivar_registro(tabla);
                envio_mail_recuperar_pass(tabla);
                envio_mail_verificar_mail(tabla);
            });
        })

    </script>
@endsection
