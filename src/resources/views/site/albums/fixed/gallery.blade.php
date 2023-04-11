@if(isset($album) && $gallery->count())
    <div class="col-12 mb-3">
        <h2>{{ $album->title }}</h2>
    </div>
    @if (! empty($album->description))
        <div class="col-12 mb-3">
            <div class="album-gallery__description">
                {!! $album->description !!}
            </div>
        </div>
    @endif

    @foreach($gallery as $image)
        @if ($loop->first || ($loop->index +1) % 6 == 0 || ($loop->index +1) % 6 == 1 )
            @php($grid = ["grid" => ["lg-grid-6" => 992, "md-grid-6" => 768, "sm-grid-6" => 576], "cols" => " col-sm-6"])
        @else
            @php($grid = ["grid" => ["lg-grid-3" => 992, "md-grid-6" => 768, "sm-grid-6" => 576], "cols" => " col-sm-6 col-lg-3"])
        @endif
        @include("site-albums::site.albums.image", ["grid" => $grid, "image" => $image, "hideImageTitle" => true, "lightGroup" => $album->slug."LightGroup"])
    @endforeach

    <div class="col-12 my-3">
        @if (! empty($album->person))
            <div class="col-12 mb-3">
                <div class="album-gallery__person">
                    <h2>{{ $album->person }}</h2>
                </div>
            </div>
        @endif
        @if (! empty($album->accent))
            <div class="col-12 mb-3">
                <div class="album-gallery__accent">
                    {{ $album->accent }}
                </div>
            </div>
        @endif
         @if (! empty($album->info))
              <div class="col-12 mb-3">
                  <div class="album-gallery__info">
                      {!! $album->info !!}
                  </div>
              </div>
            @endif
    </div>
@endif
