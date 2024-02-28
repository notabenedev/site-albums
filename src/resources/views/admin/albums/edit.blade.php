@extends('admin.layout')

@section('page-title',$album->title . ' - Редактировать - ')
@section('header-title', "Редактировать {$album->title}")

@section('admin')
    @include("site-albums::admin.albums.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post"
                      class="col-12 needs-validation"
                      enctype="multipart/form-data"
                      action="{{ route('admin.albums.update', ['album' =>$album]) }}">
                    @csrf
                    @method('put')

                    <div class="form-group">
                        <label for="title">{{ config("site-albums.albumTitleName") }} </label>
                        <input type="text"
                               id="title"
                               name="title"
                               value="{{ old('title') ? old('title') :$album->title }}"
                               required
                               class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}">
                        @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input type="text"
                               id="slug"
                               name="slug"
                               value="{{ old('slug') ? old('slug') :$album->slug }}"
                               class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}"
                               {{ $fixed ? "readonly": "" }}
                        >
                        @if ($errors->has('slug'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('slug') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="description">{{ config("site-albums.albumDescriptionName") }}</label>
                        <textarea class="form-control tiny"
                                  name="description"
                                  id="description"
                                  rows="5">
                            {{ old('description') ? old('description') :$album->description }}
                        </textarea>
                    </div>

                    <div class="form-group">
                        <label for="person">{{ config("site-albums.albumPersonName") }}</label>
                        <input type="text"
                               id="person"
                               name="person"
                               value="{{ old('person') ? old('person') :$album->person }}"
                               class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="accent">{{ config("site-albums.albumAccentName") }}</label>
                        <textarea class="form-control"
                                  name="accent"
                                  id="accent"
                                  rows="2">{{ old('accent') ? old('accent') :$album->accent }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="info">{{ config("site-albums.albumInfoName") }}</label>
                        <textarea class="form-control tiny"
                                  name="info"
                                  id="info"
                                  rows="3">
                            {{ old('info') ? old('info') :$album->info }}
                        </textarea>
                    </div>

                    <div class="form-group">
                        @if($album->image)
                            <div class="d-inline-block">
                                @pic([
                                "image" =>  $album->image,
                                "template" => "small",
                                "grid" => [
                                ],
                                "imgClass" => "rounded mb-2",
                                ])
                                <button type="button" class="close ml-1" data-confirm="{{ "delete-form-{$album->id}" }}">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="custom-file">
                            <input type="file"
                                   class="custom-file-input{{ $errors->has('image') ? ' is-invalid' : '' }}"
                                   id="custom-file-input"
                                   lang="ru"
                                   name="image"
                                   aria-describedby="inputGroupMain">
                            <label class="custom-file-label"
                                   for="custom-file-input">
                                Выберите файл главного изображения
                            </label>
                            @if ($errors->has('image'))
                                <div class="invalid-feedback">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        @isset($tags)
                            <label>{{ config("site-albums.siteAlbumTagName") }}:</label>
                            @include("site-albums::admin.album-tags.includes.tree-checkbox", ['tags' => $tags])
                        @endisset
                    </div>

                    <div class="btn-group mt-2"
                         role="group">
                        <button type="submit" class="btn btn-success">Обновить</button>
                    </div>
                </form>

                @if($album->image)
                    <confirm-form :id="'{{ "delete-form-{$album->id}" }}'">
                        <template>
                            <form action="{{ route('admin.albums.show.delete-image', ['album' =>$album]) }}"
                                  id="delete-form-{{$album->id }}"
                                  class="btn-group"
                                  method="post">
                                @csrf
                                <input type="hidden" name="_method" value="DELETE">
                            </form>
                        </template>
                    </confirm-form>
                @endif
            </div>
        </div>
    </div>
@endsection
