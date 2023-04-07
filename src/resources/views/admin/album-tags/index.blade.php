@extends("admin.layout")

@section("page-title", config("site-albums.sitePackageName")." - ". config("site-albums.siteAlbumTagName")." - ")

@section('header-title', config("site-albums.sitePackageName")." - ". config("site-albums.siteAlbumTagName"))

@section('admin')
    @include("site-albums::admin.album-tags.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @if ($isTree)
                    @include("site-albums::admin.album-tags.includes.tree", ["tags" => $tags])
                @else
                    @include("site-albums::admin.album-tags.includes.table-list", ["tags" => $tags])
                @endif
            </div>
        </div>
    </div>
@endsection