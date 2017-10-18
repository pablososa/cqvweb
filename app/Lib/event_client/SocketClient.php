<?php

use ElephantIO\Client,
    ElephantIO\Engine\SocketIO\Version1X;

require __DIR__ . '/vendor/autoload.php';


/**
 * Class SocketClient
 */
class _SocketClient
{
    public function __construct($host, $type, $value)
    {
        $this->host = $host;
        $this->type = $type;
        $this->value = $value;
    }

    public function send($type, $data = [])
    {
        $client = new Client(new Version1X($this->host . '?' . $this->type . '=' . $this->value));
        $client->initialize();
        $data = [
            'data' => $data,
            'type' => $type
        ];
        $client->emit('notificate', $data);
        return $client->close();
    }

    public function __call($name, $arguments)
    {
        $data = [];
        if (!empty($arguments)) {
            $data = array_shift($arguments);
        }
        $this->send($this->underscorize($name), $data);
    }

    protected function underscorize($str)
    {
        $str = str_split($str);
        $result = '';
        foreach ($str as $char) {
            if (ctype_upper($char)) {
                if (!empty($result)) {
                    $result .= '_';
                }
            }
            $result .= $char;
        }
        return strtolower($result);
    }
}
//
//$socket = new SocketClient(30, 'http://apptaxieventtesting-cqvtesting.rhcloud.com:8000');
//$socket->newMessage();