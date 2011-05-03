
var timer = 0;

function toggleClock() {
    var btn = getById('clock_btn');
    if(timer == 0) {
        timer = setTimeout("updatetime()", 1000);
        btn.value = "Stop timer";
    } else {
        clearTimeout(timer);
        btn.value = "Start timer";
        timer = 0;
    }
}

function updatetime() {
    timer = setTimeout("updatetime()", 1000);
    var obj = getById('duration');
    var secs = obj.value;
    secs = parseInt(secs);
    secs += 1;
    update_form(secs);
}

function update_form(secs) {
    var obj = getById('totalTime');
    obj.value = Math.round(secs/36)/100;
    var start_time = getById('starttime');
    var end_time = getById('endtime');
    var duration = getById('duration');
    duration.value = secs;
		
    var add_hour = Math.floor(secs/3600);
    secs = secs - add_hour*3600;
    var add_min = Math.floor(secs/60);
    var add_sec = secs%60;
	
    var time = start_time.value.split(':');
    time[0] = parseInt(time[0])+parseInt(add_hour);
    time[1] = parseInt(time[1])+parseInt(add_min);
    time[2] = parseInt(time[2])+parseInt(add_sec);
	
    if(time[2] >= 60) {
        time[1] += 1;
        time[2]	= time[2]%60;
    }
    if(time[1] >= 60) {
        time[0] += 1;
        time[1] = time[1]%60;
    }
	
    end_time.value = time[0]+":"+time[1]+":"+time[2];
}

function update_duration() {
    var tot_time = getById('totalTime');
    var start_time = getById('starttime');
    var end_time = getById('endtime');
    var secs = (get_seconds(end_time.value)-get_seconds(start_time.value));
    update_form(secs);
}

function get_seconds(time_str) {
    var time = time_str.split(":");
    var secs = parseInt(time[0])*3600;
    secs += parseInt(time[1])*60;
    secs += parseInt(time[2]);
    return secs;
}


function ping() {
    var url = "request.php?function=ping";
    competenceXhr = false;
    competenceXhr = callURL(url, eventhandler);
    if(!competenceXhr) {
        alert("Error, no answer from the server.");
        return;
    }
}

function eventhandler(input) {
;
}