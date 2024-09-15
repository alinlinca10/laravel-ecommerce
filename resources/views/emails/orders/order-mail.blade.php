<style>
:root {
--primary: #111;
/* --primary: #006039; */
--secondary: #f7b707;
}
.content {
    color: #111;
}
.text-center {
    text-align: center;
}
.text-black {
    color: #111;
}
.border-top {
    border-top: 2px solid var(--primary); 
}
.border-bottom {
    border-bottom: 2px solid var(--primary); 
}
.footer span {
    display: block;
    color: #aaa;
    font-size: .725rem;
    font-weight: 600;
}
.border {
    border: 1px solid lightgray;
}
.border-radius-20 {
    border-radius: 20px;
}
.p-1 {
    padding: 10px;
}
.p-2 {
    padding: 20px;
}
.p-3 {
    padding: 30px;
}
p {
    margin-bottom: 0px;
}
.mt-3 {
    margin-top: 1.5rem;
}
fieldset {
    /* border-radius: 20px; */
    border: 1px solid lightgray;
}
</style>

<div class="border-bottom">
<div class="hero" style="display: flex; align-items: center; justify-content: space-between;">
<svg class="site-logo" xmlns="http://www.w3.org/2000/svg" width="110" height="22" viewBox="0 0 110 22" fill="none" style="margin: 20px;">
    <g clip-path="url(#clip0_365_23075)">
    <path d="M8.829 0H0V21.575H8.829C15.0895 21.575 18.695 17.0766 18.695 10.7875C18.695 4.49837 15.0895 0 8.829 0ZM8.18567 17.9887H4.27287V3.58628H8.18567C11.7288 3.58628 14.2973 5.86412 14.2973 10.7875C14.2973 15.7109 11.7336 17.9887 8.18567 17.9887Z" fill="black"></path>
    <path d="M48.3314 18.8435H20.3513V21.5798H48.3314V18.8435Z" fill="black"></path>
    <path d="M99.6346 18.8435H71.6401V21.5798H99.6346V18.8435Z" fill="black"></path>
    <path d="M61.5916 5.59193C59.4504 5.59193 57.9237 6.37986 56.8867 7.6883V0H52.9163V21.575H56.613V19.6028C57.65 21.1213 59.2391 22.0048 61.5628 22.0048C65.5332 22.0048 68.5002 18.8435 68.5002 13.8007C68.5002 8.75798 65.5668 5.5967 61.5964 5.5967L61.5916 5.59193ZM60.6458 18.5665C58.447 18.5665 56.733 16.8331 56.733 13.796C56.733 10.7588 58.3846 8.99675 60.6746 8.99675C62.9647 8.99675 64.4626 10.8782 64.4626 13.796C64.4626 16.7137 62.9023 18.5665 60.641 18.5665H60.6458Z" fill="black"></path>
    <path d="M108.444 0L106.874 3.98741L105.218 0H103.663V5.39614H104.772V1.57586L106.37 5.39614H107.364L108.905 1.51856V5.39614H110V0H108.444Z" fill="black"></path>
    <path d="M97.8918 1.01715H99.697V5.39614H100.892V1.01715H102.683V0H97.8918V1.01715Z" fill="black"></path>
    </g>
    <defs>
    <clipPath id="clip0_365_23075">
    <rect width="110" height="22" fill="black"></rect>
    </clipPath>
    </defs>
    </svg>
{{-- <img src="{{ asset('/dir/logo.svg') }}" width="150" height="auto" class="img-fluid" alt="Register Order"> --}}
</div>
</div>

<div class="content">
{{-- <img src="{{ asset('/dir/mail-order-template.jpg') }}" width="100%" height="auto" class="img-fluid" alt="Inregistrare comanda - {!! Settings::get('name') !!}"> --}}
{{-- @dd($order) --}}
<h1 class="text-center text-black mt-3">Order #{!! $order->id !!} has been registered.</h1>

<x-mail::table>

|     Product         |     Quantity      |                     Variant                 |          Price        |
|:-------------------:|:-----------------:|:-------------------------------------------:|:---------------------:|
@foreach(unserialize($order->products) as $prod)
| {!! $prod->name !!} |{!! $prod->qty !!} | {!! $prod->options->option_value ?? '-' !!} | {!! $prod->price !!}  |
@endforeach
|    Total costs:     |                   |                                             |{!! $order->total_price !!}|
{{-- @if($voucher_offer = $order->voucher_offer())
| Oferta voucher      |                    |                                             | - {!! $voucher_offer->value !!}
@endif
@if($client_offer = $order->client_offer())
| Oferta client       |                    |                                             | - {!! $client_offer->value !!}
@endif
@if($order_offer = $order->order_offer())
| Oferta comanda      |                    |                                             | - {!! $order_offer->value !!}
@endif
@if($order->delivery_price)
| Transport           | 1                  | {!! $order->delivery_price !!}
@endif --}}

</x-mail::table>

{{-- @component('mail::button', ['url' => Request::root().'/comanda'.'/'.$order->id ])
Vezi comanda online
@endcomponent
<br/>
@if(Settings::get('msg_comanda'))
<p class="p-1">{{ strip_tags(Settings::get('msg_comanda')) }}</p>
@endif
@if ($data['preorder'])
@if(Settings::get('msg_pre_comanda'))
<p class="p-1">{{ strip_tags(Settings::get('msg_pre_comanda')) }}</p>
<br/>
@endif
@endif --}}

{{-- @if(isset($token))
In caz ca nu ați plătit, plata se poate face la link-ul de mai jos:
<a href="https://{!! $_SERVER['HTTP_HOST'].'/payment?token='.$token !!}" target="_blank">https://{!! $_SERVER['HTTP_HOST'].'/payment?token='.$token !!}</a>
@endif --}}

<p class="text-center p-1">This is an automatic response.</p>

{{-- <div class="border-bottom">
<img src="{{ asset('/dir/logo.png') }}" width="150" height="auto" class="img-fluid"
    alt="Inregistrare comanda - {!! Settings::get('name') !!}">

</div> --}}
{{-- <div class="footer" style="text-align: center; padding-top: 10px;">
    <br />
    {{ Settings::get('name') ?? '' }}
    <br />
    {{ Settings::get('phone') ?? '' }}
    <br />
    {{ Settings::get('mail') ?? '' }}
    <br />
    {{ Settings::get('address') ?? '' }}
    <br />
</div> --}}
</div>