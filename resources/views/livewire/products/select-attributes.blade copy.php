<div>
    <div class="row d-flex align-items-center">
        <div class="col-md-5">
            <div class="form-group" wire:ignore>
                <label for="selectAttribute">Attribute</label>
                <select name="product_attribute" id="selectAttribute" class="form-select select2" wire:model.live="attr">
                    <option {{ !$item->attribute_id ? 'selected' : '' }} value="">Select option</option>
                    @foreach ($product_attributes as $key => $attribute)
                        <option value="{!! $attribute->id !!}" {!! $item->attribute_id == $attribute->id ? 'selected' : '' !!}>{!! $attribute->name !!}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-5">
            <div class="form-group" wire:ignore>
                <label for="selectAttributeValue">Values</label>
                <select name="product_attribute_values" class="form-control select2" id="selectAttributeValue" wire:model="attr_value">
                    <option value="" @if (!$attr_value) selected @endif>Select</option>
                    @foreach ($attribute_values as $attr_value)
                        <option value="{{ $attr_value->id }}">{{ $attr_value->value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md mt-4">
            <button type="button" class="btn btn-success" wire:click="addAttribute">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                    class="bi bi-plus-lg" viewBox="0 0 16 16">
                    <path fill-rule="evenodd"
                        d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                </svg>
                Add
            </button>
        </div>

        <div class="col-md-12 mt-3">
            <div class="selected-attributes">
                <h3>Atribute selectate</h3>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Attribute</th>
                            <th>Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @dd($combinedData) --}}
                        @foreach ($combinedData as $key => $data)
                            {{-- @dd($data['id']->toArray*) --}}
                            <tr>
                                <th>{!! $key + 1 !!}</th>
                                <td>{{ $data['name'] ?? '-' }}</td>
                                <td>{{ $data['value'] ?? '-' }}</td>
                                <td>
                                    @if (isset($data['id']))
                                        <button type="button" wire:click="removeFromSelected({{ $data['row_id'] }})"
                                            class="btn btn-sm btn-danger">Remove</button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        <input type="hidden" name="selected_attributes" value="{{ json_encode($selectedAttributes) }}">
                    </tbody>
                </table>
            </div>
        </div>
        {{-- <div class="col-md-6">
            @foreach ($combinations as $combination)
            @php
                [$attrId, $valueId] = explode('_', $combination);
                $attribute = $product_attributes->find($attrId);
                $value = $attribute_values->find($valueId);
            @endphp

            <div class="form-group">
                <label>Atribut: {{ $attribute->name }} - Valoare: {{ $value->value }}</label>
                <input type="text" class="form-control" wire:model.lazy="price_{{ $attrId }}_{{ $valueId }}">
                <input type="text" class="form-control" wire:model.lazy="sku_{{ $attrId }}_{{ $valueId }}">
            </div>
        @endforeach
        </div> --}}
    </div>
    @script()
        <script>
            $(document).ready(function() {
                $(".select2").select2({
                    tags: true,
                });
                $('#selectAttribute').change(function() {
                    let data = $(this).val();
                    $wire.set('attr', data);
                    console.log(data);
                });
                // Livewire.on('attrValuesUpdated', () => {
                //     $('#selectAttributeValue').select2({
                //         tags: true,
                //     });
                // });
            });
        </script>
    @endscript
</div>
