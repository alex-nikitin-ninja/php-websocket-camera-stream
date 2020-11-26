<?php

namespace MyApp;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Socket implements MessageComponentInterface {

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {

        // Store the new connection in $this->clients
        $this->clients->attach($conn);

        echo "New connection ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        foreach ( $this->clients as $client ) {

            // if ( $from->resourceId == $client->resourceId ) {
            //     continue;
            // }
            // $client->send( "Client $from->resourceId said $msg" );

            $path = __CWD . '/tmp/img.jpg';
            $f = file_get_contents($path);
            $d = [
                "f" => base64_encode($f)
            ];
            $d = json_encode($d);

            $client->send($d);
            printf( sprintf('%.3f', microtime(true)) . ': ' . strlen($f) . ' -> ' . strlen($d) . ' | ' . $msg . "\n");
        }
    }

    public function onClose(ConnectionInterface $conn) {
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
    }
}
