<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \Dimsav\Translatable\Translatable;
    public $translatedAttributes = ['name'];
    protected  $guarded=[];

    //start category & products Relation
    public function products(){
        return $this->hasMany(Product::class);
    }
    //end category & products Relation

}
