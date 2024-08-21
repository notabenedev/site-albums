@extends('admin.layout')

@section('page-title', config("site-albums.siteAlbumName"). ' - ')
@section('header-title', config("site-albums.siteAlbumName"))

@section('admin')
    @include("site-albums::admin.albums.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <form action="{{ route($currentRoute) }}"
                      class="d-lg-flex"
                      method="get">
                    <label class="sr-only" for="title">{{ config("site-albums.albumTitleName") }} </label>
                    <input type="text"
                           class="form-control mb-2 me-sm-2"
                           id="title"
                           name="title"
                           value="{{ $query->get('title') }}"
                           placeholder="{{ config("site-albums.albumTitleName") }} ">

                    <button type="submit" class="btn btn-primary mb-2 me-sm-1">Применить</button>
                    <a href="{{ route($currentRoute) }}" class="btn btn-secondary mb-2">Сбросить</a>
                </form>
            </div>
           @include("site-albums::admin.albums.includes.table-list", ["albumsList" => $albumsList,"page" => $page,"per" => $per])
        </div>
    </div>

    @if ($albumsList->lastPage() > 1)
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    {{ $albumsList->links() }}
                </div>
            </div>
        </div>
    @endif
@endsection
