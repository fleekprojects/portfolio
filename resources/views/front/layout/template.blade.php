<?php
	if(isset($_SESSION['is_wp']) && $_SESSION['is_wp']==1){
?>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		@yield('content')
<?php
	}
	else{
		?>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<link rel="stylesheet" href="{{url('assets/css/style.css')}}">
		<script type="text/javascript" src="{{url('assets/js/lib.js')}}"></script>
		@yield('content')
		<script type="text/javascript" src="{{url('assets/js/function.js')}}"></script>
		<script type="text/javascript" src="{{ url('assets/js/custom.js') }}"></script>
		<script type="text/javascript" src="{{ url('assets/js/jquery.pajinate.js') }}"></script>
		<?php
	}
?>
