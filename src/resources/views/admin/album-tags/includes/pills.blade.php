@if (! empty($tag))
    @include("site-albums::admin.album-tags.includes.breadcrumb")
@endif
<div class="col-12 mb-2">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills">
                @can("viewAny", \App\AlbumTag::class)
                    <li class="nav-item">
                        <a href="{{ route("admin.album-tags.index") }}"
                           class="nav-link{{ isset($isTree) && !$isTree ? " active" : "" }}">
                             {{ config("site-albums.sitePackageName") }} - {{ config("site-albums.siteAlbumTagName") }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.album-tags.index') }}?view=tree"
                           class="nav-link{{ isset($isTree) && $isTree ? " active" : "" }}">
                            Приоритет
                        </a>
                    </li>
                @endcan

                @empty($tag)
                    @can("create", \App\AlbumTag::class)
                        <li class="nav-item">
                            <a href="{{ route("admin.album-tags.create") }}"
                               class="nav-link{{ $currentRoute === "admin.album-tags.create" ? " active" : "" }}">
                                Добавить
                            </a>
                        </li>
                    @endcan
                @else
                    @can("create", \App\AlbumTag::class)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle"
                               data-bs-toggle="dropdown"
                               href="#"
                               role="button"
                               aria-haspopup="true"
                               aria-expanded="false">
                                Добавить
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item"
                                   href="{{ route('admin.album-tags.create') }}">
                                    Основную
                                </a>
{{--                                <a class="dropdown-item"--}}
{{--                                   href="{{ route('admin.albums.create') }}">--}}
{{--                                    Альбом--}}
{{--                                </a>--}}
                            </div>
                        </li>
                    @endcan

                    @can("view", $tag)
                        <li class="nav-item">
                            <a href="{{ route("admin.album-tags.show", ["tag" => $tag]) }}"
                               class="nav-link{{ $currentRoute === "admin.album-tags.show" ? " active" : "" }}">
                                Просмотр
                            </a>
                        </li>
                    @endcan

                    @can("update", $tag)
                        <li class="nav-item">
                            <a href="{{ route("admin.album-tags.edit", ["tag" => $tag]) }}"
                               class="nav-link{{ $currentRoute === "admin.album-tags.edit" ? " active" : "" }}">
                                Редактировать
                            </a>
                        </li>
                    @endcan


                    @can("viewAny", \App\Meta::class)
                        <li class="nav-item">
                            <a href="{{ route("admin.album-tags.metas", ["tag" => $tag]) }}"
                               class="nav-link{{ $currentRoute === "admin.album-tags.metas" ? " active" : "" }}">
                                Метатеги
                            </a>
                        </li>
                    @endcan

                    @can("delete", $tag)
                        <li class="nav-item">
                            <button type="button" class="btn btn-link nav-link"
                                    data-confirm="{{ "delete-form-album-tag-{$tag->id}" }}">
                                <i class="fas fa-trash-alt text-danger"></i>
                            </button>
                            <confirm-form :id="'{{ "delete-form-album-tag-{$tag->id}" }}'">
                                <template>
                                    <form action="{{ route('admin.album-tags.destroy', ['tag' => $tag]) }}"
                                          id="delete-form-album-tag-{{ $tag->id }}"
                                          class="btn-group"
                                          method="post">
                                        @csrf
                                        @method("delete")
                                    </form>
                                </template>
                            </confirm-form>
                        </li>
                    @endcan
                @endif
            </ul>
        </div>
    </div>
</div>