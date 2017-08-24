<?php
require __DIR__ . '/vendor/autoload.php';

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require 'chat.php';

if (isset($argv) == true)
{
    $host = $argv[1];
}

if (isset($host) == false)
{
    $host = "localhost";
}

echo 'Listening on : ' . $host . "\r\n";

// $loop = React\EventLoop\Factory::create();

echo '1.0.8' . "\r\n";

/**
 * @param string        $httpHost HTTP hostname clients intend to connect to. MUST match JS `new WebSocket('ws://$httpHost');`
 * @param int           $port     Port to listen on. If 80, assuming production, Flash on 843 otherwise expecting Flash to be proxied through 8843
 * @param string        $address  IP address to bind to. Default is localhost/proxy only. '0.0.0.0' for any machine.
 * @param LoopInterface $loop     Specific React\EventLoop to bind the application to. null will create one for you.
 */

// Run the server application through the WebSocket protocol on port 8080
/*
$app = new Ratchet\App('venantvr-corbakatak.rhcloud.com', 8080, $host, $loop);
$app->route('/chat', new Chat, array('*'));
$app->run();
*/

$chat = new Chat();
$server = IoServer::factory(new HttpServer(new WsServer($chat)), 8080, $host);

$server->loop->addPeriodicTimer(5, function () use ($chat) {
    $chat->sayHello();
});

$server->run();

