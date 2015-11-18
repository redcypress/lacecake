jQuery(document).ready(function($){
	jQuery.fn.javo_favorite = function(o, a){
		var _this = $(this);
		var this_object = this;
		var _t;
		var options = {};
		var param = {};
		var atts = $.extend({
			url:null
			, before: null
			, user: null
			, str_nologin: "Please login"
			, str_save: "Save"
			, str_unsave: "UnSave"
			, str_error: "Server Error!"
			, str_fail: "favorite regist fail."
			, mypage:false
		}, o);
		options.url = atts.url;
		options.type = "post";
		options.dataType = "json";
		options.error = function(e){ alert(atts.str_error); console.log( e.responseText ); };
		options.success = function(d){
			var save_alert = "<div class='javo-save-alert text-center'></div>";
			$("body").append(save_alert);
			$('.javo-save-alert').css({
				position:'fixed'
				, display:'none'
				, top:'50%'
				, left:'50%'
				, marginLeft:'-100px'
				, marginTop:'-50px'
				, width:'200px'
				, height:'100px'
				, opacity:0
				, background:'#000'
				, zIndex:'99999'
				, color:'#fff'
				, lineHeight:'100px'
				, borderRadius:'10px'
			});

			if(d.return == "success"){
				if( _this.hasClass("saved")){
					_this.removeClass("saved");
					_this.text(atts.str_save);
				}else{
					_this.addClass("saved");
					_this.text(atts.str_unsave);
					$('.javo-save-alert')
						.text('Saved')
						.animate({
							display:'inline-block'
							, opacity:0.5
						}, 500, function(){
							var _jt = $(this);
							var nTimeID = setInterval(function(){
								_jt.animate({opacity:0}, 500, function(){
									$(this).remove();
									clearInterval(nTimeID);
								});
						}, 800);
					});
				};

				if( typeof a == 'function' ){
					a.call(this_object);
				}
			}else{
				alert(atts.str_fail);
			};
			_this.removeClass("disabled");
		};
		_this.live("click", function(){

			if( typeof( atts.before ) == 'function'){
				if( atts.before() == false) return false;
			};

			_this = $(this);
			this_object.el = _this;
			if( atts.user == null || atts.user == "" || atts.user < 0){
				alert(atts.str_nologin);
				return false;
			};
			if(_this.hasClass("disabled")) return false;

			_this.addClass("disabled");
			param.post_id = _this.data("post-id");
			param.reg = _this.hasClass("saved") ? null : true;
			param.action = "favorite";
			options.data = param;

			if( atts.url != null ) $.ajax(options);
		});
	}
});