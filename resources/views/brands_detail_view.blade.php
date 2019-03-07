<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
@section('content')
<!-- Your html goes here -->
<table id="table-detail" class="table table-striped">
<tbody>
<tr><td>Title</td><td>{{$row->title}}</td></tr>
<tr><td>Slug</td><td>{{$row->slug}}</td></tr>
<tr><td>URL</td><td>{{$row->url}}</td></tr>
<tr>
<td>Logo</td>
<td><a data-lightbox="roadtrip" href="{{url('public/')}}/{{$row->image}}"><img style="max-width:150px" title="{{$row->title}}" src="{{url('public/')}}/{{$row->image}}"></a>
</td>
</tr>
<tr>
<td>Status</td>
<td><span class="badge">{{($row->status==1 ? 'Active' : 'InActive')}}</span> </td>
</tr>
</tbody>
</table>
<div id="tabs">
  <ul>
    <li><a href="#tabs-1">PHP Code Integeration</a></li>
    <li><a href="#tabs-2">PHP Library</a></li>
    <li><a href="#tabs-3">Wordpress Plugin</a></li>
  </ul>
  <div id="tabs-1">
    <p>Here is the code of php</p>
    <pre id="curl_script_div">
    $ch = curl_init();
    if(isset($_GET['guid']) && $_GET['guid']>0){
        $url='{{url('/')}}/p/{{$row->id}}/'.$_GET['guid'].'?wp=0';
    }
    else{
        $url='{{url('/')}}/p/{{$row->id}}'.'?wp=0';
    }
    curl_setopt($ch, CURLOPT_URL, $url); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    if(isset($_POST['action']) && $_POST['action']=="portfilter"){
		if(isset($_POST['tags_list']) && is_array($_POST['tags_list'])){
			$_POST['tags_list']=implode(",", $_POST['tags_list']);
		}
        $headers = array('X-CSRF-TOKEN' => $_POST['_token']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    $output = curl_exec($ch); 
    curl_close($ch);
    echo $output;
    </pre>
  </div>
  <div id="tabs-2">
    <p>Php Library</p>
    <a id="gen_php" href="{{url('phplibrary.zip')}}"><u>Download PHP Library</u> <img src="{{url('public/image/sublime-text-logo.png')}}" height="30px"></a>
  </div>
  <div id="tabs-3">
    <p>Wordpress Plugin</p>
    <a href="{{url('flkportfolio.zip')}}"><u>Download Plugin</u></a>
  </div>
</div>
@endsection