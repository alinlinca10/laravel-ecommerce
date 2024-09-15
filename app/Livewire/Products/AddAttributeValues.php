<?php

namespace App\Livewire\Products;

use Livewire\Component;

use App\Models\Store\ProductAttribute;
use App\Models\Store\Product;

class AddAttributeValues extends Component
{
    public $item;
    public $inputs = [];
    public $attribute_arr = [];
    public $attribute_values;

    public function mount($item)
    {
        $this->item = $item;
    }

    public function addAttributeValues()
    {
        if(!in_array($this->item->attribute_id, $this->attribute_arr))
        {
            array_push($this->inputs, $this->item->attribute_id);
            array_push($this->attribute_arr, $this->item->attribute_id);
        }
    }

    public function render()
    {
        $attributes = ProductAttribute::all();
        return view('livewire.products.add-attribute-values',
        [
            'attributes' => $attributes,
        ]);
    }
}
