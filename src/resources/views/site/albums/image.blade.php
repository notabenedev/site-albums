<div class="col-12 {{ $grid["cols"] }} mb-3">
    <a href="{{ route(class_exists(\App\ImageFilter::class ? 'image-filter' : 'imagecache'), ['template' => 'original', 'filename' => $image->file_name]) }}"
       data-lightbox="{{ isset($lightGroup) ? $lightGroup : "galleryGroup" }}">
        <div class="card card-base">
            <div class="album-image-scale">
                @picLazy([
                "image" => $image,
                "template" => "sm-grid-12",
                "grid" => $grid["grid"],
                "imgClass" => "card-img-top img-fluid",
                ])
            </div>
            @if (empty($hideImageTitle))
                <div class="card-body">
                    <h4>{{ $image->name }}</h4>
                </div>
            @endif
        </div>
    </a>
</div>