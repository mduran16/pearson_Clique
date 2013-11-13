
$.ajax({
  url: "http://clique.raspi.pw/cbe/index.php/clique?getCliqueUsers=true&id=" + $("#content").attr("ref"),
  type: "GET",
}).success(function(response) {
	var response = $.parseJSON(response);

	var r = new Array(), j = -1;
	console.log(JSON.stringify(response))
 	for (var i = 0, size=response.length; i<size; i++){
		if(j==-1)
			r[++j] = '<tr class="first">'
		else
			r[++j] = '<tr>'
		r[++j] ='<td><a href="javascript:;" onclick="changepage(\'user-profile.html\',\'' + response[i]["id"] + '\')"><h5>';
		r[++j] = response[i]["username"];
		r[++j] = '</h5></a></td>';
		r[++j] = '<td><a class="btn-flat success" disabled>Student</a></td>'	
		r[++j] = '<td>'
		r[++j] = '<div class="btn-group settings"><button class="btn glow dropdown-toggle" data-toggle="dropdown"><span class="caret"></span></button><ul class="dropdown-menu"><li><a href="#">Invite</a></li><li><a href="#">Private Message</a></li><li></ul></div>';
		r[++j] = "</td>"
		r[++j] = '</tr>';
 	}
 	$('#usersTable').html(r.join('')); 
});