<div class="scrollable-cart">
    @if (Cart::total() == 0)
        <p class="text-center mt-2">Cosul dvs. de cumparaturi este gol</p>
    @else
        @foreach (Cart::content()->groupBy('id') as $cart_products)
            @foreach ($cart_products as $key => $cart)
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0">
                        <img src="{!! $cart->options->picture !!}" class="img-fluid" width="150" alt="">
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <p class="mb-0"><strong>{!! $cart->name !!}</strong></p>
                        <p class="mb-0"><strong>{!! $cart->price !!} RON</strong></p>
                        {{-- {!! Form::select('qty', [1,2,3,4,5], $cart->qty, ['class' => 'form-select']) !!} --}}
                    </div>
                    <button type="button" class="btn" onclick="confirmDeleteItem('{{ $cart->id }}', '{{ $cart->name }}')"><i class="bi bi-trash-fill text-danger"></i></button>
                    {{-- <a href="/cart/remove/{!! $cart->rowId !!}"><i class="bi bi-trash-fill text-danger"></i></a> --}}
                </div>
                <hr />
            @endforeach
        @endforeach
    @endif
</div>