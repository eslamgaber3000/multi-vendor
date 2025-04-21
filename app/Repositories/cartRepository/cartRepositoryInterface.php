<?php
namespace App\Repositories\CartRepository;

use App\Models\Product;
use Illuminate\Support\Collection;

interface CartRepositoryInterface 
{
    public function get():Collection;

    public function add(Product $product ,$quantity=1);

    public function update(Product $product ,$quantity);

    public function delete($id);

    public function clear();

    public function total():float;
}


?>