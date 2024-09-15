@extends('admin.layouts.app')

@section('content')

<div class="row">
    <div class="col-md-6">
        <nav style="--bs-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%236c757d'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="{!! $link !!}" class="link-dark link-underline-opacity-0">Categories</a></li>
              <li class="breadcrumb-item active" aria-current="page">List</li>
            </ol>
        </nav>
        <h2 id="table-group-dividers">
            <strong>Categories</strong>
            <a class="anchor-link" href="#table-group-dividers"></a>
        </h2>
    </div>
    <div class="col-md-6 text-end my-auto">
        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
            <a href="{!! route('category.create') !!}" class="btn btn-success"><i class="bi bi-plus-lg"></i></a>
            <a href="#" class="btn btn-primary visibility-all"><i class="bi bi-eye"></i></a>
            <a href="#" class="btn btn-danger delete-all" data-link="{!! $link !!}"><i class="bi bi-trash"></i></a>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="row justify-content-end my-3 px-3">
                <div class="col-md-3">
                    {!!  Form::open(['url' => $link.'/search','method' => 'get', 'id' => 'cautare']) !!}
                       <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        {!! Form::text('terms', old('terms'), ['class' => 'form-control', 'placeholder' => 'Search', 'id' => 'terms', 'data-link' => $link]) !!}
                       </div>
                    {!!  Form::close() !!}
                </div>
            </div>
            <div class="card-body p-0">
                <div class="items">
                    @include('admin.category.items', ['items' => $items])
                </div>
            </div>
        </div>
    </div>
</div>

@stop