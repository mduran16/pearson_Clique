refreshQuestions();

function respondToQuestion(questionID,userID,message){
	$.ajax({
		url: "http://clique.raspi.pw/cbe/index.php/question?answerQuestion=true&userID=" + userID + "&questionID=" + questionID + "&content=" + message,
		cache: false,
	})
	$('#messageContainer').html('');
	refreshQuestions();
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

function refreshQuestions(){
	$.ajax({
  		url: "http://clique.raspi.pw/cbe/index.php/question?getQuestionThread=true&questionID=" + $("#content").attr("ref"),
  		type: "GET",
  		cache: false,
	}).success(function(response) {
		var response = $.parseJSON(response);
		//console.log(JSON.stringify(response))
		var r = new Array(), j = -1;
	 	for (var i=0, size=response.length; i<size; i++){
	 		//r[++j] =
	 		//if(response[i].isInvite == 0){
	 			//console.log(JSON.stringify(response[i]))
		 		r[++j] = '<div class="col-md-12"><div class="panel panel-grey"><div class="panel-heading"><h3 class="panel-title"><i class="icon-tasks"></i>&nbsp;';
		 		r[++j] = response[i].username;
			    r[++j] = '</h3></div><div class="panel-body"><h6>';
			    var timeObject = getJsTimestamp(response[i].questionDate);
			    date=  new Date(timeObject.year, timeObject.month, timeObject.day, timeObject.hour, timeObject.minute, timeObject.second);
			    r[++j] = date.toString();
			    r[++j] = "</h6><p style='font-size:16px;'>"
			    r[++j] = response[i].questionContent
			    r[++j] = '</p></div></div></div>';
			//}
	 	}

	 	$('#questionContainer').html(r.join('')); 	
	});
}