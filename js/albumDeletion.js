var request;
$(document).ready(function (){
	$("#delSubButton").click(function (){

		var elements = $("#album_deletion_form ul li :checked");
		var value_array=[];
		for(var i=0; i<elements.length; i++){
			var element = elements[i];
			var str = element.value;
			var id_str = str.split("_")[0];
			value_array.push(id_str);
		}
		var album_id_str=value_array[0];

		for(var i=1; i<value_array.length; i++){
			var id="_"+value_array[i];
			album_id_str+=id;
		}
		var albumData={IDs:album_id_str};
		
		request = $.ajax({
			url:"featureGeneration/albumDeletion.php",
			type:'get',
			data:albumData,
			dataType:'text',
			error:function(error){
				console.log(error);
			}
		});

		//delete displays after success
		request.success(function(data){
			console.log("received!!!!!");
			console.log(data);
			if(data==="success"){
				for(var i=0; i<value_array.length;i++){
					var id = value_array[i];
					var selector="#"+id;
					
					$("#albumList").find(selector).remove();
					$("#albumsContainer").find(selector).remove();
				
				}
			}
			
		})

	})

	
})