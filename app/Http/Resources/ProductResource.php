<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        //what is the shape or response do you want to return to user .

        return [

            'id'=>$this->id ,
            'name'=>$this->name ,
            'description'=>$this->description ,
            'image'=>$this->image_url ,

            'relations'=>[

                'category'=>$this->category,
                'store'=>$this->store,

            ],
            'status'=>$this->status ,
            'price'=>
            [
                'original_price'=>$this->price,
                'compare_price'=>$this->compare_price

            ],
            

        ];
    }
}
