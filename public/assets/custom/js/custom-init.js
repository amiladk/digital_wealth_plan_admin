/*
|--------------------------------------------------------------------------
| Disapprove withdrawal
|--------------------------------------------------------------------------
*/

function disapproveWithdraw(id){

    Swal.fire({
      title: 'Are you sure?',
      text: "Do you want disapprove?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes!'
    }).then((result) => {
      if (result.isConfirmed) {

        invokeLoader();

        var base_url = window.location.origin;
  
        $.ajax({  
            type: "POST",
            url: base_url+'/action/withdraw-disapprove',
            headers: {
                'X-CSRF-TOKEN': $('meta[name=token]').attr('content')
            },
            data: {
               '_token': token,
                'id'    : id,
            },
            cache:false,     
            success: function(response) {   
              $(".actionBtn_"+id).hide();
              $('.loader-wrapper').remove();
              Swal.fire(
                'Done!',
                'Your withdrawal has been disapproved.',
                'success',
              )
            }
        });
  
      }
    })
  }

  /*
|--------------------------------------------------------------------------
| Disapprove purchase
|--------------------------------------------------------------------------
*/

  function disapprovePurchase(id){

    Swal.fire({
      title: 'Are you sure?',
      text: "Do you want disapprove?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes!'
    }).then((result) => {
      if (result.isConfirmed) {

        invokeLoader();

        var base_url = window.location.origin;
  
        $.ajax({  
            type: "POST",
            url: base_url+'/action/purchases-disapprove',
            headers: {
                'X-CSRF-TOKEN': $('meta[name=token]').attr('content')
            },
            data: {
               '_token': token,
                'id'    : id,
            },
            cache:false,     
            success: function(response) {   
              $(".actionBtn_"+id).hide();
              $('.loader-wrapper').remove();
              Swal.fire(
                'Done!',
                'Your purchases has been disapproved.',
                'success',
              )
            }
        });
  
      }
    })
  }

  /*
|--------------------------------------------------------------------------
| Disapprove kyc
|--------------------------------------------------------------------------
*/

  function disapproveKyc(id){

    Swal.fire({
      title: 'Are you sure?',
      text: "Do you want disapprove?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes!'
    }).then((result) => {
      if (result.isConfirmed) {

        invokeLoader();

        var base_url = window.location.origin;
  
        $.ajax({  
            type: "POST",
            url: base_url+'/action/kyc-disapprove',
            headers: {
                'X-CSRF-TOKEN': $('meta[name=token]').attr('content')
            },
            data: {
               '_token': token,
                'id'    : id,
            },
            cache:false,     
            success: function(response) {   
              $(".actionBtn_"+id).hide();
              $('.loader-wrapper').remove();
              Swal.fire(
                'Done!',
                'Your KYC has been disapproved.',
                'success',
              )
            }
        });
  
      }
    })
  }
  


  
  function showKycModal(ele){

    var kyc_data = JSON.parse($(ele).attr("data-parent"));
   
   
      $('#kyc_name').html(kyc_data.full_name);
      $('#kyc_email').html(kyc_data.email);
      $('#kyc_number').html(kyc_data.phone_number);
      $('#kyc_address').html(kyc_data.address);
      $('#kyc_country').html(kyc_data.get_country.name);

      var base_url = 'https://mytrader.biz';
      var selfie_image      = base_url+'/image/'+kyc_data.get_selfie_image.image_name;
      var get_front_image   = base_url+'/image/'+kyc_data.get_front_image.image_name;
    
      if(kyc_data.identity_doc_type !== null){

        if(kyc_data.identity_doc_type == 3){
              $('#proof_image').html('<div class="col-md-4">\
              <a href="'+selfie_image+'" data-fancybox="proof_document">\
                  <img src='+selfie_image+' alt="" class="img-fluid">\
                </a>\
            </div>\
            <div class="col-md-4">\
                <a href="'+get_front_image+'" data-fancybox="proof_document">\
                    <img src='+get_front_image+' alt="" class="img-fluid">\
                </a>\
            </div>'
            );
        }else{
          var get_back_image    = base_url+'/image/'+kyc_data.get_back_image.image_name;
          $('#proof_image').html('<div class="col-md-4">\
          <a href="'+selfie_image+'" data-fancybox="proof_document">\
              <img src='+selfie_image+' alt="" class="img-fluid">\
          </a>\
            </div>\
            <div class="col-md-4">\
                <a href="'+get_front_image+'" data-fancybox="proof_document">\
                    <img src='+get_front_image+' alt="" class="img-fluid">\
                </a>\
            </div>\
            <div class="col-md-4">\
                <a href="'+get_back_image+'" data-fancybox="proof_document">\
                    <img src='+get_back_image+' alt="" class="img-fluid">\
                </a>\
            </div>'
          );
        }
    }else{
      $('#proof_image').html('<span class="logo-sm"></span>');
    }
    
    $('#kycModal').modal('show');
  }

/*
|--------------------------------------------------------------------------
| Approve Purchase
|--------------------------------------------------------------------------
*/
    function approveFundingPurchase(id){

      Swal.fire({
        title: 'Are you sure?',
        text: "Do you want approve?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
      }).then((result) => {
        if (result.isConfirmed) {
  
          invokeLoader();
  
          var base_url = window.location.origin;
    
          $.ajax({  
              type: "POST",
              url: base_url+'/action/approve-funding',
              headers: {
                  'X-CSRF-TOKEN': $('meta[name=token]').attr('content')
              },
              data: {
                 '_token': token,
                  'funding_payment'    : id,
              },
              cache:false,     
              success: function(response) { 
                console.log(response)  
                $(".actionBtn_"+id).hide();
                $('.loader-wrapper').remove();
                Swal.fire(
                  'Done!',
                  'Your purchase has been approved.',
                  'success',
                )
              }
          });
    
        }
      })
    }
  
