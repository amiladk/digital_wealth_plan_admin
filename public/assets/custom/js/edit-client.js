$("#email").keyup(function(){
    $('#email-error').remove();
    var value = $(this).val();
    var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    if( !emailReg.test( value ) ) {
        $('.email').append('<div class="text-danger" id="email-error" text-help" style="">Enter Valid Email</div>');
    } else {
        getEmailForClientEdit();
    }
});
   
function getEmailForClientEdit(){
    var inputEmail = $('#email').val();
    var id = $('#id').val();
    $('#email-error').remove();
    $.ajax({
        method:"GET",
        url:"/ajax/email-client-edit",
        cache:false,
        async: false,
        headers: {
            'X-CSRF-TOKEN': token,
          
        },
        data:{
            "_token"          : token,
            'input_email'    : inputEmail,
            'id'       : id
           
        },

        success:function(data){
    
            if ((data.success == false)) {     
                $('.email').append('<div class="text-danger" id="email-error" text-help" style="">Email Already Taken</div>');
            }   
        },
        error: function (xhr, status, error) {  
        }
    });
   // return response;    
      
}

// window.onload = function() {
//     var e = document.getElementById("edit-client-form"),
//         t = new Pristine(e);
//     e.addEventListener("submit", function(e) {
//     e.preventDefault();
// t.validate()
// });
// }


$("#identity_doc_type").change(function(){
    var value = $(this).val();
    if(value == 1){
        identityHtml();
    }

    if(value == 2){
        driversLicenseHtml();
    }

    if(value == 3){
        passportHtml();
    }

});

function identityHtml(){
    $('#identity_doc_type_chooser_area').html('<div class="col-lg-6 mb-3">\
                                                <label class="form-label" for="default-input">Identity Front Image Upload <span class="required-color">*</span></label>\
                                                <div>\
                                                    <button id="upload-img-btn-1" onclick="showCropModal(1)" class="btn btn-primary" type="button">Upload Identity Front Image <span class="required-color">*</span> </button>\
                                                    <span id="upload-img-msg-1"></span>\
                                                </div>\
                                                <div id="result-row-1" class="mt-2" style="padding-right: 30px;">\
                                                </div>\
                                               </div>\
                                               <div class="col-lg-6 mb-3">\
                                               <label class="form-label" for="default-input">Identity Back Image Upload <span class="required-color">*</span></label>\
                                                <div>\
                                                    <button id="upload-img-btn-2" onclick="showCropModal(2)" class="btn btn-primary" type="button">Upload Identity Back Image <span class="required-color">*</span> </button>\
                                                    <span id="upload-img-msg-2"></span>\
                                                </div>\
                                                <div id="result-row-2" class="mt-2" style="padding-right: 30px;">\
                                                </div>\
                                               </div>'
                                               
                                               
                                               );
}


function driversLicenseHtml(){
    $('#identity_doc_type_chooser_area').html('<div class="col-lg-6 mb-3">\
                                                <label class="form-label" for="default-input">License Front Image Upload <span class="required-color">*</span></label>\
                                                <div>\
                                                    <button id="upload-img-btn-3" onclick="showCropModal(3)" class="btn btn-primary" type="button">Upload License Front Image <span class="required-color">*</span> </button>\
                                                    <span id="upload-img-msg-3"></span>\
                                                    <div id="result-row-3" class="mt-2" style="padding-right: 30px;">\
                                                </div>\
                                                </div>\
                                               </div>\
                                               <div class="col-lg-6 mb-3">\
                                               <label class="form-label" for="default-input">License Front Image Upload <span class="required-color">*</span></label>\
                                                <div>\
                                                 <button id="upload-img-btn-4" onclick="showCropModal(4)" class="btn btn-primary" type="button">Upload License Back Image <span class="required-color">*</span> </button>\
                                                 <span id="upload-img-msg-4"></span>\
                                                 <div id="result-row-4" class="mt-2" style="padding-right: 30px;">\
                                                </div>\
                                                </div>\
                                               </div>');
}

function passportHtml(){
    $('#identity_doc_type_chooser_area').html('<div class="col-lg-6 mb-3">\
                                            <label class="form-label" for="default-input">Passport Image Upload <span class="required-color">*</span></label>\
                                                <div>\
                                                <button id="upload-img-btn-5" onclick="showCropModal(5)" class="btn btn-primary" type="button">Upload Passport Image <span class="required-color">*</span> </button>\
                                                <span id="upload-img-msg-5"></span>\
                                                <div id="result-row-5" class="mt-2" style="padding-right: 30px;">\
                                                </div>\
                                                </div>\
                                              </div>');
}

