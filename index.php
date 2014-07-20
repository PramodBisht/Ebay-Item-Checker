
<html>
<head>
<style type="text/css">body { font-family: arial,sans-serif;} </style>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script>
	$(document).ready(function(){
		$("#submit").click(function(){
	   	var itemtosearch=$("#key").val();
	   		$.ajax({
			type:"GET",
			url:"action.php",
			
			data:{keyword:itemtosearch},
			success:function(xml){
				alert();
				
				console.log(xml);
			}
			});

	   });


	   		

	});
</script>
</head>
<body>

<h3>Search within a ebay</h3>
<div>
	<form >
		<input type="text" name="keyword"value="good hard" id="key"></input>
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
	</form>

</div>



</body>
</html>