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
    {{-- <style>
        .video-section-text {
            top: 35%;
            transform: translateY(-35%);
            left: 15%;
            transform: translatex(-15%);
            z-index: 3;
        }
    </style> --}}

    <div class="container-fluid">
        <div class="row ">
            <div class="col-md-12 g-0">
                <section class="video-section position-relative overflow-hidden d-flex align-items-end" style="max-height: 700px;">
                    <div class="video-section-text position-absolute">
                        <div class="row">
                            <div class="col-lg-12 px-md-5 px-4 text-white" style="z-index: 5;">
                                <h1 class="h1"><strong>All products</strong></h1>
                                <p>Our products are built to go together. Save up to 20% when buying multiple products above €100.</p>
                            </div>
                        </div>
                    </div>
                    <img src="\dir\products\background.webp" class="img-fluid object-fit-cover" alt="">
                </section>
            </div>
        </div>
    </div>
    
    <div class="container-fluid g-0">
        <div class="row g-0">
            @foreach ($products as $key => $product)
                <div class="col-md-3">
                    <div class="card h-100 rounded-0">
                        <div class="p-4">
                            <a href="{{ route('viewProduct', [$product->id, $product->link]) }}" class="text-decoration-none text-black">
                                <p class="fw-medium"><strong>{!! $product->name !!}</strong></p>
                            </a>
                            <p class="text-dark-emphasis fw-medium">&euro;{!! $product->price !!}</p>
                        </div>
                        <div class="card-body">
                            <a href="{{ route('viewProduct', [$product->id, $product->link]) }}" class="text-decoration-none">
                                @if ($imgs = $product->imgs())
                                {{-- @if ($img = $imgs->first()) --}}
                                    <img src="{!! $imgs[0]->picture !!}" class="img-fluid rounded-0 object-fit-contain dev-hover-image" alt="{!! $product->name !!}" data-hover-src="{!! $imgs[2]->picture ?? $imgs[1]->picture !!}" data-original-src="{!! $imgs[0]->picture !!}" style="height: 500px;">
                                {{-- @endif --}}
                                @endif
                            </a>
                        </div>
                        <div class="card-footer bg-transparent border-top-0 pb-3 px-4 d-flex justify-content-between align-items-center">
                            <div class="position-relative">
                                <img src="/dir/products/colors/swatch-black-out.png" class="rounded-pill border mx-1" alt="" style="width: 1.5rem; height: 1.5rem; padding: 3px;">
                                <img src="/dir/products/colors/swatch-c-anderson.png" class="rounded-pill mx-1" alt="" style="width: 1.25rem; height: 1.25rem;">
                                <img src="/dir/products/colors/swatch-fogbow-beige.png" class="rounded-pill mx-1" alt="" style="width: 1.25rem; height: 1.25rem;">
                            </div>
                            <livewire:frontend.recommended-products :product="$product" :imgs="$imgs" />
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

@endsection
