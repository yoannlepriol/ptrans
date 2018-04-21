$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID
    
    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><input type="text" name="mytext[]"/><a href="#" class="remove_field">Supprimer</a></div>'); //add input box
        }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
	
	
	
		
	
	////////////////////////////////////
	
	$("input[name='type_question']").click(function(){
		
		if($('input:radio[name=type_question]:checked').val() == "choix_multiple"){
			$('#choix_multiple').css('display', 'block');
			$('#echelle').css('display', 'none');			
		}
		
		else if($('input:radio[name=type_question]:checked').val() == "choix_simple"){
			$('#choix_multiple').css('display', 'block');
			$('#echelle').css('display', 'none');
		}
		
		else if($('input:radio[name=type_question]:checked').val() == "champ_texte"){
			$('#choix_multiple').css('display', 'none');
			$('#echelle').css('display', 'none');
		}
		
		else if($('input:radio[name=type_question]:checked').val() == "champ_numerique"){
			$('#choix_multiple').css('display', 'none');
			$('#echelle').css('display', 'none');
		}
		
		else if($('input:radio[name=type_question]:checked').val() == "echelle"){
			$('#choix_multiple').css('display', 'none');
			$('#echelle').css('display', 'block');
		}
	});
	
});
