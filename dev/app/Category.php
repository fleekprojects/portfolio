<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $fillable   = ['id','title','slug','status', 'created_at','updated_at'];
    protected $id = 1;
    protected $title;
    protected $slug;
    protected $status;
    protected $created_at;
    protected $updated_at;
}
