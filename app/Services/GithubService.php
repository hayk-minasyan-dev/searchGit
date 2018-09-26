<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class GithubService
{
    protected $username;
    protected $page = 1;
    protected $perPage = 30;
    protected $token = null;
    protected $sort = 'followers';
    protected $location = '';

    /**
     * GithubService constructor.
     */
    function __construct()
    {

    }
//private function __call($name,$arguments){
// return $name($arguments);
//}

    /**
     * @param $username
     * @return $this
     */
    public function setUsername($username)
    {

        $this->username = $username;
        return $this;
    }

    /**
     * @param $page
     * @return $this
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @param $perPage
     * @return $this
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
        return $this;
    }

    public function setParams($params = [])
    {
        foreach ($params as $key => $item) {
            $method = 'set' . $this->toCamel($key);
            $this->{$method}($item);
        }
        return $this;
    }

    /**
     * @param $token
     * @return $this
     */
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    public function setLocation($country)
    {
        $this->location = $country;
        return $this;
    }

    /**
     * @param $sort
     * @return $this
     */
    public function setSort($sort)
    {
        $this->sort = $sort;
        return $this;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getUsers()
    {

        $result = $this->requestResult(
            $this->getBaseLink(),
            $this->getSearchUrl(
                [
                    'q' => $this->username,

                ])
        );


        return $this->parseResult($result)['items'];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getFollowers()
    {
        $result = $this->requestResult(
            $this->getBaseLink($this->token),
            $this->getFollowersUrl($this->username, $this->customParametrs())
        );
        return $this->parseResult($result);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getRepos()
    {
        $result = $this->requestResult(
            $this->getBaseLink($this->token),
            $this->getReposUrl($this->username, $this->customParametrs())

        );
        return $this->parseResult($result);
    }

    /**
     * @param array $parametrs
     * @return string
     */
    private function getSearchUrl(array $parametrs = [])
    {

        if (!empty($this->location))
            return 'search/users?' . http_build_query($parametrs) . '+location:' . $this->location . '&sort=' . $this->sort;
        else {
            return 'search/users?' . http_build_query($parametrs) . '&sort=' . $this->sort;
        }
    }

    /**
     * @param $userName
     * @param array $parametrs
     * @return string
     */
    private function getFollowersUrl($userName, $parametrs = [])
    {
        return 'users/' . $userName . "/followers?" . http_build_query($parametrs);
    }

    /**
     * @param $userName
     * @param array $parametrs
     * @return string
     */
    private function getReposUrl($userName, $parametrs = [])
    {
        return 'users/' . $userName . '/repos?' . http_build_query($parametrs);
    }

    /**
     * @param $baseUrl
     * @param $url
     * @return mixed
     */
    private function requestResult($baseUrl, $url)
    {
        return $baseUrl->request('GET', $url);
    }

    /**
     * @param null $token
     * @param array $headers
     * @return Client
     */
    private function getBaseLink($token = null, $headers = [])
    {
        $defaultHeader = ['Authorization' => 'token ' . $token,];
        $headers = array_merge($defaultHeader, $headers);
        if ($token == null) {
            return new Client(['base_uri' => 'https://api.github.com']);
        } else {
            return new Client([
                'base_uri' => 'https://api.github.com/',
                'headers' => $headers,
            ]);
        }
    }

    /**
     * @param $result
     * @return \Illuminate\Support\Collection
     */
    private function parseResult($result)
    {
        $result = json_decode(
            $result
                ->getBody()
                ->getContents()
        );
        return collect($result);
    }

    /**
     * @return array
     */
    private function customParametrs()
    {
        $arr = [
            'page' => $this->page,
            'per_page' => $this->perPage,
        ];
        return $arr;

    }

    private function toCamel($str)
    {
        $str[0] = strtoupper($str[0]);
        $pos=strpos($str,'-');
        if($pos){
           $str=str_replace('-'.$str[$pos+1],strtoupper($str[$pos+1]),$str);
        }
        return $str;
    }


}