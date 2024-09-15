@extends('admin.layouts.app')

@section('scripts')
    <script type="text/javascript">
        $('.dev-page-name').keyup(function() {
            $('.dev-page-link').val($(this).val().split(' ').join('-').split(',').join('').split('.').join('').split('/').join('-').split('--').join('-').split('---').join('-').toLowerCase());
            $('.seo-title').val($(this).val().substring(0, parseInt($('.seo-title').attr('maxlength'))));
            $('.seo-title').closest('.row').find('.text-remaining').html(parseInt($('.seo-title').attr('maxlength')) - $('.seo-title').val().length);
        });
        // CKEDITOR.instances['description'].on('change', function(e) {
        //     content = CKEDITOR.instances['description'].getData();
        //     console.log(content);
        //     description = $('<div>' + content + '</div>').text();
        //     // description = $('<div>' + content + '</div>').find("p:first").text();
        //     $('.seo-description').val(description.substring(0, parseInt($('.seo-description').attr('maxlength'))));
        //     $('.seo-description').closest('.row').find('.text-remaining').html(parseInt($('.seo-description').attr('maxlength')) - $('.seo-description').val().length);

        //     keywords = kwords($(content).text(), 15);
        //     $('.seo-keywords').val(keywords.substring(0, parseInt($('.seo-keywords').attr('maxlength'))));
        //     $('.seo-keywords').closest('.row').find('.text-remaining').html(parseInt($('.seo-keywords').attr('maxlength')) - $('.seo-keywords').val().length);

        // });
        $('.text-counting').keyup(function() {
            $(this).closest('.row').find('.text-remaining').html(parseInt($(this).attr('maxlength')) - $(this).val().length);
        });

        var globalElemVariation = false;

        function openFilemanagerForVariations(a) {
            globalElemVariation = $(a).closest('.variation-row');  // Setăm elementul curent doar pentru valoarea pe care am dat click
            window.open('/admin/files?variation=1', 'elfinder', 'status=0, toolbar=0, location=0, menubar=0, directories=0, resizable=1, scrollbars=0, width=800, height=600');
        }

        function setUrlForVariations(file) {
            if (!globalElemVariation) {
                return; // Nu facem nimic dacă nu avem un element global setat
            }

            var attributeId = globalElemVariation.data('attribute-id');  // ID-ul atributului
            var valueId = globalElemVariation.data('value-id');  // ID-ul valorii

            // Verificăm dacă imaginea a fost deja adăugată
            var existingImg = globalElemVariation.find('.imgs-variations .img-link').filter(function() {
                return $(this).val() === file;
            });

            if (existingImg.length > 0) {
                // Imaginea este deja adăugată
                return;
            }

            // Clonăm template-ul și îl adăugăm
            var newImg = $('.img-add-template-variations').clone().removeClass('img-add-template-variations').show();
            
            // Setăm ID-urile pentru datele de atribut și valoare
            newImg.find('.img-link').attr('name', 'variations[' + attributeId + '][attribute_values][' + valueId + '][images][]');
            newImg.find('.img-link').val(file); // Setăm calea imaginii
            newImg.find('.img-alt-text').attr('name', 'variations[' + attributeId + '][attribute_values][' + valueId + '][alt_texts][]');

            // Actualizăm src-ul imaginii
            newImg.find('.img-showcase').attr('src', file);

            // Adăugăm imaginea nouă la lista de imagini
            globalElemVariation.find('.imgs-variations').append(newImg);

            // Resetăm elementul global după adăugare
            globalElemVariation = false;
        }

        // function setUrlForVariations(file) {
        //     if (!globalElemVariation) {
        //         // Dacă nu există un element selectat, ieșim din funcție
        //         return;
        //     }

        //     // Clonăm template-ul de imagine și actualizăm informațiile
        //     newImg = $('.img-add-template-variations').clone();
        //     newImg.find('.img-showcase').attr('src', file);
        //     newImg.find('.img-expand').attr('href', file);
        //     newImg.find('.img-link').val(file);

        //     // Adăugăm imaginea nouă la secțiunea varianta curentă (globalElemVariation)
        //     globalElemVariation.find('.imgs-variations .col-md-2:last').before(newImg.html());

        //     // Resetează elementul global pentru variante
        //     globalElemVariation = false;
        // }

        $('body').on('click', '.img-add-variation', function(e) {
            e.preventDefault();
            openFilemanagerForVariations(this);
            return false;
        });

        function openFilemanagerVideo(a) {
            window.open('/elfinder?file=2',
            'elfinder', 'status=0, toolbar=0, location=0, menubar=0, ' +
            'directories=0, resizable=1, scrollbars=0, width=800, height=600');
        }
        function openFilemanager(a) {            
            window.open('/admin/files',
            'elfinder', 'status=0, toolbar=0, location=0, menubar=0, ' +
            'directories=0, resizable=1, scrollbars=0, width=800, height=600,' +
            'commandsOptions={"upload":{"multiple":true}},uiOptions={"toolbar":["reload", "upload", "download"]}');
        }

        var globalElem = false;
        function setUrl(file) {
            if (!globalElem) {
            newImg = $('.img-add-template').clone();
            newImg.find('.img-showcase').attr('src', file);
            newImg.find('.img-expand').attr('href', file);
            newImg.find('.img-link').val(file);
            $('.imgs .col-md-2:last').before(newImg.html());
            } else {
            globalElem.find('.img-showcase').attr('src', file);
            globalElem.find('.img-expand').attr('href', file);
            globalElem.find('.img-link').val(file);
            }
            $('.imgs').find('.badge').remove();
            $('.imgs .col-md-2:first').find('.img').append($('.img-cover-template').clone().html());
            globalElem = false;
        }

        $('body').on('click', '.img-add', function(e) {
            e.preventDefault();
            openFilemanager(this);
            return false;
        });
        $('body').on('click', '.img-edit', function(e) {
            e.preventDefault();
            globalElem = $(this).parents('.col-md-2');
            openFilemanager(this);
            return false;
        });
        $('body').on('click', '.img-delete', function(e) {
            e.preventDefault();
            $(this).parents('.col-md-2').remove();
            $('.imgs').find('.badge').remove();
            $('.imgs .col-md-4:first').find('.img').append($('.img-cover-template').clone().html());
            return false;
        });
        $('body').on('click', '.img-alt', function(e) {
            e.preventDefault();
            globalElem = $(this).parents('.col-md-2');
            modalAlt = $('.img-alt-modal-template').clone();
            alt = $(this).parents('.img').find('.img-alt-text').val();
            $('#modal-window .modal-content').html(modalAlt.html());
            $('#modal-window').find('.input-img-alt').val(alt);
            $('#modal-window').modal('show');
            return false;
        });

        function productStyles(selection) {
            if (!selection.id) { return selection.text; }
                var thumb = $(selection.element).data('image');
                if(!thumb){
                return selection.text;
                } else {
                var $selection = $(
                '<img src="' + thumb + '" alt=""><span class="img-changer-text">' + $(selection.element).text() + '</span>'
            );
            return $selection;
            }
        }
        
        $('.select2').select2({
            templateResult: productStyles
        });

        // $(".select2").select2({
        //     tags: true,
        // });



        $(document).ready(function() {
            $('#selectAttribute').change(function() {
                var attributeId = $(this).val();
                $('#selectAttributeValue').empty(); // Goliți selectul valorilor atributului

                if (attributeId) {
                    $.ajax({
                        type: "GET",
                        url: '/attributes-values/' + attributeId,
                        success: function(data) {
                            $.each(data, function(key, value) {
                                $('#selectAttributeValue').attr('disabled', false);
                                $('#selectAttributeValue').append($('<option>', {
                                    value: value.id,
                                    text: value.value
                                }));
                            });
                        },
                        error: function() {
                            console.log("Eroare la obținerea valorilor atributului.");
                        }
                    });
                }
            });

            var addedVariations = [];
            // Adăugăm câmpuri pentru variații dinamice
            $('#addAttributeBtn').click(function() {
                var selectedAttribute = $('#selectAttribute option:selected').text();
                var selectedAttributeValue = $('#selectAttributeValue option:selected').text();
                var selectedAttributeId = $('#selectAttribute').val();
                var selectedAttributeValueId = $('#selectAttributeValue').val();

                // Verificăm dacă atributul și valoarea au fost deja adăugate
                var variationExists = addedVariations.some(function(variation) {
                    return variation.attributeId === selectedAttributeId && variation.valueId === selectedAttributeValueId;
                });

                if (variationExists) {
                    alert('Această combinație de atribut și valoare a fost deja adăugată.');
                    return; // Nu mai adăugăm câmpurile
                }

                if (selectedAttributeId && selectedAttributeValueId) {
                    // Adăugăm combinația la lista de variații
                    addedVariations.push({
                        attributeId: selectedAttributeId,
                        valueId: selectedAttributeValueId
                    });

                    // Adaugă câmpuri pentru variație în container
                    var newVariation = `
                        <div class="row g-3 variation-row" data-attribute-id="${selectedAttributeId}" data-value-id="${selectedAttributeValueId}">
                            <div class="col-md-auto">
                                <div>
                                    ${selectedAttribute}: ${selectedAttributeValue}
                                </div>
                                <input type="hidden" name="variations[${selectedAttributeId}][attribute_id]" value="${selectedAttributeId}">
                                <input type="hidden" name="variations[${selectedAttributeId}][attribute_values][${selectedAttributeValueId}]][value_id]" value="${selectedAttributeValueId}]">
                            </div>
                            <div class="col-md-auto">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="variations[${selectedAttributeId}][attribute_values][${selectedAttributeValueId}]][price]" class="form-label">Price</label>
                                        <input type="number" class="form-control" name="variations[${selectedAttributeId}][attribute_values][${selectedAttributeValueId}]][price]" placeholder="Price">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="variations[${selectedAttributeId}][attribute_values][${selectedAttributeValueId}]][stock]" class="form-label">Stock</label>
                                        <input type="number" class="form-control" name="variations[${selectedAttributeId}][attribute_values][${selectedAttributeValueId}]][stock]" placeholder="Stoc">
                                    </div>
                                </div>
                                
                                <div class="row my-3 imgs-variations">
                                    <div class="col-md-2 col-sm-4">
                                        <div class="img text-center dropzone py-0">
                                            <div class="img-btns img-add-variation d-flex align-items-center justify-content-center py-3">
                                                <div class="img-add-variation">
                                                    <a href="#" class="img-add-variation">
                                                        <i class="bi bi-image fs-3"></i>
                                                        <span class="d-block fs-7">Add</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    `;
                    $('#variationContainer').append(newVariation);
                } else {
                    alert('Select both an attribute and a value.');
                }
            });
        });

    </script>
