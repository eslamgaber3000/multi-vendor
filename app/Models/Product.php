<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder ;
use Illuminate\Support\Facades\Auth ;
use Illuminate\Support\Str ;


class Product extends Model
{
    use HasFactory;
    protected $fillable=[

        'name','slug','description','image','store_id','category_id','rating','options','featured','price','compare_price','quantity','status'
    ];

    //Create relationship between category and Product
    public function category(){

        return $this->belongsTo(Category::class,'category_id','id');
    }
    //Create  one to many relationship between store and Product
    public function store(){

        return $this->belongsTo(Store::class,'store_id','id');
    }

    protected $hidden = [
        'created_at','updated_at','deleted_at','image'
    ];

    protected $appends=['image_url'];
    protected static function booted(){
    
        //use closue to applay global scope
        // static::addGlobalScope('store', function (Builder $builder) {
            
        //     $user=Auth::user();
        
        //     if($user->store_id){
    
        //         $builder->where('store_id','=',$user->store_id);
        //     }
        // });

        //use class to applay  global scope
        static::addGlobalScope('store', new StoreScope()); 
    }

    //many to many relationship between porduct and his tags

    public function tags(){
        return $this->belongsToMany(
            Tag::class ,'product_tag','product_id' ,'tag_id','id','id' 
        );
    }

    //intialize active scope for products

    public function scopeActive ($query){
        $query->where('status' , '=' ,'active');
    }

    //create local scope for easy maintance and kep contorller more organized .

    public function scopeFilter(Builder $query , $requestParameters){

        // $data=array(  //here I don't merge the data came from request with array key I defined .

        //     'status'=>null ,
        //     'category_id'=>null ,
        //     'store_id'=>null ,
        //     'tag_id'=>null
        // );
         $data=array_merge(  // I use to merge the request data with key I defined

          [  
            'status'=>"active" ,
            'category_id'=>null ,
            'store_id'=>null ,
            'tag_id'=>null
          ],$requestParameters
          
        );

       
    
    $query->when($data['status'] , function($query , $value){

      return  $query->where('status',$value);
    })
    
    ->when($data['category_id'], function($query , $value){

     return $query->where('category_id',$value);
    })
    ->when($data['store_id'], function($query , $value){

          return  $query->where('store_id',$value);
    })
    ->when($data['tag_id'], function($query , $value){
          return  $query->whereExists(function($query) use($value){
            $query->selectRaw('1')->from('product_tag')->whereColumn('product_tag.product_id','products.id')
            ->where('product_tag.tag_id',$value);
          });

            

//   ->when($request->query('tag_id'), function($query , $value){

    //   $query->whereHas('tags', function($query) use($value){   1-//consume high in database .
    //         $query->where('id',$value);
    //     });
    // $query->whereExists(function($query) use ($value){
    //     $query->selectRaw('1')->from('product_tag')->whereColumn('products.id', 'product_tag.product_id')
    //     ->where('product_tag.tag_id',$value); // 2-best practice because we use exits and use laravel query builder to make it more readable.
    // });
    // $query->whereRaw('Exists (SELECT 1 FROM product_tag where product_tag.product_id=products.id AND product_tag.tag_id = ?)',[$value]); //3-exactly number 2 but it is raw sql

           // $query->whereRaw('id IN (SELECT product_id from product_tag where tag_id = ?)',[$value] ); //using prepared statement //4-using IN clause but when we don't using in in large database.
        // });
//    })
    });
    
    }

    // use laravel accessors to check image after it came from db if it url or pathe or not found ; 
    public function getImageUrlAttribute (){

        if(! $this->image){

            return 'https://www.incathlab.com/images/products/default_product.png';
        }
        if(Str::startsWith( $this->image , ['http://','https://'])){
            return $this->image ;
        }

        return  asset('storage/'.$this->image);

        
    }

    //we need to make accessor to calculate the percentage of sale in each product

    public function getSalePercentageAttribute(){

        if(!$this->compare_price){
            return 0 ;
        }
        // sale percentage= 100*(sale_price / original price -1)
        return  number_format( 100* (($this->price / $this->compare_price)-1) ,0);
    }
}
