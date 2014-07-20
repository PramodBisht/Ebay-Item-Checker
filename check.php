<?php
$endpoint  = 'http://svcs.ebay.com/services/search/FindingService/v1'; // URL to call
$version   = '1.0.0'; // API version supported by your application
$appid     = 'student93-fb81-4fa5-ba17-7e8eef23bd1'; // Replace with your own AppID
$globalid  = 'EBAY-IN'; // Global ID of the eBay site you want to search (e.g., EBAY-DE)
$query     = 'golf'; // You may want to supply your own query
$safequery = urlencode($query); // Make the query URL-friendly

// Construct the findItemsByKeywords HTTP GET call
$apicall = "$endpoint?";
$apicall .= "OPERATION-NAME=findItemsAdvanced";
$apicall .= "&SERVICE-VERSION=$version";
$apicall .= "&SECURITY-APPNAME=$appid";
$apicall .= "&GLOBAL-ID=$globalid";
$apicall .= "&keywords=$safequery";
$apicall .= "&paginationInput.entriesPerPage=12";
$apicall .= "&paginationInput.pageNumber=1";
$apicall .= "&categoryId=1513";

// Load the call and capture the document returned by eBay API
$resp = simplexml_load_file($apicall);

// Check to see if the request was successful, else print an error
if ($resp->ack == "Success") {
    $results = '';
    // If the response was loaded, parse it and build links
    foreach ($resp->searchResult->item as $item) {
        $pic   = $item->galleryURL;
        $link  = $item->viewItemURL;
        $title = $item->title;
        $price = $item->currentPrice;

        // For each SearchResultItem node, build a link and append it to $results
        $results .= "<div id='prod-wrap'><div class='prodimg-wrap' align='center'><img src=\"$pic\" class='prodimg'></div> <div class='prodtxt' align='center'><a href=\"$link\">$title</a></div><div class='price' align='center'><p class='price' align='center'>$price</p></div></div>";
    }
}
// If the response does not indicate 'Success,' print an error
else {
    $results = "<h3>Oops! The request was not successful. Make sure you are using a valid ";
    $results .= "AppID for the Production environment.</h3>";
}
?>
<!-- Build the HTML page with values from the call response -->
<html>
<head>
    <style type="text/css">
        body {
            font-family: arial, sans-serif;
        }

        img {
            border: none;
        }

        #store-wrap {
            width:    770px;
            height:   auto;
            position: relative;
        }

        #filter-wrap {
            width:            160px;
            float:            left;
            height:           500px;
            margin-right:     10px;
            background-color: #EBEBEB;
        }

        #result-wrap {
            width:    600px;
            float:    left;
            height:   auto;
            position: relative;
        }

        #pagination-wrap {
            width:  200px;
            float:  right;
            height: 20px;
        }

        #prod-wrap {
            width:            150px;
            height:           200px;
            margin:           0 15px 15px;
            float:            left;
            border:           1px solid #999999;
            background-color: #CCCCCC;
        }

        .prodimg-wrap {
            width: 150px;
        }

        .prodimg {
            width:   100px;
            height:  100px;
            padding: 4px;
        }

        .prodtxt {
            font-size: 11px;
            width:     130px;
            padding:   0 8px;
        }
        .price {
            font-size: 11px;
            width: 60px;
            padding: 0 8px;
        }
        .price p {
            font-size: 11px;
            color: black;
        }
    </style>
</head>
<body>

<h1><?php echo $query; ?></h1>

<table>
    <tr>
        <td>
            <div id="store-wrap">

                <div id="result-wrap">
                    <?php echo $results;?>

                </div>
            </div>
        </td>
    </tr>
</table>

</body>
</html>