<?php

namespace App\Models;

use App\Models\RoleAblity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Define relationship with RoleAbility
    public function abilities(){

        return $this->hasMany(RoleAblity::class);
    }
}
