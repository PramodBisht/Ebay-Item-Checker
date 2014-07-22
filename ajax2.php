<?php
	//error_reporting(E_ALL);  // Turn on all errors, warnings and notices for easier debugging

	header("Content-type:text/xml");
	$endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';  // URL to call
	$version = '1.0.0';  // API version supported by your application
	$appid = 'student93-fb81-4fa5-ba17-7e8eef23bd1';  // Replace with your own AppID
	  // Global ID of the eBay site you want to search (e.g., EBAY-DE)
	$query = $_GET['keyword']; // You may want to supply your own query
	$sorttype=$_GET['type'];
	$category=$_GET['categorytype'];
	$safequery = urlencode($query);  // Make the query URL-friendly
	//echo $safequery;
	$i = '0'; 
	$filterarray =
	  array(
	    array(
	    'name' => 'MaxPrice',
	    'value' => '10000',
	    'paramName' => 'Currency',
	    'paramValue' => 'USD'),
	    array(
	    'name' => 'FreeShippingOnly',
	    'value' => 'true',
	    'paramName' => '',
	    'paramValue' => ''),
	    array(
	    'name' => 'ListingType',
	    'value' => array('AuctionWithBIN','FixedPrice'),
	    'paramName' => '',
	    'paramValue' => ''),
	   
	    	
	  );
	  function buildURLArray ($filterarray) {
		  global $urlfilter;
		  global $i;
		  // Iterate through each filter in the array
		  foreach($filterarray as $itemfilter) {
		    // Iterate through each key in the filter
		    foreach ($itemfilter as $key =>$value) {
		      if(is_array($value)) {
		        foreach($value as $j => $content) { // Index the key for each value
		          $urlfilter .= "&itemFilter($i).$key($j)=$content";
		        }
		      }
		      else {
		        if($value != "") {
		          $urlfilter .= "&itemFilter($i).$key=$value";
		        }
		      }
		    }
		    $i++;
		  }
		  return "$urlfilter";
		} // End of buildURLArray function

		// Build the indexed item filter URL snippet
		buildURLArray($filterarray);
	// Construct the findItemsByKeywords HTTP GET call
	$apicall = "$endpoint?";
	$apicall .= "OPERATION-NAME=findItemsAdvanced";
	$apicall .= "&SERVICE-VERSION=$version";
	$apicall .= "&SECURITY-APPNAME=$appid";
	$apicall .= "&RESPONSE-DATA-FORMAT=XML&REST-PAYLOAD";
	$apicall .= "&categoryId=$category";
	$apicall .= "&keywords=$safequery";
	$apicall .= "&paginationInput.entriesPerPage=20";
	$apicall .= "&sortOrder=$sorttype";

//	$apicall .= "&sortOrder=$sorttype";
	
	//$apicall .= "$urlfilter";

	$resp = simplexml_load_file($apicall);
	//echo $resp;
   	$xml="<?xml version=\"1.0\" ?>";
   	$xml.="<product>";
	if ($resp->ack == "Success") {
	  $results = '';
	  foreach($resp->searchResult->item as $item) {
	    $pic   = $item->galleryURL;
	    $pic=preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $pic);
	    $link  = $item->viewItemURL;
	    $link=preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $link);
	    $title = $item->title;

	    $title=preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $title);
	    $itemid= preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $item->itemId);
	    $categoryName=preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $item->primaryCategory->categoryName); 
	    $price=preg_replace('/&(?!#?[a-z0-9]+;)/', '&amp;', $item->sellingStatus->currentPrice);
	    
	    $xml.="<item><title>$title</title><link>$link</link><pic>$pic</pic><itemid>$itemid</itemid><categoryname>$categoryName</categoryname><price>$price</price></item>";
	  	
	  }
	  $xml.="</product>";
	}
	else{
		echo "<script>console.log('ajax.php fetch nothing')</script>";
	}
	echo $xml;
?>
