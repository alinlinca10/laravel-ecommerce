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
    @if($products->lastPage() > 1)
        <div class="row justify-content-between align-items-center px-3 mb-3">
            @if($products->isEmpty())
                <div class="col-md-auto">
                    <p class="text-center">No records.</p>
                </div>
            @endif
            @if($products->total() > 0)
                <div class="col-md-auto">
                    Showing {!! $products->firstItem() !!} to {!! $products->lastItem() !!} of {!! $products->total() !!} results
                </div>
                @if ($products->hasPages())
                    <div class="col-md-auto">
                        {!! $products->links() !!}
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
                    <th>Image</th>
                    <th wire:click="setSortBy('name')" class="sortable">Name<span class="table-sort-{!! $sortBy !== 'name' ? 'desc opacity-50' : ($sortDir == 'ASC' ? 'asc' : 'desc') !!}"></span></th>
                    <th wire:click="setSortBy('category_id')" class="sortable">Category<span class="table-sort-{!! $sortBy !== 'category_id' ? 'desc opacity-50' : ($sortDir == 'ASC' ? 'asc' : 'desc') !!}"></span></th>
                    <th wire:click="setSortBy('created_at')" class="sortable">Created at<span class="table-sort-{!! $sortBy !== 'created_at' ? 'desc opacity-50' : ($sortDir == 'ASC' ? 'asc' : 'desc') !!}"></span></th>
                    <th wire:click="setSortBy('updated_at')" class="sortable">Updated at<span class="table-sort-{!! $sortBy !== 'updated_at' ? 'desc opacity-50' : ($sortDir == 'ASC' ? 'asc' : 'desc') !!}"></span></th>
                    <th>Quantity</th>
                    <th>QR Code</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $key => $item)
                    <tr id="{!! $item->id !!}" data-node="treetable-{!! $item->id !!}"  @if($item->parent_id) data-pnode="treetable-parent-{!! $item->parent_id !!}" @endif>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input checkbox-item" type="checkbox" data-itemid="{!! $item->id !!}">
                            </div>
                        </td>
                        <td>{!! $item->id !!}</td>
                        <td>
                            @if($imgs = $item->imgs())
                                @if($img = $imgs->first())
                                    <div class="ratio ratio-1x1">
                                        <img src="{!! $img->picture !!}" class="img-fluid object-fit-cover" alt="{!! $img->alt !!}">
                                    </div>
                                @endif
                            @endif
                        </td>
                        {{-- <td><img src="/products/{!! $item->pictures !!}" class="img-thumbnail" style="max-width: 75px; max-height: 75px;" alt="{!! $item->name !!}"></td> --}}
                        <td>
                            <a href="{!! route('products.edit', $item->id) !!}" class="text-decoration-none fw-light">
                                <strong>{!! $item->name !!}</strong> <span class="d-block fs-9">{!! $item->price !!} RON</span>
                            </a>
                        </td>
                        @if($item->category_id > 0)
                            @if ($parent = $item->category->parent)
                                <td>{!! $parent->path ? $parent->path.'/' : '' !!}{!! $parent->name ? $parent->name.'/' : '' !!}{!! $item->category->name !!}</td>
                            @else
                                <td>{!! ucfirst($item->category->name) !!}</td>
                            @endif
                        @else
                            <td>Fara categorie</td>
                        @endif
                        <td><strong>{!! $item->creator->name !!}</strong> <span class="d-block fs-9">{!! $item->created_at !!}</span></td>
                        <td><strong>{!! $item->creator->name !!}</strong> <span class="d-block fs-9">{!! $item->updated_at !!}</span></td>
                        <td>{!! $item->qty !!}</td>
                        <td><div>{!! QRCode::size(50)->generate($item->code) !!}</div></td>
                        <td class="text-end">
                            <div class="btn-group">
                                <button type="button" class="btn btn-fab" wire:click="highlight({!! $item->id !!})">
                                    <i class="bi bi-star{!! $item->highlight != null ? '-fill' : '' !!} text-warning"></i>
                                </button>
                                <a href="{!! route('products.edit', $item->id) !!}" class="btn btn-fab"><i class="bi bi-pencil-fill text-success"></i></a>
                                <!-- BUTON ACTIV / INACTIV -->
                                <button type="button" class="btn text-primary btn-visibility" data-state="{!! $item->active !!}" data-link="{!! $link !!}" data-itemid="{!! $item->id !!}">
                                    <i class="bi bi-eye{!! $item->active == null ? '-slash' : '' !!}"></i>
                                </button>
                        
                                {{-- @livewire('products.visibility', ['item' => $item, 'link' => $link]) --}}
                                <form action="{{ route('products.destroy', $item->id) }}" class="d-inline" method="POST">
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
    
    @if($products->isEmpty())
        <div class="row justify-content-between align-items-center">
            <div class="col-md-auto mx-auto">
                <p class="text-center">No records.</p>
            </div>
        </div>
    @endif
    @if($products->total() > 0)
        <div class="row justify-content-between align-items-center mb-3 px-3">
            <div class="col-md-auto">
                Showing {!! $products->firstItem() !!} to {!! $products->lastItem() !!} of {!! $products->total() !!} results
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
            @if ($products->hasPages())
                <div class="col-md-auto">
                    {!! $products->links() !!}
                </div>
            @endif
        </div>
    @endif
</div>
