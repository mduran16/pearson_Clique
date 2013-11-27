/*
courses table
*/
$.ajax({
  url: "http://clique.raspi.pw/cbe/index.php/courses",
  type: "GET",
}).success(function(response) {
	var response = $.parseJSON(response);
	var r = new Array(), j = -1;

	if(response.courses.length > 0){
	 	for (var key=0, size=response.courses.length; key<size; key++){

	 		for (var course in response.courses[key]){
	 			if(j==-1)
	 				r[++j] = '<tr class="first">'
	 			else
	 				r[++j] = '<tr>'
		 		r[++j] ='<td><h4><a href="javascript:;" onclick="changepage(\'course.html\',\'' + response.courses[key][course]["details"]["id"] + '\')">';
			    r[++j] = response.courses[key][course]["details"]["displayCourseCode"] + ": " + response.courses[key][course]["details"]["title"];
			    r[++j] = '</a></h4></td><td><h4>';
			    r[++j] = response.courses[key][course]["instructor"]["firstName"] + " " + response.courses[key][course]["instructor"]["lastName"];
			    r[++j] = '</h4></td><td><h4>';
			    r[++j] = response.courses[key][course]["ta"]["firstName"] + " " + response.courses[key][course]["ta"]["lastName"];
			    r[++j] = '</h4></td></tr>';
	 		}
	 	}
	}
	else{
		r[++j] = '<tr class="first"><td><h4>You aren\'t registered to any classes.</h4></td></tr>'
	}
 	$('#courseTable').html(r.join('')); 
	
});

/*
cliques table
*/
$.ajax({
  url: "http://clique.raspi.pw/cbe/index.php/clique?getUserCliques=true",
  type: "GET",
}).success(function(response) {
	var response = $.parseJSON(response);
	var r = new Array(), j = -1;
	if(response.length > 0){
	 	for (var i = 0, size=response.length; i<size; i++){
			if(j==-1)
				r[++j] = '<tr class="first">'
			else
				r[++j] = '<tr>'
			r[++j] ='<td><h4><a href="javascript:;" onclick="changepage(\'clique.html\',\'' + response[i]["cliqueID"] + '\')">';
			r[++j] = response[i]["cliqueName"];
			r[++j] = '</a></h4></td>';
			r[++j] = '</tr>';
	 	}
 	}
 	else{
 		r[++j] = '<tr class="first"><td><h4>You have yet to join any Cliques</h4></td></tr>'
 	}
 	$('#cliqueTable').html(r.join('')); 
});



/*
Messages Table
*/
$.ajax({
  url: "http://clique.raspi.pw/cbe/index.php/thread?getThreads=true",
  type: "GET",
}).success(function(response) {
	var response = $.parseJSON(response);
	var userID = $('#userdata').attr('userid')
	var r = new Array(), j = -1;
	if(response.length > 0){
	 	for (var i=0, size=response.length; i<size; i++){
 			if(j==-1)
 				r[++j] = '<tr class="first">'
 			else
 				r[++j] = '<tr>'
 			if(response[i]['senderID'] == userID)
	 			r[++j] ='<td><h4><a href="javascript:;" onclick="changepage(\'thread.html\',\'' + response[i]['recipientID'] + '\')">';
	 		else
	 			r[++j] ='<td><h4><a href="javascript:;" onclick="changepage(\'thread.html\',\'' + response[i]['senderID'] + '\')">';
		    r[++j] = response[i]['username'];
		    r[++j] = '</a></h4></td><td><h4>';
		    r[++j] = response[i]['messageDate'];
		    r[++j] = '</h4></td><td><h4>';
		    r[++j] = response[i]['content'];
		    r[++j] = '</h4></td></tr>';
		}
	 }
	 else{
	 	r[++j] = '<tr class="first"><td><h4>No new messages to report</h4></td></tr>'
	 }
 	$('#messageTable').html(r.join('')); 
	
});



/*
Notifications Table
*/
$.ajax({
  url: "http://clique.raspi.pw/cbe/index.php/thread?getInvites=true",
  type: "GET",
}).success(function(response) {
	var response = $.parseJSON(response);
	var r = new Array(), j = -1;
	if(response.length > 0){
	 	for (var i=0, size=response.length; i<size; i++){
	 		console.log(response[i]['messageID'])
			if(j==-1)
				r[++j] = '<tr class="first">'
			else
				r[++j] = '<tr>'
			if(response[i]['isInvite'] == 1){
				r[++j] = '<td><div class="btn-group settings"><button class="btn glow dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button><ul class="dropdown-menu"><li><a href="javascript:;" onclick="acceptInvite('+response[i]['messageID']+')">Accept</a></li><li><a href="javascript:;">Decline</a></li></ul></div></td>'
				r[++j] = '<td>'
				r[++j] = '<h4><a href="javascript:;">'
				r[++j] = response[i]['username']
				r[++j] = '</a>&nbsp; has sent you an invite join to&nbsp;<a href="javscript:;">'
				r[++j] = response[i]['content']
				r[++j] = '</a>'
				r[++j] = '</h4></td>'
			}
	    	r[++j] = '</tr>';
	 	}
 	}
 	else{
	 	r[++j] = '<tr class="first"><td><h4>No notifications</h4></td></tr>'
 	}
 	$('#notificationsTable').html(r.join('')); 
	
});


function acceptInvite(messageID){
	$.ajax({
		url: "http://clique.raspi.pw/cbe/index.php/thread?acceptInvite=true&messageID=" + messageID,
	})
}

function declineInvite(){
	return true;
}
