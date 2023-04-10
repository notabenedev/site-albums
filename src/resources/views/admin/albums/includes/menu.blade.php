@can("viewAny", \App\AlbumTag::class)
    @if ($theme == "sb-admin")
        @php($active = strstr($currentRoute, 'admin.albums') || strstr($currentRoute, 'admin.album-tags') !== FALSE)
        <li class="nav-item dropdown{{ $active ? ' active' : '' }}">
            <a class="nav-link"
               href="#"
               data-toggle="collapse"
               data-target="#collapse-album-tags-menu"
               aria-controls="#collapse-album-tags-menu"
               aria-expanded="{{ $active ? "true" : "false" }}">
                @isset($ico)
                    <i class="{{ $ico }}"></i>
                @endisset
                <span>{{ config("site-albums.sitePackageName") }}</span>
            </a>
            <div id="collapse-album-tags-menu" class="collapse{{ $active ? " show" : "" }}" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a href="{{ route('admin.albums.index') }}"
                       class="collapse-item{{ strstr($currentRoute, 'admin.albums.') !== FALSE  ? " active" : "" }}">
                        <span>{{ config("site-albums.siteAlbumName") }}</span>
                    </a>
                    <a href="{{ route('admin.album-tags.index') }}"
                       class="collapse-item{{strstr($currentRoute, 'admin.album-tags') !== FALSE ? ' active' : '' }}">
                        <span>{{ config("site-albums.siteAlbumTagName") }}</span>
                    </a>
                </div>
            </div>
        </li>
    @else
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle{{ strstr($currentRoute, 'admin.albums') !== FALSE ? ' active' : '' }}"
               href="#"
               id="user-dropdown"
               role="button"
               data-toggle="dropdown"
               aria-haspopup="true"
               aria-expanded="false">
                @isset($ico)
                    <i class="{{ $ico }}"></i>
                @endisset
                {{ config("site-albums.sitePackageName") }}
            </a>
            <div class="dropdown-menu" aria-labelledby="user-dropdown">
                <a href="{{ route('admin.albums.index') }}"
                   class="dropdown-item">
                    {{ config("site-albums.siteAlbumName") }}
                </a>
                <a href="{{ route('admin.album-tags.index') }}"
                   class="dropdown-item">
                    {{ config("site-albums.siteAlbumTagName") }}
                </a>
            </div>
        </li>
    @endif
@endcan