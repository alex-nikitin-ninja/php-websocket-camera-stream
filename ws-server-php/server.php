<?php

use MyApp\Socket;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

define("__CWD", dirname(__FILE__));

require __CWD . '/vendor/autoload.php';

$server = IoServer::factory(
	new HttpServer(
		new WsServer(
			new Socket()
		)
	),
	8764
);

print_r("starting video server...");

$server->run();
