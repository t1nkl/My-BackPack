<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        SitemapGenerator::create('http://backpack.dev')->hasCrawled(function (Url $url) {
            if ($url->segment(1) === 'login' || $url->segment(1) === 'register' || $url->segment(1) === 'admin') {
                return;
            }
            return $url;
        })->writeToFile(public_path('sitemap.xml'));

        return view('home');
    }
}
