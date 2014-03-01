
function validate(form){
    var form_array = form.getElementsByTagName('input');
	
    var valid = true;
    for (var i = 0; i < form_array.length; i++)
    {
        var error_str;
        if(error_str = getById(form_array[i].name+"_error")) {
            var ok = true;
            if(form_array[i].type == "radio") {
                if(form_array[i].checked != true) {
                    error_str.innerHTML = "You have to choose at least one alternative!";
                    valid = false;
                    ok = false;
                }
            } else if (form_array[i].type == "text") {
                if (form_array[i].value == "")	{
                    error_str.innerHTML = "The text field above must not be empty";
                    valid = false;
                    ok = false;
                }
            }
			
            if(ok) {
                error_str.innerHTML ="";
            }
        }
    }
    return valid;
}