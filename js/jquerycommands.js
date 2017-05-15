$(function(){
    $('input').keydown(function(){
        $(this).css({"background" : "white", "color" : "black"});
    })
    
    $('.okBtn').click(function(){
        //alert('Yo!');
    });
    
    $('.cancelBtn').click(function(){
        
        console.log($('#main_form').attr('onsubmit'));
        $('.cover-div').hide();
        $('#confirm_div').hide();  
        $('#main_form').attr('onsubmit', "return checkFrm(this)");
        console.log($('#main_form').attr('onsubmit'));
    });
    
    $('.pagination-nb').click(function(){
       console.log(this); 
    });
    
    $('.film-format').click(function() {
       alert('yo'); 
    });
});

$(document).ready(function() {
    $('select').material_select();
    $('.modal').modal();
    $(".button-collapse").sideNav();
});
