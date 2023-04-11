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
                @if (count($album->tags) > 0)
                    <div class="col-12 mb-3">
                        <ul class="list-inline album-gallery__ul">
                            @foreach($album->tags as $tag)
                                <li class="list-inline-item">
                                    <a href="{{ route("site.album-tags.show", ["tag" => $tag]) }}" class="text-secondary"
                                       title="{{ $tag->title }}">
                                        {{ $tag->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
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
                    @include("site-albums::site.albums.image", ["grid" => $grid, "image" => $image])
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
