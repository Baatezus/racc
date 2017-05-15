    function maxLengthCheck(input) {
        if (input.value.length > input.maxLength)
            input.value = input.value.slice(0, input.maxLength);
        
        if(input.value.length === input.maxLength) { 
            var str =  $(input).attr('id');
            var idName = str.substring(0, str.length - 1);
            var idNumber = str.substring(str.length - 1, str.length);
            var id = idName + (parseInt(idNumber) + 1);
            $('#' + id).focus();
        }
    }

    function show(div) {
        if(div === "national") {
            $('#nb_label').text('Numéro de registre national');
            
            $('#business_nb1').attr('id', 'national_nb1')
                    .attr('name', 'national_nb1')
                    .attr('maxlength', 6)
                    .css({
                        "width" : "120px"
                    });
                    
            $('#business_nb2').attr('id', 'national_nb2')
                    .attr('name', 'national_nb2')
                    .attr('maxlength', 3)
                    .css({
                        "width" : "60px"
                    });
                    
            $('#business_nb3').attr('id', 'national_nb3')
                    .attr('name', 'national_nb3')
                    .attr('maxlength', 2)
                    .css({
                        "width" : "40px"
                    });
        } else {
            $('#nb_label').text('Numéro d\'entreprise');
            
            $('#national_nb1').attr('id', 'business_nb1')
                    .attr('name', 'business_nb1')
                    .attr('maxlength', 4)
                    .css({
                        "width" : "80px"
                    });
                    
            $('#national_nb2').attr('id', 'business_nb2')
                    .attr('name', 'business_nb2')
                    .attr('maxlength', 3)
                    .css({
                        "width" : "60px"
                    });
                    
            $('#national_nb3').attr('id', 'business_nb3')
                    .attr('name', 'business_nb3')
                    .attr('maxlength', 3)
                    .css({
                        "width" : "60px"
                    });            
        }
    }