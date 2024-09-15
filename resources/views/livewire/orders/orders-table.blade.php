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
    @if($orders->lastPage() > 1)
        <div class="row justify-content-between align-items-center px-3 mb-3">
            @if($orders->isEmpty())
                <div class="col-md-auto">
                    <p class="text-center">No records.</p>
                </div>
            @endif
            @if($orders->total() > 0)
                <div class="col-md-auto">
                    Showing {!! $orders->firstItem() !!} to {!! $orders->lastItem() !!} of {!! $orders->total() !!} results
                </div>
                @if ($orders->hasPages())
                    <div class="col-md-auto">
                        {!! $orders->links() !!}
                    </div>
                @endif
            @endif
        </div>
    @endif
    <div class="table-responsive treefy">
        <table class="table table-hover align-middle">
            <thead class="bg-body-tertiary">
                <tr>
                    <th class="text-center">#ID</th>
                    <th>User</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Delivery</th>
                    <th>Notes</th>
                    <th>Placed on</th>
                    {{-- <th wire:click="setSortBy('created_at')" class="sortable">Created at<span class="table-sort-{!! $sortBy !== 'created_at' ? 'desc opacity-50' : ($sortDir == 'ASC' ? 'asc' : 'desc') !!}"></span></th> --}}
                    {{-- <th wire:click="setSortBy('updated_at')" class="sortable">Updated at<span class="table-sort-{!! $sortBy !== 'updated_at' ? 'desc opacity-50' : ($sortDir == 'ASC' ? 'asc' : 'desc') !!}"></span></th> --}}
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $key => $item)
                    <tr id="{!! $item->id !!}" data-node="treetable-{!! $item->id !!}"  @if($item->parent_id) data-pnode="treetable-parent-{!! $item->parent_id !!}" @endif>
                        <td class="text-center">{!! $item->id !!}</td>
                        <td>
                            @if ($item->creator)
                                {{ $item->creator->name }}
                                <p class="mb-0 fs-9"><a href="tel:{{ $item->creator->phone }}" class="text-decoration-none"><i class="bi bi-telephone-fill"></i> {{ $item->creator->phone }}</a></p>
                                <p class="mb-0 fs-9"><a href="mailto:{{ $item->creator->email }}" class="text-decoration-none"><i class="bi bi-envelope-fill"></i> {{ $item->creator->email }}</a></p>
                            @else
                                @if ($user = unserialize($item->details))
                                    {!! $user['first_name']. ' ' .$user['last_name'] !!} - No Account.
                                    <p class="mb-0 fs-9"><a href="tel:{{ $user['phone'] }}" class="text-decoration-none"><i class="bi bi-telephone-fill"></i> {{ $user['phone'] }}</a></p>
                                    <p class="mb-0 fs-9"><a href="mailto:{{ $user['email'] }}" class="text-decoration-none"><i class="bi bi-envelope-fill"></i> {{ $user['email'] }}</a></p>
                                @endif
                            @endif
                        </td>
                        <td>&euro;{!! $item->total_price !!}</td>
                        <td><span class="badge text-bg-{!! $item->status_payment == 'unpaid' ? 'danger' : 'success' !!}">{!! Str::ucfirst( $item->status_payment) !!}</span></td>
                        <td><span class="badge text-bg-{{ $item->statusDeliveryColor() }}">{!! $item->statusDelivery() !!}</span></td>
                        <td>{{ $item->notes ? substr($item->notes, 0, 50) : '-' }}</td>
                        <td>
                            <small>{!! $item->created_at->format('d.m.Y - H:i:s') !!}</small>
                            <br/>
                            <small>{!! $item->updated_at->format('d.m.Y - H:i:s') !!}</small>
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="{!! route('orders.edit', $item->id) !!}" class="btn btn-success btn-sm"><i class="bi bi-eye"></i> View order</a>
                        
                                {{-- {!! Form::open(['route' => ['orders.destroy', $item->id], 'class' => 'd-inline' ,'method' => 'POST']) !!}
                                    @csrf
                                    @method('DELETE')
        
                                    <button type="submit" class="btn btn-fab d-inline"><i class="bi bi-trash-fill text-danger"></i></button>
                                {!! Form::close() !!} --}}
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($orders->isEmpty())
        <div class="row justify-content-between align-items-center">
            <div class="col-md-auto mx-auto">
                <p class="text-center">No records.</p>
            </div>
        </div>
    @endif
    @if($orders->total() > 0)
        <div class="row justify-content-between align-items-center mb-3 px-3">
            <div class="col-md-auto">
                Showing {!! $orders->firstItem() !!} to {!! $orders->lastItem() !!} of {!! $orders->total() !!} results
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
            @if ($orders->hasPages())
                <div class="col-md-auto">
                    {!! $orders->links() !!}
                </div>
            @endif
        </div>
    @endif
</div>
