<?php

namespace Epmnzava\AeDs;

use Exception;

class AeDs
{

    protected $token;
    protected $client;
    protected $app_client;

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
            return json_decode($response);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }



    public function getRefreshToken($refresh_token)
    {
        $action = "/auth/token/refresh";
        $client = new IopClient(UrlConstants::$api_authorization_url, $this->app_key, $this->app_secret);

        // $client = new IopClientImpl($url, $appkey, $appSecret);
        $request = new IopRequest($action);
        // $request->setApiName($action);
        $request->addApiParam("refresh_token", $refresh_token);

        try {
            $response = $client->execute($request, null);
            //$this->token = json_decode($response)->access_token;

            $this->refresh_token = json_decode($response)->refresh_token;
            return json_decode($response)->refresh_token;
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }



    public function getProduct($token, $product_id, $currency = "TZS", $language = "en", $shipCountryCode = "TZ",)
    {
        $c = new IopClient(UrlConstants::$api_gateway_url_tw, $this->app_key, $this->app_secret);
        $request = new IopRequest('aliexpress.ds.product.get');

        $request->addApiParam('ship_to_country', $shipCountryCode);
        $request->addApiParam('product_id', $product_id);
        $request->addApiParam('target_currency', $currency);
        $request->addApiParam('target_language', $language);
        $res = $c->execute($request, $token);

        return $res;
    }

    public  function getProducts($category_id, $token, $search_term = null, $result_size = 200, $feed_name = "DS bestseller")
    {
        // $token = $this->getAccessToken();
        $c = new IopClient(UrlConstants::$api_gateway_url_tw, $this->app_key, $this->app_secret);
        $request = new IopRequest('aliexpress.ds.feed.itemids.get');
        $request->addApiParam('page_size', $result_size);
        $request->addApiParam('category_id', $category_id);
        $request->addApiParam('feed_name', $feed_name);
        $request->addApiParam('search_id', $search_term);
        $res = $c->execute($request,  $token);
        return $res;
    }

    public function search_product($token, $keyword, $currency = "TZS", $sort_by = "min_price,asc", $categoryid = null, $local = "zh_CN", $countryCode = "TZ", $page_size = "20", $pageIndex = 1)
    {

        $c = new IopClient(UrlConstants::$api_gateway_url_tw, $this->app_key, $this->app_secret);
        $request = new IopRequest('aliexpress.ds.text.search');
        $request->addApiParam('keyWord', $keyword);
        $request->addApiParam('local', $local);
        $request->addApiParam('countryCode', $countryCode);
        $request->addApiParam('categoryId', $categoryid);
        $request->addApiParam('sortBy', $sort_by);
        $request->addApiParam('pageSize', $page_size);
        $request->addApiParam('pageIndex', $pageIndex);
        $request->addApiParam('currency', $currency);

        // $this->getAccessToken();

        $res = $c->execute($request, $token);

        return $res;
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

    public function getItemListByFeedName($feed_name = 'DS bestseller', $page_no = 1, $page_size = 50, $category_id = null, $country = "TZ", $target_currency = "TZS", $target_language = "en", $sort = "DSRratingAsc")
    {
        $c = new IopClient(UrlConstants::$api_gateway_url_tw, $this->app_key, $this->app_secret);

        $request = new IopRequest('aliexpress.ds.recommend.feed.get');
        $request->addApiParam('country', $country);
        $request->addApiParam('target_currency', $target_currency);
        $request->addApiParam('target_language', $target_language);
        $request->addApiParam('page_size', $page_size);
        $request->addApiParam('sort', $sort);
        $request->addApiParam('page_no', $page_no);
        $request->addApiParam('category_id', $category_id);
        $request->addApiParam('feed_name', $feed_name);
        $res = $c->execute($request);
        return $res;
    }
}
