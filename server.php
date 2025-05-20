<?php
require __DIR__ . '/vendor/autoload.php';

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface {
    protected $clients;
    protected $userMap = []; // connection => user_id
    protected $adminConn = null;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) {
        $this->clients->attach($conn);
    }

    public function onMessage(ConnectionInterface $from, $msg) {
        $data = json_decode($msg, true);
        // Expecting: {type: "init", user_id: "...", is_admin: true/false}
        if (isset($data['type']) && $data['type'] === 'init') {
            if (!empty($data['is_admin'])) {
                $this->adminConn = $from;
                $this->userMap[$from->resourceId] = 'admin';
            } else {
                $this->userMap[$from->resourceId] = $data['user_id'];
            }
            return;
        }

        // Expecting: {from: user_id, to: 'admin' or user_id, message: "..."}
        if (isset($data['to']) && $data['to'] === 'admin' && $this->adminConn) {
            $this->adminConn->send(json_encode($data));
        } elseif (isset($data['to'])) {
            // Find the user connection
            foreach ($this->clients as $client) {
                if (
                    isset($this->userMap[$client->resourceId]) &&
                    $this->userMap[$client->resourceId] === $data['to']
                ) {
                    $client->send(json_encode($data));
                }
            }
        }
    }

    public function onClose(ConnectionInterface $conn) {
        $this->clients->detach($conn);
        unset($this->userMap[$conn->resourceId]);
        if ($this->adminConn === $conn) {
            $this->adminConn = null;
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        $conn->close();
    }
}

use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;

echo "WebSocket server started on ws://localhost:8080\n";
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new Chat()
        )
    ),
    8080
);
$server->run();