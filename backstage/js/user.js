var User = function () {

    var main_content = $('.emailContent');
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
	var showInbox = function (el, name) {
		var url="";
		if(name=="1")
		{
			url = 'user_main.php?report=0'; 
		}
		else{
			username = $('.form-control').val();
			url = 'user_main.php?search='+username;    
		}    
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
	
	
	
	
	/*操作*/
	var operationbox = function (el) {
		
		$('.isDeleted').click(function () {
			inputchecked(el);
			console.log(array);
	    });
		
		$('.isEssential').click(function () {
			inputchecked(el);
			console.log(array);
	    });
		
		
		
	}
	
	var inputchecked = function (el) {
		array=new Array();
		$("[type='checkbox'][name='box']:checked").each(function(){  
			
			array.push($(this).attr('value'));
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
			
			/* 查询 */
            $('.emailNav > li.inbox > a').click(function () {
            	$('.emailNav > li ').removeClass("active");
            	$('.emailNav > li.inbox ').addClass("active");
                showInbox($(this), '0');
            });
            
            /*黑名单 */
            $('.emailNav > li.starred > a').click(function () {
            	$('.emailNav > li ').removeClass("active");
            	$('.emailNav > li.starred ').addClass("active");
            	$('.form-control').html('');
                showInbox($(this), '1');
            });
            
            
            
            /* Show email reply screen */
            $('.btn-success').on('click', function () {
            	showInbox($(this), $('.form-control').val());
            });

            /* Show email reply screen */
            $('.email').on('click', '.replyBtn', function () {
            	showInbox($(this), 'inbox');
            });

            
			/* Show main inbox for the first load */
            
			$('.emailNav > li.inbox > a').click();
			$('.emailNav > li.inbox ').addClass("active");
			
			showheader();
			//showindex_menu();
			
        }
    };

}();