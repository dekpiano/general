<?php
$data = file_get_contents("php://input");
file_put_contents('webhook-test.log', date('Y-m-d H:i:s') . "\n" . $data . "\n\n", FILE_APPEND);
http_response_code(200);
echo "OK";