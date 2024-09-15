@extends('frontend.layouts.app')

{{-- @section('scripts')
@parent
    <script>
        window.confirmDeleteItem = function(id,name) {
            Swal.fire({
                icon: 'question',
                text: 'Ești sigur că vrei să stergi acest produs din coș?',

            }).then((result) => {
                if(result.isConfirmed) {
                    $.ajax({
                        url: '/cart/remove/d03f99e501c4ce57e1b63eb2a8fcd325',
                        type: 'GET',
                        async: true,
                        cache: false,
                        data: {},
                        beforeSend: function () {
                        },
                        success: function (data) {

                        },
                        error: function () {

                        }
                    });
                    Swal.fire(
                        'Produs sters2',
                        'success'
                    );
                }
            });
        } 
    </script>
@stop --}}
@section('content')

    <div class="container" style="margin-top: 100px;">
        @if(Cart::count() > 0)
            <div class="row">
                <div class="col-md-8">
                    <h1><strong>Shopping cart</strong></h1>
                    <p>You've added {!! Cart::count() == 1 ? Cart::count().' product' : Cart::count().' products' !!} în coș.</p>
                    <br />
                    <p><i class="bi bi-box-seam"></i> Free delivery on orders above 100&euro;</p>
                </div>
                <div class="col-md-8">
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
                                {{-- <button type="button" class="btn" onclick="confirmDeleteItem('{{ $cart->id }}', '{{ $cart->name }}')"><i class="bi bi-trash-fill text-danger"></i></button> --}}
                                <a href="/cart/remove/{!! $cart->rowId !!}"><i class="bi bi-trash-fill text-danger"></i></a>
                            </div>
                            <hr />
                        @endforeach
                    @endforeach
                </div>
                <div class="col-md-4 bg-body-tertiary p-4">
                    <div class="row">
                        <div class="col-6">
                            <p><strong>Subtotal</strong></p>
                        </div>
                        <div class="col-6 text-end">
                            {{ Cart::subtotal() }} RON
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p><strong>Delivery</strong></p>
                        </div>
                        <div class="col-6 text-end">
                            FROM 0,00 RON
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-0"><strong>Total</strong></p>
                            <p class="text-muted mt-0" style="font-size: .875rem;">with TVA</p>
                        </div>
                        <div class="col-6 text-end">
                            <strong>{{ Cart::subtotal() }} RON</strong>
                        </div>
                    </div>
                    
                    {{-- Checkout --}}
                    <div class="row">
                        <div class="col-12">
                            <a href="/checkout/place-order" class="btn btn-dark d-block">Place order</a>
                        </div>
                    </div>
                    <br />
                    <br />
                    <br />
                    {{-- Info --}}
                    <div class="row">
                        <div class="col-12">
                            <p><i class="bi bi-shop-window"></i> Livrarea în magazin mereu gratuită</p>
                            <p><i class="bi bi-box-seam"></i> Livrare gratuită la achiziții de articole cu preț întreg de peste 180 RON</p>
                            <p><i class="bi bi-arrow-return-left"></i> Retur gratuit în termen de 30 de zile</p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-12 text-center mt-5">
                    <h1><strong>Coșul de cumpărături este gol</strong></h1>
                    <p>Dacă ai adăugat produse în coș la vizita trecută pe site, te rugăm să te loghezi.</p>
                    <div class="d-grid gap-2 col-4 mx-auto my-5">
                        <a class="btn btn-primary btn-block" href="/login">Logare</a>
                    </div>
                    <a href="/" class="text-muted">SAU CONTINUĂ CUMPĂRĂTURILE</a>
                </div>
            </div>
        @endif
    </div>

@endsection