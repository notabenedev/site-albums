<?php

namespace Notabenedev\SiteAlbums\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Album;
use App\Meta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlbumController extends Controller
{

    const PAGER = 20;

    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(Album::class, "album");
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     */
    public function index(Request $request)
    {
        $query = $request->query;
        $albums = Album::query();

        if ($query->get('title')) {
            $title = trim($query->get('title'));
            $albums->where('title', 'LIKE', "%$title%");
        }
        $albums->orderBy('created_at', 'desc');
        return view("site-albums::admin.albums.index", [
            'albumsList' => $albums->paginate(self::PAGER)->appends($request->input()),
            'query' => $query,
            'per' => self::PAGER,
            'page' => $query->get('page', 1) - 1
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view("site-albums::admin.albums.create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->storeValidator($request->all());
        $album = Album::create($request->all());
        $album->uploadImage($request, "albums/main");
        $album->updateTags($request->all(), true);
        $album->publish();
        return redirect()
            ->route("admin.albums.show", ['album' => $album])
            ->with('success', 'Успешно создано');
    }

    /**
     * Валидация сохранения.
     *
     * @param $data
     */
    protected function storeValidator($data)
    {
        Validator::make($data, [
            "title" => ["required", "min:2", "max:100", "unique:albums,title"],
            "slug" => ["nullable", "min:2", "max:100", "unique:albums,slug"],
            "image" => ["nullable", "image"],
        ], [], [
            "title" => config("site-albums.albumTitleName"),
            "slug" => "Адресная строка",
            "image" => "Главное изображение",
        ])->validate();
    }

    /**
     * Display the specified resource.
     *
     * @param Album $album
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Album $album)
    {
        return view("site-albums::admin.albums.show", [
            'album' => $album,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Album $album
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     */
    public function edit(Album $album)
    {
        $fixed = false;
        foreach (config("site-albums.siteAlbumsFixed") as $slug){
            if($album->slug == $slug) {
                $fixed = true;
                break;
            }
        }
        return view("site-albums::admin.albums.edit", [
            'album' => $album,
            'fixed' => $fixed,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Album $album
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function update(Request $request, Album $album)
    {
        $this->updateValidator($request->all(), $album);
        $album->update($request->all());
        $album->uploadImage($request, "albums/main");
        $album->updateTags($request->all(), true);

        return redirect()
            ->route('admin.albums.show', ['album' => $album])
            ->with('success', 'Успешно обновленно');
    }

    /**
     * Валидация обновления.
     *
     * @param $data
     * @param Album $album
     * @return void
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function updateValidator($data, Album $album)
    {
        $id = $album->id;
        Validator::make($data, [
            "title" => ["required", "min:2", "max:100", "unique:albums,title,{$id}"],
            "slug" => ["nullable", "min:2", "max:100", "unique:albums,slug,{$id}"],
            "image" => ["nullable", "image"],
        ], [], [
            'title' => config("site-albums.albumTitleName"),
            "slug" => "Адресная строка",
            'main_image' => 'Главное изображение',
        ])->validate();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Album $album
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Album $album)
    {
        $album->delete();
        return redirect()
            ->route("admin.albums.index")
            ->with('success', 'Успешно удалено');
    }

    /**
     * Страница метатегов.
     *
     * @param Album $album
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function metas(Album $album)
    {
        $this->authorize("update", $album);
        $this->authorize("viewAny", Meta::class);
        return view('site-albums::admin.albums.metas', [
            'album' => $album,
        ]);
    }

    /**
     * Страница галлереи.
     *
     * @param Album $album
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function gallery(Album $album)
    {
        $this->authorize("update", $album);
        return view("site-albums::admin.albums.gallery", [
            'album' => $album,
        ]);
    }

    /**
     * Удалить главное изображение.
     *
     * @param Album $album
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function deleteImage(Album $album)
    {
        $this->authorize("update", $album);
        $album->clearImage();
        return redirect()
            ->back()
            ->with('success', 'Изображение удалено');
    }

    /**
     * Изменить статус публикации.
     *
     * @param Album $album
     * @return \Illuminate\Http\RedirectResponse
     */
    public function publish(Album $album)
    {
        $album->publish();

        return redirect()
            ->back()
            ->with('success',"Статус публикации изменен");

    }

    /**
     * Приоритет.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function priority()
    {
        $collection = Album::query()
            ->select("title", "id", "slug")
            ->orderBy("priority")
            ->get();
        $priority = [];
        foreach ($collection as $item) {
            $priority[] = [
                'name' => $item->title,
                "id" => $item->id,
                "url" => route("admin.albums.show", ["album" => $item])
            ];
        }
        return view("site-albums::admin.albums.priority", [
            'priority' => $priority
        ]);
    }



}
