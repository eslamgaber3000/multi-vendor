<?php

namespace App\Models;

use App\Rules\Filter;
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

            'name'=>['required',"unique:categories,name,$id",'string','max:255','min:3',
            //create custom role and wite it as laravel rules using macros system
            'filter:user,localhost,host',
            //create custom role only seen in the category rules

            function ($attribute,$value,$fails){
            //check if $value == spacic word
             if(strtolower($value)=='laravel'){
                //give $fails function message
                $fails('this name is forbidden');
            }
        },  
        //create new opject from filter rule with array of not allwed roles
        new Filter(['PHP','css','html','php','admin','manger','adminstrator'])
        ],
            'parent_id'=>['nullable','int','exists:categories,id'],
            'image'=>['image','max:1048576' ,'dimensions:min_width=100,min_height=200'],
            'status'=>['in:exist,archived'],
            
        ];
    }
}
