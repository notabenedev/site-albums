## Config
    php artisan vendor:publish --provider="Notabenedev\SiteAlbums\AlbumsServiceProvider" --tag=config

## Install
    php artisan migrate
    php artisan make:albums
                            {--all : Run all}
                            {--models : Export models}
                            {--controllers : Export models}
                            {--observers : Export observers}
                            {--policies : Export policies}
                            {--only-default : preset only default rules}
                            {--menu : preset only default rules}
                            {--fill : fill fixed albums from Config}
    npm run dev