<?php
$host = 'mail.digigo.click';
$ports = [465, 587, 25];

foreach ($ports as $port) {
    $t0 = microtime(true);
    $fp = @fsockopen($host, $port, $errno, $errstr, 5);
    $dt = round((microtime(true) - $t0) * 1000);
    if ($fp) {
        $banner = fgets($fp, 512);
        fclose($fp);
        echo "Port $port: OPEN ($dt ms) -> Banner: " . trim($banner) . "\n";
    } else {
        echo "Port $port: CLOSED/TIMED OUT ($errno: $errstr)\n";
    }
}

