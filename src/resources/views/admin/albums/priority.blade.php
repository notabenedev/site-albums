@extends("admin.layout")

@section("page-title", "Приоритет - ". config("site-albums.siteAlbumName"))
@section('header-title', "Приоритет - ".config("site-albums.siteAlbumName"))

@section('admin')
    @include("site-albums::admin.albums.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <universal-priority :url="'{{ route("admin.vue.priority", ['table' => "albums", "field" => "priority"]) }}'"
                                    :elements="{{ json_encode($priority) }}">
                </universal-priority>
            </div>
        </div>
    </div>
@endsection