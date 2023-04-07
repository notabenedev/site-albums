@can("update", \App\AlbumTag::class)
    <universal-priority :elements="{{ json_encode($tags) }}"
                         :url="'{{ route("admin.vue.priority",['table' => "album_tags", "field" => "priority"]) }}'">
    </universal-priority>
@else
    <ul>
        @foreach ($tags as $tag)
            <li>
                @can("view", \App\AlbumTag::class)
                    <a href="{{ route('admin.album-tags.show', ['tag' => $tag["slug"]]) }}"
                       class="btn btn-link">
                        {{ $tag["title"] }}
                    </a>
                @else
                    <span>{{ $tag['title'] }}</span>
                @endcan
            </li>
        @endforeach
    </ul>
@endcan
