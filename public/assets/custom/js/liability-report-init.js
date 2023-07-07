
$(function () {
    var table = $('#liability-report').DataTable({
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
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
        "columnDefs": [
            {
                "targets": [4,5,6,7,8,],
                "render": function (data, type, row) {
                    return parseFloat(data).toFixed(2);
                },
                //"className": "rigth-aligment",
            },  
            {
                "targets": [9,10],
                "render": function (data, type, row) {
                    if (data < 0) {
                        data = 0;
                    }
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
            { "data": "approved_date" },
            { "data": "get_client.membership_no" },
            { "data": "get_client.first_name" },
            { "data": "trading_amount" },
            { "data": "earning_eligibility" },
            { "data": "daily_reward_limit" },
            { "data": "daily_reward_amount" },
            { "data": "accumalated_up_todate" },
            { "data": "balance_to_be_accumalated" },
            { "data": "Paid_more_than" },
            { "data": "date_range_due_report" },
           
           // { "data": "get_client.holding_wallet" },
             
           
        ],

        "ajax": {
            "url": "/ajax/liability-report-data",
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
            //var response = settings.data;
            console.log(settings.json);
            var api = this.api();
            $(api.column(4).footer()).html(parseFloat(settings.json.investamnt_total).toFixed(2));
            $(api.column(6).footer()).html(parseFloat(settings.json.total_paybale).toFixed(2));
            $(api.column(7).footer()).html(parseFloat(settings.json.total_daily_due_amount).toFixed(2));
            $(api.column(8).footer()).html(parseFloat(settings.json.total_accumalated_up_to_date).toFixed(2));
            $(api.column(9).footer()).html(parseFloat(settings.json.total_balance_to_be_accumalated).toFixed(2));
            $(api.column(10).footer()).html(parseFloat(settings.json.total_paid_more_than).toFixed(2));
            
            // Output the data for the visible rows to the browser's console
       // console.log( api.rows( {page:'current'} ).data() );
        },
        
        
        //"ajax": "/ajax/packagelist"
        // ajax: '/ajax/packagelist'
        
    });

    
    

  
});