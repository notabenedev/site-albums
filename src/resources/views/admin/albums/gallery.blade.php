@extends('admin.layout')

@section('page-title', config("site-albums.albumGalleryName").' - ')
@section('header-title', config("site-albums.albumGalleryName")." {$album->title}")

@section('admin')
    @include("site-albums::admin.albums.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <gallery csrf-token="{{ csrf_token() }}"
                         upload-url="{{ route('admin.vue.gallery.post', ['id' => $album->id, 'model' => 'album']) }}"
                         get-url="{{ route('admin.vue.gallery.get', ['id' => $album->id, 'model' => 'album']) }}">
                </gallery>
            </div>
        </div>
    </div>
@endsection