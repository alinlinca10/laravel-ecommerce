@extends('admin.layouts.app')

@section('scripts')
    <script type="text/javascript">      
        $('.select2').select2();

        $(".select3").select2({
            tags: true,
        });    
    </script>
@stop

@section('content')

<form action="{!! route('orders.update', $item->id) !!}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    {{-- <button type="submit" class="btn btn-success btn-save">Save</button> --}}
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! $link !!}" class="link-underline link-underline-opacity-0">{!! $section !!}</a></li>
                    <li class="breadcrumb-item"><a href="{!! $link !!}/{!! $item->id !!}/edit" class="link-underline link-underline-opacity-0">Order #{!! $item->id !!}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
                <h2 id="table-group-dividers">
                    <strong>View order #{!! $item->id !!}</strong>
                    <a class="anchor-link" href="#"></a>
                </h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="row">
                    <div class="col-md">
                        <div class="card">
                            <div class="card-body p-4">
                                <h6 class="card-subtitle mb-3 fs-7 text-body-tertiary">Total</h6>
                                <h2 class="card-title"><strong>&euro;{!! $item->total_price !!}</strong></h2>
                                <span class="badge text-bg-{!! $item->status_payment == 'unpaid' ? 'danger' : 'success' !!}">{!! Str::ucfirst( $item->status_payment) !!}</span>
                                <span class="badge text-bg-{{ $item->statusDeliveryColor() }}">{!! $item->statusDelivery() !!}</span>

                                {{-- GET CUSTOMER DETAILS
                                @php
                                    $session_id = $item->session_id;
                                    $order = App\Models\Store\Order::where('session_id', $session_id)->first();
                                @endphp --}}
                            </div>
                        </div>
                    </div>
                    <div class="col-md">
                        <div class="card">
                            <div class="card-body p-4">
                                <h6 class="card-subtitle mb-3 fs-7 text-body-tertiary">Products</h6>
                                <h2 class="card-title"><strong>{!! $item->order_products()->count() !!}</strong></h2>
                                <p class="card-text fs-7">
                                    @php
                                        $qty = $item->order_products()->pluck('qty');
                                    @endphp
                                    Quantity: {!! $qty->sum() !!}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($order_details = $item->details())
                    <div class="card m-0">
                        <h5 class="card-header">Customer</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="first_name" class="form-label">First name</label>
                                        <input type="text" name="first_name" value="{!! $order_details['first_name'] ?? '-' !!}" class="form-control" id="first_name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="last_name" class="form-label">Last name</label>
                                        <input type="text" name="last_name" value="{!! $order_details['last_name'] ?? '-' !!}" class="form-control" id="last_name">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-mail</label>
                                        <input type="text" name="email" value="{!! $order_details['email'] ?? '-' !!}" class="form-control" id="email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" name="phone" value="{!! $order_details['phone'] ?? '-' !!}" class="form-control" id="phone">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" name="address" value="{!! $order_details['address'] ?? '-' !!}" class="form-control" id="address">
                                    </div>
                                </div>
                                
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="country" class="form-label">Country</label>
                                        <input type="text" name="country" value="{!! $order_details['country'] ?? '-' !!}" class="form-control" id="country">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="county" class="form-label">County</label>
                                        <input type="text" name="county" value="{!! $order_details['county'] ?? '-' !!}" class="form-control" id="county">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="locality" class="form-label">Locality</label>
                                        <input type="text" name="locality" value="{!! $order_details['locality'] ?? '-' !!}" class="form-control" id="locality">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="notes" class="form-label">Notes</label>
                                        <textarea class="form-control" name="notes" id="notes" rows="3">
                                            {!! $item->notes !!}
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="card">
                    <h5 class="card-header">Products</h5>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table align-middle table-hover">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @dd ($item->order_products()) --}}
                                    @foreach ($item->order_products() as $product)
                                        <tr>
                                            <td>
                                                <div class="ratio ratio-1x1">
                                                    <img src="{!! $product->options->picture !!}" class="img-fluid object-fit-contain" style="max-height: 100px;" alt="{!! $product->name !!}">
                                                </div>
                                            </td>
                                            <td>{!! $product->name !!}</td>
                                            <td>&euro;{!! $product->price !!}</td>
                                            <td>{!! $product->qty !!}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
    
                <button type="submit" class="btn btn-success">Save changes</button>
                <a href="{!! $link !!}" class="btn btn-light border border-1">Cancel</a>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <h5 class="card-header">QR Code</h5>
                    <div class="card-body text-center">
                        <div>
                            {!! QRCode::size(100)->generate($item->id) !!}
                        </div>
                        <p class="text-muted"><small>This QR code represents order id.</small></p>
                    </div>
                </div>
                <div class="card">
                    <h5 class="card-header">Status</h5>
                    <div class="card-body">
                        <label for="status_delivery">Status</label>
                        <select name="status_delivery" id="status_delivery" class="form-select select2">
                            @foreach (General::statusDelivery() as $key => $status)
                                <option value="{{ $key }}" {{ $item->status_delivery == $key ? 'selected' : '' }}>{!! $status !!}</option>
                            @endforeach
                        </select>
                        <p class="mb-0 mt-4"><strong>Created at</strong></p>
                        <p class="text-muted">{!! $item->created_at->format('d.m.Y - H:i:s') !!}</p>
                        <p class="m-0"><strong>Last modified at</strong></p>
                        <p class="text-muted">{!! $item->updated_at->format('d.m.Y - H:i:s') !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="row">
    <div class="img-add-template" style="display: none;">
        <div class="col-md-2 text-center mb-3 mx-2 p-0 dropzone border-0">
            <div class="dz-preview dz-processing dz-error dz-complete dz-image-preview m-0 w-100">
                <div class="img mb-3">
                    <img src="" class="img-fluid img-showcase object-fit-cover shadow w-100" alt="" style="height: 150px;">
                    {!! Form::hidden('imgs[pictures][]', old('imgs[pictures][]', null), ['class' => 'img-link']) !!}
                    {!! Form::hidden('imgs[alt][]', old('imgs[alt][]', null), ['class' => 'img-alt-text']) !!}                    
                </div>
                <a href="#" class="img-edit text-decoration-none">
                    <i class="bi bi-pencil-fill text-success"></i>
                </a>
                <a href="#" class="img-alt text-decoration-none">
                    <i class="bi bi-chat-dots"></i>
                </a>
                <a class="dz-remove img-delete" href="#">Remove file</a>
            </div>
        </div>
    </div>
    
    <div class="img-alt-modal-template" style="display: none;">
        <div class="modal-header">
            <h5 class="modal-title">Text alt</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <div class="row">
            <div class="col-md-6 offset-md-3">
            <input type="text" class="input-img-alt form-control" placeholder="Text alt" value="">
            </div>
        </div>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-link" data-bs-dismiss="modal">Close</button>
        {!! Form::submit('Save', ['class' => 'btn btn-success submit-img-alt']) !!}
        </div>
    </div>
</div>

@stop