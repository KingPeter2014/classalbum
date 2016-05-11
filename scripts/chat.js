function Chat(sw, cp, me){
	this.SCREEN_WIDTH=sw;
	this.CHAT_WINDOW_WIDTH=210;
	this.MAX_CHAT_WINDOW=Math.floor((sw/this.CHAT_WINDOW_WIDTH)-1);
	this.chatProcessor=cp;
	this.me=me;
} 

function openNewChatWindow(msg, mid, username){
	if(countChatWindows() >= chat.MAX_CHAT_WINDOW){
		alert("Sorry you cant open more windows");return;
	}
	if(!isUserExist(username)){
		$('#chatArea').append('<div id="'+username+'" class="chatPosition restoreChatWindow" style="right:'+getRightPosition()+'px;"><div id="'+username+'" class="chatTitle"><span id="closeButton">&nbsp;x&nbsp;</span> <span id="minimizeButton">&nbsp; - &nbsp;</span><span id="title">'+username+'</span></div><div id="chatBody" user="'+username+'"></div><div id="chatBottom" user="'+username+'"><a id="send" href="javascript:void(0)" title="Send" class="button" style="float: right; height:78%; text-align:center"><br>Send</a><textarea id="msg" name="msg" placeholder="Type a message" rows="2"></textarea></div></div>   <div id="'+username+'_" class="chatTitle chatPosition hideChatWindow" style="right:'+getRightPosition()+'px" ><span id="closeButton">&nbsp;x&nbsp;</span> <span id="minimizeButton">&nbsp; --- &nbsp;</span><span id="title">'+username+'</span></div>');
		
		
		initChat(username);
		if((msg != undefined) && (msg != null)){
			appendMessage(username, msg, mid);
		}else{
			saveChatWindows();
		}
	}else if((mid != undefined) && (mid != null)){
		//console.log("Appending window for: "+username);
		appendMessage(username, msg, mid);
	}else{
		//console.log("NOT Creating chta window for: "+username);
		restoreChatWindow(username);
	}
};

function minimizeChatWindow(username){
	if(username == undefined){//If undefined: minimize all chat windows
		$('#chatArea', window.parent.document).find('div iframe').removeClass('restoreChatWindow').addClass('minimizeChatWindow');	//If the event is coming from the child container
		$('#chatArea').find('div iframe').removeClass('restoreChatWindow').addClass('minimizeChatWindow'); //If the event is coming from the parent container
	}else{//minimize only the selected window
		$('#chatArea div[id="'+username+'"]:first').removeClass('restoreChatWindow').addClass('hideChatWindow');
		$('#chatArea div[id="'+username+'_"]:first').removeClass('hideChatWindow').addClass('restoreChatWindow');
	}
	saveChatWindows();	
};

function restoreChatWindow(username){
	$('#chatArea div[id="'+username+'"]:first').removeClass('hideChatWindow').addClass('restoreChatWindow');
	$('#chatArea div[id="'+username+'_"]:first').removeClass('restoreChatWindow').addClass('hideChatWindow');
	setFocusAndScroll(username);
};

function closeChatWindow(username){
	$('#chatArea div[id="'+username+'"]').replaceWith("");
	$('#chatArea div[id="'+username+'_"]').replaceWith("");
	repositionChatWindows();
};

function setOffline(username){
	//TODO: set my status to be offline
};

function clickChat(){
	x = $('#chatmenu').position().left;	
	$.ajax({
		url:'/chat/chat_users.php',
		success:function(s){$('#chatList ul').html(s);},
		error:function(){$('#chatList ul').html('<li style="color:red"><span>&times;</span> Failed to load users for chat</li>')},
		beforeSend:function(){
			$('#chatList ul').html('<li><img src="/images/loading.gif"> Loading Users ...</li>')},
	});
	$('#chatList').css({'left':(x-20)+'px'}).slideToggle('slow');
	
	//timeout = setTimeout(function(){$('#chatList').hide('slow');},10000);
};

