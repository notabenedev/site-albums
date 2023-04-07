<ul class="list-unstyled">
    @foreach ($tags as $tag)
        <li>
            <div class="custom-control custom-checkbox">
                <input class="custom-control-input"
                       type="checkbox"
{{--                       {{ (! count($errors->all()) ) && (isset($album) && $album->hasTag($tag->id)) || old('check-' . $tag->id) ? "checked" : "" }}--}}
                       value="{{ $tag->id }}"
                       id="check-{{ $tag->id }}"
                       name="check-{{ $tag->id }}">
                <label class="custom-control-label" for="check-{{ $tag->id }}">
                    <a href="{{ route("admin.album-tags.show",["tag" => $tag]) }}"
                       class="text-primary"
                       target="_blank">
                        {{ $tag->title }}
                    </a>
                </label>
            </div>
        </li>
    @endforeach
</ul>

