// Setup module
// ------------------------------

var DatatableBasic = function() {
    //
    // Setup module components
    //

    // Basic Datatable examples
    var _componentDatatable = function() {
        if (!$().DataTable) {
            console.warn('Warning - datatables.min.js is not loaded.');
            return;
        }

        // Setting datatable defaults
        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            columnDefs: [{
                orderable: false,
                width: 100,
                targets: [ 5 ]
            }],
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
            language: {
                search: '<span>Filter:</span> _INPUT_',
                searchPlaceholder: 'Type to filter...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            }
        });
        // Alternative pagination
        $('.datatable-pagination').DataTable({
            pagingType: "simple",
            language: {
                paginate: {'next': $('html').attr('dir') == 'rtl' ? 'Next &larr;' : 'Next &rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr; Prev' : '&larr; Prev'}
            }
        });
//money format
        var formatter = new Intl.NumberFormat('en-US', {
            style: 'currency',
            currency: 'USD',
        });
        // Scrollable datatable
        var table = $('.datatable-scroll-y').DataTable({
            autoWidth: true,
            scrollX: true,
            scrollY: 400,
            processing: true,
            serverSide: true,
            ajax: {
                url: route('expense.list').template,
                method:'get'
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'desc', name: 'desc' },
                { data: 'amount', name: 'amount' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action',searchable:false,orderable:false },
            ],
            order: [3,'desc'],
            rowGroup: {
                startRender: null,
                endRender: function ( rows, group ) {
                    var amount = 0;
                    $.each(rows.data(),function (key,value) {
                        amount+=parseFloat(value.amount.replace('$',''));
                    });
                    return $('<tr/>')
                        .append( '<td colspan="2" class="bg-info">'+group+'</td>' )
                        .append( '<td class="pl-3 bg-info">'+formatter.format(amount)+'</td>' )
                        .append( '<td class="pl-3 bg-info"></td>' )
                        .append( '<td class="pl-3 bg-info"></td>' );
                },
                dataSrc: 'created_at'
            },
            "columnDefs": [
                { className: "pl-3", "targets": [ 0,1,2,3 ] },
                { className: "text-center", "targets": [ 4 ] },
            ]
        });

        // Resize scrollable table when sidebar width changes
        $('.sidebar-control').on('click', function() {
            table.columns.adjust().draw();
        });
    };

    // Select2 for length menu styling
    var _componentSelect2 = function() {
        if (!$().select2) {
            console.warn('Warning - select2.min.js is not loaded.');
            return;
        }

        // Initialize
        $('.dataTables_length select').select2({
            minimumResultsForSearch: Infinity,
            dropdownAutoWidth: true,
            width: 'auto'
        });
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDatatable();
            _componentSelect2();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DatatableBasic.init();
});