function getNewMessage(me){
	var mid=0;
	count=0;
	setInterval(function(){
		//console.log("Interval : "+ count++);
		$.ajax({
			type: "POST",
			url:  chat.chatProcessor,
			data: "source=readNew&me="+me,
			success: function(data){
				var msgs = eval( data );
				if(msgs.length > 0){
					mid=msgs[0].msgId;
					if(isUserExist(msgs[0].from)){
						//console.log("APEND===================\nFrom: "+msgs[0].from+"  ::  To: "+msgs[0].to+"  ::  Body: "+msgs[0].msgBody+"  ::  MID: "+msgs[0].msgId);
						appendMessage( msgs[0].from, msgs[0].msgBody, msgs[0].msgId);
					}else{
						//console.log("NEW===================\nFrom: "+msgs[0].from+"  ::  To: "+msgs[0].to+"  ::  Body: "+msgs[0].msgBody+"  ::  MID: "+msgs[0].msgId);
						openNewChatWindow(msgs[0].msgBody, msgs[0].msgId, msgs[0].from);
					}
					
					setAsRead(mid);
				}
			}, error: function(){
				//console.log("Error: getNewMessage");
			}
		});
	}, 2000);
	//appendMessage(msg);
};

function sendMessage(to, msg){
	$.ajax({
		type: "POST",
		url: chat.chatProcessor ,
		data: "source=send&from="+chat.me+"&to="+to+"&msg="+msg.trim(),
		success: function(data){
			//TODO:	Append time and msg id to the paragraph/Horizontal line
			//console.log("Success: sendMessage"+data);
		},
		error: function(){
			//TODO: alert failure and prompt for resend
			//console.log("Error: sendMessage");	
		}
	});	
};

function setAsRead(mid){
	console.log("Setting as read: "+mid+"\n");
	$.ajax({
		type: "POST" ,
		url: chat.chatProcessor ,
		data: "source=setRead&mid="+mid ,
		success: function(data){
			//console.log("Successfully SET To READ: "+data);
		},
		error: function(){
			//console.log("Error: setAsRead");	
		}
	});		
};


function iSendLast(username){
	chatBody=$('#chatArea div[id="'+username+'"] #chatBody[user="'+username+'"]');
	//console.log("iSendLast: "+chatBody.has('p[class="triangle-right"]').length);
}

function appendMessage(username, msg, mid){
	if(mid == undefined){mid=0;}
	if(mid == 0){//If msg is from self
		iSendLast(username);
		//console.log(msg+" :appendMessage:1 "+$('#chatArea div[id="'+username+'"] #chatBody[user="'+username+'"]'));
		var chatBody=$('#chatArea div[id="'+username+'"] #chatBody[user="'+username+'"]');
		if(chatBody.find('p').length>0){//If there is message already 
			if(chatBody.find('p:last').attr('class') == "triangle-right"){//and I am the last sender
				//console.log("1. Appending to: "+chatBody.find('p:last').html());
				chatBody.find('p:last').append('<span msgId="'+mid+'"></span>'+msg);
			}else{
				//console.log("2. Appending to: "+chatBody.find('p:last').html());
				chatBody.find('p:last').after('<p class="triangle-right" msgId="'+mid+'">'+msg+'</p>');	
			}
		}else{//First time msg
			chatBody.html('<p class="triangle-right" msgId="'+mid+'">'+msg+'</p>');
		}
	}else{
		//console.log("appendMessage:2 "+$('#chatArea div[id="'+username+'"] #chatBody[user="'+username+'"]').html());
		var chatBody=$('#chatArea div[id="'+username+'"] #chatBody[user="'+username+'"]');
		
		if(chatBody.find('p').length>0){//If there is message already 
			if(chatBody.find('p:last').attr('class') == "triangle-right"){//and I am NOT the last sender
				//console.log("3. Appending to: "+chatBody.find('p:last').html());
				chatBody.find('p:last').after('<p class="triangle-right top" msgId="'+mid+'">'+msg+'</p>');	
			}else{
				chatBody.find('p:last').append('<span msgId="'+mid+'"></span>'+msg);
				//console.log("5. Appending to: "+chatBody.find('p:last').html());
			}
		}else{//First time msg
			chatBody.html('<p class="triangle-right top" msgId="'+mid+'">'+msg+'</p>');
		}
	}
	setFocusAndScroll(username);
	if(mid == 0){clearMsgBox(username);}
};

function setFocusAndScroll(username){
	$('#chatArea div[id="'+username+'"] #chatBottom').find('#msg').focus();
	$('#chatArea div[id="'+username+'"] #chatBody[user="'+username+'"]').scrollTop('0');
	saveChatWindows();
};

function clearMsgBox(username){
	$('#chatArea div[id="'+username+'"] #chatBottom').find('#msg').val('');
}

function isUserExist(username){
	var status=false;
	if($('#chatArea div[id="'+username+'"]').length > 0){
		status=true;
	}			
	return status;
};

function markAsActiveChat(username){
	//TODO: Find and mark as Active Chat
	//e.attr('activeChat', '1');
};

