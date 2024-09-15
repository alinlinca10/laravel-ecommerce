<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\Features\SupportAttributes\AttributeCollection;

use App\Models\Store\ProductAttribute;
use App\Models\Store\ProductAttributeValue;
use App\Models\Store\ProductAttributeRows;

class SelectAttributes extends Component
{
    public AttributeCollection $attributes;

    public $product_attributes;
    public $attribute_values;

    public $item;
    public $attr;
    public $attr_value;
    public $combinations = [];
    public $selectedAttributes = [];

    public function mount()
    {
        $this->product_attributes = ProductAttribute::all();
        $this->attribute_values = collect();
    }

    public function updatedSelectedAttributes($values)
    {
        $this->selectedAttributes = $values; // Actualizează valorile selectate

        // Aici poți itera prin valorile selectate și face orice operații dorești
        $this->attribute_values = ProductAttributeValue::whereIn('attribute_id', $values)->get();
        $this->combinations = []; // Reset combinațiile
    }

    // public function updatedAttr($value)
    // {
    //     $this->attribute_values = ProductAttributeValue::where('attribute_id', $value)->get();
    //     $this->combinations = []; // Reset combinațiile
    //     // $this->dispatch('attrValues');
    //     $this->dispatch('attrValuesUpdated');
    // }

    public function updatedAttr($value)
    {
        $this->attribute_values = ProductAttributeValue::where('attribute_id', $value)->get();
        $this->combinations = []; // Reset combinațiile
        $this->attribute_values = $this->attribute_values->filter(function ($value) {
            return !collect($this->selectedAttributes)->contains('value_id', $value->id);
        });
        $this->dispatch('attrValuesUpdated');
    }


    public function updatedAttrValue()
    {
        $combinationKey = $this->attr . '_' . $this->attr_value;

        if (!in_array($combinationKey, $this->combinations)) {
            $this->combinations[] = $combinationKey;
        }
    }

    public function addAttribute()
    {
        // Verifică dacă atributul și valoarea atributului au fost selectate
        $existingAttribute = collect($this->selectedAttributes)->first(function ($item) {
            return $item['attribute_id'] == $this->attr && $item['value_id'] == $this->attr_value;
        });

        if (!$existingAttribute && $this->attr && $this->attr_value) {
            // Obține numele și valoarea atributului
            $attributeName = ProductAttribute::find($this->attr)->name;
            $attributeValue = ProductAttributeValue::find($this->attr_value)->value;

            // Adaugă atributul și valoarea atributului la lista
            $this->selectedAttributes[] = [
                'attribute_id' => $this->attr,
                'value_id' => $this->attr_value,
                'name' => $attributeName,
                'value' => $attributeValue,
            ];

            // Ordonează lista după numele atributelor
            $this->selectedAttributes = collect($this->selectedAttributes)->sortBy(['name', 'value'])->values()->all();

            // Resetează câmpurile de selecție după adăugare
            // Adaugă o opțiune goală la începutul listei de valori
            // array_unshift($this->attribute_values, null);

            $this->attr_value = null;

            // dd($this->selectedAttributes);
            // Actualizează lista de valori ale atributului curent
            $this->attribute_values = ProductAttributeValue::where('attribute_id', $this->attr)->get();

            // Elimină valoarea deja selectată din opțiunile disponibile
            $this->attribute_values = $this->attribute_values->filter(function ($value) {
                return !collect($this->selectedAttributes)->contains('value_id', $value->id);
            });
            // dd($this);

        } else {
            // Afișează un mesaj că atributul și valoarea atributului sunt deja în listă
            $this->addError('attribute_exists', 'Atributul și valoarea atributului sunt deja în listă.');
        }
    }

    public function removeFromSelected($id)
    {
        // Asigură-te că index-ul este valid
        $productAttributes = $this->item->product_attributes->pluck('attribute_value_id', 'attribute_id');
       
        // dd($attribute);

        if (isset($id)) {
            $attribute = ProductAttributeRows::find($id);
            $attribute->delete();
            // // Adaugă elementul înapoi în lista de valori
            // $this->attribute_values[] = [
            //     'id' => $attribute->id,
            //     'value' => $attribute->value,
            // ];

            // // Elimină elementul din lista deja selectată
            // unset($this->selectedAttributes[$id]);

            // // Reindexează array-ul pentru a evita index-urile lipsă
            // $this->selectedAttributes = array_values($this->selectedAttributes);

            return view('livewire.products.select-attributes');
        }
    }


    public function render()
    {
        $dataFromDatabase = $this->item->product_attributes->map(function ($attribute) {
            return [
                'id' => $attribute->attribute->id,
                'row_id' => $attribute->id,
                'name' => $attribute->attribute->name,
                'value' => $attribute->attributeValue->value,
            ];
        })->toArray();

        // Filtrăm $attribute_values pentru a elimina elementele deja prezente în tabel
        $this->attribute_values = $this->attribute_values->reject(function ($value) use ($dataFromDatabase) {
            return collect($dataFromDatabase)->contains('value', $value->value);
        });

        $combinedData = array_merge($dataFromDatabase, $this->selectedAttributes);

        return view('livewire.products.select-attributes', ['combinedData' => $combinedData]);
    }
}
