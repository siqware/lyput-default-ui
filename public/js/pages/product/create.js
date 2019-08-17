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
    var _jqueryUI = function () {
        /*jQuery UI*/
        $( ".ac-basic" ).autocomplete({
            source: function( request, response ) {
                $.ajax( {
                    url: route('product.search.autocomplete').template,
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
    FormLayouts.init();
});
function validateForm() {
    var isValid = true;
    $('#pro-input-list input').each(function() {
        if ( $(this).val() === '' )
            isValid = false;
    });
    return isValid;
}
$(document).mouseover(function () {
    if (validateForm()){
        $('#btn-submit').prop('disabled',false);
    } else {
        $('#btn-submit').prop('disabled',true);
    }
});
var _no = 1;
$(document).on('click','#btn-add-more',function () {
    var product_tr = '<tr>\n' +
        '                    <td class="text-center">'+_no+'</td>\n' +
        '                    <td>\n' +
        '                        <input type="text" placeholder="ពិពណ៌នា" name="product['+_no+'][desc]" class="form-control ac-basic">\n' +
        '                    </td>\n' +
        '                    <td>\n' +
        '                        <input name="product['+_no+'][qty]" id="qty" value="1" type="number" min="0" step="any" class="form-control" placeholder="ចំនួន">\n' +
        '                    </td>\n' +
        '                    <td>\n' +
        '                        <input name="product['+_no+'][pur_price]" id="purchase" value="1" type="number" min="0" step="any" class="form-control" placeholder="តម្លៃទិញ">\n' +
        '                    </td>\n' +
        '                    <td>\n' +
        '                        <input name="product['+_no+'][sell_price]" id="sell" type="number" min="0" step="any" class="form-control" placeholder="តម្លៃលក់">\n' +
        '                    </td>\n' +
        '                    <td>\n' +
        '                        <input name="product['+_no+'][amount]" id="amount" readonly type="number" min="0" step="any" class="form-control" placeholder="សរុប">\n' +
        '                    </td>\n' +
        '                    <td>\n' +
        '                        <button type="button" id="btn-remove-tr" class="btn btn-warning"><i class="icon-diff-removed"></i></button>\n' +
        '                    </td>\n' +
        '                </tr>';
    $('#pro-input-list').append(product_tr);
    FormLayouts.initJqueryUI();
    _no++;
});
/*remove tr*/
$(document).on('click','#btn-remove-tr',function () {
    $(this.parentNode.parentNode).remove();
    calcTotal();
});
$(document).on('keyup keydown change keypress blur','#pro-input-list input',function () {
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
//calculate total qty*purchase
$(document).on('keyup change keypress blur click','#qty,#purchase, #sell',function () {
    var qty = parseFloat($(this.parentNode.parentNode).find('#qty').val());
    var purchase = parseFloat($(this.parentNode.parentNode).find('#purchase').val());
    $(this.parentNode.parentNode).find('#amount').val(qty*purchase);
    calcTotal();
});
/*Save data to local storage*/
$(document).on('click','#btn-submit',function () {

// Retrieve the object from storage
    var clone = document.getElementById("pro-input-list");
console.log(clone);
    // var testObject = { 'last_item': $('#pro-input-list').clone()[0].innerHTML };
    var testObject = { 'last_item': clone };

// Put the object into storage
    localStorage.setItem('testObject', JSON.stringify(testObject));
    var retrievedObject = localStorage.getItem('testObject');
    $('#pro-input-list').append(JSON.parse(retrievedObject).last_item)
});
