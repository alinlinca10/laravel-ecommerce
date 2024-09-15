@extends('frontend.layouts.app')

@section('scripts')
    @parent
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (() => {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        const forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
            }

            form.classList.add('was-validated')
            }, false)
        })
        })()
    </script>
@stop
@section('content')
    <br />
    <br />
    <br />
    <br />
    <br />
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1><strong>Place order</strong></h1>
            </div>
        </div>
        <form action="{!! route('post_order') !!}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-7">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="firstName" class="form-label">First name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="first_name" id="firstName" value="" required="">
                        </div>

                        <div class="col-sm-6">
                            <label for="lastName" class="form-label">Last name<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="last_name" id="lastName" value="" required="">
                        </div>

                        <div class="col-6">
                            <label for="email" class="form-label">Email<span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="email" pattern="[^@\s]+@[^@\s]+\.[^@\s]+" required  placeholder="name@gmail.com">
                        </div>

                        <div class="col-6">
                            <label for="phone" class="form-label">Phone number<span class="text-danger">*</span></label>
                            {{-- <div class="input-group flex-nowrap">
                                <span class="input-group-text p-0">
                                    <select name="phone_prefix" class="form-select rounded-0">
                                        @foreach (App\Models\Country::phonecode() as $phone_code)
                                            <option value="{!! $phone_code['phonecode'] !!}">{!! $phone_code['name'].'-'.$phone_code['phonecode'] !!}</option>
                                        @endforeach
                                    </select>
                                </span>
                                <input type="text" class="form-control" name="phone" id="phone" required>
                            </div> --}}
                            <input type="text" class="form-control" name="phone" id="phone" required>
                        </div>

                        <div class="col-12">
                            <label for="address" class="form-label">Address<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="address" id="address" required="" placeholder="Old Hall Street 21">
                        </div>

                        <div class="col-md-4">
                            <label for="country" class="form-label">Country<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="country" id="country" required="" placeholder="United Kingdom">
                        </div>

                        <div class="col-md-4">
                            <label for="county" class="form-label">County<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="county" id="county" required="" placeholder="Liverpool">
                        </div>

                        <div class="col-md-4">
                            <label for="state" class="form-label">Locality<span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="locality" id="state" required="" placeholder="Liverpool">
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="same-address">
                        <label class="form-check-label" for="same-address">Shipping address is the same as my billing
                            address</label>
                    </div>

                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="save-info">
                        <label class="form-check-label" for="save-info">Save this information for next time</label>
                    </div>

                    <hr class="my-4">

                    <h4>Payment</h4>

                    <div class="mb-3">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="form-check">
                                    <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked="" required="">
                                    <label class="form-check-label" for="credit">
                                        Online (Stripe)
                                    </label>
                                </div>
                            </div>
                            <div class="col-md text-end">
                                <a href="https://stripe.com/" target="_blank">
                                    <img src="/dir/logo-stripe.svg" class="img-fluid" alt="Logo Stripe" style="max-height: 50px;" title="See our payment processator website">
                                </a>
                            </div>
                        </div>
                        
                        {{-- <div class="form-check">
                            <input id="debit" name="paymentMethod" type="radio" class="form-check-input"
                                required="">
                            <label class="form-check-label" for="debit">Debit card</label>
                        </div>
                        <div class="form-check">
                            <input id="paypal" name="paymentMethod" type="radio" class="form-check-input"
                                required="">
                            <label class="form-check-label" for="paypal">PayPal</label>
                        </div> --}}
                    </div>

                    {{-- Checkout --}}
                    <div class="row">
                        <div class="col-12">
                            <button class="w-100 btn btn-primary" type="submit">Checkout</button>
                            <p class="mt-3 fs-7"><small><i class="bi bi-check-circle-fill text-success"></i> After you click "Checkout" button, you will be redirected to <a href="https://stripe.com/">Stripe</a> secure payment page.</small></p>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                    @if(Cart::count() > 0)
                        <div class="row sticky-top" style="top: 100px;">
                            <div class="col-md-12">
                                @foreach (Cart::content()->groupBy('id') as $cart_products)
                                    @foreach ($cart_products as $key => $cart)
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <img src="{!! $cart->options->picture !!}" class="img-fluid" width="120" alt="">
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="mb-0"><strong>{!! $cart->name !!}</strong></p>
                                                <p class="mb-0"><strong>{!! $cart->price !!} RON</strong></p>
                                            </div>
                                        </div>
                                        <hr />
                                    @endforeach
                                @endforeach
                            </div>
                            <div class="col-md-12 bg-body-tertiary p-4">
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
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection
