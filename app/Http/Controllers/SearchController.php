<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Services\GithubService;

class SearchController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function gitSearch()
    {
        $validator = $this->customValidate(['username' => request()->get('username')]);
        if ($validator) {
            return view('search-users',
                [
                    'errorMessage' => 'username should be Alpha-Numeric'
                ]);
        };
        $githubService = new GithubService([
            'username' => request()->get('username')
        ]);
        $userArr = $githubService
            ->setParams([
                'username' => request()->get('username'),
                'sort' => request()->get('sort'),
                'location' => request()->get('location'),
            ])
            ->getUsers();

        return view('search-users',
            [

                'userArr' => $userArr,
                'errorMessage' => false
            ]);
    }

    /**
     * @param $username
     * @param $page
     * @return mixed
     */
    public function getFollowers($username, $page)
    {
        $validator = $this->customValidate(['page' => $page,]);
        if ($validator) {
            return \Response::json(
                [
                    'success' => false,
                    'validationMessage' => $validator->messages(),
                ]);
        }
        $githubService = new GithubService();
        $followerArr = $githubService
            ->setParams([
                'username' => $username,
                'page' => $page,
                'per-page' => 30,
                'token' => '6fdcaea1b70310ab0c7ad204d89e731cd9b065c0',
            ])
            ->getFollowers();
        return \Response::json(
            [
                'success' => true,
                'page' => $page,
                'collection' => $followerArr,
            ]);
    }

    /**
     * @param $username
     * @param $page
     * @return mixed
     */
    public function getRepos($username, $page)
    {
        $validator = $this->customValidate(['page' => $page,]);
        if ($validator) {
            return \Response::json(
                [
                    'success' => false,
                    'validationMessage' => $validator->messages(),
                ]);
        }
        $githubService = new GithubService();
        $repoArr = $githubService
            ->setParams([
                'username' => $username,
                'page' => $page,
                'per-page' => 30,
                'token' => '6fdcaea1b70310ab0c7ad204d89e731cd9b065c0',
            ])
            ->getRepos();
        return \Response::json(
            [
                'success' => true,
                'page' => $page,
                'repoArr' => $repoArr,

            ]);


    }


    public function getTwitterUser(){


}

    /**
     * @param array $parametrs
     * @return bool|\Illuminate\Support\MessageBag
     */
    private function customValidate($parametrs = [])
    {
        $validator = Validator::make(

            $parametrs,
            [

                'username' => ['alpha_num'],
                'page' => ['regex:/^[0-9]+$/'],
            ]
        );
        return $validator->fails() ? $validator->errors() : false;
    }

}
