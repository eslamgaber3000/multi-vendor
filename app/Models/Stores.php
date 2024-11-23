<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stores extends Model
{
    use HasFactory;

    protected $connection='mysql';
    protected $table='stores';

    protected $primaryKey ='id';

    protected $keyType = 'int';

    public $incrementing = true;


}
