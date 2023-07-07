// flatpickr("#datepicker-range",{mode:"range",defaultDate:new Date});

flatpickr("#datepicker-range", {
    mode: "range",
    //defaultDate: new Date
})

$(document).ready(function(){
    dataCount()
  });

$( "#datepicker-range" ).change(function() {
    var value = $( this ).val();
    var fromDate = value.split(' to ')[0];  
    var toDate = value.split(' to ')[1];  
    if (fromDate !=null && toDate !=null) { 
        dataCount(fromDate,toDate)
    }else{
        dataCount();
   
    }
   
  });
  
function dataCount(fromDate, toDate){
    $.ajax({
        method:"GET",
        url:"/ajax/dashbord-counts", 
        cache:false,
        async: false,
        headers: {
            'X-CSRF-TOKEN': token
        },
        data:{
            "_token"          : token,
            "fromDate"        : fromDate,
            "toDate"          : toDate,
           
        },

        success:function(data){

            if (data.success == true) {

                $('#total-users').html(data.total_users);
                $('#total-initial-funds').html(data.total_initial_funds);
                $('#total-top-ups').html(data.total_top_ups);
                $('#total-balance-funds').html(data.total_counts.total_balance_funds);
                $('#total-initial-funds-upto-date').html(data.total_counts.total_initial_funds_up_to_date);
                $('#total-top-up-funds-upto-date').html(data.total_counts.total_top_up_funds_up_to_date);
                $('#total-withdrawals-up-to-date').html(data.total_counts.total_withdrawals_up_to_date);
                $('#total-initial-funds-service-charges-up-to-date').html(data.total_counts.total_initial_funds_service_charges_up_to_date);
                $('#total-top-up-funds-service-charges-up-to-date').html(data.total_counts.total_top_up_funds_service_charges_up_to_date);
                // $('#total-withdrawal-service-charges-up-to-date').html(data.total_counts.total_withdrawal_service_charges_up_to_date);
                $('#total-initial-funds-upto-date-by-crypto').html(data.total_counts.total_initial_funds_up_to_date_by_crypto);
                $('#total-initial-funds-upto-date-by-wallet').html(data.total_counts.total_initial_funds_up_to_date_by_wallet);
                $('#total-top-up-funds-upto-date-by-crypto').html(data.total_counts.total_top_up_funds_up_to_date_by_crypto);
                $('#total-top-up-funds-upto-date-by-wallet').html(data.total_counts.total_top_up_funds_up_to_date_by_wallet);
                $('#initial-funds-service-charges-up-to-date-by-crypto').html(data.total_counts.total_initial_funds_service_charges_up_to_date_by_crypto);
                $('#initial-funds-service-charges-up-to-date-by-wallet').html(data.total_counts.total_initial_funds_service_charges_up_to_date_by_wallet);
                $('#top-up-funds-service-charges-up-to-date-by-crypto').html(data.total_counts.total_top_up_funds_service_charges_up_to_date_by_crypto);
                $('#top-up-funds-service-charges-up-to-date-by-wallet').html(data.total_counts.total_top_up_funds_service_charges_up_to_date_by_wallet);
                $('#total-withdrawal-service-charges-up-to-date').html(data.total_counts.total_withdrawal_service_charges_up_to_date);
                $('#total-p2p-service-charges-up-to-date').html(data.total_counts.total_p2p_service_charges_up_to_date);
                $('#transaction-fee-up-to-date').html(data.total_counts.transaction_fee);


                

            }else{
                showAlert('error','oops! Something went wrong.','error') 
            }
             
        },
        error: function (xhr, status, error) {
            response.success = false;
            response.msg = xhr.statusText;
        }
    });
  
}