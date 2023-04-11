<div class="col-12 {{ $grid["cols"] }} mb-3">
    <div class="card card-base h-100 album-teaser">
        @if ($album->image)
            <a href="{{ route("site.albums.show", ['album' => $album]) }}">
                <div class="album-image-scale">
                    @picLazy([
                    "image" => $album->image,
                    "template" => "sm-grid-12",
                    "grid" => $grid["grid"],
                    "imgClass" => "card-img-top album-teaser__image",
                    ])
                </div>
            </a>
        @endif
        <div class="card-body album-teaser__title">
            <a href="{{ route("site.albums.show", ['album' => $album]) }}">
                <h3>{{ $album->title }}</h3>
            </a>
            @if (count($album->tags))
                <ul class="list-inline album-teaser__ul">
                    @foreach($album->tags as $tag)
                        <li class="list-inline-item">
                            <a href="{{ route("site.album-tags.show", ["tag" => $tag]) }}" class="text-secondary"
                               title="{{ $tag->title }}">
                                {{ $tag->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>


