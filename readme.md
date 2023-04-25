## Description
- альбомы:
  заголовок, slug, описание, автор, акцент, инфо, приоритет, статус публикации  в разделе + галерея изображений
- теги:
  заголовок, slug, описание, приоритет

На странице Галерей альбомы выводятся в порядке приоритета. Изображения в альбоме также выводятся по приоритету.

Заголовки полей Альбома можно заменить в конфиге, html можно занести в поля Описание и Инфо.

Можно в конфиге указать фиксированные альбомы (slug которых нельзя изменить, такой альбом нельзя удалить).
Фиксированные альбомы могут, например, использоваться в верстке блоков на главной странице сайта. 

Для вывода фиксированных альбомов созданы два шаблона - галерея и преимущества, можно подключить их к шаблону страниц, передав предварительно параметры $album (альбом) и $gallery (изображения альбома)

## Config
    php artisan vendor:publish --provider="Notabenedev\SiteAlbums\AlbumsServiceProvider" --tag=config

## Install
    php artisan migrate
    php artisan vendor:publish --provider="Notabenedev\SiteAlbums\AlbumsServiceProvider" --tag=public --force
    php artisan make:albums
                            {--all : Run all}
                            {--models : Export models}
                            {--controllers : Export models}
                            {--observers : Export observers}
                            {--policies : Export policies}
                            {--only-default : preset only default rules}
                            {--scss : Export scss}
                            {--menu : preset only default rules}
                            {--fill : fill fixed albums from Config}
    npm run dev

## Update
    v0.0.2 Add metas to album tag