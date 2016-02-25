var Security = function () {

    var main_content = $('.main-content');
    var container = $('.headercontainer');
    var index_menu = $('.sidebar');
    var array= new Array();
    var showindex_menu = function () {
        var url = 'admin_index_menu.php';      
        index_menu.html('');
        $.ajax({
            type: "GET",
            cache: false,
            url: url,
            dataType: "html",
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
	var showInbox = function (el,Securityid,exchange,id) {
		var  url = 'SecurityInfo.php?Securityid='+ Securityid +'&exchange='+ exchange+'&id='+ id ; 

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
                huifu(el);
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
	
	var huifu = function (el) {
		
		$('.btn-grey').click(function () {
			
			$('#userid').val($(this).find("input").val());
			$('#username').val($(this).parent().find("small").html());
			$('#Toinput').val($(this).parent().find("small").html());
			$('#editor').focus();
		});
		
		$('.btn-hf').click(function () {
        	var editor= $('#editor').val();
        	var securityid= $('#securityid').val();
        	var id= $('#id').val();
        	var exchange= $('#exchange').val();

        	if($('#Toinput').val()!=""){
        		var uid= $('#userid').val();
    			var uname = $('#username').val();
	        	$.ajax({
	    			url : 'action.php', 
	    			type : 'post',
	    			//async : false,
	    			data : { action : 'hfgpitem', editor : encodeURI(editor),securityid:id ,userid:uid,username:uname},
	    			cache : false,
	    			success : function(obj) {
	    				
	    				var data = eval('(' + obj+ ')');
	    				console.log(data);
	    				if(data.Message!=undefined){
	    					alert(data.Message);
	    				}
	    				showInbox($(this), securityid,exchange,id);		
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
        			data : { action : 'hfgp', editor : encodeURI(editor),securityid:id },
        			cache : false,
        			success : function(obj) {
        				
        				var data = eval('(' + obj+ ')');
        				console.log(data);
        				if(data.Message!=undefined){
        					alert(data.Message);
        				}
        				showInbox($(this), securityid,exchange,id);		
    	
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
			
            $('#main-content').on('click', '.viewEmail', function () {
            
            	var temp= $(this).parent().find(".idtype").html().split("|");
            	
            	showInbox($(this),temp[0],temp[1],temp[2]);
            	
            	$('.content-title').html($(this).parent().find(".sname").html());
            	
                
            });
            
			/* Show main inbox for the first load */
            
			$('.emailNav > li.inbox > a').click();
			$('.emailNav > li.inbox ').addClass("active");
			//$('#myModal').modal('show');
			showheader();
			
			
        }
    };

}();