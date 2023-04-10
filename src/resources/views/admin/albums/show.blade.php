@extends('admin.layout')

@section('page-title', config("site-albums.siteAlbumName").' - ')
@section('header-title', config("site-albums.siteAlbumName")." {$album->title}")

@section('admin')
    @include("site-albums::admin.albums.includes.pills")

    <div class="col-12">
        @if($album->image)
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Изображение</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-inline-block">
                            @img([
                            "image" => $album->image,
                            "template" => "medium",
                            "lightbox" => "lightGroup" . $album->id,
                            "imgClass" => "rounded mb-2",
                            "grid" => [],
                            ])
                            @can("update",\App\Album::class)
                                <button type="button" class="close ml-1" data-confirm="{{ "delete-form-{$album->id}" }}">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            @endcan
                        </div>
                        @can("update",\App\Album::class)
                            <confirm-form :id="'{{ "delete-form-{$album->id}" }}'">
                                <template>
                                    <form action="{{ route('admin.albums.show.delete-image', ['album' => $album]) }}"
                                          id="delete-form-{{ $album->id }}"
                                          class="btn-group"
                                          method="post">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                    </form>
                                </template>
                            </confirm-form>
                        @endcan
                    </div>
                </div>
        @endif
        <div class="card mb-2">
            <div class="card-header">
                <h5 class="card-title">{{ config("site-albums.albumDescriptionName") }}</h5>
            </div>
            <div class="card-body">
                {!! $album->description !!}
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-header">
                <h5 class="card-title">{{ config("site-albums.albumPersonName") }}</h5>
            </div>
            <div class="card-body">
                {{ $album->person }}
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-header">
                <h5 class="card-title">{{ config("site-albums.albumAccentName") }}</h5>
            </div>
            <div class="card-body">
                {{ $album->accent }}
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-header">
                <h5 class="card-title">{{ config("site-albums.albumInfoName") }}</h5>
            </div>
            <div class="card-body">
                {!! $album->info !!}
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-header">
                <h5 class="card-title">{{ config("site-albums.siteAlbumTagName") }}</h5>
            </div>
            <div class="card-body">
                @foreach ($album->tags as $tag)
                    <a href="{{ route("admin.album-tags.show", ["tag" => $tag]) }}" class="badge badge-pill badge-secondary">{{ $tag->title }}</a>
                @endforeach
            </div>
        </div>
    </div>
@endsection