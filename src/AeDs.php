<?php

namespace Epmnzava\AeDs;

use Exception;

class AeDs
{
    protected $api_key;
    protected $api_secret;
    public function __construct() {}

    public function getAccessToken($app_key, $app_secret)
    {
        $action = "/auth/token/create";

        // $client = new IopClientImpl($url, $appkey, $appSecret);
        $client = new IopClient(UrlConstants::$api_authorization_url, $app_key, $app_secret);
        $request = new IopRequest($action);
        // $request->setApiName($action);
        $request->addApiParam("code", 0);

        try {
            $response = $client->execute($request, null);
            echo json_encode($response);
            //   echo json_encode($response->getGopResponseBody());
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
