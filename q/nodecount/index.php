<?php
require '../util.php';
$config = (require '../../config.php');

$_url = $config['services'] . '/nodes/geodata';
$response = json_decode(file_get_contents($_url), true);

print_r(count($response));