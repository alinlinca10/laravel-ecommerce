@extends('frontend.layouts.app')

@section('scripts')
    @parent
    <script type="text/javascript">
        $(document).ready(function() {
            Fancybox.bind('[data-fancybox="gallery"]', {
                //
            });
        });
    </script>
@stop

@section('content')
    <br />
    <br />
    <br />
    <br />
    <br />
    {{-- <form action="{!! route('post_order') !!}" method="POST"> --}}
    {{-- @csrf --}}
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8 g-0">
                @if ($imgs = $product->imgs())
                    <div class="row">
                        @foreach ($imgs as $key => $img)
                            <div class="col-md-6">
                                <a href="{!! $img->picture !!}" data-fancybox="gallery">
                                    <img src="{!! $img->picture !!}" class="img-fluid" alt="{!! $img->picture !!}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
            <div class="col-md-4">
                <div class="p-md-4 sticky-top" style="top: 85px;">
                    <h1 class="display-5 fs-5 fw-bold">{!! $product->name !!}</h1>
                    <p>{!! $product->price !!} RON</p>
                    {{-- <img src="{!! $product->product_attribute->attributeValue->image !!}" class="rounded-pill border mx-1"
                        alt="{!! $product->product_attribute->attributeValue->value !!}" style="width: 1.5rem; height: 1.5rem; padding: 3px;" title="{!! $product->product_attribute->attributeValue->value !!}"> --}}

                    {{-- <div class="mb-2">
                        <span class="text-uppercase fs-7 text-secondary">{!! $product->attribute->name ?? '' !!}</span>
                        <span class="text-uppercase fs-7 ms-3">{!! $product->product_attribute->attributeValue->value ?? '' !!}</span>
                    </div> --}}
                    @foreach ($product->associatedProducts as $associatedProductId)
                        @php
                            $associatedProduct = Product::find($associatedProductId);
                        @endphp

                        @foreach ($associatedProduct->product_attributes->groupBy('attribute_id') as $key => $p_attribute)
                            <div class="position-relative d-inline">
                                @foreach ($p_attribute as $key => $attribute)
                                    <a href="{{ route('viewProduct', [$attribute->product->id, $attribute->product->link]) }}" class="text-decoration-none">
                                        <img src="{!! $attribute->attributeValue->image !!}" class="rounded-pill mx-1 {{ $product->product_attribute->attributeValue->value == $attribute->attributeValue->value ? 'border' : '' }}"
                                            alt="{!! $attribute->attributeValue->value !!}" style="width: 1.5rem; height: 1.5rem; padding: 3px;" title="{!! $attribute->attributeValue->value !!}">
                                    </a>
                                @endforeach
                         
                            </div>
                            {{-- <label for="{{ Str::lower($p_attribute->first()->attribute->name) }}">{!! $p_attribute->first()->attribute->name !!}</label>

                            <select name="{{ Str::lower($p_attribute->first()->attribute->name) }}" class="form-select">
                                @foreach ($p_attribute as $key => $attribute)
                                    <option value="{{ $attribute->attributeValue->id }}">
                                        {{ $attribute->attributeValue->value }}
                                    </option>
                                @endforeach
                            </select> --}}
                        @endforeach
                    @endforeach

                    {{-- @foreach ($product->product_attributes->groupBy('attribute_id') as $key => $p_attribute)
                        <label for="{{ Str::lower($p_attribute->first()->attribute->name) }}">{!! $p_attribute->first()->attribute->name !!}</label>

                        <select name="{{ Str::lower($p_attribute->first()->attribute->name) }}" class="form-select">
                            @foreach ($p_attribute as $key => $attribute)
                                <option value="{{ $attribute->attributeValue->id }}">{{ $attribute->attributeValue->value }}
                                </option>
                            @endforeach
                        </select>
                    @endforeach --}}

                    <livewire:frontend.add-to-cart :product="$product" :imgs="$imgs" />
                </div>
            </div>
        </div>
    </div>
    {{-- </form> --}}
@endsection
