@extends('admin.templates.template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3>Noticias</h3>
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-12">
                <a href="{{ route('admin.noticias.crear') }}" class="btn btn-success">+ Crear Noticia</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Noticias
                    </div>
                    <div class="card-body">
                        <table id="tablaNoticias" class="table dataTable table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th data-filtrable="1">Titulo</th>
                                <th data-filtrable="1">Categoría</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
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
                            <tr class="table-danger">
                                <td>Registro caducado</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section ("scripts")
    <script>
        $(document).ready(function (){
            //Funcion para hacer un buscador en una columna, solo se aplicará a aquellas que tenga el atriburo "data-filtrable = 1"
            var tabla = $("#tablaNoticias");
            $(tabla).find('thead tr').clone(true).appendTo( $(tabla).find('thead') );
            $(tabla).find('thead tr:eq(1) th').each( function (i) {
                if($(this).data('filtrable')) {
                    $(this).html('<input type="text" />');
                    $('input', this).on('keyup change', function () {
                        if (tabla.column(i).search() !== this.value) {
                            tabla
                                .column(i)
                                .search(this.value)
                                .draw();
                        }
                    });
                }
                else{
                    $(this).html('');
                }
            });
            //===================OPCIONES DATATABLE
            tabla = $('#tablaNoticias').DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                dom: 'lfBrtp',
                buttons: [
                    'pdf',
                    'csv',
                    'print'
                ],
                ajax: "{{route('admin.noticias.listar')}}",
                columns: [
                    {
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'Titulo.es',
                        name: 'Titulo',
                    },
                    {
                        data: 'categorias_noticia.Titulo.es',
                        defaultContent: "<i>Sin categoría</i>",
                        name: 'categorias_noticia.Titulo',
                    },
                    {
                        data: 'FechaInicio',
                        name: 'FechaInicio',
                        type: 'datetime',
                        displayFormat: 'M/D/YYYY',
                    },
                    {
                        data: 'FechaFin',
                        name: 'FechaFin',
                    },
                    {
                        data: 'acciones',
                        name: 'Acciones',
                        orderable: false,
                        searchable: false
                    }
                ]

            });
            tabla.on('draw', function () {
                borrar_registro(tabla);
                activar_desactivar_registro(tabla);
            });

        })

    </script>
@endsection
