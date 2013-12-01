$.ajax({
	url: "http://clique.raspi.pw/cbe/index.php/chat?configureChat=true&id=" + $("#content").attr("ref"),
	type: "GET",
	cache: false,
}).success(function(response) {
	var response = $.parseJSON(response)
	$("#content").attr("ref",response["room_id"])
	$.ajax({
	  url: "http://clique.raspi.pw/cbe/index.php/chat?getChatMessages=true&id=" + response["room_id"],
	  type: "GET",
	}).success(function(response) {

		var response = $.parseJSON(response)
		var r = new Array(), j = -1;
	 	for (var i = 0, size=response.length; i<size; i++){

			r[++j] ='<div'
			if(i == 0){
	 			r[++j] = " id='latest' ref="
	 			r[++j] = response[i]['message_id']
			}
			r[++j] = ' class="col-md-12"><p>[<a href=\'javascript:;\'>';
			r[++j] = response[i]["username"]
			r[++j] = "</a>]["
			r[++j] = response[i]["date"]
			r[++j] = "]:&nbsp;"
			r[++j] = response[i]["message"];
			r[++j] = '</p></div>';
	 	}
	 	$('#messages').html(r.join('')); 
	});
});

window.setInterval(function(){
	if($('#latest').length){
		syncChat($("#latest").attr('ref'),$('#content').attr('ref'));
	}
}, 2000);



function syncChat(latestID,chatID){
	$.ajax({
		url: "http://clique.raspi.pw/cbe/index.php/chat?getLatestMessages=true&latestID="+ latestID +"&chatID=" + chatID,
		type: "GET",
		cache: false,
	}).success(function(response) {
		var response = $.parseJSON(response)
		if(response.length > 0){
			var r = new Array(), j = -1;
		 	for (var i = 0, size=response.length; i<size; i++){

				r[++j] ='<div'
				if(i == 0){
		 			r[++j] = " id='latest' ref="
		 			r[++j] = response[i]['message_id']
				}
				r[++j] = ' class="col-md-12"><p>[<a href=\'javascript:;\'>';
				r[++j] = response[i]["username"]
				r[++j] = "</a>]["
				r[++j] = response[i]["date"]
				r[++j] = "]:&nbsp;"
				r[++j] = response[i]["message"];
				r[++j] = '</p></div>';
		 	}
		 	$('#latest').attr('id','old')
		 	$('#old').before(r.join(''));
		 }
	});
}




function submitMessage(chatID,userID, message){
	$.ajax({
		url: "http://clique.raspi.pw/cbe/index.php/chat?addMessage=true&chatID=" + chatID + "&userID=" + userID + "&message=" + message,
		type: "GET",
		cache: false,
	});
}


function schedulePrompt(){
	if($('#schedulePrompt').length){
		$('#schedulePrompt').remove();
	}
	var html = '<div class="" id="schedulePrompt">TEST</div>'
	$("#content").before(html);
}

function insertEquation(){
	if($('#schedulePrompt').length){
		$('#schedulePrompt').remove();
	}
	var html = '<div class="" id="schedulePrompt">TEST</div>'
	$("#content").before(html);
}	

function insertCode(){
	if($('#schedulePrompt').length){
		$('#schedulePrompt').remove();
	}
	var html = '<div class="" id="schedulePrompt">TEST</div>'
	$("#content").before(html);
}

function insertDefinition(){
	if($('#schedulePrompt').length){
		$('#schedulePrompt').remove();
	}
	var html = '<div class="" id="schedulePrompt">TEST</div>'
	$("#content").before(html);
}