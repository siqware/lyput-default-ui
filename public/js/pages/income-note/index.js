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
                url: route('income.note.list').template,
                method:'get'
            },
            columns: [
                { data: 'id', name: 'id' },
                { data: 'amount', name: 'amount' },
                { data: 'created_at', name: 'created_at' },
                { data: 'action', name: 'action',searchable:false,orderable:false }
            ],
            "columnDefs": [
                { className: "pl-3", "targets": [ 0,1,2 ] },
                { className: "text-center", "targets": [ 3 ] }
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
    var _jqueryUI = function () {
        /*jQuery UI*/
        $( ".ac-basic" ).autocomplete({
            source: function( request, response ) {
                $.ajax( {
                    url: route('budget.autocomplete').template,
                    method:'post',
                    dataType: "json",
                    data: {
                        _term: request.term
                    },
                    success: function( data ) {
                        response( data );
                    }
                } );
            },
        } );
    };
    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentDatatable();
            _componentSelect2();
            _jqueryUI();
        },
        initJqueryUI:function () {
            _jqueryUI();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DatatableBasic.init();
    /*btn add more*/
    var _no = 1;
    $('.btn-add-more').click(function () {
        var tr_el = '<tr>\n' +
            '                                            <td>\n' +
            '                                                <input readonly type="text" name="income_note['+_no+'][invoice]" class="form-control" value="0">\n' +
            '                                            </td>\n' +
            '                                            <td>\n' +
            '                                                <input type="number" required min="0" step="any" name="income_note['+_no+'][amount]" placeholder="តម្លៃ" class="form-control">\n' +
            '                                            </td>\n' +
            '                                            <td>\n' +
            '                                                <button type="button" class="btn btn-warning btn-icon btn-remove-tr">\n' +
            '                                                    <i class="icon-diff-removed"></i>\n' +
            '                                                </button>\n' +
            '                                            </td>\n' +
            '                                        </tr>';
        $('.budget-input-list').append(tr_el);
        _no++;
        DatatableBasic.initJqueryUI();
    });
    /*remove tr*/
    $(document).on('click','.btn-remove-tr',function () {
        $(this.parentNode.parentNode).remove()
    })
});
