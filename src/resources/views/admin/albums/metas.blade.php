@extends('admin.layout')

@section('page-title', 'Meta - ')
@section('header-title', 'Meta')

@section('admin')
    @include("site-albums::admin.albums.includes.pills")
    <div class="col-12 mt-2">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Добавить мета-тег</h5>
            </div>
            <div class="card-body">
                @include("seo-integration::admin.meta.create", ['model' => 'albums', 'id' => $album->id])
            </div>
        </div>
    </div>
    <div class="col-12 mt-2">
        <div class="card">
            <div class="card-body">
                @include("seo-integration::admin.meta.table-models", ['metas' => $album->metas])
            </div>
        </div>
    </div>
@endsection
