<?php
define('PRIVATE_KEY', 'q1w2e3r4t5y6u7i8o9p0');

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $headers = getallheaders();
    $hubSignature = $headers['X-Hub-Signature'];
    list($algo, $hash) = explode('=', $hubSignature, 2);
    $payload = file_get_contents('php://input');
    $payloadHash = hash_hmac($algo, $payload, PRIVATE_KEY);
    if ($hash !== $payloadHash) {
        die('Bad secret');
    }
    $data = json_decode($payload);

    echo "start\n";
    echo shell_exec("git pull origin master 2>&1") . "\n";
    echo "finish\n";
}