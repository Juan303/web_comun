@extends('admin.templates.template')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <h3>Categorias Noticias</h3>
            </div>
        </div>
        <div class="row justify-content-center mb-3">
            <div class="col-md-12">
                <a href="{{ route('admin.categoriasNoticias.crear') }}" class="btn btn-success">+ Crear Categoría Noticia</a>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Categorias Noticias
                    </div>
                    <div class="card-body">
                        <table id="tablaCategoriasNoticias" class="table dataTable table-bordered">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th data-filtrable="1">Título</th>
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
    <script>
        $(document).ready(function (){
            //Funcion para hacer un buscador en una columna, solo se aplicará a aquellas que tenga el atriburo "data-filtrable = 1"
            var tabla = $("#tablaCategoriasNoticias");
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
            tabla = $("#tablaCategoriasNoticias").DataTable({
                orderCellsTop: true,
                fixedHeader: true,
                dom: 'lfBrtp',
                buttons: [
                    'pdf',
                    'csv',
                    'print'
                ],
                ajax: "{{route('admin.categoriasNoticias.listar')}}",
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
