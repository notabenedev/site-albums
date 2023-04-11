@extends('layouts.boot')

@section('page-title', $tag->title.' - '.config("site-albums.sitePackageName"). '- ')

@section('header-title')
    {{  $tag->title }}
@endsection

@section('content')
    @foreach ($tag->albums as $album)
        {!! $album->getTeaserData($grid) !!}
    @endforeach
@endsection
