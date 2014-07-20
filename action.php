<?php
	error_reporting(E_ALL);  // Turn on all errors, warnings and notices for easier debugging

	header("Content-type: text/xml");
	$endpoint = 'http://svcs.ebay.com/services/search/FindingService/v1';  // URL to call
	$version = '1.0.0';  // API version supported by your application
	$appid = 'student93-fb81-4fa5-ba17-7e8eef23bd1';  // Replace with your own AppID
	$globalid = 'EBAY-IN';  // Global ID of the eBay site you want to search (e.g., EBAY-DE)
	$query = $_GET['keyword']; // You may want to supply your own query
	$safequery = urlencode($query);  // Make the query URL-friendly
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
	$apicall .= "OPERATION-NAME=findItemsByKeywords";
	$apicall .= "&SERVICE-VERSION=$version";
	$apicall .= "&SECURITY-APPNAME=$appid";
	$apicall .= "&GLOBAL-ID=$globalid";
	$apicall .= "&keywords=$safequery";
	$apicall .= "&paginationInput.entriesPerPage=30";
	$apicall .= "$urlfilter";
	
	$resp = simplexml_load_file($apicall);
	//echo $resp;
   	$xml="<?xml version=\"1.0\" ?>";
   	$xml.="<product>";
	// Check to see if the request was successful, else print an error
	if ($resp->ack == "Success") {
	  $results = '';
	  // If the response was loaded, parse it and build links
	  foreach($resp->searchResult->item as $item) {

	    $pic   = $item->galleryURL;
	    $link  = $item->viewItemURL;
	    $title = $item->title;
	    $itemid= $item->itemId;
	    $categoryName= $item->primaryCategory->categoryName;
	    $price=$item->sellingStatus->currentPrice;


	    /*addding item to xml feed to be used by index.php*/
	    $xml.="<item><title>$title</title><link>$link</link><pic>$pic</pic><itemid>$itemid</itemid><categoryname>$categoryName</categoryname><price>$price</price></item>";

   /*
	    // For each SearchResultItem node, build a link and append it to $results
	    $results .= "<tr><td><img src=\"$pic\"></td><td><a href=\"$link\">$title</a></td>
	    <tr><td>item id is $itemid</td></tr><tr><td>category name is $categoryName</td></tr><tr><td>price is $price</td></tr>";
			*/	 
	  }
	  $xml.="</product>";
	}
	// If the response does not indicate 'Success,' print an error
	else {
	//  $results  = "<h3>Oops! The request was not successful. Make sure you are using a valid ";
	//  $results .= "AppID for the Production environment.</h3>";
	}
	
	echo $xml;

?>
