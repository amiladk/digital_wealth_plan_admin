// crypto network blade
// new Choices("#cypto_network", {
//     removeItemButton: !0
// });

// new Choices("#cypto_network-1", {
//     removeItemButton: !0
// });

$('select').select2({ width: '100%', placeholder: "Select an Option", allowClear: true });

function editCurrencyTypeModal(index){

        var currency_type = currency_types[index];
        
        $('#id-1').val(currency_type.id);
        $('#title-1').val(currency_type.title);

        if(currency_type.is_active == 1){
            $("#is_active-1").prop("checked", true);
        }else{
            $("#is_active-1").prop("checked", false);
        }

        const cypto_networks = currency_type.network_map.map(item => item.crypto_network.id);
        $("#cypto_network-1").val(cypto_networks).trigger('change');

        $('#edit-currency-type').modal('show');
}
    

function showAlert(title,msg,type) {
    Swal.fire({
        title: title,
        text: msg,
        icon: type,
        confirmButtonColor: '#3085d6',
        confirmButtonText: 'Ok'
    })
}