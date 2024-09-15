<?php

namespace App\Livewire\Orders;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

use App\Models\Store\Order;

class OrdersTable extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $folder = 'admin/orders';
    public $link = '/admin/orders';

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

    public function delete(Order $item){
        $item->delete();
    }

    public function highlight(Order $item){
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
        return view('livewire.orders.orders-table',
        [
            'orders' => Order::search($this->search)
                ->with(['creator'])
                ->orderBy($this->sortBy, $this->sortDir)
                ->paginate($this->perPage)
        ]
        );
    }
}
