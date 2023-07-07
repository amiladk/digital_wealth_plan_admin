
$(function () {
    var table = $('#liability-report-client-wise').DataTable({
        "paging": true,
        "info": true,
        "ordering": true,
        "search": true,
        "processing": true,
        "serverSide": true,
        // "order": [[ 0, "desc" ]],
        "destroy": true,
        "responsive": false,
        // "oSearch": { "sSearch": searchString },
        "dom": 'lBfrtip',
        
        "buttons": [
            'copy', 'csv', 'excel','pdf'
        ],
        "lengthMenu": [[10, 25, 50, 1000,-1], [10, 25, 50, 1000, 'All']],
        "columnDefs": [
            {
                "targets": [4,5,6,7,8,9,11,13],
                "render": function (data, type, row) {
                    if (data == null) {
                        data = 0 
                    }
                    return parseFloat(data).toFixed(2);
                },
                //"className": "rigth-aligment",
            }, 
             
            {
                "targets": [10,12],
                "render": function (data, type, row) {
                   
                    return parseFloat(data).toFixed(2);
                },
                //"className": "rigth-aligment",
            }, 
            {
                "targets": [0],
                "render": function (data, type, row, meta) {
                    return meta.row + 1;
               },
                //"className": "rigth-aligment",
            },  
            
        ],
        "columns": [
            { "data": "id" },
            { "data": "registered_date" },
            { "data": "membership_no" },
            { "data": "first_name" },
            { "data": "trading_amount" },
            //{ "data": "daily_reward_limit" },
            { "data": "daily_reward_limit" },
            { "data": "daily_reward_amount" },
            { "data": "accumalated_up_todate" },
            { "data": "referral_reward" },
            { "data": "bv_reward" },
            { "data": "balance_to_be_accumalated" },
            { "data": "wallet" },
            { "data": "Paid_more_than" },
            { "data": "holding_wallet" },
            { "data": "date_range_due_report" },
            
           
           
           // { "data": "get_client.holding_wallet" },
             
           
        ],

        "ajax": {
            "url": "/ajax/liability-report-data-client-wise",
            "type": "POST",
            "headers": {
            'X-CSRF-TOKEN': $('meta[name=token]').attr('content')
            },
            "data": {
            "_token"      : token,
            },
        },
       "drawCallback": function (settings) { 
           // Here the response
            var response = settings.data;
            var api = this.api();
            $(api.column(4).footer()).html(parseFloat(settings.json.total_data.total_trading_amount).toFixed(2));
            $(api.column(5).footer()).html(parseFloat(settings.json.total_data.total_payble).toFixed(2));
            $(api.column(6).footer()).html(parseFloat(settings.json.total_data.total_daily_due_amount).toFixed(2));
            $(api.column(7).footer()).html(parseFloat(settings.json.total_accumalated_up_to_date).toFixed(2));
            $(api.column(8).footer()).html(parseFloat(settings.json.total_referral_reward).toFixed(2));
            $(api.column(9).footer()).html(parseFloat(settings.json.total_bv_reward).toFixed(2));
            $(api.column(10).footer()).html(parseFloat(settings.json.total_balance_to_be_accumalated).toFixed(2));
            $(api.column(11).footer()).html(parseFloat(settings.json.total_available_balance).toFixed(2));
            $(api.column(12).footer()).html(parseFloat(settings.json.total_paid_more_than).toFixed(2));
            $(api.column(13).footer()).html(parseFloat(settings.json.total_holding_wallet).toFixed(2));
            

            
            


            
           // $("#total-balance-to-be-accumalated").text(settings.json.total_balance_to_be_accumalated.toFixed(2));
           // $("#total-paid-more-than").text(settings.json.total_paid_more_than.toFixed(2));


           


           // Output the data for the visible rows to the browser's console
       //console.log( api.rows( {page:'current'} ).data() );
       },
        
        
        //"ajax": "/ajax/packagelist"
        // ajax: '/ajax/packagelist'
        
    });

    
    

  
});