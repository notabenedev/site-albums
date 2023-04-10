<?php

use Illuminate\Support\Facades\Route;

Route::group([
"namespace" => "App\Http\Controllers\Vendor\SiteAlbums\Site",
"middleware" => ["web"],
"as" => "site.album-tags.",
"prefix" => config("site-albums.albumsSiteUrlName")."/".config("site-albums.albumTagUrlName"),
], function () {
    Route::get("/{tag}", "AlbumController@show")->name("show");
});