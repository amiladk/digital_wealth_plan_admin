
$(function () {
    var table = $('#client-list').DataTable({
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
               
            
        ],
        "columns": [
            { "data": "membership_no" },
            { "data": "full_name" },
            { "data": "created_at" },
            { "data": "initialfund" },
            { "data": "action" },
           
           
        ],
        "ajax": {
            "url": "/ajax/client-list",
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