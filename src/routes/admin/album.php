<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vendor\SiteAlbums\Admin\AlbumController;
Route::group([
    'namespace' => 'App\Http\Controllers\Vendor\SiteAlbums\Admin',
    'middleware' => ['web', 'management'],
    'as' => 'admin.',
    'prefix' => 'admin',
], function () {

    Route::group([
        "prefix" => config("site-albums.albumUrlName"),
        "as" => "albums.",
    ],function (){
        Route::get("/", [AlbumController::class, "index"])->name("index");
        Route::get("/create", [AlbumController::class, "create"])->name("create");
        Route::post("", [AlbumController::class, "store"])->name("store");
        Route::get("/{album}", [AlbumController::class, "show"])->name("show");
        Route::get("/{album}/edit", [AlbumController::class, "edit"])->name("edit");
        Route::put("/{album}", [AlbumController::class, "update"])->name("update");
        Route::delete("/{album}", [AlbumController::class, "destroy"])->name("destroy");
    });

    // Публикация
    Route::put(config("site-albums.albumUrlName")."/{album}/publish", "AlbumController@publish")
        ->name("albums.publish");

    // Изменить вес
    Route::put(config("site-albums.albumUrlName")."/tree/priority", [AlbumController::class,"changeItemsPriority"])
        ->name("albums.item-priority");

    Route::group([
        'prefix' => config("site-albums.albumUrlName").'/{album}',
        'as' => 'albums.show.',
    ], function () {
        Route::get('metas', 'AlbumController@metas')
            ->name('metas');
        Route::get('gallery', 'AlbumController@gallery')
            ->name('gallery');
        Route::delete('delete-image', 'AlbumController@deleteImage')
            ->name('delete-image');
    });

});