function editCryptoNetworkModal(index){

    var crypto_network = crypto_networks[index];

    $('#id').val(crypto_network.id);
    $('#title-1').val(crypto_network.title);
    $('#network_fee-1').val(crypto_network.network_fee);
    $('#withdrawal_fee-1').val(crypto_network.withdrawal_fee);
    $('#company_wallet_address-1').val(crypto_network.company_wallet_address);

    if(crypto_network.client_wallet == 1){
        $("#client_wallet-1").prop("checked", true);
    }else{
        $("#client_wallet-1").prop("checked", false);
    }
    if(crypto_network.is_active == 1){
        $("#is_active-1").prop("checked", true);
    }else{
        $("#is_active-1").prop("checked", false);
    }
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