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
                pageLength:100,
                ajax: {
                    url: route('buy.list').template,
                    method:'get',
                    data: {
                        "range": {start,end}
                    }
                },
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'product.desc', name: 'product.desc' },
                    { data: 'qty', name: 'qty' },
                    { data: 'pur_price', name: 'pur_price' },
                    { data: 'pur_amount', name: 'pur_amount' },
                    { data: 'sell_price', name: 'sell_price' },
                    { data: 'sell_amount', name: 'sell_amount' },
                    { data: 'stock_id', name: 'stock_id' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', name: 'action',searchable:false,orderable:false },
                ],
                order: [7,'desc'],
                rowGroup: {
                    startRender: null,
                    endRender: function ( rows, group ) {
                        var totalQty = 0;
                        var totalSell = 0;
                        var totalPurchase = 0;
                        var totalSellAmount = 0;
                        var totalPurchaseAmount = 0;
                        $.each(rows.data(),function (key,value) {
                            totalQty+=parseInt(value.qty);
                            totalSell+=parseFloat(value.sell_price.replace('$',''));
                            totalPurchase+=parseFloat(value.pur_price.replace('$',''));
                            totalSellAmount+=parseFloat(value.sell_amount.replace('$',''));
                            totalPurchaseAmount+=parseFloat(value.pur_amount.replace('$',''));
                        });
                        return $('<tr/>')
                            .append( '<td colspan="2" class="bg-info">'+group+'</td>' )
                            .append( '<td class="pl-3 bg-info">'+totalQty+'</td>' )
                            .append( '<td class="pl-3 bg-info"></td>')
                            .append( '<td class="pl-3 bg-info">'+formatter.format(totalPurchaseAmount)+'</td>' )
                            .append( '<td class="pl-3 bg-info"></td>')
                            .append( '<td class="pl-3 bg-info">'+formatter.format(totalSellAmount)+'</td>' )
                            .append( '<td class="pl-3 bg-info"></td>' )
                            .append( '<td class="pl-3 bg-info"></td>' )
                            .append( '<td class="pl-3 bg-info"></td>' );
                    },
                    dataSrc: 'stock_id'
                },
                drawCallback:function (settings) {
                    var totalAmount = 0;
                    var totalQty = 0;
                    $.each(settings.json.data,function (key,val) {
                        totalAmount+=parseFloat(val.pur_amount.replace('$',''));
                        totalQty+=parseInt(val.qty);
                    });
                    $('.totalAmount').html(formatter.format(totalAmount));
                    $('.totalCount').html(totalQty);
                },
                "columnDefs": [
                    { className: "pl-3", "targets": [ 0,1,2,3,4,5,6,7 ] },
                    { className: "text-center", "targets": [ 8 ] },
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
