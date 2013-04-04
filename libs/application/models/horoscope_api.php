<?php

class Horoscope_api extends CI_Model{

    const API_URL = 'http://api.jugemkey.jp/api/horoscope';
    const API_KEY = '';
    const API_PW = '';

    private $apikey;
    private $secret;
    private $error;

    public function __construct()
    {
    	parent::__construct();
    	$this->apikey = Horoscope_api::API_KEY;
        $this->secret = Horoscope_api::API_PW;
		require_once(APPPATH.'pear/HTTP/Request.php');
		require_once('horoscope_data.php');
    }

    public function fetch($date = null)
    {
        $body = $this->getData($date);
        if( is_null($body) ){
            return false;
        }

        $json = $this->parseJson($body);

        if( date('d') == date('t') && is_null($date) ){
            $time = time() + ( 60 * 60 * 24 );
            $body = $this->getData( date('Y/m', $time) );
            if($body){
                $tmp = $this->parseJson($body);
                if($tmp){
                    $json['horoscope'] = array_merge($json['horoscope'], $tmp['horoscope']);
                }
            }
        };

        return new Horoscope_data( $json['horoscope'] );
    }

    public function errstr()
    {
        return $this->error;
    }

    private function parseJson($data)
    {
        if( function_exists('json_decode') ){
            return json_decode($data, true);
        }
        else {
            require_once 'JSON.php';
            $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
            return $json->decode($data);
        }
    }

    private function getData($date = null)
    {
        $url  = Horoscope_api::API_URL . "/$date";
        $created = $this->getDate();
        $req = new HTTP_Request($url);
        $req->addHeader('X-JUGEMKEY-API-KEY', $this->apikey);
        $req->addHeader('X-JUGEMKEY-API-CREATED', $created);
        $req->addHeader('X-JUGEMKEY-API-SIG', $this->getSig($created));
        $req->setMethod(HTTP_REQUEST_METHOD_GET);
        $res = $req->sendRequest();
        if(PEAR::isError($res)) {
            $this->error = 'Could not send request.';
            return false;
        }

        if (200 != $req->getResponseCode()) {
            $this->error = $req->getResponseBody();
            return false;
        }

        return $req->getResponseBody();
    }

    private function getSig($date)
    {
        $str = $this->apikey . $date;
        $sig = $this->hmacSha1($this->secret, $str);
        return $sig;
    }

    private function getDate()
    {
        return gmdate('Y-m-d').'T'.gmdate('H:i:s').'Z';
    }

    private function hmacSha1($key, $data)
    {
        $blocksize = 64;
        if (strlen($key) > $blocksize) {
            $key = pack("H*", sha1($key));
        }
        $key  = str_pad($key, $blocksize, chr(0x00));
        $ipad = str_pad("", $blocksize, chr(0x36));
        $opad = str_pad("", $blocksize, chr(0x5c));
        $k_ipad = $key ^ $ipad ;
        $k_opad = $key ^ $opad;

        return sha1($k_opad . pack("H*", sha1($k_ipad . $data)));
    }
}
