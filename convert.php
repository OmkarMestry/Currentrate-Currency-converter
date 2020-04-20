<?php
$params = $_REQUEST;
               
$to_currency = isset($params['to_currency']) != '' ? $params['to_currency'] : '';
$from_currency = isset($params['from_currency']) != '' ? $params['from_currency'] : '';
$amount = isset($params['amount']) != '' ? $params['amount'] : '';
 
function currencyConverter($from_currency, $to_currency, $amount) {
$from_currency = urlencode($from_currency);
$to_currency = urlencode($to_currency);
$encode_amount = urlencode($amount);
$get = file_get_contents("https://www.google.com/finance/converter?a=$encode_amount&from=$from_currency&to=$to_currency");
$get = explode("<span class=bld>",$get);
$get = explode("</span>",$get[1]);
$converted_currency = preg_replace("/[^0-9\.]/", null, $get[0]);
$params['converted_amount'] = $converted_currency;
$params['to_currency'] = $to_currency;
$params['rate'] = $converted_currency/$encode_amount;
$params['error'] = 0;
return $params;
}
if($amount == '' || $amount <=0 ) { 
    $params['error'] = 1;
    echo json_encode($params);
} else {
	$response = currencyConverter($from_currency, $to_currency, $amount);
echo json_encode($response);	
}

?>
 
