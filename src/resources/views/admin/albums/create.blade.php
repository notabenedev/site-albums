@extends('admin.layout')

@section('page-title', config("site-albums.siteAlbumName").' - Добавить - ')
@section('header-title',  config("site-albums.siteAlbumName").' - Добавить')

@section('admin')
    @include("site-albums::admin.albums.includes.pills")
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form method="post"
                      class="col-12 needs-validation"
                      enctype="multipart/form-data"
                      action="{{ route('admin.albums.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="title">{{ config("site-albums.albumTitleName") }} <span class="text-danger">*</span></label>
                        <input type="text"
                               id="title"
                               name="title"
                               value="{{ old('title') }}"
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
                               Name="slug"
                               value="{{ old('slug') }}"
                               class="form-control{{ $errors->has('slug') ? ' is-invalid' : '' }}">
                        @if ($errors->has('slug'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('slug') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="description">{{ config("site-albums.albumDescriptionName") }}</label>
                        <textarea class="form-control tiny {{ $errors->has('description') ? ' is-invalid' : '' }}"
                                  name="description"
                                  id="description"
                                  rows="5">
                            {{ old('description') }}
                        </textarea>
                        @if ($errors->has('description'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="person">{{ config("site-albums.albumPersonName") }}</label>
                        <input type="text"
                               id="person"
                               Name="person"
                               value="{{ old('person') }}"
                               class="form-control">
                        @if ($errors->has('person'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('person') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="accent">{{ config("site-albums.albumAccentName") }}</label>
                        <textarea class="form-control {{ $errors->has('accent') ? ' is-invalid' : '' }}"
                                  name="accent"
                                  id="accent"
                                  rows="2">{{ old('accent') }}</textarea>
                        @if ($errors->has('accent'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('accent') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="info">{{ config("site-albums.albumInfoName") }}</label>
                        <textarea class="form-control tiny {{ $errors->has('info') ? ' is-invalid' : '' }}"
                                  name="info"
                                  id="info"
                                  rows="3">
                            {{ old('info') }}
                        </textarea>
                        @if ($errors->has('info'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('info') }}</strong>
                            </span>
                        @endif
                    </div>

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

                    <div class="form-group mt-3">
                        @isset($tags)
                            <label>{{ config("site-albums.siteAlbumTagName") }}:</label>
                           @include("site-albums::admin.album-tags.includes.tree-checkbox", ['tags' => $tags])
                        @endisset
                    </div>

                    <div class="btn-group mt-2"
                         role="group">
                        <button type="submit" class="btn btn-success">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
