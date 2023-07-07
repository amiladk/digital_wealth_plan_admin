
$(function () {
    var table = $('#pending-withdrawls').DataTable({
        "paging": true,
        "info": true,
        "ordering": true,
        "search": true,
        // "processing": true,
        "serverSide": true,
        // "order": [[ 0, "desc" ]],
        "destroy": true,
        "responsive": true,
        // "oSearch": { "sSearch": searchString },
        "dom": 'lBfrtip',
        "buttons": [
            'copy', 'csv', 'excel','pdf'
        ],
        "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
        "columnDefs": [ 
            {
                "targets": 9,
                "render": function (data, type, row) {
                        if(data==0) {
                            return 'Pending';  
                        }else if(data==1){
                            return 'Approved'; 
                        }else{
                            return 'Disapproved'; 
                        }
                }
            },
            {
                "targets": [3,4,5],
                "render": function (data, type, row) {
                    return parseFloat(data).toFixed(2)
                    // return data.toFixed(2);
                },
                "className": "rigth-aligment",
            }, 
            {
                "targets": [6],
                "className": "text-center",
            }, 
        ],
        "columns": [
            { "data": "created_at" },
            { "data": "get_client.membership_no"},
            { "data": "get_client.first_name"},
            { "data": "get_client.wallet"},
            { "data": "withdraw_amount" },
            { "data": "recieving_amount" },
            { "data": "currencyTypeWith" },
            { "data": "cyptoNetworkWith" },
            { "data": "wallet_address" },
            { "data": "status" },
            { "data": "approved_date" },
            { "data": "approvedBy" },
            { "data": "action", },
           
        ],
        "ajax": {
            "url": "/ajax/pending-withdrawls",
            "type": "POST",
            "headers": {
            'X-CSRF-TOKEN': $('meta[name=token]').attr('content')
            },
            "data": {
            "_token"      : token,
            
                // d.startDate = $("#txtStartDate").val();
                // d.endDate = $("#txtEndDate").val();
            }
        }
        //"ajax": "/ajax/packagelist"
        // ajax: '/ajax/packagelist'
    });

    // filter approved
    
    $("#approved").click(function() {
        var value = 1;
        table.columns(9).search(value).draw();
        $(".header").html("Approved withdrawals");
    });

    // filter disapproved
    $("#disapproved").click(function() {
        var value = 2;
        table.columns(9).search(value).draw();
        $(".header").html("Disapproved withdrawals");

    });

    // filter pending
    $("#pending").click(function() {
        var value = 0;
        table.columns(9).search(value).draw();
        $(".header").html("Pending withdrawals");
    });

    table.columns(9).search(0).draw();

});