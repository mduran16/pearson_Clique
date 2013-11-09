$.ajax({
  url: "http://clique.raspi.pw/cbe/index.php/courses",
  type: "GET",
}).success(function(response) {
	var response = $.parseJSON(response);
	var r = new Array(), j = -1;

 	for (var key=0, size=response.courses.length; key<size; key++){
 		//alert(JSON.stringify(response.courses[key]["details"]))
	    r[++j] ='<tr><td><h4><a href="javascript:;" onclick="changepage(\'course.html\',\'' + response.courses[key]["details"]["id"] + '\')">';
	    r[++j] = response.courses[key]["details"]["displayCourseCode"] + ": " + response.courses[key]["details"]["title"];
	    r[++j] = '</a></h4></td><td><h4>';
	    r[++j] = response.courses[key]["instructor"]["firstName"] + " " + response.courses[key]["instructor"]["lastName"];
	    r[++j] = '</h4></td><td><h4>';
	    r[++j] = response.courses[key]["ta"]["firstName"] + " " + response.courses[key]["ta"]["lastName"];
	    r[++j] = '</h4></td></tr>';
 	}
 	$('#courseTable').html(r.join('')); 
	
});