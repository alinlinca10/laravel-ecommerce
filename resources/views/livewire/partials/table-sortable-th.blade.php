{{ $displayName }}
@if ($sortBy !== $name)
    <span class="table-sort-desc opacity-50"></span>
@elseif($sortDir === 'ASC')
    <span class="table-sort-asc"></span>
@else
    <span class="table-sort-desc"></span>
@endif
