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

    @php($grid = ["grid" => [], "cols" => "col-md-6 col-lg-3"])
    @foreach($gallery as $image)
        <div class="col-12 {{ $grid["cols"] }} mb-5">
            <div class="album-benefits__icon album-image-scale mb-3">
                @picLazy([
                "image" => $image,
                "template" => "benefit",
                "grid" => $grid["grid"],
                "imgClass" => "img-fluid album-benefits__img",
                ])
            </div>
            <h5 class="album-benefits__title">{{ $image->name }}</h5>
        </div>
    @endforeach

    <div class="col-12 my-3">
        @if (! empty($album->info))
            <div class="col-12 mb-3">
                <div class="album-gallery__info">
                    {!! $album->info !!}
                </div>
            </div>
        @endif
    </div>
@endif
