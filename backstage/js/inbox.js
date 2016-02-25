var Inbox = function () {

    var main_content = $('.emailContent');
    var container = $('.headercontainer');
    var index_menu = $('.sidebar');
    
    var array= new Array();
    var tid= ''; //当前选中的第一个帖子id
    var uid= ''; //tid的用户id
    var tmp = null; 
	/*-----------------------------------------------------------------------------------*/
	/*	Show single email view
	/*-----------------------------------------------------------------------------------*/
    var showSingleEmail = function (el,id) {
        var url = 'inbox_email.php?id='+ id;
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
                showWYSIWYG();
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

	/*-----------------------------------------------------------------------------------*/
	/*	Show WYSIWYG Editor
	/*-----------------------------------------------------------------------------------*/
    var showWYSIWYG = function () {
		function initToolbarBootstrapBindings() {
		  var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 
				'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
				'Times New Roman', 'Verdana'],
				fontTarget = $('[title=Font]').siblings('.dropdown-menu');
		  $.each(fonts, function (idx, fontName) {
			  fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
		  });
		  $('a[title]').tooltip({container:'body'});
			$('.dropdown-menu input').click(function() {return false;})
				.change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
			.keydown('esc', function () {this.value='';$(this).change();});

		  $('[data-role=magic-overlay]').each(function () { 
			var overlay = $(this), target = $(overlay.data('target')); 
			overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
		  });
		  if ("onwebkitspeechchange"  in document.createElement("input")) {
			var editorOffset = $('#editor').offset();
			$('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editor').innerWidth()-35});
		  } else {
			$('#voiceBtn').hide();
		  }
		};
		function showErrorAlert (reason, detail) {
			var msg='';
			if (reason==='unsupported-file-type') { msg = "Unsupported format " +detail; }
			else {
				console.log("error uploading file", reason, detail);
			}
			$('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>'+ 
			 '<strong>File upload error</strong> '+msg+' </div>').prependTo('#alerts');
		};
		initToolbarBootstrapBindings();  
		$('#editor').wysiwyg({ fileUploadError: showErrorAlert} );
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
        var url = 'inbox_main.php?type='+name;      
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
	        var url = 'inbox_main.php?type='+type+'&maxId='+maxId;      
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
    			data : { action : 'fenghao',id:tid },
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
		
		//取消加精
		$('.NOEssential').click(function () {
			inputchecked(el);
			if(array.length ==1){
        	$.ajax({
    			url : 'action.php', 
    			type : 'post',
    			//async : false,
    			data : { action : 'falseoperation',type: 3,id:tid,stickType:type },
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
		
		//取消置顶
		$('.NOstick').click(function () {
			inputchecked(el);
			if(array.length ==1){
        	$.ajax({
    			url : 'action.php', 
    			type : 'post',
    			//async : false,
    			data : { action : 'falseoperation',type: 4,id:tid,stickType:type },
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
		
		//取消置顶
		$('.report').click(function () {
			inputchecked(el);
			if(array.length ==1){
        	$.ajax({
    			url : 'action.php', 
    			type : 'post',
    			//async : false,
    			data : { action : 'fenghao',id:tid },
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
		
		 
//		 $("[type='checkbox'][name='box']").each(function(){  
//
//				if($(this).is(':checked')){
//				
//					$(this).attr('checked',true).siblings().attr('checked',false);
//				
//					alert($(this).val());
////					 var temp = $(this).attr('value').split("|");
////					 tid=temp[0];
////					 uid=temp[1];
////					 alert(tid);
//				}else{
//				
//					$(this).attr('checked',false).siblings().attr('checked',false);
//				
//				}
//		  	})
		  	
//		  	$(':checkbox[name=box]').each(function(){
//            $(this).click(function(){
//            	//if($(this).attr('checked')){
//                if($(this).is(':checked')){
//                	$(this).attr('checked',false).siblings().attr('checked',false);
//                	//$(this).attr('checked',true).siblings().attr('checked',false);
//                    $(this).attr('checked','checked');
//                    
////                    //$(this).attr('checked',true).siblings().attr('checked',false);
////
////		  			//alert($(this).val());
////                    
////                    if(tmp!=null){
////                        tmp.removeAttr("checked");
////                    }
////                    tmp = $(this);
//
//		  		}
//                else{
//
//		  			//$(this).attr('checked',false).siblings().attr('checked',false);
//
//		  		}
//            });
//        });
		 
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
	/*	编辑
	/*-----------------------------------------------------------------------------------*/
	var showEmailReply = function (el) {
        var url = 'inbox_email_reply.html'; 
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
                handleCCControl();
				handleCCBCC();
                showWYSIWYG();
				$('#editor').html($('#reply-content').html());
				$('#reply-content').hide();                
                App.initUniform();
				$('#editor').focus();
            },
            error: function(xhr, ajaxOptions, thrownError)
            {
                toggleButton(el);
            },
            async: false
        });
    }
	/*-----------------------------------------------------------------------------------*/
	/*	新建撰写
	/*-----------------------------------------------------------------------------------*/
    var showCompose = function (el) {
        var url = 'inbox_compose.html';       
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
                showWYSIWYG();
				handleCCBCC();
				timeline();
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
      
        $('.btn-info').click(function () {
        	var editor= $('#editor').val();
        	var header= $('#Iheader').val();
        	var type= $('#type').val();
        	console.log(editor);
        	
        	if($('#Inputcheck').prop('checked'))
        		{
        		$.ajax({
        			url : 'action.php', 
        			type : 'post',
        			//async : false,
        			data : { action : 'fabuprize', editor : encodeURI(editor),header:header },
        			cache : false,
        			success : function(obj) {
        				console.log(obj);
        				if(obj!="")
        				{
	        				var data = eval('(' + obj+ ')');
	        				if(data.Message!=undefined){
	        					alert(data.Message);
	        				}else
        					{
        					alert("发布成功");
        					}
        				}
        				showInbox($(this), type);	
        			},
        			error : function(
        					XMLHttpRequest,
        					textStatus, errorThrown) {
        			}
        		});
        		}else
        			{
        			$.ajax({
            			url : 'action.php', 
            			type : 'post',
            			//async : false,
            			data : { action : 'fabu', editor : encodeURI(editor),header:header },
            			cache : false,
            			success : function(obj) {
            				console.log(obj);
            				if(obj!="")
            				{
            				
            				var data = eval('(' + obj+ ')');
            				if(data.Message!=undefined){
            					alert(data.Message);
            				}else
            					{
            					alert("发布成功");
            					}
            				}
            				showInbox($(this), type);
            				//TODO 发布成功，跳转到 我的发帖
//            				var data = eval('(' + obj+ ')');
//            				if(data.status=="success"){
//            					
//            				}	
            			},
            			error : function(
            					XMLHttpRequest,
            					textStatus, errorThrown) {
            			}
            		});
        			}
        
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
			
			/* 讨论大厅 */
            $('.emailNav > li.inbox > a').click(function () {
            	$('.emailNav > li ').removeClass("active");
            	$('.emailNav > li.inbox ').addClass("active");
                showInbox($(this), '0');
                $('.daohang').html("讨论大厅");
                
            });
            
            /*新手学堂 */
            $('.emailNav > li.starred > a').click(function () {
            	$('.emailNav > li ').removeClass("active");
            	$('.emailNav > li.starred ').addClass("active");
                showInbox($(this), '1');
                $('.daohang').html("新手学堂");
            });
            
            /*精华帖 */
            $('.emailNav > li.sent > a').click(function () {
            	$('.emailNav > li ').removeClass("active");
            	$('.emailNav > li.sent ').addClass("active");
                showInbox($(this), '2');
                $('.daohang').html("精华帖 ");
            });
            
            /*悬赏贴 */
            $('.emailNav > li.draft > a').click(function () {
            	$('.emailNav > li ').removeClass("active");
            	$('.emailNav > li.draft ').addClass("active");
                showInbox($(this), '3');
                $('.daohang').html("悬赏贴");
            });
           
            
            /*公告*/
            $('.emailNav > li.otice > a').click(function () {
            	$('.emailNav > li ').removeClass("active");
            	$('.emailNav > li.otice ').addClass("active");
                showInbox($(this), '4');
                $('.daohang').html("公告");
            });
            
           
            /* Show compose screen */
            $('.email .composeBtn').on('click', 'a', function () {
                showCompose($(this));
            });
            

            /* Show email reply screen */
            $('.email').on('click', '.replyBtn', function () {
            	showInbox($(this), 'inbox');
            });

            /* Show email reply screen */
//            $('.email').on('click', '.replyBtn', function () {
//                showEmailReply($(this));
//            });
            
            /* Show single email screen */
            $('.emailContent').on('click', '.viewEmail', function () {
            	var temp= $(this).parent().find("[type='checkbox']").val().split("|");
            	
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