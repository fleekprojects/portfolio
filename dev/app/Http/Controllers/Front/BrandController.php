<?php
namespace App\Http\Controllers\Front;
use Auth;
use DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Category;
use App\Portfolio;
use App\Tags;
use App\RecordSearch;
use App\Brandportfolio;

class BrandController extends Controller
{
	public function __construct()
    {
        $this->view = 'front.brand';
		if(isset($_GET['wp']) && $_GET['wp']==1){
			$_SESSION['is_wp']=1;
		}
		else{
			$_SESSION['is_wp']=0;
		}
    }

    public function index($id){
		$this->get_filters($id);
		
		$portfolio = Portfolio::from('portfolio AS p')->leftJoin('categories AS c', 'p.category_id','=','c.id')->leftJoin('portfolio_brands AS pb', 'pb.portfolio_id','=','p.id')->select('p.*', 'c.title AS cat_title')->where('p.status',1)->where('pb.brands_id',$id)->orderBy('id', 'desc')->get()->toArray();
		
        for($i=0; $i<count($portfolio); $i++){
			$portfolio[$i]['tech'] = DB::table('portfolio_technologies AS pt')->leftJoin('technologies AS t', 'pt.technologies_id', '=', 't.id')->select('t.title', 't.image AS icon')->where('portfolio_id', $portfolio[$i]['id'])->get()->toArray();
        }
        return view($this->view)->with('categories',$this->categories)->with('industries',$this->industries)->with('tags',$this->tags)->with('portfolios',$portfolio)->with('brand_id',$id);
    }
	
	public function recordSearch(Request $request){
		
        $p_cat = $request->input('p_cat');
        $p_ind = $request->input('p_ind');
        $p_br = $request->input('p_br');
        $keyword = $request->input('keyword');
        $p_tags = $request->input('tags_list');
		
        if($p_cat == '' && $p_ind == '' && $keyword == ''){
            return redirect('/');
        }
		else{
            $rec_search = new \App\RecordSearch();
            $rec_search->brand_id  = $p_br;
            $rec_search->category_id = $p_cat;
            $rec_search->industry_id  = $p_ind;
            $rec_search->keyword  = $keyword;
            $rec_search->tag_ids = $p_tags;
            $rec_search->client_ip = $request->ip();
            $rec_search->save();
            $lastId = $rec_search->id;
			$guid=date("Ymd").$lastId;
			
            $rec_search = \App\RecordSearch::where('id', $lastId)->first();
            $rec_search->guid = $guid;
            $rec_search->save();
            return redirect('/p/'.$p_br.'/'.$guid);
        }
    }
	
	public function getSearch($id,$guid){
		$this->get_filters($id);
		if (RecordSearch::where('guid', '=', $guid)->count() > 0){

			$search_param = \App\RecordSearch::where('guid', $guid)->first();
			
			$keyword=$search_param->keyword;
			
			
			$query = Portfolio::from('portfolio AS p')->leftJoin('categories AS c', 'p.category_id','=','c.id')->leftJoin('portfolio_brands AS pb', 'pb.portfolio_id','=','p.id')->select('p.*', 'c.title AS cat_title');
			
			if($keyword != '' || $search_param->tag_ids != ''){
				$query->leftJoin('portfolio_tags AS pt', 'pt.portfolio_id', '=', 'p.id')
				->leftJoin('tags AS t', 'pt.tags_id', '=', 't.id');
			}
			
			if($search_param->category_id > 0){
				$query->where('p.category_id', '=', $search_param->category_id); 
			}
			
			if($search_param->industry_id > 0){
				$query->where('p.industry_id', '=', $search_param->industry_id); 
			}
			
			if($search_param->tag_ids != ''){
				$tags_arr = explode(",",$search_param->tag_ids);
				$query->whereIn('pt.tags_id', $tags_arr);
			}
			
			if($keyword != ''){
				$query->where(function ($query) use ($keyword) {
					$query->where('p.title', 'LIKE','%'.$keyword.'%')
						  ->orwhere('t.title', 'LIKE','%'.$keyword.'%');
				});
			}
			
			$portfolio = $query->where('p.status',1)->where('pb.brands_id',$id)->groupBy('id')->orderBy('id', 'desc')->get()->toArray();
			
			for($i=0; $i<count($portfolio); $i++){
				$portfolio[$i]['tech'] = DB::table('portfolio_technologies AS pt')->leftJoin('technologies AS t', 'pt.technologies_id', '=', 't.id')->select('t.title', 't.image AS icon')->where('portfolio_id', $portfolio[$i]['id'])->get()->toArray();
			}
			
			return view($this->view)->with('categories',$this->categories)->with('industries',$this->industries)->with('tags',$this->tags)->with('portfolios',$portfolio)->with('brand_id',$id)->with('params',$search_param);
		}
	}
	
	public function get_filters($id){
		$this->categories = DB::table('portfolio AS p')->leftJoin('portfolio_brands AS pb', 'pb.portfolio_id','=','p.id')->leftJoin('categories AS c', 'p.category_id', '=', 'c.id')->select('p.industry_id AS ind_id', 'c.id AS cat_id', 'c.title AS cat_title')->where('pb.brands_id',$id)->where('p.status', 1)->where('c.status',1)->orderBy('c.title')->get();
        
        $this->industries = DB::table('portfolio AS p')->leftJoin('portfolio_brands AS pb', 'pb.portfolio_id','=','p.id')->leftJoin('industries AS i', 'p.industry_id', '=', 'i.id')->select('p.category_id AS cat_id', 'i.id  AS ind_id', 'i.title  AS ind_title')->where('pb.brands_id',$id)->where('p.status', 1)->where('i.status',1)->orderBy('i.title')->get();
        
        $this->tags = DB::table('portfolio AS p')->leftJoin('portfolio_brands AS pb', 'pb.portfolio_id','=','p.id')->leftJoin('portfolio_tags AS pt', 'pt.portfolio_id', '=', 'p.id')->leftJoin('tags AS t', 'pt.tags_id', '=', 't.id')->select('p.category_id AS cat_id', 't.id AS tag_id', 't.title AS tag_title')->where('pb.brands_id',$id)->where('p.status', 1)->where('t.status',1)->where('is_filter',0)->get();
	}
 
}
