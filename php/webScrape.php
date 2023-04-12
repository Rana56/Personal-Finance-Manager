<?php
    // Set the target URL
    $url = 'https://www.argos.co.uk/product/1304963?clickPR=plp:2:90';

    // Initialize cURL
    $curl = curl_init();
    $requestType = 'GET';

    // Set cURL options
    curl_setopt_array($curl, [
        CURLOPT_URL => $url,
        CURLOPT_CUSTOMREQUEST => $requestType,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_RETURNTRANSFER => true
    ]);

    // Make the HTTP request and get the response
    $response = curl_exec($curl);

    // Close cURL
    curl_close($curl);

    libxml_use_internal_errors(true);
    // Initialize DOMDocument
    $doc = new DOMDocument();

    // Load the HTML content
    $doc->loadHTML($response);

    $xpath = new DOMXPath($doc);

   // $price = $xpath->query('//*[@id="pdp-react-critical-app"]/div[1]/span[2]');

    //$item_p = $price->item(0);
    
    //print_r($price)

    //echo $item_p->textContent;
    
    $elements = $xpath->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' hYxevI ')]");

    // Loop through the elements and do something with each one
    foreach ($elements as $element) {
        // Do something with the element
        echo $element->nodeValue;
        //echo $element->textContent;
    }
?>