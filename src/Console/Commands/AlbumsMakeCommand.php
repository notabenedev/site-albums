<?php

namespace Notabenedev\SiteAlbums\Console\Commands;

use App\Menu;
use App\MenuItem;
use PortedCheese\BaseSettings\Console\Commands\BaseConfigModelCommand;


class AlbumsMakeCommand extends BaseConfigModelCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:albums
    {--all : Run all}
    {--models : Export models}
    {--controllers : Export controllers}
    {--policies : Export policies}    
    {--only-default :  Fill only default policies} 
    {--observers : Export observers}   
    {--menu : Create admin menu}
    ';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Settings for site-albums package';

    /**
     * Vendor Name
     * @var string
     *
     */
    protected $vendorName = 'Notabenedev';

    /**
     * Package Name
     * @var string
     *
     */
    protected $packageName = 'SiteAlbums';

    /**
     * The models to  be exported
     * @var array
     */
    protected $models = ["AlbumTag", "Album"];

    /**
     * Policies
     * @var array
     *
     */
    protected $ruleRules = [
        [
            "title" => "Теги альбомов",
            "slug" => "album-tags",
            "policy" => "AlbumTagPolicy",
        ],
        [
            "title" => "Альбомы",
            "slug" => "albums",
            "policy" => "AlbumPolicy",
        ],
    ];

    /**
     * Make Controllers
     */
    protected $controllers = [
        "Admin" => ["AlbumTagController", "AlbumController"],
    ];

    /**
     * Создание наблюдателей
     *
     * @var array
     */
    protected $observers = ["AlbumTagObserver"];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $all = $this->option("all");

        if ($this->option("models") || $all) {
            $this->exportModels();
        }

        if ($this->option("policies") || $all) {
            $this->makeRules();
        }

        if ($this->option("controllers") || $all) {
            $this->exportControllers("Admin");
        }

        if ($this->option("observers") || $all) {
            $this->exportObservers();
        }

        if ($this->option("menu") || $all) {
            $this->makeMenu();
        }

        return 0;
    }


    protected function makeMenu()
    {
        try {
            $menu = Menu::query()
                ->where('key', 'admin')
                ->firstOrFail();
        }
        catch (\Exception $e) {
            return;
        }

        $title = config("site-albums.sitePackageName");
        $itemData = [
            'title' => $title,
            'template' => "site-albums::admin.albums.includes.menu",
            'url' => "#",
            'ico' => 'far fa-images',
            'menu_id' => $menu->id,
        ];

        try {
            $menuItem = MenuItem::query()
                ->where("menu_id", $menu->id)
                ->where('title', $title)
                ->firstOrFail();
            $menuItem->update($itemData);
            $this->info("Элемент меню '$title' обновлен");
        }
        catch (\Exception $e) {
            MenuItem::create($itemData);
            $this->info("Элемент меню '$title' создан");
        }
    }
}
