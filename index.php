
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
		<input type="text" value="die hard" id="key"></input>
		<select id="cat">
			<option selected="selected" value="0">All Categories </option>
			<option value="178777">Baby &amp; Mom</option>
<option value="267">Books &amp; Magazines</option><option value="625">Cameras &amp; Optics</option><option value="131090">Cars &amp; Bike Accessories</option><option value="116365">Charity</option><option value="11450">Clothing &amp; Accessories</option><option value="11116">Coins &amp; Notes</option><option value="1">Collectibles</option><option value="178743">eBay Daily</option><option value="13361">Fitness &amp; Sports</option><option value="26395">Fragrances, Beauty &amp; Health</option><option value="1249">Games, Consoles &amp; Accessories</option><option value="11700">Home &amp; Living</option><option value="20710">Home Appliances</option><option value="281">Jewellery &amp; Precious Coins</option><option value="178816">Kitchen &amp; Dining</option><option value="160">Laptops &amp; Computer Peripherals</option><option value="11071">LCD, LED &amp; Televisions</option><option value="162260">Memory Cards, Pen Drives &amp; HDD</option><option value="14416">Mobile Accessories</option><option value="15032">Mobile Phones</option><option value="9800">Motor Classifieds</option><option value="11232">Movies &amp; Music</option><option value="619">Musical Instruments</option><option value="174982">Shoes</option><option value="169977">Stamps</option><option value="92470">Stationery &amp; Office Supplies</option><option value="178741">Tablets &amp; Accessories</option><option value="631">Tools &amp; Hardware</option><option value="220">Toys, Games &amp; School Supplies</option><option value="179545">Warranty Services</option><option value="14324">Watches</option><option value="99">Everything Else</option>
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