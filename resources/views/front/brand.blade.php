@extends('front.layout.template')
@section('content')

<div class="my-portfolio">
   <div class="loader2 main"></div>
   <div id="loder"></div>
   <div class="container">
      <div class="filterSection">
         <form name="p_srch_frm" id="p_srch_frm" method="POST">
			@csrf	
            <div class="dtbl">
               <div class="dtd wd-per30">
                  <div class="selectEle">
                     <input name="p_guid" type="hidden" value="{{$params->guid}}">
                     <input name="p_br" type="hidden" value="{{$brand_id}}">
                     <select name="p_cat" id="p_cat" onchange="ch_category()">
                     </select>
                  </div>
               </div>
               <div class="dtd wd-per30">
                  <div id="div_ind" class="selectEle">
                     <select name="p_ind" id="p_ind" onchange="ch_industry()">
                     </select>
                  </div>
               </div>
               <div class="dtd last">
                  <div class="searchBox">
                     <i class="icon-search"></i>
                     <!--<input id="tgs_srch" name="tgs_srch" type="text" placeholder="What are you looking for....">
                     <input type="hidden" name="tags_hide_id" id="tags_hide_id">-->
					 <input name="keyword" id="keyword" type="text" placeholder="What are you looking for....">
                     <button type="submit" name="action" value="portfilter" id="submit">Search</button>
                  </div>
               </div>
            </div>
            <div id="AdvTags" style="display:none;">
               <div class="advFilter">
                  <h2>Advance Filters</h2>
                  <i class="icon-minus">-</i>
               </div>
               <div class="row advrow">
                  <div id="chngtags" class="col-lg-9">
                     <ul class="filters" id="p_tag">
                     </ul>
                  </div>
                  <div class="col-lg-3 clearSec">
                     <a href="javascript:;" class="reset" onclick="resetfilter()">
                        <i class="icon-close"></i>
                        <p class="cls">Clear Selection</p>
                     </a>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
   <div id="portgolisimgs" class="container webImages">
      <div id="paging_container7" class="container">
         <ul class="content">
			@php 
			foreach($portfolios as $portfolio){ 
			@endphp
            <li><a class="showPop ele" data-imgsrc="{{url('/')}}/{{$portfolio['thumbnail']}}" data-title="{{$portfolio['title']}}" data-dsc="{{$portfolio['description']}}" data-showimg="{{url('/')}}/{{$portfolio['image']}}" data-techs="{{$tc}}" data-cat="{{$portfolio['cat_title']}}" href="<?= ($portfolio['url'] != "" ?  $portfolio['url'] : 'javascript:;'); ?>" ></a>
			@php
				if(!empty($portfolio['tech'])){
			@endphp
               <ul class="logos">
				  @php
					foreach($portfolio['tech'] as $tech){
				  @endphp
                  <li>
                     <img src="{{url('/').'/'.$tech->icon}}" class="cC">
                  </li>
                  @php } @endphp
               </ul> 
			   @php } @endphp
            </li>
            @php } @endphp
         </ul>
         <div class="page_navigation"></div>
      </div>
   </div>
</div>
<div class="frameHolder">
   <div class="overlay"></div>
   <div class="inCnt">
      <div class="header">
         <div class="row">
            <div class="col-lg-8">
               <i class="icon-previous backto"></i>
               <h3></h3>
               <h4></h4>
            </div>
            <div class="col-lg-4 borderLeft text-center">
               <ul class="navIcons">
                  <li>
                     <a href="javascript:;" class="desktopView">
                     <i class="icon-desktop"></i>
                     </a>
                  </li>
                  <li>
                     <a href="javascript:;" class="tabletPort">
                     <i class="icon-tablet"></i>
                     </a>
                  </li>
                  <li>
                     <a href="javascript:;" class="tabletLand">
                     <i class="icon-tablet rotate"></i>
                     </a>
                  </li>
                  <li>
                     <a href="javascript:;" class="phonePort">
                     <i class="icon-mobile"></i>
                     </a>
                  </li>
                  <li>
                     <a href="javascript:;" class="phoneLand">
                     <i class="icon-mobile rotate"></i>
                     </a>
                  </li>
               </ul>
            </div>
         </div>
      </div>
      <div class="webWrap loader">
         <iframe id="myIframe" src="javascript:;" width="100%" height="100%"></iframe>
      </div>
      <div class="footer">
         <div class="row">
            <div class="col-lg-8 col-md-7">
               <h4>DESCRIPTION</h4>
               <p></p>
            </div>
            <div class="col-lg-4 col-md-5 borderLeft text-center">
               <ul class="logos">
                  <li>
                     <img src="{{url('assets/images/t.gif')}}" data-imgsrc="{{url('assets/images/wordpress.png')}}" alt="">
                  </li>
                  <li>
                     <img src="{{url('assets/images/t.gif')}}" data-imgsrc="{{url('assets/images/php.png')}}" alt="">
                  </li>
                  <li>
                     <img src="{{url('assets/images/t.gif')}}" data-imgsrc="{{url('assets/images/html5.png')}}" alt="">
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</div>
<script type="text/javascript">
	var params = <?= json_encode($params); ?>;
	var cat_arr = JSON.parse('<?= json_encode($categories); ?>');
	var ind_arr = JSON.parse('<?= json_encode($industries); ?>');
	var tags_arr = JSON.parse('<?= json_encode($tags); ?>');
</script>
@endsection