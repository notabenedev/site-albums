@extends('layouts.boot')

@section('page-title', "{$album->title}")

@section('header-title', "{$album->title}")

@section('rawContent')
    <section class="content-section album-gallery">
        <div class="container">
            <div class="row justify-content-start">
                <div class="col-12 mb-3">
                    <h1>{{ $album->title }}</h1>
                </div>
                @if (! empty($album->description))
                    <div class="col-12 mb-3">
                        <div class="album-gallery__description">
                            {!! $album->description !!}
                        </div>
                    </div>
                @endif
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
            @if($gallery->count())
                <div class="row justify-content-start">
                    <div class="col-12">
                        <h3>Изображения</h3>
                    </div>
                </div>
                <div class="row justify-content-start">
                @foreach($gallery as $image)
                    <div class="col-12 {{ $grid["cols"] }} mb-3">
                        <a href="{{ route('imagecache', ['template' => 'original', 'filename' => $image->file_name]) }}"
                            data-lightbox="galleryGroup">
                            <div class="card card-base h-100">
                                <div class="hover-image-scale">
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
                @endforeach
                </div>
            @endif
            <div class="row justify-content-start">
                <div class="col-12 my-3">
                    <a href="{{ route('site.albums.index') }}"
                       class="btn btn-outline-primary">
                        Закрыть альбом
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
