<?php

use Illuminate\Support\Facades\Route;

Route::group([
"namespace" => "App\Http\Controllers\Vendor\SiteAlbums\Site",
"middleware" => ["web"],
"as" => "site.albums.",
"prefix" => config("site-albums.albumsSiteUrlName"),
], function () {
    Route::get("/", "AlbumController@index")->name("index");
    Route::get("/{album}", "AlbumController@show")->name("show");
});