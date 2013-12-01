/*
Course header info query
*/
$.ajax({
  url: "http://clique.raspi.pw/cbe/index.php/courses",
  type: "GET",
  cache: false,
}).success(function(response) {
	var response = $.parseJSON(response);
	var r = new Array(), j = -1;

 	for (var key=0, size=response.courses.length; key<size; key++){

 		if(response.courses[key][$("#content").attr("ref")] != null){
			var course = $("#content").attr("ref");
			$("#course").html(response.courses[key][course]["details"]["displayCourseCode"] + ": " + response.courses[key][course]["details"]["title"])
			$("#instructor").append(response.courses[key][course]["instructor"]["firstName"] + " " + response.courses[key][course]["instructor"]["lastName"])
			$("#ta").append(response.courses[key][course]["ta"]["firstName"] + " " + response.courses[key][course]["ta"]["lastName"])
		}
 	}
});

/*
Course Roster Query
*/
$.ajax({
  url: "http://clique.raspi.pw/cbe/index.php/courses?id=" + $("#content").attr("ref") + "&classmates=true",
  type: "GET",
  cache: false,
}).success(function(response) {
	var response = $.parseJSON(response);
	userID = $('#userdata').attr('userID')
	var r = new Array(), j = -1;
	//console.log(JSON.stringify(response))
	if(response.length > 0){
	 	for (var i = 0, size=response.length; i<size; i++){
	 		if(response[i]["id"] == userID){
	 			$('#userdata').attr('courserole',response[i]["roleType"])
	 		}
			if(j==-1)
				r[++j] = '<tr class="first" '
			else
				r[++j] = '<tr '
			r[++j] = 'userid='
			r[++j] = response[i]["id"]
			r[++j] = "><td>"
			if($('#userdata').attr('courserole') != 'STUD' || $('#userdata').attr('userid') == response[i]['id']){
				r[++j] ='<a href="javascript:;" onclick="changepage(\'user-profile.html\',\''
				r[++j] = response[i]["id"]
				r[++j] = '\')">'
			}
			r[++j] = '<h5>';
			r[++j] = response[i]["loginId"]
			//r[++j] = response[i]["firstName"]
			//r[++j] = " "
			//r[++j] = response[i]["lastName"];
			r[++j] = '</h5></a></td>';

			if(response[i]["id"] != userID){
				r[++j] = '<td>'
				r[++j] = '<div class="btn-group settings"><button class="btn glow dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button><ul class="dropdown-menu"><li><a href="javascript:;" onclick="messageBox(' + i + ',$(this).closest(\'tr\').attr(\'userid\'))">Private Message</a></li>';
				
				if(response[i]["roleType"] == "STUD"){
					r[++j] = '<li><a href="javascript:;" onclick="inviteBox(' + i + ',$(this).closest(\'tr\').attr(\'userid\'))">Invite</a></li>';
				}
				r[++j] = '</ul></div>';
				r[++j] = "</td>"
			}
			else{
				r[++j] = "<td></td>"
			}

			
			if(response[i]["roleType"] == "STUD" && response[i]['id'] != userID){
				r[++j] = '<td><a class="btn-flat success" disabled>Student</a></td>'
			}
			else if(response[i]["roleType"] == "PROF" && response[i]['id'] != userID){
				r[++j] = '<td><a class="btn-flat danger" disabled>Professor</a></td>';
			}
			else if(response[i]["roleType"] == "TAST" && response[i]['id'] != userID){
				r[++j] = '<td><a class="btn-flat info " disabled>Assistant</a></td>';
			}
			else{
				r[++j] = '<td><a class="btn-flat primary" disabled>YOU</a></td>';
			}


			r[++j] = '</tr>';
	 	}
 	}
 	else{
 		r[++j] = '<tr class="first"><td><h4>It looks like theres been an error. Try logging out and logging back in.</h4></td></tr>'
 	}
 	$('#classmatesTable').html(r.join('')); 
});




