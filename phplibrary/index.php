<?php 
    $ch = curl_init();
    if(isset($_GET['guid']) && $_GET['guid']>0){
        $url='http://portfolioz.tk/p/3/'.$_GET['guid'].'?wp=0';
    }
    else{
        $url='http://portfolioz.tk/p/3'.'?wp=1';
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
    ?>