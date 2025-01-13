@extends('layouts.boot')

@section('page-title', config("site-albums.sitePackageName"). '- ')

@section('header-title')
    {{ config("site-albums.sitePackageName") }}
@endsection

@section('content')
    @foreach ($albums as $id => $album)
        {!! $album->getTeaserData($grid) !!}
    @endforeach
    <div class="col-12 my-3">
        {{ $albums->links() }}
    </div>
@endsection
