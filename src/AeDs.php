<?php

namespace Epmnzava\AeDs;

use Exception;

class AeDs
{

    protected $token;
    protected $client;
    protected $code;
    protected $refresh_token;
    protected $app_key;
    protected $app_secret;
    public function __construct($app_key, $app_secret, $code)
    {
        $this->app_key = $app_key;
        $this->app_secret = $app_secret;
        $this->code = $code;
    }

    public function getAccessToken()
    {
        $action = "/auth/token/create";
        $client = new IopClient(UrlConstants::$api_authorization_url, $this->app_key, $this->app_secret);

        // $client = new IopClientImpl($url, $appkey, $appSecret);
        $request = new IopRequest($action);
        // $request->setApiName($action);
        $request->addApiParam("code", $this->code);

        try {
            $response = $client->execute($request, null);
            $this->token = json_decode($response)->access_token;

            $this->refresh_token = json_decode($response)->refresh_token;
            return json_decode($response)->access_token;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function getCategories($lang)
    {
        //$token = $this->getAccessToken();
        $c = new IopClient(UrlConstants::$api_gateway_url_tw, $this->app_key, $this->app_secret);
        $request = new IopRequest('aliexpress.ds.category.get');
        //$request->addApiParam('categoryId', '15');
        $request->addApiParam('language', $lang);
        $request->addApiParam('app_signature', 'sgi');
        $res = $c->execute($request);

        return $res;
    }

    public function getCategoryById($categoryid, $lang)
    {
        //$token = $this->getAccessToken();
        $c = new IopClient(UrlConstants::$api_gateway_url_tw, $this->app_key, $this->app_secret);
        $request = new IopRequest('aliexpress.ds.category.get');
        $request->addApiParam('categoryId', $categoryid);
        $request->addApiParam('language', $lang);
        $request->addApiParam('app_signature', 'sgi');
        $res = $c->execute($request);

        return $res;
    }




    public function getFeedName()
    {
        //$token = $this->getAccessToken();
        $c = new IopClient(UrlConstants::$api_gateway_url_tw, $this->app_key, $this->app_secret);
        $request = new IopRequest('aliexpress.ds.feedname.get');
        $request->addApiParam('app_signature', 'sgi');
        $res = $c->execute($request);

        return $res;
    }
}
