<div>
    <div class="row justify-content-end my-3 px-3">
        <div class="col-md-auto mb-3 mb-md-0">
            <form action="{!! $link !!}/search" method="GET">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" wire:model.live.debounce.300ms="search"
                        name="terms" value="{!! old('terms') !!}" class="form-control" id="terms" placeholder="Search" data-link="{!! $link !!}">
                </div>
            </form>
        </div>
    </div>
    @if($products_attributes->lastPage() > 1)
        <div class="row justify-content-between align-items-center px-3 mb-3">
            @if($products_attributes->isEmpty())
                <div class="col-md-auto">
                    <p class="text-center">No records.</p>
                </div>
            @endif
            @if($products_attributes->total() > 0)
                <div class="col-md-auto">
                    Showing {!! $products_attributes->firstItem() !!} to {!! $products_attributes->lastItem() !!} of {!! $products_attributes->total() !!} results
                </div>
                @if ($products_attributes->hasPages())
                    <div class="col-md-auto">
                        {!! $products_attributes->links() !!}
                    </div>
                @endif
            @endif
        </div>
    @endif
    <div class="table-responsive treefy">
        <table class="table table-hover align-middle">
            <thead class="bg-body-tertiary">
                <tr>
                    <th>
                        <div class="form-check">
                            <input class="form-check-input select-all" type="checkbox" value="" id="flexCheckDefault">
                        </div>
                    </th>
                    <th>#ID</th>
                    <th wire:click="setSortBy('name')" class="sortable">Name<span class="table-sort-{!! $sortBy !== 'name' ? 'desc opacity-50' : ($sortDir == 'ASC' ? 'asc' : 'desc') !!}"></span></th>
                    <th>Values</th>
                    <th>Products</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products_attributes as $key => $item)
                    <tr id="{!! $item->id !!}" data-node="treetable-{!! $item->id !!}"  @if($item->parent_id) data-pnode="treetable-parent-{!! $item->parent_id !!}" @endif>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input checkbox-item" type="checkbox" data-itemid="{!! $item->id !!}">
                            </div>
                        </td>
                        <td>{!! $item->id !!}</td>

                        <td><strong><a href="{!! route('attributes.edit', $item->id) !!}">{!! $item->name !!}</a></strong></td>
                        <td>
                            @foreach ($item->values as $key => $attribute)
                                @if ($key < 5)
                                    @if ($attribute->image)
                                        <img src="{{ $attribute->image }}" class="rounded-pill" alt="{{ $attribute->value }}" style="width: 1.5rem; height: 1.5rem;">
                                    @else
                                        {{ $attribute->value }}{{ $loop->last ? '' : ',' }}
                                    @endif
                                @elseif ($key == 5)
                                    + {{ $item->values()->count() - 5 }}
                                @endif
                            @endforeach
                        </td>
                        <td></td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="{!! route('attributes.edit', $item->id) !!}" class="btn btn-fab"><i class="bi bi-pencil-fill text-success"></i></a>
                                <!-- BUTON ACTIV / INACTIV -->
                                <button type="button" class="btn text-primary btn-visibility" data-state="{!! $item->active !!}" data-link="{!! $link !!}" data-itemid="{!! $item->id !!}">
                                    <i class="bi bi-eye{!! $item->active == null ? '-slash' : '' !!}"></i>
                                </button>
                                
                                <form action="{!! route('attributes.destroy', $item->id) !!}" class="d-inline" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-fab d-inline"><i class="bi bi-trash-fill text-danger"></i></button>

                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="row justify-content-between align-items-center px-3 mb-3">
        @if($products_attributes->isEmpty())
            <div class="col-md-auto">
                <p class="text-center">No records.</p>
            </div>
        @endif
        @if($products_attributes->total() > 0)
            <div class="col-md-auto">
                Showing {!! $products_attributes->firstItem() !!} to {!! $products_attributes->lastItem() !!} of {!! $products_attributes->total() !!} results
            </div>
            <div class="col-md-auto">
                <div class="input-group">
                    <span class="input-group-text">Per page</span>
                    <select wire:model.live='perPage'
                        class="form-select">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
            @if ($products_attributes->hasPages())
                <div class="col-md-auto">
                    {!! $products_attributes->links() !!}
                </div>
            @endif
        @endif
    </div>
</div>
