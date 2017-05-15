function checkFrm(frm) {
    var $selects = $('.required_select');
    var $inputs = $('.required');
    var $filmValues = $('.required-film-value');
    var checked = true;
    var selected_film = true;
    var nbRegex = /[a-z]|[A-Z]|[<>ÀÁÂÃÄÅâàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ&"#'{(\[-|`_\\^@)\]=\+}$\*:;,.?!%£¨^`]/;
    var IBANRegex = /BE[0-9]{2}-[0-9]{4}-[0-9]{4}-[0-9]{4}/;
    var nationalNbRegex = /[0-9]{2}.[0-9]{2}.[0-9]{2}-[0-9]{3}.[0-9]{2}/;
    var businessNbRegex = /[0-9]{4}.[0-9]{3}.[0-9]{3}/;
    var $message_list = $("<ul></ul>");
    
    $message_list.css({
        "font-size" : "1.3em",
        "text-align" : "center",
        "list-style-type" : "none",
        "color" : "orange"
    });
    
    function addMessage(message) {
        var $p = $('<p></p>');
        
        $p.html(message);
        
        $p.addClass('message issue');
        
        $message_list.append($p);      
    };

    $('#saisie').css({"background" : "white", "color" : "black"});
    $inputs.css({"background" : "white", "color" : "black"});
    $selects.css({"background" : "white", "color" : "black"});
    $(frm.phone_nb).css({"background" : "white", "color" : "black"});
    $(frm.business_nb).css({"background" : "white", "color" : "black"});
    $(frm.national_nb).css({"background" : "white", "color" : "black"});

    for (var i = 0; i < $filmValues.length; i++)
        selected_film = $filmValues.eq(i).val().length > 0;

    for (var i = 0; i < $inputs.length; i++) {
        if ($inputs.eq(i).val().length <= 0) {
            $inputs.eq(i).css({"background" : "rgb(255, 159, 64)", "color" : "white"});
            checked = false;
        }
    }
    
    if (!checked) { 
        addMessage('Tous les champs doivent être complétés !');
    }
       
    for (var i = 0; i < $selects.length; i++) {
        if (!$selects.eq(i).val()){
            $selects.eq(i).css({"background" : "rgb(255, 159, 64)", "color" : "white"});
            checked = false;
        }
    }
    
    if(!selected_film) { 
        addMessage('Aucun film sélectionné !');
        
        $('#saisie').css({"background" : "rgba(255, 159, 64, 0.2)", "color" : "white"});
        
        selected_film = false;
    }
            
    if(nbRegex.test(frm.phone_nb.value)) {
        addMessage('Le numéro de téléphone contient des caractères non admis !');

        $(frm.phone_nb).css({"background" : "rgb(255, 159, 64)", "color" : "white"});
        
        checked = false;
    }
       
    if($('.unchecked').length > 0) {
        addMessage("Aucun type d'association choisie !");
        
        $('.chk-txt').css({"color" : "red"});
        
        checked = false;
    }
   
     /*   
    if(frm.account_nb.value.length > 0 && !IBANRegex.test(frm.account_nb.value)) {
        addMessage("Le format du compte IBAN ne correspond pas, veuillez l'encoder selon le format suivant: <br /> BExx-xxxx-xxxx-xxxx");

        $(frm.account_nb).css({"background" : "rgb(255, 159, 64)", "color" : "white"});
        
        checked = false;
    }
    */
    if(frm.national_nb && frm.national_nb.value.length > 0 && !nationalNbRegex.test(frm.national_nb.value)) {
        addMessage("Le format du numéro de registre national ne correspond pas, veuillez l'encoder selon le format suivant: <br /> XX.XX.XX-XXX.XX");
        
       $(frm.national_nb).css({"background" : "rgb(255, 159, 64)", "color" : "white"});
        
        checked = false;           
    }
    
    if(frm.business_nb && frm.business_nb.value.length > 0 && !businessNbRegex.test(frm.business_nb.value)){
        addMessage("Le format du numéro du numéro d'entreprise ne correspond pas, veuillez l'encoder selon le format suivant: <br /> XXXX.XXX.XXX");
        
        $(frm.business_nb).css({"background" : "rgb(255, 159, 64)", "color" : "white"});
        
        checked = false; 
    }
    
    $('html, body').animate({
        scrollTop: $("#navbar").offset().top
    }, 200);  
    
    if(!checked || !selected_film) {
        $('#message_container').children().remove();      
        $('#message_container').append($message_list);
    } else {
        $('.cover-div').show();
        $('#confirm_div').fadeIn(600);
        $(frm).attr('onsubmit', "");
    }
    
    return false;
}
