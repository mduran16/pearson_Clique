refreshMessages();

function threadSendMessage(recipientID,message){
	$.ajax({
		url: "http://clique.raspi.pw/cbe/index.php/thread?sendMessage=true&recieverID="+ recipientID + "&message=" + escape(message),
	})
	$('#messageContainer').html('');
	refreshMessages();
}




function getJsTimestamp( timeString ) {
    // split the mssql timestamp, and return it so that we 
    // can create a date in javascript
    var arrMssqldate = timeString.split( ' ' );
    var arrDate = arrMssqldate[0].split( '-', 3 );
    var arrTime = arrMssqldate[1].split( ':', 2);

    var timeObject = new Object;
    timeObject.year = arrDate[0];
    timeObject.month = arrDate[1]-1;
    timeObject.day = arrDate[2];
    timeObject.hour = arrTime[0];
    timeObject.minute = arrTime[1];
    timeObject.second = '00';
    
    return timeObject;
}

function refreshMessages(){
	$.ajax({
  		url: "http://clique.raspi.pw/cbe/index.php/thread?getConversation=true&otherID=" + $("#content").attr("ref"),
  		type: "GET",
  		cache: false,
	}).success(function(response) {
		//console.log('http://clique.raspi.pw/cbe/index.php/thread?getConversation=true&otherID=' + $("#content").attr("ref"))
		var response = $.parseJSON(response);
		//console.log(JSON.stringify(response))
		var r = new Array(), j = -1;
	 	for (var i=0, size=response.length; i<size; i++){
	 		//r[++j] =
	 		if(response[i].isInvite == 0){
		 		r[++j] = '<div class="col-md-12"><div class="panel panel-grey"><div class="panel-heading"><h3 class="panel-title"><i class="icon-tasks"></i>&nbsp;';
		 		r[++j] = response[i].username;
			    r[++j] = '</h3></div><div class="panel-body"><h6>';
			    var timeObject = getJsTimestamp(response[i].messageDate);
			    date=  new Date(timeObject.year, timeObject.month, timeObject.day, timeObject.hour, timeObject.minute, timeObject.second);
			    r[++j] = date.toString();
			    r[++j] = "</h6><p style='font-size:16px;'>"
			    r[++j] = response[i].content
			    r[++j] = '</p></div></div></div>';
			}
	 	}

	 	$('#messageContainer').html(r.join('')); 	
	});
}