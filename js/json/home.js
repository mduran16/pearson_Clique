$.ajax({
  url: "http://clique.raspi.pw/cbe/index.php/courses",
  type: "GET",
}).success(function(response) {
	var response = $.parseJSON(response);
	var r = new Array(), j = -1;
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
 	$('#courseTable').html(r.join('')); 
	
});

$.ajax({
  url: "http://clique.raspi.pw/cbe/index.php/clique?getUserCliques=true",
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