function showCropModal(index){

    var title = '';
    if(index == 1){
        title = 'Identity Front Image';
    }

    if(index == 2){
        title = 'Identity Back Image';
    }

    if(index == 3){
        title = 'Drivers License Front Image';
    }

    if(index == 4){
        title = 'Drivers License Back Image';
    }

    if(index == 5){
        title = 'Passport Image';
    }

    if(index == 6){
        title = 'Selfie Image';
    }


    $('#image_crop_modal_title').html(title);
    $('#image_crop_modal_footer').html('<button type="button" class="btn btn-secondary" onclick="closeCrop()">Close</button>\
                                        <button type="button" class="btn btn-primary" onclick="cropImage('+index+');">Upload</button>');
    
    $('#image_crop_modal').modal('show');

}

    /*
    |--------------------------------------------------------------------------
    |Image cropper function
    |--------------------------------------------------------------------------
    */
    var  $model = $('#imagecrop');
    var  $image = document.getElementById('canvace_image');
    var  cropper;
    var  image_name = '';

$(document).on('change', '#image_chooser', function(e) {
    
    if(cropper){
        $image.src = null;
        cropper.destroy(),
        cropper = null;
    }

    var files = e.target.files;

    var done = function(url){
        $image.src = url;
        if($('#canvace_image').show()){cropperInitialize();}
        //cropBtnAreaIDFrontHtml();
    }

    var reader;
    var file;
    var url;

  if(files && files.length>0){
      file = files[0];
      image_name = file.name;
      if(URL){
        done(URL.createObjectURL(file));
      }else if(FileReader){
        reader =  new FileReade();
        reder.onload = function(e){
          done(reader.result);
        }
        reader.readAsDataURL(file);
      }
  }

});

function cropperInitialize(){
    cropper = new Cropper($image,{
        dragMode: 'move',
        // aspectRatio:1,
        // autoCropArea: 1,
        restore: false,
        guides: false,
        center: false,
        highlight: false,
        cropBoxMovable: true,
        cropBoxResizable: true,
        toggleDragModeOnDblclick: false,
        autoCropArea: 1
      

        // viewMode: 1,
        // aspectRatio: 1,
        // maxContainerWidth: 100,
        // maxContainerHeight: 100,
        // maxCropBoxWidth: 100,
        // maxCropBoxHeight: 100,
        // maxCanvasHeight:100,
        // maxCanvasWidth:100,
        // movable: true,
        // maxWidth:100,
        // maxHeight:100,
        // minCropBoxWidth: 100,
        // minCropBoxHeight: 100,
     });

    //  cropper.initialCanvasData.maxWidth = 100;
    // cropper.initialCanvasData.maxHeight = 100;

    
}

function closeCrop(){
    if(cropper){
        $image.src = null;
        cropper.destroy(),
        cropper = null;
    }
    image_name = '';
    $("#image_chooser" ).val(null);
    $('#canvace_image').hide();
    $('#crop-btn-area').html('');
    $('#image_crop_modal').modal('hide');
}



function cropImage(index){

    if($("#image_chooser").val()){

        canvas = cropper.getCroppedCanvas({
            width:350,
            height:350,
            });

        canvas.toBlob(function(blob){
            url = URL.createObjectURL(blob);
            reader = new FileReader();
            reader.readAsDataURL(blob);
            reader.onload = function(e){
                var base64data = reader.result;
                $model.modal('hide');
                sendFromData(base64data,index);
                var base64data = reader.result;    
            }

        });
    }
    
    else{
        Swal.fire('','image requierd','error');
    }

};


function sendFromData(base64data,index){

    var base_url            = window.location.origin;
    var identity_doc_type   = $('#identity_doc_type').val();
    var nic_no              = $('#nic_no').val();
    var id                  = $('#id').val();

    $.ajax({
        type: "POST",
        dataType: "json",
        url:  base_url+"/ajax/upload-kyc-crop-images",
        headers: {
                'X-CSRF-TOKEN': $('meta[name=token]').attr('content')
            },
        data: {
            '_token'            : token,
            'image'             : base64data,
            'index'             : index,
            'image_name'        : image_name,
            'identity_doc_type' : identity_doc_type,
            'id'                : id,
        },
        success: function(response){
            
            console.log(response);
          

            if(response.success==true){
                
                $('#proof_image-'+index).html('');
                $('#result-row-'+index).html('<img class="img-fluid pad" src="'+base64data+'" alt="">');
                 
                $('#upload-img-msg-'+index).html('<i id="upload-img-msg-fa-'+index+'" class="fa fa-check text-success" aria-hidden="true"></i>');
                $('#upload-img-btn-'+index).removeClass("is-invalid").addClass("is-valid");
                if (index==1) {
                    $('#upload-img-btn-'+index).html("Uploaded  Identity Front Image");  
                }
                if (index==2) {
                    $('#upload-img-btn-'+index).html("Uploaded Identity Back Image");  
                }
                if (index==3) {
                    $('#upload-img-btn-'+index).html("Uploaded License Front Image");  
                }
                if (index==4) {
                    $('#upload-img-btn-'+index).html("Uploaded  License Back Image");  
                }
                if (index==5) {
                    $('#upload-img-btn-'+index).html("Uploaded  Passport Image");  
                }
                if (index==6) {
                    $('#upload-img-btn-'+index).html("Uploaded Selfie Photo");  
                }
                 
                closeCrop();
                Swal.fire('Done','Image Uploaded','success');
            }
            else{
                closeCrop();
                Swal.fire('Opps',response.msg,'error');
            }
        
        }
        
    
    });

}

