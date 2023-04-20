<?php
namespace App\Repository\Situator;

use App\Models\PeopleModel;
use GuzzleHttp\Client as guzz;
use GuzzleHttp\Psr7\Request;
use App\Exceptions\ClientException;


trait LoginSituatorTrait{

    protected $teste;
    protected $cookie;
    protected $client;
    protected $apiUrl;
    protected $userName;
    protected $password;
    protected $accountId;
    protected $rememberMe;

    protected function setDataLogin($apiUrl, $userName, $password, $accountId, $rememberMe)
    {
        $this->apiUrl = $apiUrl;
        $this->userName = $userName;
        $this->password = $password;
        $this->accountId = $accountId;
        $this->rememberMe = $rememberMe;
    }
    
    protected function setCookieLogin()
    {
        $cookieJar   = $this->client->getConfig('cookies');
        $cookiesList = $cookieJar->toArray(); 
        $cookieAuth  = null;
        foreach($cookiesList = $cookieJar->toArray() as $cookie){
            if(!isset($cookie['Name'])){
                continue;
            }
            if($cookie['Name'] == self::COOKIE_AUTH_NAME){
                $cookieAuth = $cookie['Value'];
            }
        }
        if(!$cookieAuth){
            throw new \Exception('Invalid cookie in login: '.self::COOKIE_AUTH_NAME);
        }
        $this->cookie = $cookiesList[0]['Value'];
    }

    protected function checkCurrentUser()
    {
        if($this->getCurrentUser() != $this->accountId){
            throw new \Exception('Invalid Current UserId');
        }
    }

    protected function getCurrentUser()
    {
        $request = new Request('GET', $this->apiUrl.self::ENDPOINT_CURRENT_USER, self::HEADER);
        $res = $this->client->sendAsync($request)->wait();
        $data = json_decode($res->getBody()->getContents());
        return $data->id;
    }

    public function login($apiUrl, $userName, $password, $accountId, $rememberMe)
    {
        $this->setDataLogin($apiUrl, $userName, $password, $accountId, $rememberMe);
        $body = array(
            'userName'   => $this->userName,
            'password'   => $this->password,
            'accountId'  => $this->accountId,
            'rememberMe' => $this->rememberMe
        );

        $bodyJson = json_encode($body);
        $request = new Request('PUT', $this->apiUrl.self::ENDPOINT_LOGIN, self::HEADER, $bodyJson);
        $res = $this->client->sendAsync($request)->wait();
        $this->setCookieLogin();
        $this->checkCurrentUser();
        //return($res->getBody()->getContents());  
    }

}