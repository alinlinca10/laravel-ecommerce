<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

use App\Models\Store\Attribute;

class ProductsAttributesTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $folder = 'admin/products/attributes';
    public $link = '/admin/products/attributes';

    #[Url(history:true)]
    public $search = '';

    #[Url(history:true)]
    public $sortBy = 'id';

    #[Url(history:true)]
    public $sortDir = 'DESC';

    #[Url()]
    public $perPage = 25;

    public function updatedSearch(){
        $this->resetPage();
    }

    public function delete(Attribute $item){
        $item->delete();
    }

    public function highlight(Attribute $item){
        $item->highlight = !$item->highlight;
        $item->save();
        
        $this->render();
    }

    public function setSortBy($sortByField){

        if($this->sortBy === $sortByField){
            $this->sortDir = ($this->sortDir == "ASC") ? 'DESC' : "ASC";
            return;
        }

        $this->sortBy = $sortByField;
        $this->sortDir = 'DESC';
    }

    public function render()
    {
        return view('livewire.products.products-attributes-table',
        [
            'products_attributes' => Attribute::search($this->search)
                ->with(['values'])
                ->orderBy($this->sortBy, $this->sortDir)
                ->paginate($this->perPage)
        ]
        );
    }
}
