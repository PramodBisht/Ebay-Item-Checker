
<html>
<head>
<style type="text/css">body { font-family: arial,sans-serif;} </style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
var results="";
	$(document).ready(function(){
		$("#submit").click(function(){
			results="";
	   		var itemtosearch=$("#key").val();
	   		
	   		$("#tab").empty();
           $.ajax({
			type: 'GET',
			dataType: 'xml',
			url: 'ajax.php',
			data:{keyword:itemtosearch},
			success: function(data) {
				$(data).find('item').each(function(){
					var title=($(this).find('title').text());
					var link=($(this).find('link').text());
					var pic=($(this).find('pic').text());
					var item_id=($(this).find('itemid').text());
					//con
					var Categoryname=($(this).find('categoryname').text());
					var price=($(this).find('price').text());
					results += "<tr><td><img src="+pic+"></td><td><a href="+link+">"+title+"</a></td><tr><td>item id is "+item_id+"</td></tr><tr><td>category name is "+Categoryname+"</td></tr><tr><td>price is "+price+"</td></tr>";



				});
				console.log(results);
				$("#tab").html(results);
				
			},
			error: function (xhr, ajaxOptions, thrownError) {
		        console.log(xhr.status);
		        console.log(thrownError);
		    } 
		   });
	   		

	   });
	});
</script>
</head>
<body>

<h3>Search within a ebay</h3>
<div>
	<div >
		<input type="text" value="die hard" id="key"></input>
		<select>
			<option>Select Category</option>
			<option>All Category</option>
			<option>Books & Magazine</option>
		</select>
		<select>
			<option>Select Sort Order</option>
			<option>Price:Lowest to highest</option>
			<option>Price:Higest First</option>
		</select>
		<button id="submit">submit</button>
	</div>

</div>
<div id="data">
<table id="tab">

  
    
  
</table>
</div>



</body>
</html>