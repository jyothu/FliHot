<?php
/**
* 
*/
namespace Api;

class MistiFly
{
    private $accountNumber = 'MCN004188';
    private $userName = 'ENCHANTINGXML';
    private $password = "ENCHANTING2015_xml";
    private $target = 'Test';
    private $soapApi = 'http://apidemo.myfarebox.com/V2/OnePoint.svc?wsdl';

    function __construct()
    {
        $this->client = new \SoapClient( $this->soapApi );
    }

    function soapCall( $params, $action ){
        $response = $this->client->$action( $params );
        
        switch ( $action ) {
            case 'CreateSession':
                return $response->CreateSessionResult->SessionId;
                break;
            case 'AirLowFareSearch':
                return $response->AirLowFareSearchResult;
                break;

            default:
                # code...
                break;
       }
    }

    function createSession(){
        $params = array('rq' => array(
           'AccountNumber' => $this->accountNumber,
           'UserName' => $this->userName,
           'Password' => $this->password,
           'Target' => $this->target
        ));

        return $this->soapCall( $params, 'CreateSession' );
    }
}
?>