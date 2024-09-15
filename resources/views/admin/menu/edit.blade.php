@extends('admin.layouts.app')

@section('scripts')
    <script type="text/javascript">
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

        $('.select2').select2();
        $('.category-title').keyup(function() {
            $('.category-name').val($(this).val().split(' ').join('-').toLowerCase());
        });  
    </script>
@endsection

@section('content')

<form action="{!! route('menu.update', $item->id) !!}" method="POST" enctype="multipart/form-data">
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
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name" class="form-label">Name<span class="text-danger">*</span></label>
                                <input type="text" name="name" value="{!! old('name', $item->name) !!}" id="name" class="form-control category-name">
                            </div>
                            <div class="col-md-6">
                                <label for="parent_id" class="form-label">Parent</label>
                                <select name="parent_id" id="parent_id" class="form-select select2">
                                    @foreach ($menus as $key => $menu)
                                        <option value="{!! $key !!}" {!! $item->parent_id == $key ? 'selected' : '' !!}>{!! $menu !!}</option>
                                    @endforeach
                                </select>
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
                                    <div class="col-md-2 text-center mb-3">
                                        <div class="img mb-3">
                                            <a href="{!! $img->picture !!}">
                                                <img src="{!! $img->picture !!}" class="img-fluid object-fit-cover" alt="" style="height: 150px; width: 150px;">
                                            </a>
                                            <input type="hidden" name="imgs[pictures][]" value="{!! old('imgs[pictures][]', $img->picture) !!}" class="img-link">
                                            <input type="hidden" name="imgs[alt][]" value="{!! old('imgs[alt][]', $img->alt) !!}" class="img-alt-text">
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
                        <p class="text-muted"><small>Visible to customers.</small></p>

                        <div class="mt-3">
                            <p class="m-0"><strong>Created at</strong></p>
                            <p class="text-muted">{!! $item->created_at->format('d.m.Y - H:i:s') !!}</p>
                            <p class="m-0"><strong>Last modified at</strong></p>
                            <p class="text-muted">{!! $item->updated_at->format('d.m.Y - H:i:s') !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

<div class="row">
    <div class="img-add-template" style="display: none;">
        <div class="col-md-2">
            <div class="img text-center">
                <img src="" class="img-fluid img-showcase object-fit-cover" alt="" style="height: 150px; width: 150px;">
                <input type="hidden" name="imgs[pictures][]" value="{!! old('imgs[pictures][]') !!}" class="img-link">
                <input type="hidden" name="imgs[alt][]" value="{!! old('imgs[alt][]') !!}" class="img-alt-text">
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
</div>

@stop