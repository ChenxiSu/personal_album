var request;
$(document).ready(function(){
	$("#updateAlbumButton").click(function (){
		var albumData;
		var al_id = $("#al_id").text();
		var albumName = $("#albumNameInput").val();
		var description = $("#descriptionArea").val();
		albumData={ID: al_id,Name: albumName,Desc:description};
		request = $.ajax({
			url:"featureGeneration/albumInfoEdition.php",
			type:'get',
			data:albumData,
			dataType:'text',
			error:function(error){
				console.log(error);
			}
		});

		request.success(function(data){
			console.log("recevied!!!!!");
			console.log(data);
			if(data=="success"){

				$("#name").text(albumName);
				$("#desc").text(description);
				$("#albumNameInPosition").text(albumName);
			
			}
		})
	})
})