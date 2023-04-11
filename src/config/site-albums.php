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
    "siteAlbumsGrid" => 3,
    "siteAlbumGalleryGrid" => 4,

    "siteAlbumsFixed" => array(
        "works" => "Наши работы",
    ),
    "benefitBgColor" => 'fff',

    "albumTagAdminRoutes" => true,
    "albumAdminRoutes" => true,
    "albumTagSiteRoutes" => true,
    "albumSiteRoutes" => true,

    "albumTagFacade" => \Notabenedev\SiteAlbums\Helpers\AlbumTagActionsManager::class,

];