<?php

namespace MyApp;

use Ratchet\ConnectionInterface;
use Ratchet\MessageComponentInterface;

class Socket implements MessageComponentInterface {

	public function __construct() {
		$this->clients = new \SplObjectStorage;
	}

	public function onOpen(ConnectionInterface $conn) {

		// Store the new connection in $this->clients
		$this->clients->attach($conn);

		print_r("New connection ({$conn->resourceId})\n");
	}

	public function onMessage(ConnectionInterface $from, $msg) {
		// print_r($this->clients);
		foreach ($this->clients as $client) {

			// if ( $from->resourceId == $client->resourceId ) {
			//     continue;
			// }
			// $client->send( "Client $from->resourceId said $msg" );

			$f = false;
			$path = __CWD . '/tmp/img.jpg';
			if (file_exists($path)) {
				$f = file_get_contents($path);
				while (strlen($f) === 0) {
					$f = file_get_contents($path);
				}
			}

			$d = ["f" => base64_encode($f)];
			$d = json_encode($d);
			$client->send($d);
			printf(sprintf('%.3f', microtime(true)) . ': ' . strlen($f) . ' -> ' . strlen($d) . ' | ' . $msg . "\n");
		}
	}

	public function onClose(ConnectionInterface $conn) {
		print_r("Connection dropped ({$conn->resourceId})\n");
		$this->clients->detach($conn);
	}

	public function onError(ConnectionInterface $conn, \Exception $e) {
		print_r("Error received ({$conn->resourceId})\n");
		print_r($e->getMessage());
	}
}
