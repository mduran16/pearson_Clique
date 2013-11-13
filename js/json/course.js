$.ajax({
  url: "http://clique.raspi.pw/cbe/index.php/courses",
  type: "GET",
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


$.ajax({
  url: "http://clique.raspi.pw/cbe/index.php/courses?id=" + $("#content").attr("ref") + "&classmates=true",
  type: "GET",
}).success(function(response) {
	var response = $.parseJSON(response);

	var r = new Array(), j = -1;
	//console.log(JSON.stringify(response))
 	for (var i = 0, size=response.length; i<size; i++){
		if(j==-1)
			r[++j] = '<tr class="first">'
		else
			r[++j] = '<tr>'
		r[++j] ='<td><a href="javascript:;" onclick="changepage(\'user-profile.html\',\'' + response[i]["id"] + '\')"><h5>';
		r[++j] = response[i]["firstName"] + " " + response[i]["lastName"];
		r[++j] = '</h5></a></td>';
		r[++j] = '<td>';
		r[++j] = response[i]["personaId"];
		r[++j] = '</td>';
		if(response[i]["roleType"] == "STUD"){
			r[++j] = '<td><a class="btn-flat success" disabled>Student</a></td>'	
			r[++j] = '<td>'
			r[++j] = '<div class="btn-group settings"><button class="btn glow dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button><ul class="dropdown-menu"><li><a href="#">Invite</a></li><li><a href="#">Private Message</a></li><li></ul></div>';
			r[++j] = "</td>"
		}
		else if(response[i]["roleType"] == "PROF"){
			r[++j] = '<td><a class="btn-flat danger" disabled>Professor</a></td>';
			r[++j] = '<td>'
			r[++j] = '<div class="btn-group settings"><button class="btn glow dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button><ul class="dropdown-menu"><li><a href="#">Private Message</a></li><li></ul></div>';
			r[++j] = "</td>"
		}
		else if(response[i]["roleType"] == "TAST"){
			r[++j] = '<td><a class="btn-flat info " disabled>TA</a></td>';
			r[++j] = '<td>'
			r[++j] = '<div class="btn-group settings"><button class="btn glow dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button><ul class="dropdown-menu"><li><a href="#">Private Message</a></li><li></ul></div>';
			r[++j] = "</td>"
		}

		r[++j] = '</tr>';
 	}
 	$('#classmatesTable').html(r.join('')); 
});


$.ajax({
  url: "http://clique.raspi.pw/cbe/index.php/clique?getUserCliques=true&parent=" + $("#content").attr("ref"),
  type: "GET",
}).success(function(response) {
	var response = $.parseJSON(response);
	var r = new Array(), j = -1;
	//console.log(JSON.stringify(response))
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
 	$('#cliqueTable').html(r.join('')); 
});

