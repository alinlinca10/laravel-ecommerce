<div class="modal-header">
    <h5 class="modal-title">Atentie!</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

{!! Form::open(['url' => $url, 'method' => 'POST', 'class' => 'delete-form']) !!}
<div class="modal-body">
    <div class="row">
        <div class="col-md-12 text-center py-3">
            <h4>Esti sigur ca vrei sa stergi?</h4>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-default" data-bs-dismiss="modal">Inchide</button>
    {!! Form::submit('Sterge', ['class' => 'btn btn-danger']) !!}
</div>
{!! Form::close() !!}