/*
your cliques box
*/
if($('#userdata').attr('courserole') == 'PROF' || $('#userdata').attr('courserole') == 'TAST'){
	console.log("http://clique.raspi.pw/cbe/index.php/clique?getCourseCliques=true&parent=" + $("#content").attr("ref"))
	$.ajax({
	  url: "http://clique.raspi.pw/cbe/index.php/clique?getCourseCliques=true&parent=" + $("#content").attr("ref"),
	  type: "GET",
	  cache: false,
	}).success(function(response) {
		var response = $.parseJSON(response);
		//console.log(JSON.stringify(response));
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
}
else{
//console.log("http://clique.raspi.pw/cbe/index.php/clique?getUserCliques=true&parent=" + $("#content").attr("ref"))
	$.ajax({
	  url: "http://clique.raspi.pw/cbe/index.php/clique?getUserCliques=true&parent=" + $("#content").attr("ref"),
	  type: "GET",
	  cache: false,
	}).success(function(response) {
		var response = $.parseJSON(response);
		//console.log(JSON.stringify(response));
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
}



/*
invite box popup
*/
function inviteBox(index,userid){
	//alert(index)
	if(!($("#inviteBox").length) && !($("#messageBox").length)){
		

		var r = new Array(), j = -1;
		getCliqueList(function(response){
			var box='<div class="pop-dialog full" id="inviteBox" style="position:absolute;width:80%"><div class="pointer"><div class="arrow"></div><div class="arrow_border"></div></div><div class="body"><div class="settings"><a href="javascript:;" onclick="$(\'#inviteBox\').remove()" class="close-icon"><i class="icon-remove-sign"></i></a><div class="items"><div class="item"><div class="field-box"><div class="col-md-12" style="margin-bottom: 20px;"><input type="radio" name="choice" value="existing"checked>Select a Clique:&nbsp;<div class="ui-select"><select id="cliques" name="cliques">'

			for (var i = 0, size=response.length; i<size; i++){
				box += '<option value="' + response[i]['cliqueID'] + '">' + response[i]['cliqueName'] + "</option>"
			} 
			box += '</select></div></div></div><div class="field-box" style="margin-bottom: 20px;"><div class="col-md-12"><input name="choice" type="radio" value="new">New Clique: <input name="newname" class="form-control" type="text"></div></div><div class="col-md-12"> <a class="btn-flat success" onclick="sendInvite(' + userid + ');">SEND</a>&nbsp;&nbsp;<a class="btn-flat danger" onclick="$(\'#inviteBox\').remove()">CANCEL</a></div></div></div></div></div></div>'
		
			$('#classmatesTable tr:nth-child(' + (index + 1)+ ')').after(box);
		})

	}
	else{
		$("#inviteBox").remove()
		$("#messageBox").remove()
		inviteBox(index)
	}
}


/*
message box popup
*/
function messageBox(index,userid){
	//alert(index)
	if(!($("#messageBox").length) && !($("#inviteBox").length)){
		var box='<div class="pop-dialog full" id="messageBox" style="position:absolute;width:80%"><div class="pointer"><div class="arrow"></div><div class="arrow_border"></div></div><div class="body"><div class="settings"><a href="javascript:;" onclick="$(\'#messageBox\').remove()" class="close-icon"><i class="icon-remove-sign"></i></a><div class="items"><div class="item"><textarea id="messageField" style="width:100%;margin-bottom:10px" class="form-control" rows="4"></textarea><a class="btn-flat success" onclick="sendMessage($(\'#messageField\').val(),' + userid + ');">SEND</a>&nbsp;&nbsp;<a class="btn-flat danger" onclick="$(\'#messageBox\').remove()">CANCEL</a></div></div></div></div></div>'
		$('#classmatesTable tr:nth-child(' + (index + 1)+ ')').after(box);
	}
	else{
		$("#messageBox").remove()
		$("#inviteBox").remove()
		messageBox(index)
	}
}


/*
send message function
*/
function sendMessage(message,userID)
{	

	//console.log(message)
	//console.log(userID)
	$.ajax({
		url: "http://clique.raspi.pw/cbe/index.php/thread?sendMessage=true&recieverID="+ userID + "&message=" + escape(message),
		cache: false,
	})

	$('#messageBox').remove()
	return true;
}


function sendInvite(userID){
	if($("input[name='choice']:checked").val() == "existing"){
		$.ajax({
			url: "http://clique.raspi.pw/cbe/index.php/thread?sendInvite=true&recieverID="+userID+"&cliqueID="+$("#cliques").val(),
			cache: false,
			
		})
	}
	else{
		$.ajax({
			url: "http://clique.raspi.pw/cbe/index.php/thread?sendInvite=true&recieverID="+userID+"&cliqueID="+escape($("input[name='newname']").val()) + "_" + $("#content").attr("ref"),
			cache: false,
		})
	}

	$('#inviteBox').remove()
	return true;
}


/*
used to get a list of all cliques inside of an ajax callback
*/
function getCliqueList(callback){	
	$.ajax({
		url: "http://clique.raspi.pw/cbe/index.php/clique?getUserCliques=true&parent="+$("#content").attr("ref"),
		cache: false,
		type: "GET",
	}).success(function(response) {
		var response = $.parseJSON(response);
		callback(response)
	});
}