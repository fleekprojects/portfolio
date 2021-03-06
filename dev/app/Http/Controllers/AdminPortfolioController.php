<?php namespace App\Http\Controllers;

	use Session;
	use Request;
	use DB;
	use CRUDBooster;

	class AdminPortfolioController extends \crocodicstudio\crudbooster\controllers\CBController {

	    public function cbInit() {

			# START CONFIGURATION DO NOT REMOVE THIS LINE
			$this->title_field = "title";
			$this->limit = "20";
			$this->orderby = "id,desc";
			$this->global_privilege = false;
			$this->button_table_action = true;
			$this->button_bulk_action = true;
			$this->button_action_style = "button_icon";
			$this->button_add = true;
			$this->button_edit = true;
			$this->button_delete = true;
			$this->button_detail = true;
			$this->button_show = false;
			$this->button_filter = true;
			$this->button_import = false;
			$this->button_export = true;
			$this->table = "portfolio";
			# END CONFIGURATION DO NOT REMOVE THIS LINE

			# START COLUMNS DO NOT REMOVE THIS LINE
			$pthumsize=CRUDBooster::getSetting('thumbnail_maximum_size');
			$this->col = [];
			$this->col[] = ["label"=>"Category","name"=>"category_id","join"=>"categories,title"];
			$this->col[] = ["label"=>"Industry","name"=>"industry_id","join"=>"industries,title"];
			$this->col[] = ["label"=>"Title","name"=>"title"];
			$this->col[] = ["label"=>"Slug","name"=>"slug"];
			$this->col[] = ["label"=>"URL","name"=>"url"];
			$this->col[] = ["label"=>"Thumbnail","name"=>"thumbnail","image"=>true];
			$this->col[] = ["label"=>"Status","name"=>"status","callback_php"=>'($row->status == "1" ? "Active" : "In Active")'];
			$this->col[] = ["label"=>"Created At","name"=>"created_at","callback_php"=>'($row->created_at != "" ? date("jS M Y h:i A",strtotime($row->created_at)) : "")'];
			$this->col[] = ["label"=>"Last Updated","name"=>"updated_at","callback_php"=>'($row->updated_at != "" ? date("jS M Y h:i A",strtotime($row->updated_at)) : "")'];
			$this->col[] = ["label"=>"Uploaded By","name"=>"uploaded_by","join"=>"cms_users,name"];
			# END COLUMNS DO NOT REMOVE THIS LINE

			# START FORM DO NOT REMOVE THIS LINE
			$this->form = [];
			$this->form[] = ['label'=>'Brands','name'=>'brands','type'=>'select2','validation'=>'required','width'=>'col-sm-9','datatable'=>'brands,title','relationship_table'=>'portfolio_brands','datatable_where'=>'status=1'];
			$this->form[] = ['label'=>'Category','name'=>'category_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-9','datatable'=>'categories,title','datatable_where'=>'status=1'];
			$this->form[] = ['label'=>'Industry','name'=>'industry_id','type'=>'select2','validation'=>'required|integer|min:0','width'=>'col-sm-9','datatable'=>'industries,title','datatable_where'=>'status=1'];
			$this->form[] = ['label'=>'Title','name'=>'title','type'=>'text','validation'=>'required|string|min:3|max:70','width'=>'col-sm-9','placeholder'=>'Enter Text Only'];
			$this->form[] = ['label'=>'Slug','name'=>'slug','type'=>'text','width'=>'col-sm-9','placeholder'=>'Leave Empty to generate automatic slug'];
			$this->form[] = ['label'=>'URL','name'=>'url','type'=>'text','validation'=>'url','width'=>'col-sm-9','placeholder'=>'Please enter a valid URL'];
			$this->form[] = ['label'=>'Technologies Used','name'=>'technologies','type'=>'select2','width'=>'col-sm-9','datatable'=>'technologies,title','relationship_table'=>'portfolio_technologies','datatable_where'=>'status=1'];
			$this->form[] = ['label'=>'Thumbnail','name'=>'thumbnail','type'=>'upload','validation'=>"required|image|max:$pthumsize",'width'=>'col-sm-9','help'=>'File types support : JPG, JPEG, PNG, GIF, BMP -- Max Image Size: 500KB'];
			$this->form[] = ['label'=>'Image','name'=>'image','type'=>'upload','validation'=>'image|max:3000','width'=>'col-sm-9','help'=>'File types support : JPG, JPEG, PNG, GIF, BMP'];
			$this->form[] = ['label'=>'Description','name'=>'description','type'=>'textarea','validation'=>'required|string|min:5|max:5000','width'=>'col-sm-9','help'=>'The description must be at least 5 characters.'];
			$this->form[] = ['label'=>'Tags','name'=>'tags','type'=>'select2','validation'=>'required','width'=>'col-sm-9','datatable'=>'tags,title','relationship_table'=>'portfolio_tags','datatable_where'=>'status=1'];
			if(CRUDBooster::myPrivilegeId()<=2){
				$this->form[] = ['label'=>'Uploaded By','name'=>'uploaded_by','type'=>'select2','validation'=>'required','width'=>'col-sm-9','datatable'=>'cms_users,name'];
				$this->form[] = ['label'=>'Status','name'=>'status','type'=>'radio','width'=>'col-sm-9','dataenum'=>'1|Active;0|In Active','value'=>'1'];
			}
			# END FORM DO NOT REMOVE THIS LINE

			/* 
	        | ---------------------------------------------------------------------- 
	        | Sub Module
	        | ----------------------------------------------------------------------     
			| @label          = Label of action 
			| @path           = Path of sub module
			| @foreign_key 	  = foreign key of sub table/module
			| @button_color   = Bootstrap Class (primary,success,warning,danger)
			| @button_icon    = Font Awesome Class  
			| @parent_columns = Sparate with comma, e.g : name,created_at
	        | 
	        */
	        $this->sub_module = array();


	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Action Button / Menu
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @url         = Target URL, you can use field alias. e.g : [id], [name], [title], etc
	        | @icon        = Font awesome class icon. e.g : fa fa-bars
	        | @color 	   = Default is primary. (primary, warning, succecss, info)     
	        | @showIf 	   = If condition when action show. Use field alias. e.g : [id] == 1
	        | 
	        */
	        $this->addaction = array();



	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add More Button Selected
	        | ----------------------------------------------------------------------     
	        | @label       = Label of action 
	        | @icon 	   = Icon from fontawesome
	        | @name 	   = Name of button 
	        | Then about the action, you should code at actionButtonSelected method 
	        | 
	        */
	        $this->button_selected = array();

	                
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add alert message to this module at overheader
	        | ----------------------------------------------------------------------     
	        | @message = Text of message 
	        | @type    = warning,success,danger,info        
	        | 
	        */
	        $this->alert        = array();
	                

	        
	        /* 
	        | ---------------------------------------------------------------------- 
	        | Add more button to header button 
	        | ----------------------------------------------------------------------     
	        | @label = Name of button 
	        | @url   = URL Target
	        | @icon  = Icon from Awesome.
	        | 
	        */
	        $this->index_button = array();
			
			if(CRUDBooster::myPrivilegeId()<=2){
				$this->index_button[] = ["label"=>"Show Pending Items","icon"=>"fa fa-check",'color'=>'warning',"url"=>CRUDBooster::adminpath('portfolio-pending')];
			}




	        /* 
	        | ---------------------------------------------------------------------- 
	        | Customize Table Row Color
	        | ----------------------------------------------------------------------     
	        | @condition = If condition. You may use field alias. E.g : [id] == 1
	        | @color = Default is none. You can use bootstrap success,info,warning,danger,primary.        
	        | 
	        */
	        $this->table_row_color = array();     	          

	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | You may use this bellow array to add statistic at dashboard 
	        | ---------------------------------------------------------------------- 
	        | @label, @count, @icon, @color 
	        |
	        */
	        $this->index_statistic = array();



	        /*
	        | ---------------------------------------------------------------------- 
	        | Add javascript at body 
	        | ---------------------------------------------------------------------- 
	        | javascript code in the variable 
	        | $this->script_js = "function() { ... }";
	        |
	        */
	        $this->script_js = '
				$(function() {
					var category=$("#category_id").find(":selected").text();
					if(category == "Website"){
						$("#form-group-url").slideDown();
						$("#form-group-technologies").slideDown();
						$("#form-group-image").slideUp();
					}
					else{
						$("#form-group-image").slideDown();
						$("#form-group-url").slideUp();
						$("#form-group-technologies").slideUp();
					}
					$("#category_id").change(function() {
						var category=$(this).find(":selected").text();
						if(category == "Website"){
							$("#form-group-url").slideDown();
							$("#form-group-technologies").slideDown();
							$("#form-group-image").slideUp();
							$("#image").val("");
						}
						else{
							$("#form-group-image").slideDown();
							$("#form-group-url").slideUp();
							$("#form-group-technologies").slideUp();
							$("#url").val("");
							$("#technologies").select2("val", "");
						}
					});
				});';


            /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code before index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it before index table
	        | $this->pre_index_html = "<p>test</p>";
	        |
	        */
	        $this->pre_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include HTML Code after index table 
	        | ---------------------------------------------------------------------- 
	        | html code to display it after index table
	        | $this->post_index_html = "<p>test</p>";
	        |
	        */
	        $this->post_index_html = null;
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include Javascript File 
	        | ---------------------------------------------------------------------- 
	        | URL of your javascript each array 
	        | $this->load_js[] = asset("myfile.js");
	        |
	        */
	        $this->load_js = array();
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Add css style at body 
	        | ---------------------------------------------------------------------- 
	        | css code in the variable 
	        | $this->style_css = ".style{....}";
	        |
	        */
	        $this->style_css = '#form-group-url, #form-group-technologies, #form-group-image{
				display:none;
			}';
	        
	        
	        
	        /*
	        | ---------------------------------------------------------------------- 
	        | Include css File 
	        | ---------------------------------------------------------------------- 
	        | URL of your css each array 
	        | $this->load_css[] = asset("myfile.css");
	        |
	        */
	        $this->load_css = array();
	        
	        
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for button selected
	    | ---------------------------------------------------------------------- 
	    | @id_selected = the id selected
	    | @button_name = the name of button
	    |
	    */
	    public function actionButtonSelected($id_selected,$button_name) {
	        //Your code here
	            
	    }


	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate query of index result 
	    | ---------------------------------------------------------------------- 
	    | @query = current sql query 
	    |
	    */
	    public function hook_query_index(&$query) {
	        //Your code here
	            
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate row of index table html 
	    | ---------------------------------------------------------------------- 
	    |
	    */    
	    public function hook_row_index($column_index,&$column_value) {	        
	    	//Your code here
	    }

	    /*
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before add data is execute
	    | ---------------------------------------------------------------------- 
	    | @arr
	    |
	    */
	    public function hook_before_add(&$postdata) {
			if(CRUDBooster::myPrivilegeId()>2){
				$postdata['uploaded_by']=CRUDBooster::myId();
			}
			if(empty($postdata['slug'])){
				$postdata['slug']=strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $postdata['title'])));
			}
			$data['category_id']=$postdata['category_id'];
			foreach($_POST['tags'] as $key => $tag){
				if(!is_numeric($tag)){
					$data['title']=$tag;
					$data['slug']=strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $tag)));
					$check=CRUDBooster::first('tags',['slug'=>$data['slug']]);
					if(!isset($check->id)){
						$last_id=CRUDBooster::insert('tags',$data);
						$_POST['tags'][$key]=$last_id;
					}
					else{
						$_POST['tags'][$key]=$check->id;
					}
				}
			}
			define('tags_arr',$_POST['tags']);
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after add public static function called 
	    | ---------------------------------------------------------------------- 
	    | @id = last insert id
	    | 
	    */
	    public function hook_after_add($id) {        
	        //Your code here
			if(CRUDBooster::myPrivilegeId()>2){
				$config['content'] = "New Portfolio Item";
				$config['to'] = CRUDBooster::adminPath('portfolio-pending');
				$config['id_cms_users'] = [1,2];
				CRUDBooster::sendNotification($config);
			}
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for manipulate data input before update data is execute
	    | ---------------------------------------------------------------------- 
	    | @postdata = input post data 
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_edit(&$postdata,$id) {
		   $data['category_id']=$postdata['category_id'];
		   foreach($_POST['tags'] as $key => $tag){
			   if(!is_numeric($tag)){
				   $data['title']=$tag;
				   $data['slug']=strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $tag)));
				   $check=CRUDBooster::first('tags',['slug'=>$data['slug']]);
				   if(!isset($check->id)){
					   $last_id=CRUDBooster::insert('tags',$data);
					   $_POST['tags'][$key]=$last_id;
				   }
				   else{
					   $_POST['tags'][$key]=$check->id;
				   }
			   }
		   }
		   define('tags_arr',$_POST['tags']);      
	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after edit public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_edit($id) {
	        //Your code here 

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command before delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_before_delete($id) {
	        //Your code here

	    }

	    /* 
	    | ---------------------------------------------------------------------- 
	    | Hook for execute command after delete public static function called
	    | ----------------------------------------------------------------------     
	    | @id       = current id 
	    | 
	    */
	    public function hook_after_delete($id) {
	        //Your code here

	    }



	    //By the way, you can still create your own method in here... :) 


	}