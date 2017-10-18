<?php

require __DIR__ . '/event_client/SocketClient.php';


/**
 * Class SocketClient
 */
class SocketClient
{
    /**
     * @param $empresaId
     * @param $type
     * @param array $data
     * @return $this
     */
    public static function sendNodeEventEmpresa($empresaId, $type, $data = []) {
        try {
            $socketClient = new _SocketClient(NODE_EVENT_SERVER_URL, 'empresa_id', $empresaId);
            return $socketClient->send($type, $data);
        } catch(\Exception $e) {
            return false;
        }
    }

    /**
     * @param $viajeId
     * @param $type
     * @param array $data
     * @return $this
     */
    public static function sendNodeEventViaje($viajeId, $type, $data = []) {
        try {
            $socketClient = new _SocketClient(NODE_EVENT_SERVER_URL, 'viaje_id', $viajeId);
            return $socketClient->send($type, $data);
        } catch(\Exception $e) {
            return false;
        }
    }
}