document.addEventListener('DOMContentLoaded', function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url:route('product.search.out.stock.alert').template,
        method:'post',
        dataType:'json',
        success:function (data) {
            $('.stock-alert').text(data.stock_alert);
        }
    })
});