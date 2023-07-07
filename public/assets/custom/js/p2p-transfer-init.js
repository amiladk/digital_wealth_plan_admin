
$(function () {
    var table = $('#p2p').DataTable({
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
                "targets": [5,6,7],
                "render": function (data, type, row) {
                    return parseFloat(data).toFixed(2);
                },
                "className": "rigth-aligment",
            },   
            
        ],
        "columns": [
            { "data": "created_at" },
            { "data": "get_from.first_name" },
            { "data": "get_from.membership_no" },
            { "data": "get_to.first_name" },
            { "data": "get_to.membership_no" },
            { "data": "transfer_amount" },
            { "data": "transaction_fee" },
            { "data": "received_amount" },
           
        ],
        "ajax": {
            "url": "/ajax/p2p-trasfer",
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

 

});