function initChat(username){
	//console.log("Initialing........: "+username+"\n"+$('#chatArea div[id="'+username+'"] #chatBottom').find('#msg').length);

	$('#chatArea div[id="'+username+'"] .chatTitle').find('#minimizeButton').click(function(e) {
       minimizeChatWindow(username);
    });	
	$('#chatArea div[id="'+username+'"] .chatTitle').find('#title').click(function(e) {
       //console.log("This should be linked to this user's profile.\nNote: Not yet implementated");
    });	
	$('#chatArea div[id="'+username+'_"]').find('#title').click(function(e) {
		//this.minimizeChatWindow();
        restoreChatWindow(username);		
    });
	
	$('#chatArea div[id="'+username+'"]').find('#closeButton').click(function(e) {//connects the both close buttons
        closeChatWindow(username);
    });
	$('#chatArea div[id="'+username+'_"]').find('#closeButton').click(function(e) {//connects the both close buttons
        $('#chatArea div[id="'+username+'"]').find('#closeButton').click();
    });
	
	$('#chatArea div[id="'+username+'"] #chatBottom').find('#msg').keypress(function(e) {
        if(e.keyCode == 13){
			var msg=$(this).val();
			if(msg.length >0){
				appendMessage(username, msg);
				sendMessage(username, msg);	
			}else{
				setFocusAndScroll(username);				
			}
		}
    });
	$('#chatArea div[id="'+username+'"] #chatBottom').find('#send').click(function(e) {
		var msg=$('#chatArea div[id="'+username+'"] #chatBottom').find('#msg').val();
		if(msg.length >0){
			appendMessage(username, msg);
			sendMessage(username, msg);	
		}else{
			setFocusAndScroll(username);				
		}
    });
	setFocusAndScroll(username);
};

function getSavedChatWindows(){
	console.log("Pre-Loading:..................... "+$('#chatArea').find('*').parent().html());
	store.get('chatAreaContent', function(ok, val){
		if(ok && (val != undefined) && (val != null ) && (val != "null")){
			fillChatArea(val);
		}
	});
}

function saveChatWindows(){
	var chatAreaContent= $('#chatArea').find('*').parent().html();
	store.set('chatAreaContent', chatAreaContent);
	console.log("Saving:..........  "+chatAreaContent);
}

function fillChatArea(html){
	console.log($('#chatArea').html()+"................................\nb4: "+html)
	$('#chatArea').html(html);
	console.log("After: "+ $('#chatArea').html())
	$('#chatArea').find('div[id="chatBody"]').each(function(index, e) {
        initChat(e.getAttribute('user'));
		console.log("\n\n"+ (index+1) +".  "+ $(this).parent().html());
    });
	//store.set('chatAreaContent', "");
}

function getRightPosition(){
	return (countChatWindows()*chat.CHAT_WINDOW_WIDTH);
};

function countChatWindows(){
	return ( $('#chatArea').find('div[class~="chatPosition"]').length)/2;
}

function repositionChatWindows(){
	var frames=$('#chatArea').find('div[class~="chatPosition"]');
	var lastFrame=frames.last();
	if(frames.length== 0)return;
	var lastRightPixel=lastFrame.css("right");
	var lastRightValue=parseInt(lastRightPixel.substr(0, lastRightPixel.length-2).trim());//Remove the px
	console.log("lastRightValue::  "+lastRightValue);
	var supposedChatWindows=parseInt(Math.floor(lastRightValue / chat.CHAT_WINDOW_WIDTH));
		//console.log("Frames...........:  "+frames.html()+"\n===========\n"+lastFrame.html());
	
	if(countChatWindows() == supposedChatWindows){//If not equal it implies that closed window is the last window hence no need for re-positioning
		var right=0, next=false, cont=-1;
		frames.each(function(index, e) {			
			if(cont++ %2==1){right += parseInt(chat.CHAT_WINDOW_WIDTH)}
			e.setAttribute('style', 'right:'+ right +'px');
			//console.log("Index "+index+" : "+e.getAttribute('class')+" ::  "+ right);
			
		});
	}else{
		//console.log("No Need");
	}	
	saveChatWindows();
};

function getQueryString(src, param){
	var pageURL=decodeURIComponent(src).substring(1);
	var urlParams=pageURL.split('&');
	for(var i=0; i<urlParams.length; i++){
		var paramName=urlParams[i].split('=');
		if(paramName[0] == param){
			return paramName[1];
		}
	}
};
