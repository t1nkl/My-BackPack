<?php

namespace App\Http\Controllers\Admin;

use Config;
use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

class SitemapGeneratorController
{

    public function index()
    {
        SitemapGenerator::create(Config::get('app.url'))->hasCrawled(function (Url $url) {
            if ($url->segment(1) === 'login' || $url->segment(1) === 'register' || $url->segment(1) === 'admin') {
                return;
            }
            return $url;
        })->writeToFile(public_path('sitemap.xml'));

        return view('home');
    }
}
