<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable=[

        'name','description','parent_id','slug','image','status'
    ];

    public static function rules($id=0){

        return [

            'name'=>['required',"unique:categories,name,$id",'string','max:255','min:3'],
            'parent_id'=>['nullable','int','exists:categories,id'],
            'image'=>['image','max:1048576' ,'dimensions:min_width=100,min_height=200'],
            'status'=>['in:exist,archived']
        ];
    }
}
