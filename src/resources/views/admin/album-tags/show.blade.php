@extends("admin.layout")

@section("page-title", "{$tag->title} - ". config("site-albums.siteAlbumTagName"))

@section('header-title',  config("site-albums.siteAlbumTagName")." - {$tag->title}")

@section('admin')
    @include("site-albums::admin.album-tags.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Заголовок</dt>
                    <dd class="col-sm-9">{{ $tag->title }}</dd>
                    @if ($tag->slug)
                        <dt class="col-sm-3">Адрес</dt>
                        <dd class="col-sm-9">{{ $tag->slug }}</dd>
                    @endif
                    @if ($tag->description)
                        <dt class="col-sm-3">Описание</dt>
                        <dd class="col-sm-9">{!! $tag->description !!}</dd>
                    @endif
                </dl>
            </div>
        </div>
    </div>
@endsection