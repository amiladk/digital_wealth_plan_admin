
$(document).ready(function() {
    $('#country').val(client.get_country.name);
});

function showAlert(title,msg,type) {
    Swal.fire({
      title: title,
      text: msg,
      icon: type,
      confirmButtonColor: '#3085d6',
      confirmButtonText: 'Ok'
    })
}

$('#change_email').change(function(){
  $('#readOnlyDiv').find(':input').prop('readonly',!this.checked);
});

$('#change_login_details').change(function(){
  $('#disableDiv').find(':input').prop('disabled',!this.checked);
});


// country select
        
mobiscroll.setOptions({
    locale: mobiscroll.localeEn,   // Specify language like: locale: mobiscroll.localePl or omit setting to use default
    theme: 'ios',                  // Specify theme like: theme: 'ios' or omit setting to use default
    themeVariant: 'light'          // More info about themeVariant: https://docs.mobiscroll.com/5-20-0/javascript/select#opt-themeVariant
});

var inst = mobiscroll.select('#country', {
    display: 'anchored',           // Specify display mode like: display: 'bottom' or omit setting to use default
    filter: true,                  // More info about filter: https://docs.mobiscroll.com/5-20-0/javascript/select#opt-filter
    itemHeight: 40,                // More info about itemHeight: https://docs.mobiscroll.com/5-20-0/javascript/select#opt-itemHeight
    renderItem: function (item) {  // More info about renderItem: https://docs.mobiscroll.com/5-20-0/javascript/select#opt-renderItem
        return '<div class="md-country-picker-item">' +
            '<img class="md-country-picker-flag" src="https://img.mobiscroll.com/demos/flags/' + item.data.value + '.png" />' +
            item.display + '</div>';
    }
});

mobiscroll.util.http.getJson('https://trial.mobiscroll.com/content/countries.json', function (resp) {
    var countries = [];
    for (var i = 0; i < resp.length; ++i) {
        var country = resp[i];
        countries.push({ text: country.text, value: country.value });
    }
    inst.setOptions({ data: countries });
    countries.push({ text: 'Canada', value: 'CA' });//Adding Countries Not In the List
});



// phone number with country
  $('#phone').intlTelInput({
      autoHideDialCode: true,
      autoPlaceholder: "ON",
      dropdownContainer: document.body,
      formatOnDisplay: true,
      hiddenInput: "full_number",
      initialCountry: "auto",
      nationalMode: true,
      placeholderNumberType: "+91123456789",
      preferredCountries: ['US'],
      separateDialCode: true
  }).on('countrychange', function (e, countryData) {
      validatePhone();
  });

  $("#phone").keyup(function(){
      validatePhone();
  });

function validatePhone(){
  var country_code = $("#phone").intlTelInput("getSelectedCountryData").dialCode;
  var phoneNumber = $('#phone').val();
  if (phoneNumber.charAt( 0 ) == '0') {
      $('#phone').val(phoneNumber.substring(1));
  }
  if (!/^[0-9]{9,10}$/.test(phoneNumber)) {
      $("#phone_number_error").html("Please enter a valid phone number").addClass("required-color");
      $('#phone_number').val('')
      return false;
  }
  $("#phone_number_error").html("");
  var phone = '+' + country_code + phoneNumber;
  $('#phone_number').val(phone);
  return true;
}


// $("#phone").blur(function() {
//     var regexp = /^[\s()+-]*([0-9][\s()+-]*){6,20}$/
//     var no = $("#phone").val();
//     if (!regexp.test(no) && no.length < 0) {
//       alert("Wrong phone no");
//     }
//   });

// window.onload = function() {
//     var e = document.getElementById("edit-client-form"),
//         t = new Pristine(e);
//     e.addEventListener("submit", function(e) {
//         e.preventDefault();
//         t.validate()
//     });
// }