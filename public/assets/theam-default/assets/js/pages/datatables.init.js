$(document).ready(function(){$("#datatable").DataTable(),

$("#datatable-buttons").DataTable({
    responsive: true,
    lengthChange:!1,buttons:["copy","excel","pdf","colvis"]}).buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"),$(".dataTables_length select").addClass("form-select form-select-sm");

$("#datatable-client-top-up").DataTable({
    responsive: true,
    lengthChange:!1,buttons:["copy","excel","pdf","colvis"]}).buttons().container().appendTo("#datatable-client-top-up_wrapper .col-md-6:eq(0)");

$("#datatable-client-withdrawals").DataTable({
    responsive: true,
    lengthChange:!1,buttons:["copy","excel","pdf","colvis"]}).buttons().container().appendTo("#datatable-client-withdrawals_wrapper .col-md-6:eq(0)");

$("#datatable-funding").DataTable({
    responsive: true,
    lengthChange:!1,buttons:["copy","excel","pdf","colvis"]}).buttons().container().appendTo("#datatable-funding_wrapper .col-md-6:eq(0)");

$("#datatable-top-up").DataTable({
    responsive: true,
    lengthChange:!1,buttons:["copy","excel","pdf","colvis"]}).buttons().container().appendTo("#datatable-top-up_wrapper .col-md-6:eq(0)");

$("#datatable-bv").DataTable({
    responsive: true,
    lengthChange:!1,buttons:["copy","excel","pdf","colvis"]}).buttons().container().appendTo("#datatable-bv_wrapper .col-md-6:eq(0)");

$("#datatable-daily").DataTable({
    responsive: true,
    lengthChange:!1,buttons:["copy","excel","pdf","colvis"]}).buttons().container().appendTo("#datatable-daily_wrapper .col-md-6:eq(0)");

$("#datatable-p2p-send").DataTable({
    responsive: true,
    lengthChange:!1,buttons:["copy","excel","pdf","colvis"]}).buttons().container().appendTo("#datatable-p2p-send_wrapper .col-md-6:eq(0)");

$("#datatable-p2p-received").DataTable({
    responsive: true,
    lengthChange:!1,buttons:["copy","excel","pdf","colvis"]}).buttons().container().appendTo("#datatable-p2p-received_wrapper .col-md-6:eq(0)");

});