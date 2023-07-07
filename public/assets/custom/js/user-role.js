$( document ).ready(function() {
   
    $("#user-role tbody tr").each(function () {
        var allchecked = true;
        $(this).find(".form-check-input").each(function () {
            if(!$(this).is(':checked')){
                allchecked = false;
            }
        });
        if(allchecked == true){
            $(this).find(".select-all").prop('checked',true)
        }
    });
});

function selectAll(ele) {
    if($(ele).is(':checked')) {
      $(ele).closest("tr").find(".form-check-input").prop('checked',true);
    } else {
      $(ele).closest("tr").find(".form-check-input").prop('checked',false);
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

