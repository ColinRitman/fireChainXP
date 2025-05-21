<?php
require_once 'util.php';
$config = require_once '../config.php';

// List of available RPC methods
$rpc_methods = [
    'getlastblockheader' => '""',
    'f_block_json' => '{"hash":"last_block_hash"}',
    'getinfo' => '""',
    'getblockcount' => '""',
    'getblocktemplate' => '{"wallet_address":"","reserve_size":60}',
    'get_connections' => '""',
    'get_transaction_pool' => '""',
    'get_transaction_pool_stats' => '""'
];

// Handle AJAX requests
if (isset($_POST['method'])) {
    header('Content-Type: application/json');
    $method = $_POST['method'];
    $params = isset($_POST['params']) ? $_POST['params'] : '""';
    
    if ($method === 'getinfo') {
        $result = fetch_getinfo($config['api']);
    } else {
        $result = fetch_rpc($config['api'], $method, $params);
    }
    
    echo json_encode($result, JSON_PRETTY_PRINT);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RPC Interface</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .rpc-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 18px;
        }
        .rpc-button {
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-align: left;
            transition: background-color 0.3s;
            min-width: 180px;
        }
        .rpc-button:hover {
            background-color: #45a049;
        }
        .rpc-result {
            background-color: #fff;
            padding: 10px 15px;
            border-radius: 4px;
            min-width: 350px;
            min-height: 24px;
            font-size: 14px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.06);
            white-space: pre-wrap;
            word-break: break-all;
        }
        .loading {
            color: #888;
        }
        .error {
            color: #ff0000;
            background-color: #ffe6e6;
            padding: 6px;
            border-radius: 4px;
            margin-top: 4px;
        }
    </style>
</head>
<body>
    <h1>RPC Interface</h1>
    <div>
        <?php $i = 0; foreach ($rpc_methods as $method => $params): $i++; $result_id = 'result_' . $i; ?>
        <div class="rpc-row">
            <button class="rpc-button" onclick="makeRpcCall('<?php echo $method; ?>', '<?php echo $params; ?>', '<?php echo $result_id; ?>')">
                <?php echo $method; ?>
            </button>
            <div id="<?php echo $result_id; ?>" class="rpc-result">&nbsp;</div>
        </div>
        <?php endforeach; ?>
    </div>
    <script>
        function makeRpcCall(method, params, resultId) {
            const resultElement = document.getElementById(resultId);
            resultElement.innerHTML = '<span class="loading">Loading...</span>';

            const formData = new FormData();
            formData.append('method', method);
            formData.append('params', params);

            fetch('rpc_interface.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.error) {
                    resultElement.innerHTML = `<div class=\"error\">${data.error}</div>`;
                } else {
                    resultElement.textContent = JSON.stringify(data, null, 2);
                }
            })
            .catch(error => {
                resultElement.innerHTML = `<div class=\"error\">Error: ${error.message}</div>`;
            });
        }
    </script>
</body>
</html> 