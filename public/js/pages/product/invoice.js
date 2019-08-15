var FormLayouts = function() {

    //
    // Setup module components
    //

    // Select2
    var _componentSelect2 = function() {
        if (!$().select2) {
            console.warn('Warning - select2.min.js is not loaded.');
            return;
        }
        //
        // Select with icons
        //

        // Format icon
        function iconFormat(icon) {
            var originalOption = icon.element;
            if (!icon.id) { return icon.text; }
            var $icon = "<i class='icon-" + $(icon.element).data('icon') + "'></i>" + icon.text;

            return $icon;
        }

        // Initialize with options
        $('.form-control-select2-icons').select2({
            templateResult: iconFormat,
            minimumResultsForSearch: Infinity,
            templateSelection: iconFormat,
            escapeMarkup: function(m) { return m; }
        });
    };

    // Uniform
    var _componentUniform = function() {
        if (!$().uniform) {
            console.warn('Warning - uniform.min.js is not loaded.');
            return;
        }

        // Initialize
        $('.form-input-styled').uniform({
            fileButtonClass: 'action btn bg-pink-400'
        });
        $('.form-check-input-styled').uniform();
    };


    //
    // Return objects assigned to module
    //

    return {
        init: function() {
            _componentSelect2();
            _componentUniform();
        }
    }
}();

// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    FormLayouts.init();
    var select2DOM = '.form-control-select2';
    function validateForm() {
        var isValid = true;
        $('#pro-input-list input').each(function() {
            if ( $(this).val() === '' )
                isValid = false;
        });
        return isValid;
    }
    var _no = 1;
    $(document).on('click','#btn-add-more',function () {
        var product_tr = '<tr>\n' +
            '                    <td class="text-center">'+_no+'</td>\n' +
            '                    <td>\n' +
            '                        <select data-placeholder="កត់ទំនិញចូល" name="product['+_no+'][id]" class="form-control form-control-select2" data-fouc></select>\n' +
            '                    </td>\n' +
            '                    <td>\n' +
            '                        <input name="product['+_no+'][qty]" id="qty" value="1" type="number" min="1" step="any" class="form-control" placeholder="ចំនួន">\n' +
            '                    </td>\n' +
            '                    <td>\n' +
            '                        <input name="product['+_no+'][pur_price]" readonly id="purchase" value="1" type="number" min="1" step="any" class="form-control" placeholder="តម្លៃទិញ">\n' +
            '                    </td>\n' +
            '                    <td>\n' +
            '                        <input name="product['+_no+'][sell_price]" id="sell" value="1" type="number" min="1" step="any" class="form-control" placeholder="តម្លៃលក់">\n' +
            '                    </td>\n' +
            '                    <td>\n' +
            '                        <input name="product['+_no+'][amount]" value="1" readonly id="amount" type="number" min="1" step="any" class="form-control" placeholder="សរុប">\n' +
            '                    </td>\n' +
            '                    <td>\n' +
            '                        <button type="button" id="btn-remove-tr" class="btn btn-warning"><i class="icon-diff-removed"></i></button>\n' +
            '                    </td>\n' +
            '                </tr>';
        $('#pro-input-list').append(product_tr);
        _no++;
        /*init select2*/
        initSelect2();
    });
    /*remove tr*/
    $(document).on('click','#btn-remove-tr',function () {
        $(this.parentNode.parentNode).remove();
        initSelect2();
        calcTotal();
    });
    $(document).on('keyup change keypress blur','#pro-input-list input',function () {
        if (validateForm()){
            $('#btn-submit').prop('disabled',false);
        } else {
            $('#btn-submit').prop('disabled',true);
        }
    });
//calc total amount amount++
    function calcTotal(){
        var amount = document.querySelectorAll('#amount');
        var total_amount = 0;
        $(amount).each(function (key, value) {
            total_amount +=parseFloat($(value).val())
        });
        $('#total').val(total_amount);
    }
    // income note event
    $(document).on('keyup change keypress blur click','#amount',function () {
        calcTotal();
    });
//calculate total qty*sell
    $(document).on('keyup change keypress blur click','#qty,#purchase, #sell',function () {
        var qty = parseFloat($(this.parentNode.parentNode).find('#qty').val());
        var sell = parseFloat($(this.parentNode.parentNode).find('#sell').val());
        $(this.parentNode.parentNode).find('#amount').val(qty*sell);
        calcTotal();
    });
    function initSelect2() {
        // Basic example
        var selectedId = document.querySelectorAll(select2DOM);
        var listedId = [];
        $.each(selectedId,function (key,val) {
            listedId.push(parseInt($(val).val()))
        });
        $(select2DOM).select2({
            ajax:{
                url:route('product.search.stock').template,
                method:'post',
                dataType:'json',
                delay:250,
                data:function (params) {
                    return {
                        _term: params.term,
                        _data:listedId
                    };
                },
            }
        });
        $(select2DOM).on("select2:select", function (e) {
            var id = $(this).val();
            var qty_el = $(e.delegateTarget.parentNode.parentNode).find('#qty');
            var pur_el = $(e.delegateTarget.parentNode.parentNode).find('#purchase');
            var sell_el = $(e.delegateTarget.parentNode.parentNode).find('#sell');
            var amount_el = $(e.delegateTarget.parentNode.parentNode).find('#amount');
            var url = route('stock.detail.data',':id').template.replace('{id}',id);
            $.ajax({
                url:url,
                method: 'get',
                dataType: 'json',
                data:{_token:$('meta[name="csrf-token"]').attr('content')},
                success:function (data) {
                    /*qty*/
                    qty_el.val(1);
                    qty_el.prop('min',1);
                    qty_el.prop('max',data.remain_qty);
                    /*purchase*/
                    pur_el.val(data.pur_price);
                    /*sell*/
                    sell_el.val(data.sell_price);
                    sell_el.prop('min',1);
                    /*calc qty * sell*/
                    var qty = parseFloat(qty_el.val());
                    var sell = parseFloat(sell_el.val());
                    amount_el.val(qty*sell);
                    calcTotal();
                }
            });
            initSelect2();
        });
    }
    initSelect2();
});
