@section('scripts')
<script>
    $(".treefy").treeFy({
        treeColumn: 1,
        initStatusClass: 'treetable-collapsed',
        collapseAnimateCallback: function(row) {
            row.fadeOut();
        },
        expandAnimateCallback: function(row) {
            row.fadeIn();
        }
        // expanderExpandedClass: 'bi bi-dash-lg',
        // expanderCollapsedClass: 'bi bi-plus-lg',
    });
</script>
@stop
@if($items->lastPage() > 1)
    <div class="row align-items-center px-3">
        <div class="col-md-6">{!!  $items->render() !!}</div>
        <div class="col-md-6 text-end"><br />Afisare de la {!! $items->firstItem() !!} la {!! $items->lastItem() !!} din {!! $items->total() !!}<br /><br /></div>
    </div>
@endif
<div class="table-responsive treefy">
    <table class="table table-hover align-middle">
        <thead>
            <tr>
                <td>
                    <div class="form-check">
                        <input class="form-check-input select-all" type="checkbox" value="" id="flexCheckDefault">
                    </div>
                </td>
                <td>#ID</td>
                <td>Imagine</td>
                <td>Titlu</td>
                <td>Categorie magazin</td>
                <td>Creat de</td>
                <td>Ultima modificare</td>
                <td class="text-end">Actiuni</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $key => $item)
                <tr id="{!! $item->id !!}" data-node="treetable-{!! $item->id !!}" @if($item->parent_id) data-pnode="treetable-parent-{!! $item->parent_id !!}" @endif>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input checkbox-item" type="checkbox" data-itemid="{!! $item->id !!}">
                        </div>
                    </td>
                    <td>{!! $item->id !!}</td>
                    <td>
                        @if($imgs = $item->imgs())
                            @if($img = $imgs->first())
                                <img src="{!! $img->picture !!}" class="img-fluid rounded img-thumbnail" alt="" style="max-width: 75px;">
                            @endif
                        @else
                            <img src="#" class="img-fluid rounded img-thumbnail" alt="" style="max-width: 75px;">
                        @endif
                    </td>
                    <td><strong>{!! $item->title !!}</strong></td>

                    <td><span class="badge text-bg-{!! $item->shop_category ? 'success' : 'danger' !!}">{!! $item->shop_category ? 'Da' : 'Nu' !!}</span></td>
                    <td><strong>{!! $item->creator->name !!}</strong> <span class="d-block fs-9">{!! $item->created_at !!}</span></td>
                    <td><strong>{!! $item->creator->name !!}</strong> <span class="d-block fs-9">{!! $item->updated_at !!}</span></td>
                    <td class="text-end">
                        <div class="btn-group">
                            <a href="{!! route('category.edit', $item->id) !!}" class="btn btn-fab"><i class="bi bi-pencil-fill text-success"></i></a>
                            <!-- BUTON ACTIV / INACTIV -->
                            <button type="button" class="btn text-primary btn-visibility" data-state="{!! $item->active !!}" data-link="{!! $link !!}" data-itemid="{!! $item->id !!}">
                                <i class="bi bi-eye{!! $item->active == null ? '-slash' : '' !!}"></i>
                            </button>
                            {{-- @livewire('products.visibility', ['item' => $item, 'link' => $link]) --}}
                            {!! Form::open(['route' => ['category.destroy', $item->id], 'class' => 'd-inline' ,'method' => 'POST']) !!}
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
<div class="row align-items-center px-3">
  <div class="col-md-6">{!!  $items->render() !!}</div>
  <div class="col-md-6 text-end"><br />Afisare de la {!! $items->firstItem() !!} la {!! $items->lastItem() !!} din {!! $items->total() !!}<br /><br /></div>
</div>
@endif