<div class="nav-scroller py-1 mb-2">
    <nav class="nav d-flex justify-content-between">
        @foreach($menuitems as $item)
            <a class="p-2 link-secondary" href="#">{{ $item->title }}</a>
        @endforeach

        <a class="p-2 link-secondary" href="{{ route('contacts') }}">Contacts</a>
    </nav>
</div>
