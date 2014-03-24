onloadEvent(showtable);
//var bg = getCookie('excel_bg');
function changeSkin(i){
		document.body.style.background = "url('/images/bg/"+i+".gif')";
		 //document.getElementById('cssChange').href=css; //
		 setCookie('excel_bg',i);
}
function loaction(){
	var i;
	i = document.getElementById('code');
	location.href = '#'+i.value;
}
function toword(i,ver){
    if (i == 0) i = '';
	if (i){
		location.href = '?action=toword&ver='+ver+'&keywords='+i;
	}else{
		alert('请先搜索单个员工！');
		document.getElementById('keywords').focus();
	}
}
function onloadEvent(func){
	 var one = window.onload
	 if (typeof window.onload != 'function'){
		 window.onload = func
	 }
	 else{
		 window.onload=function(){
			   one();
			   func();
		 }
	 }
}
function showtable(){
	 var tableid = 'table';
	 var overcolor = '#ebebeb';
	 var color1 = '#FFFFFF';
	 var color2 = '#F8F8F8';
	 var tablename = document.getElementById(tableid)
	 var tr = tablename.getElementsByTagName("tr")
	 for(var i = 1 ;i < tr.length; i++){
		  tr[i].onmouseover = function(){
			   this.style.backgroundColor = overcolor;
		  }
		  tr[i].onmouseout = function(){
			   if(this.rowIndex%2 == 0){
					this.style.backgroundColor = color1;
			   }else{
					this.style.backgroundColor = color2;
			   }
		  }
		  if(i%2 == 0){
				tr[i].className = "color1";
		  }else{
				tr[i].className = "color2";
		  }
	 }
}
//浮动栏
function float_toolBar(id){
	var windowGeometry = {};
	if (window.innerWidth) { // All browsers but IE
		windowGeometry.getViewportWidth = function( ) { return window.innerWidth; };
		windowGeometry.getViewportHeight = function( ) { return window.innerHeight; };
		windowGeometry.getHorizontalScroll = function( ) { return window.pageXOffset; };
		windowGeometry.getVerticalScroll = function( ) { return window.pageYOffset; };
	}else if (document.documentElement && document.documentElement.clientWidth) {
		// These functions are for IE 6 when there is a DOCTYPE
		windowGeometry.getViewportWidth =
			function( ) { return document.documentElement.clientWidth; };
		windowGeometry.getViewportHeight =
			function( ) { return document.documentElement.clientHeight; };
		windowGeometry.getHorizontalScroll =
			function( ) { return document.documentElement.scrollLeft; };
		windowGeometry.getVerticalScroll =
			function( ) { return document.documentElement.scrollTop; };
	}else if (document.body.clientWidth) {
		// These are for IE4, IE5, and IE6 without a DOCTYPE
		windowGeometry.getViewportWidth =
			function( ) { return document.body.clientWidth; };
		windowGeometry.getViewportHeight =
			function( ) { return document.body.clientHeight; };
		windowGeometry.getHorizontalScroll =
			function( ) { return document.body.scrollLeft; };
		windowGeometry.getVerticalScroll =
			function( ) { return document.body.scrollTop; };
	}

   var floatbar = document.getElementById(id);
   if(floatbar)
   {
	floatbar.style.top = 
		parseInt(windowGeometry.getViewportHeight() + windowGeometry.getVerticalScroll() - floatbar.offsetHeight - 35) + "px"; 
	floatbar.style.left = 
		parseInt(windowGeometry.getViewportWidth() + windowGeometry.getHorizontalScroll() - floatbar.offsetWidth -55) + "px";
	setTimeout(function(){float_toolBar(id);},100)
   }
}

function setCookie(name, value) {
    var argv = setCookie.arguments;
    var argc = setCookie.arguments.length;
    var exp = (argc > 2) ? argv[2] : 1;
    var path = (argc > 3) ? argv[3] : null;
    var domain = (argc > 4) ? argv[4] : null;
    var secure = (argc > 5) ? argv[5] : false;
    var expires = new Date();
    expires.setTime(expires.getTime() + (exp*24*60*60*1000));
    document.cookie = name + "=" + value +
        "; expires=" + expires.toGMTString() +
        ((domain == null) ? "" : ("; domain=" + domain)) +
        ((path == null) ? "" : ("; path=" + path)) +
        ((secure == true) ? "; secure" : "");
	//alert(document.cookie);
}