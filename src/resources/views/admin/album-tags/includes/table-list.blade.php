<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>Заголовок</th>
            <th>Адресная строка</th>
            @canany(["edit", "view", "delete"], \App\AlbumTag::class)
                <th>Действия</th>
            @endcanany
        </tr>
        </thead>
        <tbody>
        @foreach ($tags as $item)
            <tr>
                <td>{{ $item->title }}</td>
                <td>{{ $item->slug }}</td>
                @canany(["edit", "view", "delete"], \App\AlbumTag::class)
                    <td>
                        <div role="toolbar" class="btn-toolbar">
                            <div class="btn-group mr-1">
                                @can("update", \App\AlbumTag::class)
                                    <a href="{{ route("admin.album-tags.edit", ["tag" => $item]) }}"
                                       class="btn btn-primary">
                                        <i class="far fa-edit"></i>
                                    </a>
                                @endcan
                                @can("view", \App\AlbumTag::class)
                                    <a href="{{ route('admin.album-tags.show', ["tag" => $item]) }}"
                                       class="btn btn-dark">
                                        <i class="far fa-eye"></i>
                                    </a>
                                @endcan
                                @can("delete", \App\AlbumTag::class)
                                    <button type="button"
                                            class="btn btn-danger"
                                            data-confirm="{{ "delete-form-{$item->id}" }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                @endcan
                            </div>
                        </div>
                        @can("delete", \App\AlbumTag::class)
                            <confirm-form :id="'{{ "delete-form-{$item->id}" }}'">
                                <template>
                                    <form action="{{ route('admin.album-tags.destroy', ["tag" => $item]) }}"
                                          id="delete-form-{{ $item->id }}"
                                          class="btn-group"
                                          method="post">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                    </form>
                                </template>
                            </confirm-form>
                        @endcan
                    </td>
                @endcanany
            </tr>
        @endforeach
        <tr class="text-center">
            @canany(["edit", "view", "delete"], \App\AlbumTag::class)
                <td colspan="3">
            @else
                <td colspan="2">
            @endcanany
                </td>
        </tr>
        </tbody>
    </table>
</div>