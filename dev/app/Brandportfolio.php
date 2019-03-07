<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brandportfolio extends Model
{
    protected $table = 'portfolio_brands';
    protected $primaryKey = 'id';
    protected $fillable   = ['id','portfolio_id','brands_id'];
    protected $id = 1;
    protected $portfolio_id;
    protected $brands_id;
}
