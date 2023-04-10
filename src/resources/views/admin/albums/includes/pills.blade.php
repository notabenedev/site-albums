<div class="col-12 mb-2">
    <div class="card">
        <div class="card-body">
            <ul class="nav nav-pills">
                @can("viewAny", \App\Album::class)
                    <li class="nav-item">
                        <a href="{{ route("admin.albums.index") }}"
                           class="nav-link{{ $currentRoute === "admin.albums.index" ? " active" : "" }}">
                            Список
                        </a>
                    </li>
                @endcan
                @can("update", \App\Album::class)
                    <li class="nav-item">
                        <a href="{{ route("admin.albums.priority") }}"
                           class="nav-link{{ $currentRoute === "admin.albums.priority" ? " active" : "" }}">
                            Приоритет
                        </a>
                    </li>
                @endcan
                @can("create", \App\Album::class)
                    <li class="nav-item">
                        <a href="{{ route("admin.albums.create") }}"
                           class="nav-link{{ $currentRoute === "admin.albums.create" ? " active" : "" }}">
                            Добавить
                        </a>
                    </li>
                @endcan
                @if (! empty($album))
                    @can("view", \App\Album::class)
                        <li class="nav-item">
                            <a href="{{ route("admin.albums.show", ["album" => $album]) }}"
                               class="nav-link{{ $currentRoute === "admin.albums.show" ? " active" : "" }}">
                                Просмотр
                            </a>
                        </li>
                    @endcan

                    @can("update", \App\Album::class)
                        <li class="nav-item">
                            <a class="nav-link{{ $currentRoute == 'admin.albums.edit' ? ' active' : '' }}"
                               href="{{ route('admin.albums.edit', ['album' => $album]) }}">
                                Редактировать
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link{{ $currentRoute == 'admin.albums.show.gallery' ? ' active' : '' }}"
                               href="{{ route('admin.albums.show.gallery', ['album' => $album]) }}">
                                {{ config("site-albums.albumGalleryName") }}
                            </a>
                        </li>
                        @can("viewAny", \App\Meta::class)
                            <li class="nav-item">
                                <a class="nav-link{{ $currentRoute == 'admin.albums.show.metas' ? ' active' : '' }}"
                                   href="{{ route('admin.albums.show.metas', ['album' => $album]) }}">
                                    Метатеги
                                </a>
                            </li>
                        @endcan
                    @endcan

                    @can("delete", \App\Album::class)
                        <li class="nav-item">
                            <button type="button" class="btn btn-link nav-link"
                                    data-confirm="{{ "delete-form-album-{$album->id}" }}">
                                <i class="fas fa-trash-alt text-danger"></i>
                            </button>
                            <confirm-form :id="'{{ "delete-form-album-{$album->id}" }}'">
                                <template>
                                    <form action="{{ route('admin.albums.destroy', ['album' => $album]) }}"
                                          id="delete-form-album-{{ $album->id }}"
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