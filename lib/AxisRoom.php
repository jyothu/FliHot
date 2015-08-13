<?php
/**
* 
*/
namespace Api;

class AxisRoom
{
    private $api = "http://52.24.104.85:8080/hexapi";
    private $buyer_id = 11;
    private $key = "AXR-ECT";
    private $corporate_buyer_id = 123;

    function __construct( $params )
    {
       $this->action = $params["action"];
       unset($params["action"]);
       $this->params = $params;
       $this->curl = curl_init();
    }

    function post(){
        $this->params["buyer_id"] = $this->buyer_id;
        $this->params["key"] = $this->key;
        $this->params["corporate_buyer_id"] = $this->corporate_buyer_id;
        $jsonInput = str_replace( '\/', '/', json_encode( $this->params, JSON_UNESCAPED_SLASHES ) );

        curl_setopt($this->curl, CURLOPT_URL,            $this->api."/".$this->action );
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1 );
        curl_setopt($this->curl, CURLOPT_POST,           1 );
        curl_setopt($this->curl, CURLOPT_POSTFIELDS,     $jsonInput ); 
        curl_setopt($this->curl, CURLOPT_HTTPHEADER,     array('Content-Type: application/json') ); 

        $jsonResponse = curl_exec( $this->curl );
        curl_close( $this->curl );

        return json_decode( $jsonResponse, true );
    }
}
?>