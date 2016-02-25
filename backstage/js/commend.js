var Commend = function () {

    var main_content = $('.emailContent');
    var container = $('.headercontainer');
    var index_menu = $('.sidebar');
    var collapsed = false;
    var is_fixed_header = false;
    var array= new Array();
    var tid= ''; //当前选中的第一个帖子id
    var uid= ''; //tid的用户id
    var tmp = null; 
	/*-----------------------------------------------------------------------------------*/
	/*	Show single email view
	/*-----------------------------------------------------------------------------------*/
    var showSingleEmail = function (el,id) {
    	
        var url = 'commend_email.php?id='+ id;
        main_content.html('');
        toggleButton(el);        
        $.ajax({
            type: "GET",
            cache: false, 
            url: url,
            dataType: "html",
            //async : false,
            success: function(res) 
            {
                toggleButton(el);               
                main_content.html(res);    
                huifu(el);
           
				$('#editor').html($('#reply-content').html());
				$('#reply-content').hide();                
				
				$('#editor').focus();
                
                App.initUniform();
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                toggleButton(el);
            },
            async: false
        });
    }

    
    var handleThemeSkins = function () {
		// Handle theme colors
        var setSkin = function (color) {
            $('#skin-switcher').attr("href", "css/themes/" + color + ".css");
            $.cookie('skin_color', color);
        }
		$('ul.skins > li a').click(function () {
            var color = $(this).data("skin");
           
            setSkin(color);
        });
		
		//Check which theme skin is set
		 if ($.cookie('skin_color')) {
            setSkin($.cookie('skin_color'));
        }
	}
    
    
    var showindex_menu = function () {
        var url = 'admin_index_menu.php';      
        index_menu.html('');
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            async : false,
            success: function(res) 
            {
        		index_menu.html(res);
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
               
            },
            async: false
        });
    }
    
    var showheader = function () {
        var url = 'admin_index_top.php';      
        container.html('');
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            async : false,
            success: function(res) 
            {
        		container.html(res);
        		userswitching();
        		
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
               
            },
            async: false
        });
    }
    
   
    
    
    var userswitching = function () {
    	
    	$('.dropdown-menu > li > a .fa-male').click(function () {
			 		
			var email= $(this).html(); 	
			console.log(email);
	        $.ajax({
				type : 'post',
	            cache: false,
	            url: "action.php",
	            dataType: "html",
	            data : {
					action : 'userswitching',email: email
				},
	            success: function(obj) 
	            {
					//console.log(obj);
					var data = eval('(' + obj+ ')');
					if(data.status=="success")
					{
						showheader();
					}
					else{
						alert("切换失败，请检测您的网络"+ data.status );
					}
	            },
	            error: function(xhr, ajaxOptions, thrownError)
	            {
	                toggleButton(el);
	            },
	            async: false
	        });
        });
    }
   
	
	/*-----------------------------------------------------------------------------------*/
	/*	Show Inbox view
	/*-----------------------------------------------------------------------------------*/
	var showInbox = function (el, name) {
        var url = 'commend_main.php?type='+name;      
        main_content.html('');
        toggleButton(el);
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            //async : false,
            success: function(res) 
            {
                toggleButton(el);               
                main_content.html(res);
                nextshowInbox(el);  
                operationbox(el);
                App.initUniform();
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                toggleButton(el);
            },
            async: false
        });
    }
	
	var nextshowInbox = function (el) {
		/*下一页*/
		$('.btn-sm').click(function () {
			
			var maxId= $('#maxId').val();
			var type= $('#type').val();
	        var url = 'commend_main.php?type='+type+'&maxId='+maxId;      
	        main_content.html('');
	        toggleButton(el);
	        $.ajax({
	            type: "GET",
	            cache: false,
	            url: url,
	            dataType: "html",
	            //async : false,
	            success: function(res) 
	            {
	                toggleButton(el);               
	                main_content.html(res);
	                nextshowInbox(el);    
	                operationbox(el);
	                App.scrollTo(el, -200);
	                App.initUniform();
	            },
	            error: function(xhr, ajaxOptions, thrownError)
	            {
	                toggleButton(el);
	            },
	            async: false
	        });
        });
    }
	
	
	var huifu = function (el) {
		
		$('.btn-grey').click(function () {
			
			$('#userid').val($(this).find("input").val());
			$('#username').val($(this).parent().find("small").html());
			$('#Toinput').val($(this).parent().find("small").html());
			$('#editor').focus();
		});
		
		$('.deleteBtn').click(function () {
			var timelineid= $('#timelineid').val();
			$.ajax({
    			url : 'action.php', 
    			type : 'post',
    			//async : false,
    			data : { action : 'operation',type: 0,id:timelineid },
    			cache : false,
    			success : function(obj) {
    				if(obj!="")
    				{
	    				var data = eval('(' + obj+ ')');
	    				if(data.Message!=undefined){
	    					alert(data.Message);
	    				}
    				}
    				else
					{
					alert("删除成功");
					}
    				showInbox($(this), 0);
    			},
    			error : function(
    					XMLHttpRequest,
    					textStatus, errorThrown) {
    			}
    		});
		});
		
		$('.btn-hf').click(function () {
        	var editor= $('#editor').val();
        	var timelineid= $('#timelineid').val();
        	console.log(editor);
        	if($('#Toinput').val()!=""){
        		var uid= $('#userid').val();
    			var uname = $('#username').val();
	        	$.ajax({
	    			url : 'action.php', 
	    			type : 'post',
	    			//async : false,
	    			data : { action : 'hftzitem', editor : encodeURI(editor),timelineid:timelineid ,userid:uid,username:uname},
	    			cache : false,
	    			success : function(obj) {
	    				
	    				var data = eval('(' + obj+ ')');
	    				console.log(data);
	    				if(data.Message!=undefined){
	    					alert(data.Message);
	    				}
	    				showSingleEmail($(this), timelineid);
		
	    			},
	    			error : function(
	    					XMLHttpRequest,
	    					textStatus, errorThrown) {
	    			}
	    		});
        	}else{
        		$.ajax({
        			url : 'action.php', 
        			type : 'post',
        			//async : false,
        			data : { action : 'hftz', editor : encodeURI(editor),timelineid:timelineid },
        			cache : false,
        			success : function(obj) {
        				
        				var data = eval('(' + obj+ ')');
        				console.log(data);
        				if(data.Message!=undefined){
        					alert(data.Message);
        				}
        				showSingleEmail($(this), timelineid);
    	
        			},
        			error : function(
        					XMLHttpRequest,
        					textStatus, errorThrown) {
        			}
        		});
        	}
        });
		
		$('.btn-yellow').click(function () {
			var timelineid= $('#timelineid').val();
			var id = $(this).find("input").val();
			$.ajax({
    			url : 'action.php', 
    			type : 'post',
    			//async : false,
    			data : { action : 'report',id:id },
    			cache : false,
    			success : function(obj) {
    				
    				var data = eval('(' + obj+ ')');
    				console.log(data);
    				if(data.Message!=undefined){
    					alert(data.Message);
    				}
    				showSingleEmail($(this), timelineid);
	
    			},
    			error : function(
    					XMLHttpRequest,
    					textStatus, errorThrown) {
    			}
    		});
			
			console.log(); 
			
			
		});
	
			 
	}
	
	/*操作*/
	//TODO 各种操作
	var operationbox = function (el) {
		
		var type= $('#type').val();
		
		//刷新
		$('.isrefresh').click(function () {
			showInbox($(this), type);
			
	    });
		
		//回复
		$('.isreply').click(function () {
			inputchecked(el);
			if(array.length ==1){
				
			showSingleEmail($(this),tid);
			}
	    });
		
		
		// 封号
		$('.isfenghao').click(function () {
			inputchecked(el);
			if(array.length ==1){
        	$.ajax({
    			url : 'action.php', 
    			type : 'post',
    			//async : false,
    			data : { action : 'fenghao',id:uid },
    			cache : false,
    			success : function(obj) {
    				if(obj!="")
    				{
	    				var data = eval('(' + obj+ ')');
	    				if(data.Message!=undefined){
	    					alert(data.Message);
	    				}
    				}
    				else
					{
    					alert("封号成功");
					}
    				showInbox($(this), type);
    			},
    			error : function(
    					XMLHttpRequest,
    					textStatus, errorThrown) {
    			}
    		});
			}
			else
				{
				alert("有且只能选一个哦");
				}
	    });
		
		// 删帖
		$('.isDeleted').click(function () {
			inputchecked(el);
			if(array.length ==1){
			 
        	$.ajax({
    			url : 'action.php', 
    			type : 'post',
    			//async : false,
    			data : { action : 'operation',type: 0,id:tid },
    			cache : false,
    			success : function(obj) {
    				if(obj!="")
    				{
	    				var data = eval('(' + obj+ ')');
	    				if(data.Message!=undefined){
	    					alert(data.Message);
	    				}
    				}
    				else
					{
					alert("删除成功");
					}
    				showInbox($(this), type);
    			},
    			error : function(
    					XMLHttpRequest,
    					textStatus, errorThrown) {
    			}
    		});
			}
			else
				{
				alert("有且只能选一个哦");
				}
	    });
		
		//加精
		$('.isEssential').click(function () {
			inputchecked(el);
			if(array.length ==1){
        	$.ajax({
    			url : 'action.php', 
    			type : 'post',
    			//async : false,
    			data : { action : 'operation',type: 3,id:tid },
    			cache : false,
    			success : function(obj) {
    				console.log(obj);
    				//TODO 
//    				var data = eval('(' + obj+ ')');
//    				if(data.status=="success"){
//    					
//    				}	
    				showInbox($(this), type);
    			},
    			error : function(
    					XMLHttpRequest,
    					textStatus, errorThrown) {
    			}
    		});
			}
			else
				{
				alert("有且只能选一个哦");
				
				}
			
			
	    });
		
		//置顶
		$('.stickType').click(function () {
			inputchecked(el);
			if(array.length ==1){
        	$.ajax({
    			url : 'action.php', 
    			type : 'post',
    			//async : false,
    			data : { action : 'operation',type: 4,id:tid },
    			cache : false,
    			success : function(obj) {
    				console.log(obj);
    				//TODO 
//    				var data = eval('(' + obj+ ')');
//    				if(data.status=="success"){
//    					
//    				}	
    				showInbox($(this), type);
    			},
    			error : function(
    					XMLHttpRequest,
    					textStatus, errorThrown) {
    			}
    		});
			}
			else
				{
				alert("有且只能选一个哦");
				}
	    });
		
		//公告
		$('.isNotice').click(function () {
			inputchecked(el);
			if(array.length ==1){
        	$.ajax({
    			url : 'action.php', 
    			type : 'post',
    			//async : false,
    			data : { action : 'operation',type: 1,id:tid,stickType:type },
    			cache : false,
    			success : function(obj) {
    				//TODO 
//    				var data = eval('(' + obj+ ')');
//    				if(data.status=="success"){
//    					
//    				}	
    				showInbox($(this), type);
    			},
    			error : function(
    					XMLHttpRequest,
    					textStatus, errorThrown) {
    			}
    		});
			}
			else
				{
				alert("有且只能选一个哦");
				
				}
	    });
		
		 

		 
	}
	

	
	var inputchecked = function (el) {
		array=new Array();
		$("[type='checkbox'][name='box']:checked").each(function(){  
			
			array.push($(this).attr('value'));
		});
		var temp = array[0].split("|");
		tid=temp[0];
		uid=temp[1];
	}
	

	/*-----------------------------------------------------------------------------------*/
	/*	新建撰写
	/*-----------------------------------------------------------------------------------*/
    var showCompose = function (el) {
        var url = 'commend_compose.html';       
        main_content.html('');
        toggleButton(el);
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
            success: function(res) 
            {
                toggleButton(el);               
                main_content.html(res);
               
				handleCCBCC();
				
				timeline();
                    
                App.initUniform();
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                toggleButton(el);
            },
            async: false
        });
    }
	/*-----------------------------------------------------------------------------------*/
	/*	Show Compose view
	/*-----------------------------------------------------------------------------------*/
	var handleCCBCC = function () {
        $('.emailCompose .address').on('click', '.emailCC', function () {
            handleCCControl();
        });
        $('.emailCompose .address').on('click', '.emailBCC', function () {
            handleBCCControl();
        });
	}
	
	/*-----------------------------------------------------------------------------------*/
	/*	Show Compose view
	/*-----------------------------------------------------------------------------------*/
    var handleCCControl = function () {
        var the = $('.emailCompose .address .emailCC');
        var input = $('.emailCompose .inputCC');
        the.hide();
        input.show();
        $('.close', input).click(function () {
            input.hide();
            the.show();
        });
    }
    
    
    /* btn-info 发布 */
    var timeline = function () {
    	
    	
    	 
    	$('.btn-info').on('click', function () {
    		
    		var editor = $('#editor').val();
        
        	var header= $('#Iheader').val();
        	var isStock="true";
        	//console.log(editor);
    		if ($.trim(editor).length >0&&$.trim(header).length >0) {
    			if($("#file1").val().length == 0)
    				{
    				 isStock="false";
    				}
	        	$.ajaxFileUpload
	            (
	                {
	                    url: 'canvas0.php', //用于文件上传的服务器端请求地址
	                    secureuri: false, //是否需要安全协议，一般设置为false
	                    type: 'post',
	                    data: { header: header, editor: editor, isStock: isStock },
	                    fileElementId: 'file1', //文件上传域的ID
	                    dataType: 'JSON', //返回值类型 一般设置为json
	                    success: function (data, status){
	                    	data=eval("("+data+")")
	                    	console.log(data);
	                    	console.log(data.Message);
	                    	if(data.Message != undefined)
	                    		{
	                    			alert(data.Message)
	                    		}
	                    	else{
	                    		$('.emailNav > li ').removeClass("active");
	                        	$('.emailNav > li.inbox ').addClass("active");
	                            showInbox($(this), '0');
	                            $('.daohang').html("我的帖子");
	                    	}
	                       
	                    },
	                    error: function (data, status, e)//服务器响应失败处理函数
	                    {
	                        //alert(e);
	                    }
	                }
	            )
       	 	}
    		else{
    			
    			if($("#Iheader").val().length == 0)
				{
    				alert("请输入标题");
    				return ;
				}
    			if($.trim(editor).length == 0)
				{
    				alert("请输入正文");
    				return ;
				}
    			if($("#file1").val().length == 0)
				{
    				alert("请选择配图");
    				return ;
				}
    		}
   				
   	     });
    	
    	$("#txtSearch").on("keyup",function(){
    		
        var inputField = $('#txtSearch');
 	    var suggestText =$('#search_suggest'); 
	    if ($('#txtSearch').val().length > 3) { 
	    	$.ajax({
	    		url : 'action.php', 
    			type : 'post',
    			//async : false,
    			data : { action : 'SecuritiesSearch',txtSearch: inputField.val() },
    			cache : false,
    			dataType: 'JSON',
	            success: function(responseText) 
	            {
    				suggestText.show();
                    suggestText.html('');
    				if(responseText!='')
    					{
	                         console.log(responseText);
	                         json = eval(responseText);  
	                         for(var i=0; i<json.length; i++){
	                        	 	if(i<6)
	                        	 		{
	    				     	    var Text=suggestText.html();
	                                var s='<div class="suggest_link">' +json[i].id +'|'+ json[i].symbol +'</div>';
	                                suggestText.html(Text+s);
	                        	 		}else{
	                        	 			break;	
	                        	 		}
	    					}
    					}
                        else{
                            $("#search_suggest").hide();
                        }
                        suggest_linkControl();
	            },
	            error: function(xhr, ajaxOptions, thrownError)
	            {
	                toggleButton(el);
	            }
	        });
		    }
		else { 
		    	$("#search_suggest").hide();
		}
    });
    }
    
    var suggest_linkControl = function () {
    	
    	$(".suggest_link").on("mouseover",function(e){
    		
    		$(this).attr("class","suggest_link_over")
    	});
    	
    	$(".suggest_link").on("mouseout",function(e){
    		
    		$(this).attr("class","suggest_link")
    	});
    
    	$('.suggest_link').on('click', function (e) {
    		var text=$(this).text();
 		    var v= $('#editor').val();
 		    $('#editor').val(v+text);
    		$("#txtSearch").val("") ;
    		$("#search_suggest").html("");
    		$("#search_suggest").hide();
    	    
        });
    }
    
	/*-----------------------------------------------------------------------------------*/
	/*	Show Compose view
	/*-----------------------------------------------------------------------------------*/
    var handleBCCControl = function () {
        var the = $('.emailCompose .address .emailBCC');
        var input = $('.emailCompose .inputBCC');
        the.hide();
        input.show();
        $('.close', input).click(function () {
            input.hide();
            the.show();
        });
    }

	/*-----------------------------------------------------------------------------------*/
	/*	Toggle button
	/*-----------------------------------------------------------------------------------*/
    var toggleButton = function(el) {
        if (typeof el == 'undefined') {
            return;
        }
        if (el.attr("disabled")) {
            el.attr("disabled", false);
        } else {
            el.attr("disabled", true);
        }
    }

    return {
        init: function () {
			
			/* 我的帖子 */
            $('.emailNav > li.inbox > a').click(function () {
            	$('.emailNav > li ').removeClass("active");
            	$('.emailNav > li.inbox ').addClass("active");
                showInbox($(this), '0');
                $('.daohang').html("我的帖子");
                
            });
            
            /*我的回复 */
            $('.emailNav > li.starred > a').click(function () {
            	$('.emailNav > li ').removeClass("active");
            	$('.emailNav > li.starred ').addClass("active");
                showInbox($(this), '1');
                $('.daohang').html("我的回复");
            });
            
            
           
            /* Show compose screen */
            $('.email .composeBtn').on('click', 'a', function () {
                showCompose($(this));
            });
            

            /* Show email reply screen */
            $('.email').on('click', '.replyBtn', function () {
            	showInbox($(this), 'inbox');
            });

            
            /* Show single email screen */
            $('.emailContent').on('click', '.viewEmail', function () {
            	var temp= $(this).find("[type='hidden']").val().split("|");
            	//console.log(temp);
            	showSingleEmail($(this),temp[0]);
                
            });

            /* Handle CC control links */
            $('.emailCompose .address').on('click', '.emailCC', function () {
                handleCCControl();
            });

            /* Handle BCC control links */
            $('.emailCompose .address').on('click', '.emailBCC', function () {
                handleBCCControl();
            });
			
			/* Show main inbox for the first load */
            
			$('.emailNav > li.inbox > a').click();
			$('.emailNav > li.inbox ').addClass("active");
			
			showheader();
			handleThemeSkins();
			//showindex_menu();
			

        }
    };

}();