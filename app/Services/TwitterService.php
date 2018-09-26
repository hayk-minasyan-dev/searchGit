<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Guzzle\Plugin\Oauth\OauthPlugin;
class TwitterService
{
 public function __construct()
 {

 }

 private function getBaseLink($token,$headers=[]){

     $client=new Client('https://api.twitter.com/{version}',array(
         'version'=>'v1.1'
     ));
     $client->addSubscriber(new Guzzle\Plugin\Oauth\OauthPlugin(array(
         'consumer_key'  => $twitter['consumer_key'],
         'consumer_secret' => $twitter['consumer_secret'],
         'token'       => $twitter['access_token'],
         'token_secret'  => $twitter['access_token_secret']
     )));
 }

}