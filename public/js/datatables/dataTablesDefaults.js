$.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, {
    className : 'btn btn-sm btn-light me-2'
});
$.extend(true, $.fn.dataTable.defaults, {
    conditionalPaging: true,
    ordering: true,
    language : {
        url : 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json'
    },
    serverSide: true,
    dataType: 'json',
    type: 'POST',
    processing: true,
    responsive: true,
    pageLength : 5
});
