$('select').select2({ width: '100%', placeholder: "Select Client", allowClear: true });

flatpickr("#date-range", {
    mode: "range",
});

$("#client").change(function(){
    setUrl();
});

$("#date-range").change(function(){
    client      = $("#client").val();
    data_range  = $("#date-range").val(); 
    var result  = data_range.split(' to ');
    from_date   = result[0];
    to_date     = result[1];

    if (data_range == null || data_range == '') {
        if(client != ''){
            setUrl();
        }
    }

    if (typeof(from_date) != "undefined" && typeof(to_date) != "undefined"){
        if(client != ''){
            setUrl();
        }
    }else{
        if (typeof(to_date) != "undefined") {
            if(client != ''){
                setUrl();
            }
        }
    }
});

  function setUrl() {
    var base_url = window.location.origin;
    data_range = $("#date-range").val(); 
    client = $("#client").val();
    var result = data_range.split(' to ');
    from_date = result[0];
    to_date = result[1];

    if (data_range != null || data_range != '') {
        if (from_date != null && to_date != null) {
            var url = base_url+'/client-report/'+'?start_date='+from_date+'&&end_date='+to_date+'&&'+'client='+client; 
            location.replace(url);
        }else{
            if(client != ''){
                var url = base_url+'/client-report/'+'?client='+client; 
                location.replace(url);
            }
        }    
    }else{
        if(client != ''){
            var url = base_url+'/client-report/'+'?client='+client; 
            location.replace(url);
        } 
    }  
    
}
