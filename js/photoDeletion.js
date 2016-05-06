$(document).ready(function(){
	$("#deletePhoto").click(function(){
		if( $("#display_photo_list").css("display") =="none" ){
			$("#display_photo_list").css("display","block");
		}
		else{
			$("#display_photo_list").css("display","none");
		}
		
	});

	$("#deletionButton").click(function (){
		var albumID = $("#al_id").text();
		var checkedList = $("#photoUL li :checked");
		//var id = $(checkedList[0]).attr("id");
		var idArray=""+albumID;
		var idArrayStore=[];
		for(var i=0; i<checkedList.length; i++){
			var id = $(checkedList[i]).attr("id");
			idArrayStore.push(id);
			var idStr="_"+id;
			idArray+=idStr;
		}
		console.log(idArray);

		
		
		var request;
		var data = {recordIDs:idArray};
		request = $.ajax({
			url:'featureGeneration/albumRecordDeletion.php',
			type:'get',
			data:data,
			dataType:'text',
			error:function(error){
				console.log(error);
			}
		});
		request.success(function(data) {
			console.log("received");
			if(data==="success"){
				console.log(data);
				for(var i=0; i<idArrayStore.length;i++){
					var curID = idArrayStore[i];
					var selector = "label[id="+curID+"]";
					console.log($(selector).closest("div"));
					$(selector).closest("div").remove();
				}
				$("#photoUL li :checked").closest("li").remove();

			}
		});
	});
})