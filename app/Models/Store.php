<?php

namespace App\Models;

use Database\Factories\StoresFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    protected $connection='mysql';
    protected $table='stores';

    protected $primaryKey ='id';

    protected $keyType = 'int';

    public $incrementing = true;


    //  protected static function newFactory()
    // {
    //     return StoresFactory::new();
    // }



    //create relationship between store and product
    public function products(){
        return $this->hasMany(Product::class,'store_id','id');
    }
}
