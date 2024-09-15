<?php

namespace App\Livewire\Products;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

use App\Models\Store\Product;

class ProductsTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $folder = 'admin/products';
    public $link = '/admin/products';

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

    public function delete(Product $item){
        $item->delete();
    }

    public function highlight(Product $item){
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
        return view('livewire.products.products-table',
        [
            'products' => Product::search($this->search)
                ->with(['category', 'category.parent', 'creator'])
                ->orderBy($this->sortBy, $this->sortDir)
                ->paginate($this->perPage)
        ]
        );
    }
}
