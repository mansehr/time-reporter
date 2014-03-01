
/* 
    - url: the url adress (http://www.eample.com/?q=abc)
    - eventhandler: name of the function that will handle the response

Use the ajax functions as this example:
    competenceXhr = false;
    competenceXhr = callURL(url, eventhandler);
    if(!competenceXhr) {
            // Error handling
            alert("Error, no answer from the server ");
    }

    function eventhandler(input) {

    }
*/


function getById(id) {
    var obj = document.getElementById(id);
    if(obj == null) {
        obj = document.getElementsByName(id)[0];
        if(obj == null) {
            // Debug error handling
            //alert('Javascriptet couldn\'t find the element with id: '+id);
            return null;
        }
    }
    return obj;
}

function callURL(url, eventhandler) {
    xhr = createRequest();
    if(xhr) {
        xhr.onreadystatechange = function() {
            if(xhr.readyState == 4) {
                if(xhr.status == 200) {
                    eventhandler(xhr.responseText);
                } else {
                    var text = "Ajax Error! readyState: "+xhr.readyState+", status: "+xhr.status;
                    switch(xhr.status) {
                        case 12007:
                            text = "Request timeout. Try again in a few moments.";
                        case 404:
                            text = "Didn't find the requested document: "+url;
                    }
                    display_ajax_info(text);
                }
            }
        };
        xhr.open("GET", url, true);
        xhr.send(null);
    }
    return xhr;
}

// Request calls request.php with specified parameters
function request(type, name) {
    if(name.length >= 2) {
        var url = "request.php?function="+type+"_list&name="+encodingUrl(name);
        competenceXhr = false;
        competenceXhr = callURL(url, eventhandler);
        if(!competenceXhr) {
            alert("Error, no answer from the server. ");
            return;
        }
    }
}


/* EncodeUrl - prepares the input string to be transmitted correctly by an url,
   necessary only for the GET parameters */
function encodingUrl(input)
{
    var encoded = escape(input);
    encoded =encoded.replace("+", "%2B");
    encoded =encoded.replace("/", "%2F");
    return encoded;
}


function createRequest() {
    if(window.XMLHttpRequest) {
        return new XMLHttpRequest();
    } else if(window.ActiveXObject) {
        try {
            return new ActiveXObject("Microsoft.XMLHTTP");
        } catch(e) {}
    }
    return false;
}

function display_ajax_info(info) {
    var obj = getById('ajax_error_text');
    obj.innerHTML = info;
    obj.style.display = "block";
    setTimeout("hide_ajax_info()",50000)
}

function hide_ajax_info() {
    var obj = getById('ajax_error_text');
    obj.style.display = "none";
    obj.innerHTML = "";
}

function focusLogin() {
    getById('username').focus();
}