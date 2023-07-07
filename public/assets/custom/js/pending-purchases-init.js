
$(function () {
    var table = $('#purchases').DataTable({
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
                "targets": 7,
                "render": function (data, type, row) {
                        if(data==1) {
                            actions = 'Funding'; 
                            return actions;
                        }else{
                            actions = 'Top Up';
                            return actions;
                        }
                       
                        // <button type="button" class="btn btn-cyan" data-bs-toggle="modal" data-bs-target=".bs-example-modal-center">Center modal</button>
                        
                }
            },
            {
                "targets": 8,
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
                "targets": [3,4,6],
                "render": function (data, type, row) {
                    return parseFloat(data).toFixed(2)
                   
                    // return data.toFixed(2);
                },
                 "className": "rigth-aligment",
            }, 
        ],
        "columns": [
            { "data": "created_at" },
            { "data": "get_client.membership_no" },
            { "data": "get_client.first_name" },
            { "data": "get_client.wallet" },
            { "data": "funding_amount" },
            { "data": "get_funding_payment_method.title" },
            { "data": "trading_amount" },
            { "data": "funding_type" },
            { "data": "status" },
            { "data": "approved_date" },
            { "data": "approvedBy" },
            { "data": "action", },

  
        ],
        "ajax": {
            "url": "/ajax/pending-purchases",
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
        table.columns(8).search(value).draw();
        $(".header").html("Approved Purchases");
    });

    // filter disapproved
    $("#disapproved").click(function() {
        var value = 2;
        table.columns(8).search(value).draw();
        $(".header").html("Disapproved Purchases");

    });

    // filter pending
    $("#pending").click(function() {
        var value = 0;
        table.columns(8).search(value).draw();
        $(".header").html("Pending Purchases");
    });

    table.columns(8).search(0).draw();

});