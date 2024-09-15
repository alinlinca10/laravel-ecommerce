@if($items->lastPage() > 1)
    <div class="row align-items-center">
        <div class="col-md-6">{!!  $items->render() !!}</div>
        <div class="col-md-6 text-end"><br />Afisare de la {!! $items->firstItem() !!} la {!! $items->lastItem() !!} din {!! $items->total() !!}<br /><br /></div>
    </div>
@endif
<div class="table-responsive treefy">
    <table class="table table-striped table-hover align-middle">
        <thead>
            <tr>
                <td>
                    <div class="form-check">
                        <input class="form-check-input select-all" type="checkbox" value="" id="flexCheckDefault">
                    </div>
                </td>
                <td>#ID</td>
                <td>Avatar</td>
                <td>Nume</td>
                <td>Nivel de access</td>
                <td class="text-end">Actiuni</td>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            @foreach ($items as $key => $item)
                <tr id="{!! $item->id !!}" data-node="treetable-{!! $item->id !!}"  @if($item->parent_id) data-pnode="treetable-parent-{!! $item->parent_id !!}" @endif>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input checkbox-item" type="checkbox" data-itemid="{!! $item->id !!}">
                        </div>
                    </td>
                    <td>{!! $item->id !!}</td>
                    <td>
                        <img src="{!! $item->avatar !!}" class="img-fluid rounded img-thumbnail" alt="" style="max-width: 75px;">
                    </td>
                    <td><strong>{!! $item->name !!}</strong> <span class="d-block fs-9"><a href="mailto:{!! $item->email !!}">{!! $item->email !!}</a> / <a href="tel:{!! $item->phone !!}">{!! $item->phone !!}</a></span></td>
                    <td>{!! $item->access_level !!}</td>

                    <td class="text-end">
                        <div class="btn-group">
                            <a href="{!! route('users.edit', $item->id) !!}" class="btn btn-fab"><i class="bi bi-pencil-fill text-success"></i></a>
                            <!-- BUTON ACTIV / INACTIV -->
                            <button type="button" class="btn text-primary btn-visibility" data-state="{!! $item->active !!}" data-link="{!! $link !!}" data-itemid="{!! $item->id !!}">
                                <i class="bi bi-eye{!! $item->active == null ? '-slash' : '' !!}"></i>
                            </button>
                            {!! Form::open(['route' => ['users.destroy', $item->id], 'class' => 'd-inline' ,'method' => 'POST']) !!}
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-fab d-inline"><i class="bi bi-trash-fill text-danger"></i></button>
                            {!! Form::close() !!}
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@if($items->isEmpty())
<br>
<p class="text-center">Nici o inregistrare in lista</p>
@endif
@if($items->total() > 0)
<div class="row align-items-center">
  <div class="col-md-6">{!!  $items->render() !!}</div>
  <div class="col-md-6 text-end"><br />Afisare de la {!! $items->firstItem() !!} la {!! $items->lastItem() !!} din {!! $items->total() !!}<br /><br /></div>
</div>
@endif