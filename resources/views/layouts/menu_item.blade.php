<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" href="{{ $menu->link }}" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="{{ $menu->icon }}"></i> {{ $menu->name }}
    </a>
    @if ($menu->children->isNotEmpty())
        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            @foreach ($menu->children as $child)
                @include('layouts.menu_item', ['menu' => $child])
            @endforeach
        </ul>
    @endif
</li>
