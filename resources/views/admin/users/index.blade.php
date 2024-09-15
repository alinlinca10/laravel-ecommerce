@extends('admin.layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">
        <h2 id="table-group-dividers">
            Utilizatori
            <a class="anchor-link" href="#table-group-dividers"></a>
        </h2>
    </div>
</div>

<div class="row mt-3">
    <div class="col-md-3">
        <div class="mb-3">
            {!!  Form::open(['url' => $link.'/search','method' => 'get', 'id' => 'cautare']) !!}
                {!! Form::text('terms', old('terms'), ['class' => 'form-control', 'placeholder' => 'Cauta', 'id' => 'terms', 'data-link' => $link]) !!}
            {!!  Form::close() !!}
        </div>
    </div>
    <div class="col-md-9 text-end">
        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
            <a href="{!! route('users.create') !!}" class="btn btn-success"><i class="bi bi-plus-lg"></i></a>
            <a href="#" class="btn btn-primary visibility-all"><i class="bi bi-eye"></i></a>
            <a href="#" class="btn btn-danger delete-all" data-link="{!! $link !!}"><i class="bi bi-trash"></i></a>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="items">
                    @include('admin.users.items', ['items' => $items])
                </div>
            </div>
        </div>
    </div>
</div>

@stop