@stop

@section('content')

<form action="{!! route('products.update', $item->id) !!}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{!! $link !!}" class="link-underline link-underline-opacity-0">{!! $section !!}</a></li>
                    <li class="breadcrumb-item"><a href="{!! $link !!}/{!! $item->id !!}/edit" class="link-underline link-underline-opacity-0">{!! $item->name !!}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </nav>
                <h2 id="table-group-dividers">
                    <strong>Edit {!! $item->name !!}</strong>
                    <a class="anchor-link" href="#"></a>
                </h2>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Nume<span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{!! $item->name !!}" id="name" class="form-control dev-page-name">
                            </div>
                            <div class="col-md-6">
                                <label for="link" class="form-label">Link<span class="text-danger">*</span></label>
                                <input type="text" name="link" value="{!! $item->link !!}" id="link" class="form-control dev-page-link bg-secondary-subtle opacity-50" readonly>
                            </div>
                            <div class="col-md-12 mt-3">
                                <label for="description" class="form-label">Description</label>
                                @include('admin/partials/ckeditor',['name' => 'description', 'content' => old('description', $item->description ? $item->description : ' ')])
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="card">
                    <h5 class="card-header">Images</h5>
                    <div class="card-body">
                        <div class="row imgs">
                            @if ($imgs = $item->imgs())
                                @foreach ($imgs as $key => $img)
                                    <div class="col-md-2 col-sm-4 text-center mb-3 mx-2 p-0 dropzone border-0">
                                        <div class="dz-preview dz-processing dz-error dz-complete dz-image-preview m-0 w-100">
                                            <div class="img mb-3">
                                                <img src="{!! $img->picture !!}" class="img-fluid object-fit-cover rounded-3 shadow w-100" alt="" style="height: 150px;">
                                                {!! Form::hidden('imgs[pictures][]', old('imgs[pictures][]', $img->picture), ['class' => 'img-link']) !!}
                                                {!! Form::hidden('imgs[alt][]', old('imgs[alt][]', $img->alt), ['class' => 'img-alt-text']) !!}                    
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
                                @endforeach
                            @endif
                            <div class="col-md-2 col-sm-4">
                                <div class="img text-center dropzone py-3">
                                    <div class="img-btns img-add d-flex align-items-center justify-content-center py-3">
                                        <div class="img-add">
                                            <a href="#" class="img-add">
                                                <i class="bi bi-image fs-3"></i>
                                                <span class="d-block fs-7">Click here to upload</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="card">
                    <h5 class="card-header">Pricing</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    {{-- <div class="input-group"> --}}
                                        <label for="price" class="form-label">Price<span class="text-danger">*</span></label>
                                        <input type="number" name="price" value="{!! old('price', $item->price) !!}" class="form-control" id="price" step=".01">
                                        {{-- <span class="input-group-text">RON</span> --}}
                                    {{-- </div> --}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="old_price" class="form-label">Old price</label>
                                    <input type="number" name="old_price" value="{!! old('old_price', $item->old_price) !!}" class="form-control" id="old_price" step=".01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="cost" class="form-label">Cost per item<span class="text-danger">*</span></label>
                                    <input type="number" name="cost" value="{!! old('cost', $item->cost) !!}" class="form-control" id="cost" step=".01">
                                    <p class="text-muted"><small>Customers won't see this price.</small></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        
                <div class="card">
                    <h5 class="card-header">Inventory</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="sku" class="form-label">SKU (Stock Keeping Unit)<span class="text-danger">*</span></label>
                                    <input type="text" name="sku" value="{!! old('sku', $item->sku) !!}" class="form-control" id="sku">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="qty" class="form-label">Cantitate*</label>
                                    <input type="number" name="qty" value="{!! old('qty', $item->qty) !!}" class="form-control" id="qty" step=".01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code" class="form-label">Barcode  (ISBN, UPC, GTIN, etc.)<span class="text-danger">*</span></label>
                                    <input type="text" name="code" value="{!! old('code', $item->code) !!}" class="form-control" id="code">
                                </div>
                            </div>
                            <div class="col-md-6 text-center">
                                <div class="mb-3">
                                    <label class="form-label"><strong>QR Code</strong></label>
                                    {{-- <p>{!! DNS1D::getBarcodeHTML('4445645656', 'CODABAR') !!}</p> --}}
                                    <p>{!! QRCode::size(100)->generate($item->code) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <h5 class="card-header">Variations</h5>
                    <div class="card-body">
                        <div>
                            <div class="row g-3 d-flex align-items-center">
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="selectAttribute">Attribute</label>
                                        <select name="attribute" id="selectAttribute" class="form-select select2">
                                            <option selected disabled>Select</option>
                                            @foreach ($attributes as $key => $attribute)
                                                <option value="{!! $key !!}" {!! $item->attribute_id == $key ? 'selected' : '' !!}>{!! $attribute !!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="selectAttributeValue">Value</label>
                                        <select name="attribute_values" class="form-select select2" id="selectAttributeValue" disabled>
                                            <option selected disabled>Select</option>
                                            {{-- @foreach ($attribute_values as $attr_value)
                                                <option value="{{ $attr_value->id }}">
                                                    {{ $attr_value->value }}
                                                </option>
                                            @endforeach --}}
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md mt-4">
                                    <button type="button" class="btn btn-success" id="addAttributeBtn">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                            class="bi bi-plus-lg" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                                        </svg>
                                        Add
                                    </button>
                                </div>

                                <div class="col-12 imgs-attr">
                                    <div id="variationContainer">
                                        @foreach ($item->attributeValues as $attributeValue)
                                            <div class="row g-3 variation-row" data-attribute-id="{{ $attributeValue->attribute->id }}" data-value-id="{{ $attributeValue->id }}">
                                                <div class="col-md-auto">
                                                    <div>
                                                        {{ $attributeValue->attribute->name }}: {{ $attributeValue->value }}
                                                    </div>
                                                    <input type="hidden" name="variations[{{ $attributeValue->attribute->id }}][attribute_id]" value="{{ $attributeValue->attribute->id }}">
                                                    <input type="hidden" name="variations[{{ $attributeValue->attribute->id }}][attribute_values][{{ $attributeValue->id }}][value_id]" value="{{ $attributeValue->id }}">
                                                </div>
                                                <div class="col-md-auto">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="variations[{{ $attributeValue->attribute->id }}][attribute_values][{{ $attributeValue->id }}][price]" class="form-label">Price</label>
                                                            <input type="number" class="form-control" name="variations[{{ $attributeValue->attribute->id }}][attribute_values][{{ $attributeValue->id }}][price]" value="{{ old('variations[' . $attributeValue->attribute->id . '][attribute_values][' . $attributeValue->id . '][price]', $attributeValue->pivot->price) }}" placeholder="Price">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="variations[{{ $attributeValue->attribute->id }}][attribute_values][{{ $attributeValue->id }}][stock]" class="form-label">Stock</label>
                                                            <input type="number" class="form-control" name="variations[{{ $attributeValue->attribute->id }}][attribute_values][{{ $attributeValue->id }}][stock]" value="{{ old('variations[' . $attributeValue->attribute->id . '][attribute_values][' . $attributeValue->id . '][stock]', $attributeValue->pivot->stock) }}" placeholder="Stoc">
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="row my-3 imgs-variations">
                                                        @if ($imgs = $attributeValue->pivot->images)
                                                            @foreach (unserialize($imgs) as $key => $img)
                                                                <div class="col-md-2 col-sm-4 text-center mb-3 mx-2 p-0 dropzone border-0">
                                                                    <div class="dz-preview dz-processing dz-error dz-complete dz-image-preview m-0 w-100">
                                                                        <div class="img mb-3">
                                                                            <img src="{!! $img->picture !!}" class="img-fluid object-fit-cover rounded-3 shadow w-100 img-showcase" alt="" style="height: 100px;">
                                                                            <input type="hidden" name="variations[{{ $attributeValue->attribute->id }}][attribute_values][{{ $attributeValue->id }}][images][]" value="{{ old('variations[' . $attributeValue->attribute->id . '][attribute_values][' . $attributeValue->id . '][images][]', $img->picture) }}" class="img-link">
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
                                                            @endforeach
                                                        @endif
                                                        <div class="col-md-2 col-sm-4">
                                                            <div class="img text-center dropzone py-0">
                                                                <div class="img-btns img-add-variation d-flex align-items-center justify-content-center py-3">
                                                                    <div class="img-add-variation">
                                                                        <a href="#" class="img-add-variation">
                                                                            <i class="bi bi-image fs-3"></i>
                                                                            <span class="d-block fs-7">Add</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- <div class="mt-2">
                                                        @foreach (json_decode($attributeValue->pivot->images, true) as $image)
                                                            <img src="{{ asset('storage/' . $image) }}" alt="Image" width="50">
                                                        @endforeach
                                                    </div> --}}
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                        
                                {{-- <div class="col-md-12 mt-3">
                                    <div class="selected-attributes">
                                        <h3>Atribute selectate</h3>
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Attribute</th>
                                                    <th>Value</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($combinedData as $key => $data)
                                                    <tr>
                                                        <th>{!! $key + 1 !!}</th>
                                                        <td>{{ $data['name'] ?? '-' }}</td>
                                                        <td>{{ $data['value'] ?? '-' }}</td>
                                                        <td>
                                                            @if (isset($data['id']))
                                                                <button type="button" wire:click="removeFromSelected({{ $data['row_id'] }})"
                                                                    class="btn btn-sm btn-danger">Remove</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                        
                                                <input type="hidden" name="selected_attributes" value="{{ json_encode($selectedAttributes) }}">
                                            </tbody>
                                        </table>
                                    </div>
                                </div> --}}
                            </div>
                        </div>                        
                    </div>
                </div>

                {{-- <div class="card">
                    <h5 class="card-header">Variations</h5>
                    <div class="card-body">
                        <livewire:products.select-attributes :item="$item"/>
                    </div>
                </div> --}}

                {{-- <div class="card">
                    <h5 class="card-header">Associated Products</h5>
                    <div class="card-body">
                        <div class="col-md-12">
                            <label for="associated_products" class="form-label">Select products</label>
                            <select name="associated_products[]" id="associated_products" class="form-select select2" multiple>
                                <option value="0">Select option</option>
                                @foreach ($products as $key => $productName)
                                    <?php
                                        $product = Product::find($key);
                                        $images = unserialize($product->pictures);
                                        $image = !empty($images) ? $images[0]->picture : null;
                                    ?>
                                    <option value="{{ $key }}" {{ in_array($key, $item->associated_products ?? []) ? 'selected' : '' }}
                                            @if($image)
                                                data-image="{!! $image !!}"
                                            @endif
                                        >
                                        {!! $key.' - '.$productName !!}
                                        @if ($image)
                                            <img src="{{ $image }}" alt="Imagine {{ $productName }}" style="max-width: 50px; max-height: 50px;">
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                        </div>       
                    </div>
                </div> --}}


                <button type="submit" class="btn btn-success">Save changes</button>
                <a href="{!! $link !!}" class="btn btn-light border border-1">Cancel</a>
            </div>
            
            <div class="col-md-4">
                <div class="card">
                    <h5 class="card-header">Status</h5>
                    <div class="card-body">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" name="active" id="active" {!! $item->active ? 'checked' : '' !!}>
                            <label class="form-check-label" for="active">Visible</label>
                        </div>
                        <p class="text-muted"><small>This product will be hidden from all sales channels.</small></p>
                    </div>
                </div>
                <div class="card">
                    <h5 class="card-header">Associations</h5>
                    <div class="card-body">
                        {{-- <div class="mb-3">
                            {!! Form::label('brand', 'Brand', ['class' => 'form-label']) !!}
                            {!! Form::select('brand', $brands, old('brand', $item->brand), ['class' => 'form-select select2']) !!}
                        </div> --}}
                        <div class="mb-3">
                            {!! Form::label('category_id', 'Category*', ['class' => 'form-label']) !!}
                            {!! Form::select('category_id', $categories, old('category_id', $item->category_id), ['class' => 'form-select select2']) !!}
                        </div>
                    </div>
                </div>
                <div class="card">
                    <h5 class="card-header">SEO</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="name" class="form-label">Titlu <span class="text-remaining">78</span></label>
                                {!! Form::text('title', old('name', $item->name), ['class' => 'form-control seo-title text-counting', 'maxlength' => 78]) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="description" class="form-label">Descriere <span class="text-remaining">160</span></label>
                                {!! Form::textarea('description', old('name', $item->name), ['class' => 'form-control seo-description text-counting', 'rows' => 3, 'maxlength' => 160]) !!}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="price" class="form-label">Cuvinte cheie <span class="text-remaining">255</span></label>
                                {!! Form::textarea('keywords', old('name', $item->name), ['class' => 'form-control seo-keywords text-counting', 'rows' => 3, 'maxlength' => 255]) !!}
                            </div>
                        </div>
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

    {{-- Variations --}}
    <div class="img-add-template-variations col-md-2 text-center mb-3 mx-2 p-0 dropzone border-0" style="display: none;">
        {{-- <div class="col-md-2 text-center mb-3 mx-2 p-0 dropzone border-0"> --}}
            <div class="dz-preview dz-processing dz-error dz-complete dz-image-preview m-0 w-100">
                <div class="img mb-3">
                    <img src="" class="img-fluid img-showcase object-fit-cover shadow w-100" alt="" style="height: 100px;">
                    <input type="hidden" name="variations[attributeId][attribute_values][valueId][images][]" value="{{ old('variations[attributeId][attribute_values][valueId][images][]', null) }}" class="img-link">
                    {{-- {!! Form::hidden('variations[attributeId][attribute_values][valueId][images][]', old('variations[attributeId][attribute_values][valueId][images][]', null), ['class' => 'img-link']) !!} --}}
                    {{-- {!! Form::hidden('variations[attributeId][attribute_values][valueId][alt_texts][]', old('variations[attributeId][attribute_values][valueId][alt_texts][]', null), ['class' => 'img-alt-text']) !!} --}}
                </div>
                <a href="#" class="img-edit text-decoration-none">
                    <i class="bi bi-pencil-fill text-success"></i>
                </a>
                <a href="#" class="img-alt text-decoration-none">
                    <i class="bi bi-chat-dots"></i>
                </a>
                <a class="dz-remove img-delete" href="#">Remove file</a>
            </div>
        {{-- </div> --}}
    </div>
    
    <div class="img-alt-modal-template-variations" style="display: none;">
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
    {{-- Variations --}}
</div>

@stop