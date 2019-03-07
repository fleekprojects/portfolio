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


class HomeController extends Controller
{
	public function __construct()
    {
        $this->view = 'front.home';
		if(isset($_GET['wp']) && $_GET['wp']==1){
			$_SESSION['is_wp']=1;
		}
		else{
			$_SESSION['is_wp']=0;
		}
		
		$this->categories = DB::table('portfolio AS p')->leftJoin('categories AS c', 'p.category_id', '=', 'c.id')->select('p.industry_id AS ind_id', 'c.id AS cat_id', 'c.title AS cat_title')->where('p.status', 1)->where('c.status',1)->orderBy('c.title')->get();
        
        $this->industries = DB::table('portfolio AS p')->leftJoin('industries AS i', 'p.industry_id', '=', 'i.id')->select('p.category_id AS cat_id', 'i.id  AS ind_id', 'i.title  AS ind_title')->where('p.status', 1)->where('i.status',1)->orderBy('i.title')->get();
        
        $this->tags = DB::table('portfolio AS p')->leftJoin('portfolio_tags AS pt', 'pt.portfolio_id', '=', 'p.id')->leftJoin('tags AS t', 'pt.tags_id', '=', 't.id')->select('p.category_id AS cat_id', 't.id AS tag_id', 't.title AS tag_title')->where('p.status', 1)->where('t.status',1)->where('is_filter',0)->get();
    }

    public function index(){
		$portfolio = Portfolio::from('portfolio AS p')->leftJoin('categories AS c', 'p.category_id','=','c.id')->select('p.*', 'c.title AS cat_title')->where('p.status',1)->orderBy('id', 'desc')->get()->toArray();
		
        for($i=0; $i<count($portfolio); $i++){
			$portfolio[$i]['tech'] = DB::table('portfolio_technologies AS pt')->leftJoin('technologies AS t', 'pt.technologies_id', '=', 't.id')->select('t.title', 't.image AS icon')->where('portfolio_id', $portfolio[$i]['id'])->get()->toArray();
        }
        return view($this->view)->with('categories',$this->categories)->with('industries',$this->industries)->with('tags',$this->tags)->with('portfolios',$portfolio);
    }
	
	public function recordSearch(Request $request){
        $p_cat = $request->input('p_cat');
        $p_ind = $request->input('p_ind');
        $keyword = $request->input('keyword');
        $p_tags = $request->input('tags_list');
		
        if($p_cat == '' && $p_ind == '' && $keyword == ''){
            return redirect('/');
        }
		else{
            $rec_search = new \App\RecordSearch();
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
            return redirect('/'.$guid);
        }
    }
	
	public function getSearch($guid){
		if (RecordSearch::where('guid', '=', $guid)->count() > 0){
			$search_param = \App\RecordSearch::where('guid', $guid)->first();
			
			$keyword=$search_param->keyword;
			
			$query = Portfolio::from('portfolio AS p')->leftJoin('categories AS c', 'p.category_id','=','c.id')->select('p.*', 'c.title AS cat_title');
			
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
			
			$portfolio = $query->where('p.status',1)->groupBy('id')->orderBy('id', 'desc')->get()->toArray();
			
			for($i=0; $i<count($portfolio); $i++){
				$portfolio[$i]['tech'] = DB::table('portfolio_technologies AS pt')->leftJoin('technologies AS t', 'pt.technologies_id', '=', 't.id')->select('t.title', 't.image AS icon')->where('portfolio_id', $portfolio[$i]['id'])->get()->toArray();
			}
			
			return view($this->view)->with('categories',$this->categories)->with('industries',$this->industries)->with('tags',$this->tags)->with('portfolios',$portfolio)->with('params',$search_param);
		}
		else{
			return redirect('/');
		}
	}
 
}
