@extends('admin.layouts.app')

@section('scripts')
    <script type="text/javascript">
         $('.dev-page-name').keyup(function() {
            $('.dev-page-link').val($(this).val().split(' ').join('-').split(',').join('').split('.').join('').split('/').join('-').split('--').join('-').split('---').join('-').toLowerCase());
            $('.seo-title').val($(this).val().substring(0, parseInt($('.seo-title').attr('maxlength'))));
            $('.seo-title').closest('.row').find('.text-remaining').html(parseInt($('.seo-title').attr('maxlength')) - $('.seo-title').val().length);
        });

        function openFilemanagerVideo(a) {
            window.open('/elfinder?file=2',
            'elfinder', 'status=0, toolbar=0, location=0, menubar=0, ' +
            'directories=0, resizable=1, scrollbars=0, width=800, height=600');
        }
        function openFilemanager(a) {
            window.open('/admin/files',
            'elfinder', 'status=0, toolbar=0, location=0, menubar=0, ' +
            'directories=0, resizable=1, scrollbars=0, width=800, height=600');
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
            $('[rel="tooltip"]').tooltip();
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
            $('.imgs .col-md-2:first').find('.img').append($('.img-cover-template').clone().html());
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

        Fancybox.bind('[data-fancybox="gallery"]', {
            //
        });

        $('.select2').select2();

    </script>
@stop

@section('content')

{{-- @livewire('products.product-create', ['auth', Auth::user()]) --}}
<form action="{!! route('products.store') !!}" id="dropzone" method="POST" enctype="multipart/form-data">
    @csrf
    <button type="submit" class="btn btn-success btn-save">Save</button>

<div class="container-fluid">

    <div class="row">
        <div class="col-md-12">
            <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
                <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{!! $link !!}" class="link-underline link-underline-opacity-0">{!! $section !!}</a></li>
                <li class="breadcrumb-item active" aria-current="page">Create</li>
                </ol>
            </nav>
            <h2 id="table-group-dividers">
                <strong>Create</strong>
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
                            <label for="name" class="form-label">Name*</label>
                            <input type="text" name="name" value="{{ old('name', $item->name) }}" id="name" class="form-control dev-page-name">
                        </div>
                        <div class="col-md-6">
                            <label for="slug" class="form-label">Link*</label>
                            <input type="text" name="link" value="{!! old('link', $item->link) !!}" id="link" class="form-control dev-page-link opacity-50">
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
                                <div class="col-md-2 text-center mb-3 mx-2 p-0 dropzone border-0">
                                    <div class="dz-preview dz-processing dz-error dz-complete dz-image-preview m-0 w-100">
                                        <div class="img mb-3">
                                            <img src="{!! $img->picture !!}" class="img-fluid object-fit-cover rounded-3 shadow w-100" alt="" style="height: 150px;">
                                            <input type="hidden" name="imgs[pictures][]" value="{{ old('imgs[pictures][]', $img->picture) }}" class="img-link">
                                            <input type="hidden" name="imgs[alt][]" value="{{ old('imgs[alt][]', $img->alt) }}" class="img-alt-text">
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
                        <div class="col-md-2">
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
                                <label for="price" class="form-label">Price<span class="text-danger">*</span></label>
                                {{-- {!! Form::number('price', old('price', $item->price), ['class' => 'form-control', 'step' => '.01']) !!} --}}
                                <input type="number" name="price" value="{{ old('price', $item->price) }}" id="price" class="form-control" step=".01">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="old_price" class="form-label">Old price</label>
                                <input type="number" name="old_price" value="{{ old('old_price', $item->old_price) }}" id="old_price" class="form-control" step=".01">
                                {{-- {!! Form::number('old_price', old('old_price', $item->old_price), ['class' => 'form-control', 'step' => '.01']) !!} --}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="cost" class="form-label">Cost per item<span class="text-danger">*</span></label>
                                <input type="number" name="cost" value="{{ old('cost', $item->cost) }}" id="cost" class="form-control" step=".01">
                                {{-- {!! Form::number('cost', old('cost', $item->cost), ['class' => 'form-control', 'step' => '.01']) !!} --}}
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
                                <input type="text" name="sku" value="{{ old('sku', $item->sku) }}" id="sku" class="form-control">
                                {{-- {!! Form::text('sku', old('sku', $item->sku), ['class' => 'form-control']) !!} --}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="qty" class="form-label">Cantitate*</label>
                                <input type="number" name="qty" value="{{ old('qty', $item->qty) }}" id="qty" class="form-control">
                                {{-- {!! Form::number('qty', old('qty', $item->qty), ['class' => 'form-control']) !!} --}}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="code" class="form-label">Barcode  (ISBN, UPC, GTIN, etc.)<span class="text-danger">*</span></label>
                                <input type="text" name="code" value="{{ old('code', $item->code) }}" id="code" class="form-control">
                                {{-- {!! Form::text('code', old('code', $item->code), ['class' => 'form-control']) !!} --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            

            <button type="submit" class="btn btn-success">Create</button>
            <a href="{!! $link !!}" class="btn btn-light border border-1">Cancel</a>
        </div>
        <div class="col-md-4">
            <div class="card">
                <h5 class="card-header">Status</h5>
                <div class="card-body">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" name="active" id="active" checked>
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
                        <label for="category_id" class="form-label">Category<span class="text-danger">*</span></label>
                        <select name="category_id" id="category_id" class="form-select select2">
                            @foreach ($categories as $key => $category)
                                <option value="{{ $key }}" {{ old('category_id', $item->category_id) == $key ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                        {{-- {!! Form::select('category_id', $categories, old('category_id', $item->category_id), ['class' => 'form-select select2']) !!} --}}
                    </div>
                </div>
            </div>
            <div class="card">
                <h5 class="card-header">SEO</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <label for="name" class="form-label">Titlu <span class="text-remaining">78</span></label>
                            <input type="text" name="name" value="{{ old('name', $item->name) }}" id="name" class="form-control seo-title text-counting" maxlength="78">
                            {{-- {!! Form::text('title', old('name', $item->name), ['class' => 'form-control seo-title text-counting', 'maxlength' => 78]) !!} --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="description" class="form-label">Descriere <span class="text-remaining">160</span></label>
                            <input type="textarea" name="description" value="{{ old('description', $item->description) }}" id="description" class="form-control seo-description text-counting" rows="3" maxlength="160">
                            {{-- {!! Form::textarea('description', old('name', $item->name), ['class' => 'form-control seo-description text-counting', 'rows' => 3, 'maxlength' => 160]) !!} --}}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <label for="keywords" class="form-label">Cuvinte cheie <span class="text-remaining">255</span></label>
                            <input type="textarea" name="keywords" value="{{ old('keywords', $item->keywords) }}" id="keywords" class="form-control seo-keywords text-counting" rows="3" maxlength="255">
                            {{-- {!! Form::textarea('keywords', old('name', $item->name), ['class' => 'form-control seo-keywords text-counting', 'rows' => 3, 'maxlength' => 255]) !!} --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  

</div>  

</form>

<div class="img-add-template" style="display: none;">
    <div class="col-md-2 text-center mb-3 mx-2 p-0 dropzone border-0">
        <div class="dz-preview dz-processing dz-error dz-complete dz-image-preview m-0 w-100">
            <div class="img mb-3">
                <img src="" class="img-fluid img-showcase object-fit-cover shadow w-100" alt="" style="height: 150px;">
                <input type="hidden" name="imgs[pictures][]" value="{{ old('imgs[pictures][]', null) }}" class="img-link">
                <input type="hidden" name="imgs[alt][]" value="{{ old('imgs[alt][]', null) }}" class="img-alt-text">
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
@stop