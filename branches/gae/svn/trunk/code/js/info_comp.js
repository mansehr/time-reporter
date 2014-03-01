
var report_id = 0;
function show_report(id) {
    report_id = id;
    var url = "request.php?function=report&id="+encodingUrl(id);
    competenceXhr = false;
    competenceXhr = callURL(url, eventhandler);
    if(!competenceXhr) {
        alert("Error, No answer from the server");
        return;
    }
}
	
function eventhandler(input) {
    var obj = getById('report'+report_id+'_text');
    obj.innerHTML = input;
    obj.style.display = 'block';
		
    var show_link = getById('report'+report_id+'_link');
    show_link.innerHTML = "Hide";
    show_link.href = "javascript:hide_report("+report_id+")";
}
	
function hide_report(id) {
    var show_link = getById('report'+id+'_link');
    show_link.innerHTML = "Show";
    show_link.href = "javascript:show_report("+id+")";
		
    var obj = getById('report'+id+'_text');
    obj.style.display = 'none';
}
