
<html>
<head>
<style type="text/css">body { font-family: arial,sans-serif;} </style>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script type="text/javascript">
var results="";
	$(document).ready(function(){
		$("#submit").click(function(){
			results="";
	   		var itemtosearch=$("#key").val();
	   		var sorttype=$("#sorting").val();
	   		var itemcategory=$("#cat").val();
	   		
	   		
	   		$("#tab").empty();
           $.ajax({
			type: 'GET',
			dataType: 'xml',
			url: 'ajax.php',
			data:{keyword:itemtosearch,type:sorttype,categorytype:itemcategory},
			success: function(data) {
				console.log(data);
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

<h3>Search within a ebay </h3>
<h3>if no category is selected it will show you the best match</h3>
<div>
	<div >
		<input type="text" value="Asus" id="key"></input>
		<select id="cat">
			<option value="0">All Category</option>
			<option value="16159">Laptop</option>
			<option value="14295">Laptop Batteries</option>
			<option value="176299">Video &amp; Computer Games</option>

			</select>
		<select id="sorting"> 
			<option value="BestMatch">Select Sort Order</option>
			<option value="BestMatch">Best Match</option>
			<option value="PricePlusShippingLowest">Price:Lowest to highest</option>
			<option value="CurrentPriceHighest">Price:Higest First</option>
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