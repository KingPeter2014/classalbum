<?php

require_once "inc/header.php";
?>

<script type="text/javascript">

	function start(){
		$('span#output').html(' Processing...')
	}
	function finished(s){
		//$('span#output').html('<div class="success">'+s+'</div>');

		if(s.indexOf("success")!=-1){
			s1=s.split(":");
			
				$('span#output').html('<div class="success">'+ s1[1] +'</div>');
			//Boxy.load('/highacademia/configure.php',{title:'Configure your Institution',afterHide:function(){location.href='home.php';}});
		}
		else if(s.indexOf("error")!=-1){
			s1=s.split(":");
			if(s1[0]=="error"){$('span#output').html('<div class="error">'+ s1[1] +'</div>');}
		}
		else
			$('span#output').html('<div class="error"> Unknown Error Occured</div>');
	}

	function getLGAs(x){
		var state= x.value;
	
		$.ajax({
			
			url:"ajax.getLGAs.php?state_name="+state,
			beforeSend: function(){$('#lga').html('Searching...');},
			success: function(s){
				$('#lga').html(s);
			}
		});
	}
	
	function start(){
		$('span#output').html(' Processing...')
	}
	function finished(s){
		//$('span#output').html('<div class="success">'+s+'</div>');

		if(s.indexOf("success")!=-1){
			s1=s.split(":");
			
				$('span#output').html('<div class="success">'+ s1[1] +'</div>');
			//Boxy.load('/highacademia/configure.php',{title:'Configure your Institution',afterHide:function(){location.href='home.php';}});
		}
		else if(s.indexOf("error")!=-1){
			s1=s.split(":");
			if(s1[0]=="error"){$('span#output').html('<div class="error">'+ s1[1] +'</div>');}
		}
		else
			$('span#output').html('<div class="error"> Unknown Error Occured</div>');
	}
//onsubmit="return AIM.submit(this, {'onStart' : start, 'onComplete' : finished})";
</script>
<div id="centralarea">
	<div id ="menubar">

	<li><a href="">Gender</a></li>
	<li><a href="#"> Biodata</a></li>
	<li><a href="#"> Staff</a></li>
	<li><a href="#"> Results</a></li>
	<li><a href="#"> NYSC</a></li>
	<li><a href="#"> Documents</a></li>
	<li><a href="#">SpreadSheets</a></li>
	<li><a href="#">Downloads</a></li>
</div>
	Reports and Searches

</div>