<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Input;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use guzzele;


class GitController extends Controller
{
    public function gitsearch(Request $request)
    {
        ;
        $client = new \GuzzleHttp\Client(array('base_uri' => 'https://api.github.com'));
        $searchName = $request->searchName;
        if (empty($searchName)) {


            $searchName = 'taylorotwell';
        }
        $res = $client->request('GET', 'search/users?q=' . $searchName);

        $res = $res->getBody()->getContents();
        $res = \GuzzleHttp\json_decode($res, true);
        $res = $res['items'];

        return view('searchUsers', ['userArr' => $res]);
    }


    public function getFollowers()
    {
        try {
            $client = new Client([
                'base_uri' => 'https://api.github.com/',
                'headers' => [
                    'Authorization' => 'token ' . 'd614cc4a8b8feb6c888460e462cc19ef06aaa1d1'
                ]
            ]);
            $searchName = request()->url;
            $pageNumber = (request()->page) ? request()->page : 1;
            $res = $client->request('GET', "users/" . $searchName . "/followers?page=" . $pageNumber . "&per_page=30");
            $res = $res->getBody()->getContents();
            $res = json_decode($res, true);
        } catch (\Exception $e) {
            return \Response::json([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }

        return \Response::json([
            'success' => true,
            'page' => $pageNumber,
            'collection' => $res
        ]);
    }
}
