<?php

class GCMClient
{
    const GCM_URL = GCM_URL;
	
    public static function sendNotification($idGCM, $title, $data = array(),$key)
    {
        $data = json_encode($data);//esto no se.. en los ws está así, es cuando menos "raro"
        $fields = array(
            'time_to_live' => 0,
            'registration_ids' => array($idGCM),
            'data' => array(
                'titulo' => $title,
                'mensaje' => $data
            )
        );

        //cabecera del mje GCM
        $headers = array(
			'Authorization:key=' . $key,
            'Content-Type:application/json'
        );

        $curl_handle = curl_init();

        curl_setopt($curl_handle, CURLOPT_URL, GCMClient::GCM_URL);
        curl_setopt($curl_handle, CURLOPT_POST, true);
        curl_setopt($curl_handle, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, json_encode($fields));

        $respJSON = curl_exec($curl_handle);

        if ($respJSON === false) {
            return false;
        }

        $httpCode = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);

        if (curl_errno($curl_handle)) {
            return false;
        }
        if ($httpCode != 200) {
            return false;
        }

        curl_close($curl_handle);

        $response = json_decode($respJSON, true);

        /**
         * en la respuesta puede llegar un nuevo idGCM para ese usuario
         */
        if (!empty($response['results'][0]['registration_id'])) {
            return $response['results'][0]['registration_id'];
        }

        //verifico si retorno error, sino devuelvo "OK"
        if (!empty($response['failure'])) {
            return false;
        }
        return true;
    }
}