<a href="/home" class="page-link mb-3 {{ isset($current_tab) ? '' : 'bg-info text-light' }}"> Main </a>
@can('categories')
    <a href="{{ route('categories.index') }}"
       class="page-link mb-3 {{ isset($current_tab) ? ($current_tab == 'categories') ? 'bg-info text-light' : '' : '' }}">
        Categories
    </a>
@endcan
@can('delete_item')
    <a href="{{ route('items.index') }}"
       class="page-link mb-3 {{ isset($current_tab) ? ($current_tab == 'items') ? 'bg-info text-light' : '' : '' }}">
        Items List
    </a>
@endcan
@can('delete_item')
    <a href="{{ route('items.index', ['hidden' => 1]) }}"
       class="page-link mb-3 {{ isset($current_tab) ? ($current_tab == 'items') ? 'bg-info text-light' : '' : '' }}">
        Hidden Items
    </a>
@endcan
<a href="/users"
   class="page-link mb-3 {{ isset($current_tab) ? ($current_tab == 'users') ? 'bg-info text-light' : '' : '' }}">
    Users
</a>
