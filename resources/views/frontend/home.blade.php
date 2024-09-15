@extends('frontend.layouts.app')

@section('scripts')
<script>
    $(document).ready(function() {
        $(".dev-hover-image").hover(function() {
            var hoverSrc = $(this).data("hover-src");
            $(this).attr("src", hoverSrc);
        }, function() {
            var originalSrc = $(this).data("original-src");
            $(this).attr("src", originalSrc);
        });
    });

</script>
@stop

@section('content')
    <style>
        .video-section-text {
            top: 35%;
            transform: translateY(-35%);
            left: 15%;
            transform: translatex(-15%);
            z-index: 3;
        }
    </style>

    <div class="container-fluid g-0">
        <div class="row g-0">
            <div class="col-md-12">
                <section class="video-section position-relative overflow-hidden" style="max-height: 900px;">
                    <div class="video-section-text position-absolute">
                        <div class="row">
                            <div class="col-lg-8 px-md-5 px-4 text-white" style="z-index: 5;">
                                <h1 class="h1"><strong>Award-winning travel gear</strong></h1>
                                <p>Urban. Outdoors. Everything in between. Moss green.</p>
                                <a href="#" class="btn btn-white mt-4">Explore new collection</a>
                            </div>
                        </div>
                    </div>
                    <img src="\dir\home\homepage_essential_07_b9db9a0d-956b-4a42-b698-24302ec3d19d_2000x.webp" class="img-fluid object-fit-cover" alt="">
                </section>
            </div>
        </div>
    </div>

    <div class="container-fluid g-0">
        <div class="row g-0">
            <div class="col-md-6">
                <div class="card border-0">
                    <div class="ratio ratio-1x1">
                        <img src="/dir/home/homepage-1_2_2000x.webp" class="card-fluid object-fit-cover" alt="...">
                    </div>
                    <div class="card-img-overlay p-md-5">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title"><strong>Ramverk Luggage</strong></h3>
                            <a href="#" class="btn btn-primar">Explore</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0">
                    <div class="ratio ratio-1x1">
                        <img src="/dir/home/homepage_2_2000x.webp" class="card-fluid object-fit-cover" alt="...">
                    </div>
                    <div class="card-img-overlay p-md-5">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title text-white"><strong>Backpacks</strong></h3>
                            <a href="#" class="btn btn-primar">Shop</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="container-fluid g-0">
        <div class="row g-0">
            <div class="col-md-12 px-md-5 px-3 py-5">
                <h2>Recommended for you</h2>
            </div>
            @foreach ($items->take(4) as $key => $product)
                <div class="col-md-3">
                    <a href="{{ route('viewProduct', [$product->id, $product->link]) }}" class="text-decoration-none">
                        <div class="card h-100 rounded-0">
                            <div class="p-4">
                                <p class="fw-medium"><strong>{!! $product->name !!}</strong></p>
                                <p class="text-dark-emphasis fw-medium">&euro;{!! $product->price !!}</p>
                            </div>
                            <div class="card-body">
                                @if ($imgs = $product->imgs())
                                {{-- @if ($img = $imgs->first()) --}}
                                    <img src="{!! $imgs[0]->picture !!}" class="img-fluid rounded-0 object-fit-contain dev-hover-image" alt="{!! $product->name !!}" data-hover-src="{!! $imgs[2]->picture ?? $imgs[1]->picture !!}" data-original-src="{!! $imgs[0]->picture !!}" style="height: 500px;">
                                {{-- @endif --}}
                                @endif
                            </div>
                            <div class="card-footer bg-transparent border-top-0 pb-3 px-4 d-flex justify-content-between align-items-center">
                                <div class="position-relative">
                                    <img src="/dir/products/colors/swatch-black-out.png" class="rounded-pill border mx-1" alt="" style="width: 1.5rem; height: 1.5rem; padding: 3px;">
                                    <img src="/dir/products/colors/swatch-c-anderson.png" class="rounded-pill mx-1" alt="" style="width: 1.25rem; height: 1.25rem;">
                                    <img src="/dir/products/colors/swatch-fogbow-beige.png" class="rounded-pill mx-1" alt="" style="width: 1.25rem; height: 1.25rem;">
                                </div>
                                <livewire:frontend.recommended-products :product="$product" :imgs="$imgs" />
    
                                {{-- <form action="{!! route('addCart') !!}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{!! $product->id !!}">
                                    <input type="hidden" name="picture" value="{!! $imgs[0]->picture !!}">
                                    <input type="hidden" name="qty" value="1">
                                    <button type="submit" class="btn">
                                        <svg width="24" height="23" viewBox="0 0 24 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4.80547 8.69087C4.86368 7.90774 5.51605 7.30206 6.30134 7.30206H13.6987C14.484 7.30206 15.1364 7.90774 15.1946 8.69087L16.0084 19.6388C16.0731 20.5086 15.3848 21.25 14.5125 21.25H5.48755C4.61532 21.25 3.92703 20.5086 3.99168 19.6388L4.80547 8.69087Z" stroke="black"></path>
                                            <rect x="6.88892" y="7.51389" width="0.888889" height="13.5243" fill="black"></rect>
                                            <rect x="12.2223" y="7.51389" width="0.888889" height="13.5243" fill="black"></rect>
                                            <rect x="5.61121" y="5.16666" width="8.77778" height="1.84722" rx="0.5" stroke="black"></rect>
                                            <rect x="7.77783" y="10.3611" width="4.44445" height="0.711806" fill="black"></rect>
                                            <rect x="7.77783" y="13.2083" width="4.44445" height="0.711805" fill="black"></rect>
                                            <rect x="7.77783" y="16.0555" width="4.44445" height="0.711805" fill="black"></rect>
                                            <circle cx="17" cy="7" r="6.5" fill="black" stroke="white"></circle>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M17.3128 3.49988L17.3124 10.5001L16.6874 10.5001L16.6878 3.49991L17.3128 3.49988Z" fill="white"></path>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M20.5001 7.31225L13.4999 7.31259L13.4999 6.68759L20.5001 6.68725L20.5001 7.31225Z" fill="white"></path>
                                          </svg>
                                    </button>
                                </form> --}}
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

@endsection
