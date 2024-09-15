@extends('admin.layouts.app')

@section('scripts')
    <script type="text/javascript"> 
        $('.select2').select2();
        
        $(document).ready(function() {
            $("#addAttributeTemplate").click(function() {
                var newAttribute = $("#attributeTemplate").clone().removeClass("d-none");
                // newAttribute.find("#deleteAttribute").click(function() {
                //     $(this).closest('.row').remove();
                // });
                $("#attributes").append(newAttribute);
            });

            // Atașează un eveniment click elementului cu ID "deleteAttribute" pentru elementele existente
            // $(".deleteAttribute").click(function() {
            //     var id = $(this).attr('id');
            //     // Eliminați vizual rândul corespunzător
            //     $(this).closest('.row').remove();
            // });
        });

        $(document).ready(function() {
            $(".deleteAttribute").click(function() {
                var attributeId = $(this).data('attribute-id');
                $.ajax({
                    type: "POST",
                    url: "/admin/attribute/value/" + attributeId + "/delete",
                    async: true,
                    data: { attribute_id: attributeId },
                    success: function(data) {
                        location.reload();
                    },
                    error: function(data) {
                        console.log("Eroare");
                    }
                });
            });
        });

        function openFilemanagerVideo(a) {
            window.open('/elfinder?file=2',
            'elfinder', 'status=0, toolbar=0, location=0, menubar=0, ' +
            'directories=0, resizable=1, scrollbars=0, width=800, height=600');
        }

        // Deschide managerul de fișiere și setează elementul selectat
        function openFilemanager(a) {
            globalElem = $(a).closest('.imgs-attr');  // Setăm elementul curent doar pentru valoarea pe care am dat click
            window.open('/admin/files', 'elfinder', 'status=0, toolbar=0, location=0, menubar=0, directories=0, resizable=1, scrollbars=0, width=800, height=600');
        }


        var globalElem = false;

        function setUrl(file) {
            if (!globalElem) {
                return;
            }

            // Setăm imaginea doar pentru elementul pe care s-a dat click
            globalElem.find('.img-showcase').attr('src', file);       // Imaginea vizualizată
            globalElem.find('.img-expand').attr('href', file);         // Link pentru expandare (dacă există)
            globalElem.find('.img-link').val(file);                   // Setează valoarea imaginii în inputul hidden

            // Resetăm variabila pentru a evita erori viitoare
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

    </script>
@stop

@section('content')

<form action="{!! route('attributes.update', $item->id) !!}" method="POST" enctype="multipart/form-data">
    @method('PUT')
    @csrf
    <button type="submit" class="btn btn-success btn-save">Save</button>
    
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
                        <div class="row d-flex align-items-center">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name*</label>
                                <input type="text" name="name" value="{{ old('name', $item->name) }}" class="form-control" id="name">
                                <span class="fs-9">Add attribute name (ex: size, color, capacity)</span>
                            </div>
                            <div class="col-md-6">
                                <label for="name" class="form-label">Type*</label>
                                <div class="d-flex align-items-center">
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="type" value="select" id="select" {{ $item->type == 'select' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="select">
                                          Select
                                        </label>
                                    </div>
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="type" value="radio" id="radio" {{ $item->type == 'radio' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="radio">
                                            Radio
                                        </label>
                                    </div>
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="type" value="buttons" id="buttons" {{ $item->type == 'buttons' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="buttons">
                                            Buttons
                                        </label>
                                    </div>
                                    <div class="form-check me-3">
                                        <input class="form-check-input" type="radio" name="type" value="image" id="image" {{ $item->type == 'image' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="image">
                                            Image
                                        </label>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" name="is_color" id="is_color" value="1" {!! $item->is_color ? 'checked' : '' !!}>
                                    <label class="form-check-label fs-7" for="is_color">This attribute represents product colors</label>
                                    <p class="text-muted mb-0 fs-7"><small>If this is checked, the product colors will be displayed different.</small></p>
                                </div>
                            </div> --}}
                        </div>

                        <div>
                            <label for="value" class="form-label mt-3">Values*</label>
                            @foreach ($item->values as $key => $attribute)
                                <div class="row d-flex align-items-center mt-2">
                                    <div class="col-6 d-flex">
                                        <input type="text" name="value[]" value="{{ old('value', $attribute->value) }}" class="form-control">
                            
                                        <div class="row imgs-attr">
                                            <div class="col-md-12 col-sm-4 ms-2 d-flex align-items-center">
                                                @if ($attribute->image)
                                                    <a href="#" class="img-add">
                                                        <img src="{!! $attribute->image !!}" class="img-fluid rounded-circle img-showcase" alt="{!! $attribute->value !!}" style="height: 25px;">
                                                    </a>
                                                    <input type="hidden" name="image[]" value="{{ old('image', $attribute->image) }}" class="img-link">
                                                @else
                                                    <div class="img text-center dropzone p-2">
                                                        <div class="img-btns img-add d-flex align-items-center justify-content-center">
                                                            <div class="img-add">
                                                                <a href="#" class="img-add">
                                                                    <span class="d-block fs-7">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                                                            <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                                                                        </svg>
                                                                    </span>
                                                                </a>
                                                                <img src="#" class="img-fluid img-showcase rounded-circle" alt="#" style="height: 25px;">
                                                                <input type="hidden" name="image[]" value="{{ old('image', $attribute->image) }}" class="img-link">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 text-end">
                                        {{-- <i class="bi bi-trash text-danger deleteAttribute" id="deleteAttribute_{{ $attribute->id }}"></i> --}}
                                        {{-- <input type="hidden" name="deleteAttribute" value="{{ $attribute->id }}"> --}}
                                        <a href="{{ route('attribute_value.delete', $attribute->id) }}" data-bs-toggle="modal" data-bs-target="#modal-window"><i class="bi bi-trash text-danger deleteAttribute"></i></a>
                                        {{-- <form action="{{ route('attributes.delete', $attribute->id) }}">
                                            @csrf

                                            <button type="submit" class="btn btn-transparent"><i class="bi bi-trash text-danger deleteAttribute" data-attribute-id="{{ $attribute->id }}"></i></button>
                                        </form> --}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div id="attributes">

                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <div class="btn" id="addAttributeTemplate">
                                    <i class="bi bi-plus-lg"></i> Add
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


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
                        <p class="text-muted"><small>This attribute will be hidden.</small></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

<div class="d-none" id="attributeTemplate">
    <div class="row d-flex align-items-center mt-3">
        <div class="col-6">
            <input type="text" name="value[]" value="" class="form-control">
        </div>
        <div class="col-6 text-end">
            <i class="bi bi-trash text-danger" id="deleteAttribute"></i>
        </div>
    </div>
</div>

<div class="row">
    {{-- <div class="img-add-template" style="display: none;">
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
    </div> --}}
    
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
</div>
@stop