<div class="card-body">
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                @isset($page)<th>#</th>@endisset
                <th>{{ config("site-albums.albumTitleName") }} </th>
                <th>Slug</th>
                <th>{{ config("site-albums.albumPersonName") }}</th>
                @canany(["view", "update", "delete"], \App\Album::class)
                    <th>Действия</th>
                @endcanany
            </tr>
            </thead>
            <tbody>
            @foreach ($albumsList as $item)
                <tr>
                    @isset($page)
                        <td>
                            {{ $page * $per + $loop->iteration }}
                        </td>
                    @endisset
                    <td>{{ $item->title }}</td>
                    <td>{{ $item->slug }}</td>
                    <td>{{ $item->person }}</td>
                    @canany(["view", "update", "delete", "publish"], \App\Album::class)
                        <td>
                            <div role="toolbar" class="btn-toolbar">
                                <div class="btn-group btn-group-sm mr-1">
                                    @can("update", \App\Album::class)
                                        <a href="{{ route("admin.albums.edit", ["album" => $item]) }}" class="btn btn-primary">
                                            <i class="far fa-edit"></i>
                                        </a>
                                    @endcan
                                    @can("view", \App\Album::class)
                                        <a href="{{ route('admin.albums.show', ["album" => $item]) }}" class="btn btn-dark">
                                            <i class="far fa-eye"></i>
                                        </a>
                                    @endcan
                                    @can("delete", \App\Album::class)
                                        <button type="button" class="btn btn-danger"
                                                {{ $item->isFixed() ? "disabled" : "" }}
                                                data-confirm="{{ "delete-form-{$item->id}" }}">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @endcan
                                </div>
                                @can("update", \App\Album::class)
                                    <div class="btn-group btn-group-sm">
                                        <button type="button"
                                                class="btn btn-{{ $item->published_at ? "success" : "secondary" }}"
                                                data-confirm="{{ "publish-form-{$item->id}" }}"
                                                {{ $item->isFixed() ? "disabled" : "" }} >
                                            <i class="fas fa-toggle-{{ $item->published_at ? "on" : "off" }}"></i>
                                        </button>
                                    </div>
                                @endcan
                            </div>
                            @if(! $item->isFixed())
                                @can("update", \App\Album::class)
                                    <confirm-form :id="'{{ "publish-form-{$item->id}" }}'" text="Это изменит статус публикации" confirm-text="Да, изменить!">
                                        <template>
                                            <form action="{{ route('admin.albums.publish', ["album" => $item]) }}"
                                                  id="publish-form-{{ $item->id }}"
                                                  class="btn-group"
                                                  method="post">
                                                @csrf
                                                @method("put")
                                            </form>
                                        </template>
                                    </confirm-form>
                                @endcan
                                @can("delete", \App\Album::class)
                                    <confirm-form :id="'{{ "delete-form-{$item->id}" }}'">
                                        <template>
                                            <form action="{{ route('admin.albums.destroy', ["album" => $item]) }}"
                                                  id="delete-form-{{ $item->id }}"
                                                  class="btn-group"
                                                  method="post">
                                                @csrf
                                                <input type="hidden" name="_method" value="DELETE">
                                            </form>
                                        </template>
                                    </confirm-form>
                                @endcan
                            @endif
                        </td>
                    @endcanany
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>