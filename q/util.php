<?php
function build_post_context($postdata) {
	return stream_context_create(array(
		'http' =>
			array(
				'method' => 'POST',
				'header' => 'Content-Type: application/json',
				'content' => $postdata
			)
		)
	);
};

function build_rpc_body($method, $params) {
	return '{"jsonrpc":"2.0","id":"blockexplorer","method":"'.$method.'","params":'.$params.'}';
};

function fetch_rpc($api, $method, $params) {
	$url = $api . '/json_rpc';
	$rendered_rpc = build_rpc_body($method, $params);
	$context = build_post_context($rendered_rpc);
	
	$response = @file_get_contents($url, false, $context);
	if ($response === false) {
		$error = error_get_last();
		return array('error' => 'API request failed: ' . ($error['message'] ?? 'Unknown error'));
	}
	
	$decoded = json_decode($response, true);
	if (json_last_error() !== JSON_ERROR_NONE) {
		return array('error' => 'Invalid JSON response: ' . json_last_error_msg());
	}
	
	return $decoded;
};

function fetch_getinfo($api) {
	$_url = $api . '/getinfo';
	$response = @file_get_contents($_url);
	if ($response === false) {
		$error = error_get_last();
		return array('error' => 'API request failed: ' . ($error['message'] ?? 'Unknown error'));
	}
	
	$decoded = json_decode($response, true);
	if (json_last_error() !== JSON_ERROR_NONE) {
		return array('error' => 'Invalid JSON response: ' . json_last_error_msg());
	}
	
	return $decoded;
};

function fetch_coingecko(string $coingecko) {
	$_url = $coingecko;
	$response = @file_get_contents($_url);
	if ($response === false) {
		$error = error_get_last();
		return array('error' => 'API request failed: ' . ($error['message'] ?? 'Unknown error'));
	}
	
	$decoded = json_decode($response, true);
	if (json_last_error() !== JSON_ERROR_NONE) {
		return array('error' => 'Invalid JSON response: ' . json_last_error_msg());
	}
	
	return $decoded;
};

function fetch_coinpap(string $coinpap) {
	$_url = $coinpap;
	$response = @file_get_contents($_url);
	if ($response === false) {
		$error = error_get_last();
		return array('error' => 'API request failed: ' . ($error['message'] ?? 'Unknown error'));
	}
	
	$decoded = json_decode($response, true);
	if (json_last_error() !== JSON_ERROR_NONE) {
		return array('error' => 'Invalid JSON response: ' . json_last_error_msg());
	}
	
	return $decoded;
};
