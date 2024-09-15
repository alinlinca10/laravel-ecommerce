@extends('admin.layouts.app')

@section('scripts')
    <script type="text/javascript">
        $('.select2').select2({
            tags: true
        });

    </script>
@stop

@section('content')

<button type="submit" class="btn btn-success btn-save">Save</button>

<div class="container-fluid">
    <form action="{!! route('attributes.store', $item->id) !!}" method="POST" enctype="multipart/form-data">
        @csrf

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
                                <input type="text" name="name" value="{{ old('name', $item->name) }}" class="form-control" id="name">
                                <span class="fs-9">Add attribute name (ex: size, color, capacity)</span>
                            </div>
                        </div>
                        <div id="attributes">
                            <div class="row d-flex align-items-center mt-3">
                                <label for="value" class="form-label">Values*</label>
                                <div class="col-6">
                                    {{-- <input type="text" name="value" value="" class="form-control"> --}}
                                    <select name="value[]" id="value" class="form-select select2" multiple>

                                    </select>
                                    {{-- <input type="text" name="value" value="" class="form-control"> --}}
                                </div>
                                <div class="col-6 text-end">
                                    <i class="bi bi-trash text-danger" id="deleteAttribute"></i>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mt-3">
                                <div class="btn" id="addAttributeTemplate">
                                    <i class="bi bi-plus-lg"></i> Add
                                </div>
                            </div>
                        </div>
                        {{-- <div class="d-none" id="attributeTemplate">
                            <div class="row d-flex align-items-center mt-3">
                                <div class="col-6">
                                    <input type="text" name="value" value="" class="form-control">
                                </div>
                                <div class="col-6 text-end">
                                    <i class="bi bi-trash text-danger" id="deleteAttribute"></i>
                                </div>
                            </div>
                        </div> --}}
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
                        <p class="text-muted"><small>This attribute will be hidden.</small></p>
                    </div>
                </div>
            </div>
        </div>  

    </form>
</div>
@stop