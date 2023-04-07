<?php

namespace Notabenedev\SiteAlbums\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Meta;
use App\AlbumTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlbumTagController extends Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->authorizeResource(AlbumTag::class, "album-tag");
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
        $view = $request->get("view","default");
        $isTree = $view == "tree";
        if ($isTree) {
            $collection = AlbumTag::query()
                ->select("title", "id", "slug")
                ->orderBy("priority")
                ->get();
            $tags = [];
            foreach ($collection as $item) {
                $tags[] = [
                    'name' => $item->title,
                    "id" => $item->id,
                    "url" => route("admin.album-tags.show", ["tag" => $item])
                ];
            }
        }
        else {
            $collection = AlbumTag::query()
                ->orderBy("priority","asc");
            $tags = $collection->get();
        }
        return view("site-albums::admin.album-tags.index", compact("tags", "isTree"));
    }

    /**
     * Show the form for creating a new resource
     *
     * @param AlbumTag|null $tag
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     */
    public function create(AlbumTag $tag = null)
    {
        return view("site-albums::admin.album-tags.create", [
            "tag" => $tag,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param AlbumTag|null $tag
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function store(Request $request, AlbumTag $tag = null)
    {
        $this->storeValidator($request->all());
        if (empty($tag)) {
            $item = AlbumTag::create($request->all());
        }
        else {
            $item = $tag->children()->create($request->all());
        }

        return redirect()
            ->route("admin.album-tags.show", ["tag" => $item])
            ->with("success", "Добавлено");
    }

    /**
     * Validator
     *
     * @param array $data
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function storeValidator(array $data)
    {
        Validator::make($data, [
            "title" => ["required", "max:150"],
            "slug" => ["nullable", "max:150", "unique:album_tags,slug"],
            "description" => ["nullable"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "description" => "Описание",
        ])->validate();
    }

    /**
     * Display the specified resource.
     *
     * @param AlbumTag $tag
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(AlbumTag $tag)
    {
        // albums
        $collection = []; //$tag->albums()->orderBy("priority")->get();
        $albums = [];
        foreach ($collection as $item) {
            $albums[] = [
                "name" => $item->title,
                "id" => $item->id,
            ];
        }

        return view("site-albums::admin.album-tags.show", [
            "tag" => $tag,
            "albums" => $albums
        ] );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AlbumTag $tag
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     *
     */
    public function edit(AlbumTag $tag)
    {
        return view("site-albums::admin.album-tags.edit", compact("tag"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param AlbumTag $tag
     * @return \Illuminate\Http\RedirectResponse
     *
     */
    public function update(Request $request, AlbumTag $tag)
    {
        $this->updateValidator($request->all(), $tag);
        $tag->update($request->all());

        return redirect()
            ->route("admin.album-tags.show", ["tag" => $tag])
            ->with("success", "Успешно обновлено");
    }

    /**
     * Update validate
     *
     * @param array $data
     * @param AlbumTag $tag
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function updateValidator(array $data, AlbumTag $tag)
    {
        $id = $tag->id;
        Validator::make($data, [
            "title" => ["required", "max:150"],
            "slug" => ["nullable", "max:150", "unique:album_tags,slug,{$id}"],
            "description" => ["nullable"],
        ], [], [
            "title" => "Заголовок",
            "slug" => "Адресная строка",
            "description" => "Описание",
        ])->validate();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AlbumTag $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(AlbumTag $tag)
    {
        $tag->delete();

        return redirect()
            ->route("admin.album-tags.index")
            ->with("success", "Успешно удалено");

    }

    /**
     * Add metas to tag
     *
     * @param AlbumTag $tag
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */

    public function metas(AlbumTag $tag)
    {
        $this->authorize("viewAny", Meta::class);
        $this->authorize("update", $tag);

        return view("site-albums::admin.album-tags.metas", [
            'tag' => $tag,
        ]);
    }


    /**
     * Изменить приоритет
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function changeItemsPriority(Request $request)
    {
        $data = $request->get("items", false);
        if ($data) {
            $result = false ;//StaffDepartmentActions::saveOrder($data);
            if ($result) {
                return response()
                    ->json("Порядок сохранен");
            }
            else {
                return response()
                    ->json("Ошибка, что то пошло не так");
            }
        }
        else {
            return response()
                ->json("Ошибка, недостаточно данных");
        }
    }
}
