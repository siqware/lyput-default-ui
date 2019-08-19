// Setup module
// ------------------------------

var DatatableBasic = function() {
    //
    // Setup module components
    //

    // Basic Datatable examples
    var _componentDatatable = function() {
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
            init_inc_exp();
        });
        /*end date range*/
        // Scrollable datatable
        var table;
        function init_inc_exp(){
            $.ajax({
                url:route('report.close').template,
                method:'get',
                dataType:'json',
                data: {'_token':$('meta[name="csrf-token"]').attr('content'),'start':start,'end':end},
                success:function (data) {
                    var totalPurInSell = 0;
                    var totalSell = 0;
                    /*invoice*/
                    $.each(data.sell,function (key,val) {
                        totalPurInSell += parseInt(val.qty)*parseFloat(val.stock_detail_only.pur_price);
                        totalSell += parseFloat(val.amount);
                    });
                    var toalIncmeAmount = totalSell-totalPurInSell;
                    $('.totalIncomeAmount').text(formatter.format(totalSell-totalPurInSell));
                    /*remain income note - budget expense*/
                    $('.remainIncNote').text(formatter.format(data.income_note_remain));
                    $('.outIncome').text(formatter.format(data.budget_income));
                    $('.totalAmount').text(formatter.format(data.budget_income+data.income_note_remain+toalIncmeAmount));
                }
            })
        }
        init_inc_exp();
    };
    return {
        init: function() {
            _componentDatatable();
        }
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    DatatableBasic.init();
});
