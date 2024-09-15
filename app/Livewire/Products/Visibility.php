<?php

namespace App\Livewire\Products;

use Livewire\Component;

class Visibility extends Component
{

    public $item;
    public $link;
 
    // public function visibility()
    // {   
    //     $this->item->active = !$this->item->active;
    //     $this->item->save();

    //     $this->render();
    // }

    public function render()
    {
        return view('livewire/products.visibility');
    }
}
