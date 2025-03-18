<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class InvoiceItems extends Component
{
    public $items = [];

    public function mount()
    {
        $this->items = [
            ['product_id' => '', 'description' => '', 'qty' => 1, 'rate' => 0, 'amount' => 0]
        ];
    }

    public function addItem()
    {
        $this->items[] = ['product_id' => '', 'description' => '', 'qty' => 1, 'rate' => 0, 'amount' => 0];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
    }

    public function updatedItems($value, $index)
    {
        if (str_contains($index, '.product_id')) {
            $key = explode('.', $index)[0];
            $product = Product::find($this->items[$key]['product_id']);
            $this->items[$key]['rate'] = $product->price ?? 0;
            $this->items[$key]['amount'] = ($this->items[$key]['qty'] ?? 1) * ($product->price ?? 0);
        }
        if (str_contains($index, '.qty')) {
            $key = explode('.', $index)[0];
            $this->items[$key]['amount'] = $this->items[$key]['qty'] * $this->items[$key]['rate'];
        }
    }

    public function render()
    {
        $products = Product::all();
        return view('livewire.invoice-items', compact('products'));
    }
}
