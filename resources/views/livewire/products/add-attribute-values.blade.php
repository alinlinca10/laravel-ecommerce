<div>

    <div class="col-md-6">
        <button type="button" class="btn btn-success" wire:click.prevent="addAttributeValues">Add</button>
        @foreach ($inputs as $key => $value)
            <label for="product_attribute" class="form-label">{!! $attributes->where('id', $attribute_arr[$key])->first()->name !!}</label>
            <input type="text" class="form-control" wire:model="attribute_values.{!! $value !!}">
        @endforeach
    </div>
</div>