/*
|--------------------------------------------------------------------------
| Approve Kyc
|--------------------------------------------------------------------------
*/

function approveKyc(id){

  Swal.fire({
    title: 'Are you sure?',
    text: "Do you want approve?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes!'
  }).then((result) => {
    if (result.isConfirmed) {

      invokeLoader();

      var base_url = window.location.origin;

      $.ajax({  
          type: "POST",
          url: base_url+'/action/kyc-approve',
          headers: {
              'X-CSRF-TOKEN': $('meta[name=token]').attr('content')
          },
          data: {
             '_token': token,
              'id'    : id,
          },
          cache:false,     
          success: function(response) {   
            $(".actionBtn_"+id).hide();
            $('.loader-wrapper').remove();
            Swal.fire(
              'Done!',
              'Your KYC has been approved.',
              'success',
            )
          }
      });

    }
  })
}

/*
|--------------------------------------------------------------------------
| Approve Kyc
|--------------------------------------------------------------------------
*/

function approvewithdraw(id){

  Swal.fire({
    title: 'Are you sure?',
    text: "Do you want approve?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes!'
  }).then((result) => {
    if (result.isConfirmed) {

      invokeLoader();

      var base_url = window.location.origin;

      $.ajax({  
          type: "POST",
          url: base_url+'/action/withdrawal-approve',
          headers: {
              'X-CSRF-TOKEN': $('meta[name=token]').attr('content')
          },
          data: {
             '_token': token,
              'id'    : id,
          },
          cache:false,     
          success: function(response) {   

            console.log(response)
            $(".actionBtn_"+id).hide();
            $('.loader-wrapper').remove();
            Swal.fire(
              'Done!',
              'Your withdrawal has been approved.',
              'success',
            )
          }
      });

    }
  })
}
  
// show pending purchase modal
function showPurchaseModal(ele){

  var base_url = 'https://mytrader.biz';
  var top_up_data = JSON.parse($(ele).attr("data-parent"));
  //console.log(top_up_data);
  //var top_up_data = funding_payments[index];
 

  if(top_up_data.payment_proof !== null){
    var file_name = top_up_data.get_image.image_name;
    var $img = base_url+'/image/'+file_name;
  $('#proof_image').html('<span class="logo-sm"><img  src='+$img+' class="img-fluid" height="300" alt="Proof Image"></span>');
  
}else{
  $('#proof_image').html('<span class="logo-sm"></span>');
}
$('#fundingModal').modal('show');
}

  /*
 |--------------------------------------------------------------------------
 | Invoke Loader
 |--------------------------------------------------------------------------
 */ 
 function invokeLoader(){
  if($('.loader-wrapper').length=='0'){
  var svg = '<div class="loader-wrapper" ><?xml version="1.0" encoding="utf-8"?><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" style="margin: auto; background: none; display: block; shape-rendering: auto;" width="100px" height="100px" viewBox="0 0 100 100" preserveAspectRatio="xMidYMid"><g transform="translate(50 50)"><g><animateTransform attributeName="transform" type="rotate" values="0;45" keyTimes="0;1" dur="0.2s" repeatCount="indefinite"></animateTransform><path d="M29.491524206117255 -5.5 L37.491524206117255 -5.5 L37.491524206117255 5.5 L29.491524206117255 5.5 A30 30 0 0 1 24.742744050198738 16.964569457146712 L24.742744050198738 16.964569457146712 L30.399598299691117 22.621423706639092 L22.621423706639096 30.399598299691114 L16.964569457146716 24.742744050198734 A30 30 0 0 1 5.5 29.491524206117255 L5.5 29.491524206117255 L5.5 37.491524206117255 L-5.499999999999997 37.491524206117255 L-5.499999999999997 29.491524206117255 A30 30 0 0 1 -16.964569457146705 24.742744050198738 L-16.964569457146705 24.742744050198738 L-22.621423706639085 30.399598299691117 L-30.399598299691117 22.621423706639092 L-24.742744050198738 16.964569457146712 A30 30 0 0 1 -29.491524206117255 5.500000000000009 L-29.491524206117255 5.500000000000009 L-37.491524206117255 5.50000000000001 L-37.491524206117255 -5.500000000000001 L-29.491524206117255 -5.500000000000002 A30 30 0 0 1 -24.742744050198738 -16.964569457146705 L-24.742744050198738 -16.964569457146705 L-30.399598299691117 -22.621423706639085 L-22.621423706639092 -30.399598299691117 L-16.964569457146712 -24.742744050198738 A30 30 0 0 1 -5.500000000000011 -29.491524206117255 L-5.500000000000011 -29.491524206117255 L-5.500000000000012 -37.491524206117255 L5.499999999999998 -37.491524206117255 L5.5 -29.491524206117255 A30 30 0 0 1 16.964569457146702 -24.74274405019874 L16.964569457146702 -24.74274405019874 L22.62142370663908 -30.39959829969112 L30.399598299691117 -22.6214237066391 L24.742744050198738 -16.964569457146716 A30 30 0 0 1 29.491524206117255 -5.500000000000013 M0 -20A20 20 0 1 0 0 20 A20 20 0 1 0 0 -20" fill="#bababa"></path></g></g></svg></div>';
  $(svg).appendTo('body');
  }
}