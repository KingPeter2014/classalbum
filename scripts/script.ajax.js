function createRequestObject(){
	var request_o;
	var browser = navigator.appName;
	if(browser == "Microsoft Internet Explorer"){
		request_o = new ActiveXObject("Microsoft.XMLHTTP");
	} else{
		request_o = new XMLHttpRequest();
	}
	return request_o;
}
var http = createRequestObject();

function doGetPrice(){
	http.open('get', 'ajax.php');
	http.onreadystatechange = function(){
		if(http.readyState == 4){
			var response = http.responseText;
			document.getElementById('price').innerHTML = '';
		}
	};
	http.send(null);
}