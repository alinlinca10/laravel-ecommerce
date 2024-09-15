@extends('admin.layouts.app')

@section('scripts')
    <script type="text/javascript">
        $('.page-name').keyup(function() {
            $('.page-link').val($(this).val().split(' ').join('-').split(',').join('').split('.').join('').split('/').join('-').split('---').join('-').toLowerCase());
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

        Fancybox.bind('[data-fancybox="gallery"]', {
            //
        });

    </script>
    <script type="text/javascript">
        $('.select2').select2();
    </script>
@stop

@section('content')

<div class="row">
    <div class="col-md-12">
        <h2 id="table-group-dividers">
            Editează utilizator
            <a class="anchor-link" href="#"></a>
        </h2>
    </div>
</div>
{!! Form::open(['route' => ['users.update', $item->id], 'method' => 'PUT']) !!}
{!! Form::submit('Save', ['class' => 'btn btn-success btn-save']) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="card border-0 shadow h-100">
                <h5 class="card-header">Info</h5>
                <div class="card-body">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" name="active" id="active" {!! $item->active ? 'checked' : '' !!}>
                        <label class="form-check-label" for="active">Activ/Inactiv</label>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Nume*</label>
                        {!! Form::text('name', old('name', $item->name), ['class' => 'form-control', 'id' => 'name']) !!}
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email*</label>
                        {!! Form::text('email', old('link', $item->email), ['class' => 'form-control', 'id' => 'email']) !!}
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone*</label>
                        {!! Form::text('phone', old('link', $item->phone), ['class' => 'form-control', 'id' => 'phone']) !!}
                    </div>
                    
                    {{-- <div class="row">
                        <div class="col-md-6 text-center">
                            <div class="mb-3">
                                <label for="price" class="form-label"><strong>QR Code</strong></label>
                                <p>{!! QRCode::size(100)->generate($item->code) !!}</p>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    <div class="row my-5">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <h5 class="card-header">Imagini</h5>
                <div class="card-body">
                    <div class="row imgs">
                        @if ($imgs = $item->imgs())
                            @foreach ($imgs as $key => $img)
                                <div class="col-md-2 text-center mb-3">
                                    <div class="img mb-3">
                                        <a href="{!! $img->picture !!}" data-fancybox="gallery" data-caption="asd">
                                            <img src="{!! $img->picture !!}" class="img-fluid object-fit-cover" alt="" style="height: 150px; width: 150px;">
                                        </a>
                                        {!! Form::hidden('imgs[pictures][]', old('imgs[pictures][]', $img->picture), ['class' => 'img-link']) !!}
                                        {!! Form::hidden('imgs[alt][]', old('imgs[alt][]', $img->alt), ['class' => 'img-alt-text']) !!}                    
                                    </div>
                                    <a href="#" class="img-edit text-decoration-none" title="{!! __('blog.change_image') !!}">
                                        <i class="bi bi-pencil-fill text-success"></i>
                                    </a>
                                    <a href="#" class="img-alt text-decoration-none" title="{!! __('blog.change_alt_text') !!}">
                                        <i class="bi bi-chat-dots"></i>
                                    </a>
                                    <a href="#" class="img-delete text-decoration-none"title="{!! __('blog.delete_image') !!}">
                                        <i class="bi bi-trash text-danger"></i>
                                    </a>
                                </div>
                            @endforeach
                        @endif
                        <div class="col-md-2">
                            <div class="img text-center">
                                <div class="img-btns img-add text-center border d-flex align-items-center justify-content-center p-3 mx-auto" style="height: 150px; width: 150px;">
                                    <div class="img-add">
                                        <a href="#" class="img-add">
                                            <h3><i class="bi bi-image"></i></h3>
                                            <p>Adauga imagine</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow">
                <div class="card-header card-header-info card-header-icon">
                    <h4 class="card-title mb-0">Descriere</h4>
                </div>
                <div class="card-body p-0">
                    {{-- {!! Form::textarea('description', $item->description ,['class' => 'form-control shadow ckeditor']) !!} --}}
                    @include('admin/partials/ckeditor',['name' => 'description', 'content' => old('description', $item->description ? $item->description : ' ')])

                </div>
            </div>
        </div>
    </div>

{!! Form::close() !!}

<div class="img-add-template" style="display: none;">
    <div class="col-md-2">
        <div class="img text-center">
            <img src="" class="img-fluid img-showcase object-fit-cover" alt="" style="height: 150px; width: 150px;">
            {!! Form::hidden('imgs[pictures][]', old('imgs[pictures][]', null), ['class' => 'img-link']) !!}
            {!! Form::hidden('imgs[alt][]', old('imgs[alt][]', null), ['class' => 'img-alt-text']) !!}
        </div>
        <div class="img img-btns text-center mt-3">
            <a href="#" class="img-edit text-decoration-none" title="{!! __('blog.change_image') !!}">
                <i class="bi bi-pencil-fill text-success"></i>
            </a>
            <a href="#" class="img-alt text-decoration-none" title="{!! __('blog.change_alt_text') !!}">
                <i class="bi bi-chat-dots"></i>
            </a>
            <a href="#" class="img-delete text-decoration-none" title="{!! __('blog.delete_image') !!}">
                <i class="bi bi-trash text-danger"></i>
            </a>
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

@stop