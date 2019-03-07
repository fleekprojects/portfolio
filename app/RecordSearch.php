<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RecordSearch extends Model
{
    protected $table = 'search_records';
    protected $primaryKey = 'id';
    protected $fillable   = ['id','guid','category_id','industry_id','keyword','tag_ids','created_at','updated_at'];
    protected $id = 1;
    protected $guid;
    protected $category_id;
    protected $industry_id;
    protected $keyword;
    protected $tag_ids;
    protected $created_at;
    protected $updated_at;
}
