<?php

require_once __DIR__ . '/../vendor/autoload.php';

// Command that starts the built-in web server
$command = sprintf(
    'php -S %s:%d -t %s >/dev/null 2>&1 & echo $!',
    defined(WEB_SERVER_HOST) ? WEB_SERVER_HOST : "127.0.0.1",
    defined(WEB_SERVER_PORT) ? WEB_SERVER_PORT : "8888",
    defined(WEB_SERVER_DOCROOT) ? WEB_SERVER_DOCROOT: "."
);

// Execute the command and store the process ID
$output = array();
exec($command, $output);
$pid = (int) $output[0];

echo sprintf(
        '%s - Web server started on %s:%d with PID %d',
        date('r'),
        WEB_SERVER_HOST,
        WEB_SERVER_PORT,
        $pid
    ) . PHP_EOL;

// Kill the web server when the process ends
register_shutdown_function(function() use ($pid) {
    echo sprintf('%s - Killing process with ID %d', date('r'), $pid) . PHP_EOL;
    exec('kill ' . $pid);
});
