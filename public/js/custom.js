function checkBalance() {
    $('#balance_error').remove();
    var balance = $('#user_balance').val();
    var amount = $('#transaction_amount').val();
    var type = parseInt($('#category_id option:selected').attr('data-type'));
    if (type === 0 ){
        if (parseInt(amount) >= parseInt(balance)){
            $( "#transaction_amount" ).after( "<p class='text-danger' id='balance_error'>" +
                "You cannot add an expense transaction\n with a value greater than the remaining balance in your wallet!</p>" );
            return false
        }
    }
    return true;
}

$(document).ready(function () {
    $('#transaction_amount').keyup(function(){
        checkBalance();
    });
    $('#category_id').change(function(){
        checkBalance();
    });

    $('#chart_type').change(function(){
        $(this).closest('form').submit();
    });


});