<?php
return [
    "sitePackageName" => "Галерея",
    "siteAlbumTagName" => "Теги",
    "siteAlbumName" => "Альбомы",

    "albumsSiteUrlName" => "gallery",
    "albumUrlName" => "album",
    "albumTagUrlName" => "tag",

    "albumTitleName" => "Заголовок",
    "albumDescriptionName" => "Описание",
    "albumPersonName" => "Автор",
    "albumAccentName" => "Акцент",
    "albumInfoName" => "Дополнительно",
    "albumGalleryName" => "Галерея",

    "siteBreadcrumb" => true,

    "siteAlbumsFixed" => array("zagolovok"),

    "albumTagAdminRoutes" => true,
    "albumAdminRoutes" => true,
    "albumTagSiteRoutes" => true,

    "albumTagFacade" => \Notabenedev\SiteAlbums\Helpers\AlbumTagActionsManager::class,

];