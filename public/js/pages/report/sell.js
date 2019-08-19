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
        /*date ramge*/
        var start = moment().format('Y-M-D');
var end = moment().add(1,'days').format('Y-M-D');
        var range = {
            'Today': [moment(), moment().add(1,'days')],
            'Yesterday': [moment().subtract(1, 'days'), moment()],
            'Last 7 Days': [moment().subtract(6, 'days'), moment().add(1,'days')],
            'Last 30 Days': [moment().subtract(29, 'days'), moment().add(1,'days')],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        };
        $(document).on('click','#btn-today,#btn-yesterday,#btn-last-7days,#btn-last-30days,#btn-this-month,#btn-last-month, #btn-range',function () {
            if (this.id==='btn-today') {
                start = range.Today[0].format('Y-M-D');
                end = range.Today[1].format('Y-M-D');
            }else if (this.id==='btn-yesterday') {
                start = range.Yesterday[0].format('Y-M-D');
                end = range.Yesterday[1].format('Y-M-D');
            }else if (this.id==='btn-last-7days') {
                start = range["Last 7 Days"][0].format('Y-M-D');
                end = range["Last 7 Days"][1].format('Y-M-D');
            }else if (this.id==='btn-last-30days') {
                start = range["Last 30 Days"][0].format('Y-M-D');
                end = range["Last 30 Days"][1].format('Y-M-D');
            }else if (this.id==='btn-this-month') {
                start = range["This Month"][0].format('Y-M-D');
                end = range["This Month"][1].format('Y-M-D');
            }else if (this.id==='btn-last-month') {
                start = range["Last Month"][0].format('Y-M-D');
                end = range["Last Month"][1].format('Y-M-D');
            }
            else if (this.id==='btn-range') {
                start = moment($('#start').val()).format('Y-M-D');
                end = moment($('#end').val()).format('Y-M-D');
            }
            init_table();
            console.log(start+'-'+end);
        });
        /*end date range*/
        // Scrollable datatable
        var table;
        function init_table(){
            table = $('.datatable-scroll-y').DataTable({
                destroy:true,
                paging:false,
                autoWidth: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: route('sell.list').template,
                    method:'get',
                    data: {
                        "range": {start,end}
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'stock_detail.product.desc', name: 'stock_detail.product.desc' },
                    { data: 'qty', name: 'qty' },
                    { data: 'amount', name: 'amount' },
                    { data: 'created_at', name: 'created_at' },
                ],
                order: [4,'desc'],
                rowGroup: {
                    startRender: null,
                    endRender: function ( rows, group ) {
                        var totalQty = 0;
                        var totalSell = 0;
                        $.each(rows.data(),function (key,value) {
                            totalQty+=parseInt(value.qty);
                            totalSell+=parseFloat(value.amount.replace('$',''));
                        });
                        return $('<tr/>')
                            .append( '<td colspan="2" class="bg-info">'+group+'</td>' )
                            .append( '<td class="pl-3 bg-info">'+totalQty+'</td>' )
                            .append( '<td class="pl-3 bg-info">'+formatter.format(totalSell)+'</td>' )
                            .append( '<td class="pl-3 bg-info"></td>' );
                    },
                    dataSrc: 'created_at'
                },
                drawCallback:function (settings) {
                    console.log(settings.json.data);
                    var totalAmount = 0;
                    var totalQty = 0;
                    var totalPurchase = 0;
                    $.each(settings.json.data,function (key,val) {
                        totalPurchase += parseInt(val.qty)*parseFloat(val.stock_detail.pur_price);
                        totalAmount+=parseFloat(val.amount.replace('$',''));
                        totalQty+=parseInt(val.qty);
                    });
                    $('.totalAmount').html(formatter.format(totalAmount));
                    $('.totalCount').html(totalQty);
                    $('.totalIncomeAmount').html(formatter.format(totalAmount-totalPurchase));
                },
                "columnDefs": [
                    { className: "pl-3", "targets": [ 0,1,2,3,4 ] },
                ]
            });
        }
        init_table();
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
