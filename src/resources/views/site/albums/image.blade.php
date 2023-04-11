<div class="col-12 {{ $grid["cols"] }} mb-3">
    <a href="{{ route('imagecache', ['template' => 'original', 'filename' => $image->file_name]) }}"
       data-lightbox="galleryGroup">
        <div class="card card-base h-100">
            <div class="album-image-scale">
                @picLazy([
                "image" => $image,
                "lightbox" => "galleryGroup",
                "template" => "sm-grid-12",
                "grid" => $grid["grid"],
                "imgClass" => "card-img-top",
                ])
            </div>
            <div class="card-body">
                <h4>{{ $image->name }}</h4>
            </div>
        </div>
    </a>
</div>