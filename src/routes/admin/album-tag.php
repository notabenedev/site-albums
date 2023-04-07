<?php
use Illuminate\Support\Facades\Route;

use \App\Http\Controllers\Vendor\SiteAlbums\Admin\AlbumTagController;

Route::group([
    "middleware" => ["web", "management"],
    "as" => "admin.",
    "prefix" => "admin",
], function () {
    Route::group([
        "prefix" => config("site-albums.albumUrlName")."/".config("site-albums.albumTagUrlName"),
        "as" => "album-tags.",
    ],function (){
        Route::get("/", [AlbumTagController::class, "index"])->name("index");
        Route::get("/create", [AlbumTagController::class, "create"])->name("create");
        Route::post("", [AlbumTagController::class, "store"])->name("store");
        Route::get("/{tag}", [AlbumTagController::class, "show"])->name("show");
        Route::get("/{tag}/edit", [AlbumTagController::class, "edit"])->name("edit");
        Route::put("/{tag}", [AlbumTagController::class, "update"])->name("update");
        Route::delete("/{tag}", [AlbumTagController::class, "destroy"])->name("destroy");
    });

    Route::group([
        "prefix" => config("site-albums.albumUrlName")."/".config("site-albums.albumTagUrlName")."/{tag}",
        "as" => "album-tags.",
    ], function () {

        // Meta.
        Route::get("metas", [AlbumTagController::class,"metas"])
            ->name("metas");
    });
}
);
