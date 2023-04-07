@extends("admin.layout")

@section("page-title", "{$tag->title} - ".config("site-albums.siteAlbumTagName"). " - ")

@section('header-title', config("site-albums.siteAlbumTagName")." - {$tag->title}")

@section('admin')
    @include("site-albums::admin.album-tags.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title">Добавить тег</h5>
            </div>
            <div class="card-body">
                @include("seo-integration::admin.meta.create", ['model' => 'album-tags', 'id' => $tag->id])
            </div>
        </div>
    </div>
    <div class="col-12 mt-2">
        <div class="card">
            <div class="card-body">
                @include("seo-integration::admin.meta.table-models", ['metas' => $tag->metas])
            </div>
        </div>
    </div>
@endsection