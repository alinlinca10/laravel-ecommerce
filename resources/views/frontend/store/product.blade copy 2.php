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
                    {{-- @foreach ($product->associatedProducts as $associatedProductId)
                        @php
                            $associatedProduct = Product::find($associatedProductId);
                        @endphp
                        @foreach ($associatedProduct->product_attributes as $key => $p_attribute)
                            @if ($p_attribute->attribute->is_color)
                                <div class="position-relative d-inline">
                                    <a href="{{ route('viewProduct', [$p_attribute->product->id, $p_attribute->product->link]) }}" class="text-decoration-none">
                                        <img src="{!! $p_attribute->attributeValue->image !!}" class="rounded-pill mx-1 {{ $product->product_attribute->attributeValue->value == $p_attribute->attributeValue->value ? 'border' : '' }}"
                                            alt="{!! $p_attribute->attributeValue->value !!}" style="width: 1.5rem; height: 1.5rem; padding: 3px;" title="{!! $p_attribute->attributeValue->value !!}">
                                    </a>
                                </div>
                            @else
                                <p>{!! $p_attribute->attributeValue->value !!}</p>
                            @endif
                        @endforeach
                    @endforeach --}}

                    @if ($product->associatedProducts)
                        @foreach ($product->associatedProducts as $associatedProductId)
                            @php
                                $associatedProduct = Product::find($associatedProductId);
                                // $associatedProduct = Product::find(17);
                            @endphp
                            @foreach ($associatedProduct->product_attributes as $key => $p_attribute)
                                @if ($p_attribute->attribute->is_color)
                                    <div class="position-relative d-inline">
                                        <a wire:navigate.hover href="{{ route('viewProduct', [$p_attribute->product->id, $p_attribute->product->link]) }}" class="text-decoration-none">
                                            <img src="{!! $p_attribute->attributeValue->image !!}" class="rounded-pill mx-1 {{ $product->product_attribute->attributeValue->value == $p_attribute->attributeValue->value ? 'border' : '' }}"
                                                alt="{!! $p_attribute->attributeValue->value !!}" style="width: 1.5rem; height: 1.5rem; padding: 3px;" title="{!! $p_attribute->attributeValue->value !!}">
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach
                    @endif


                    @php
                        $selectDisplayed = false;
                    @endphp
                    @foreach ($product->product_attributes as $key => $p_attribute)
                        @if (($attribute = $p_attribute->attribute) && !$attribute->is_color && !$selectDisplayed)
                            <div>
                                <label for="{{ Str::lower($attribute->name) }}">{!! $attribute->name !!}</label>
                                <select name="{{ Str::lower($attribute->name) }}" class="form-select">
                                    @foreach ($product->product_attributes->where('attribute_id', $attribute->id) as $attributeOption)
                                        <option value="{{ $attributeOption->attributeValue->id }}">
                                            {{ $attributeOption->attributeValue->value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @php
                                $selectDisplayed = true;
                            @endphp
                        @endif
                    @endforeach

                    <livewire:frontend.add-to-cart :product="$product" :imgs="$imgs" />
                </div>
            </div>
        </div>
    </div>
    {{-- </form> --}}
@endsection
