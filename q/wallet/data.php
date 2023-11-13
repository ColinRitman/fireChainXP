<?php
require '../util.php';
$config = (require '../../config.php');

//$bitstamp = fetch_bitstamp($config['bitstamp']);
//$btc = number_format($bitstamp['last'],2,".",",");

$coingecko = fetch_coingecko("https://api.coingecko.com/api/v3/coins/fango");
$ccxusd = number_format($coingecko['market_data']['current_price']['usd'],2,".",",");
$totalvolume = number_format($coingecko['market_data']['total_volume']['usd'],2,".",",");
$ccxbtc = number_format(($coingecko['market_data']['current_price']['btc'])*100000000,0,".",",");


$coinpap = fetch_coinpap("https://api.coinpaprika.com/v1/coins/xfg-fango/ohlcv/latest/");
$marketcap = number_format($coinpap['market_cap'],2,".",",");

print_r($ccxbtc." ".$ccxusd." ".$marketcap." ".$totalvolume);
