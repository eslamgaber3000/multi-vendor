<?php

namespace App\Models;

use App\Rules\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [

        'name',
        'description',
        'parent_id',
        'slug',
        'image',
        'status'
    ];

    //create local scope for filtering categories
    public static function scopeExist(Builder $builder)
    {
        $builder->where('status', 'exist');
    }
    //create local scope for archived categories

    public static function ScopeArchived(Builder $builder)
    {
        $builder->where('status', 'archived');
    }

    //create dynamic scope for filtering categories
    public static function scopeStatus(Builder $builder, $status)
    {
        $builder->where('status', $status);
    }

    //create local scope for filtering categories
    public static function scopeFilter(Builder $builder, $filters)
    {
        //use when instead of using if statement to filter categories
        $builder->when($filters['name'] ?? false, function ($builder, $value) {
            $builder->where('categories.name', 'like', "%{$value}%");
        });

        // if ($filters['name'] ??  false) {

        //     $builder->where('name', 'like', "%{$filters['name']}%");
        // }

        //filter by using if statement to filter

        // if ($filters['status'] ?? false) {

        //     $builder->where('status', '=', $filters['status']);
        // }

        //use when instead of using if statement to filter categories
        $builder->when($filters['status'] ?? false, function ($builder, $value) {

            $builder->where('categories.status', $value);
        });
    }

    public static function rules($id = 0)
    {

        return [

            'name' => [
                'required',
                "unique:categories,name,$id",
                'string',
                'max:255',
                'min:3',
                //create custom role and wite it as laravel rules using macros system
                'filter:user,localhost,host',
                //create custom role only seen in the category rules

                function ($attribute, $value, $fails) {
                    //check if $value == spacic word
                    if (strtolower($value) == 'laravel') {
                        //give $fails function message
                        $fails('this name is forbidden');
                    }
                },
                //create new opject from filter rule with array of not allwed roles
                new Filter(['PHP', 'css', 'html', 'php', 'admin', 'manger', 'adminstrator'])
            ],
            'parent_id' => ['nullable', 'int', 'exists:categories,id'],
            'image' => ['image', 'max:1048576', 'dimensions:min_width=100,min_height=200'],
            'status' => ['in:exist,archived'],

        ];
    }
}
