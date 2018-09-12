$(function(){
	// 初始化
	$(".left>li:eq(2)>.customer").css("display","none");
	for(var n=1;n<12;n++){
			$(".right>li:eq("+n+")").css("display","none");
			}
	var c=0;
	var p=c+3;
	var b;
	// 左边信息的点击
	$(".left>li").click(function(){
			var i=$(this).index();
			var d;
			if(i==2){
				$(".left>li:eq(2)>.customer").css("display","block");
				$(".left>li:eq(2)").addClass('on');
				$(".left>li:eq(2)>img").attr('src','/css/images/list3-on.png');
				for(var k=0;k<4&&k!=2;k++){
					d=k+1;
					$(".left>li:eq("+k+")>img").attr('src','/css/images/list'+d+'.png');
					$(".left>li:eq("+k+")").removeClass('on');
				}
				if(c==0){
					$(".right>li:eq(2)").css("display","block").siblings().css("display","none");
				}else{
					$(".right>li:eq("+p+")").css("display","block").siblings().css("display","none");
				}
			}else{
				$(".left>li:eq(2)>.customer").css("display","none");
				for(var j=0;j<12;j++){
					d=i+1;
					if(j<4){
						if(i==j){
							$(".left>li:eq("+j+")>img").attr('src','/css/images/list'+d+'-on.png');
							$(".left>li:eq("+j+")").addClass('on');
							$(".right>li:eq("+j+")").css("display","block").siblings().css("display","none");
						}else{
							for(var m=0;m<4;m++){
								d=m+1;
								if(i==m){
									$(".left>li:eq("+m+")>img").attr('src','/css/images/list'+d+'-on.png');
									$(".left>li:eq("+m+")").addClass('on');
									$(".right>li:eq("+m+")").css("display","block").siblings().css("display","none");
								}else{
									$(".left>li:eq("+m+")>img").attr('src','/css/images/list'+d+'.png');
									$(".left>li:eq("+m+")").removeClass('on');
								}
							}
						}
					}else{
						$(".right>li:eq("+j+")").css("display","none");
					}
				}
			}
		});
	// 客户信息的点击
	$(".left>li:eq(2)>.customer>li").click(function(){
		c=$(this).index();
		p=c+3;
		if(p==3){
			$(".left>li:eq(2)>.customer>li:eq(0)").addClass('color').siblings().removeClass('color');
			$(".right>li:eq(2)").css("display","block");
		}else{
			console.log(p);
			$(".right>li:eq("+p+")").css("display","block");
			$(".left>li:eq(2)>.customer>li:eq("+c+")").addClass('color').siblings().removeClass('color');
		}
	});
	// 游客信息操作的点击
	$(".change").click(function(){
		$(this).removeClass('change').addClass('dosomething');
	});


	
	// 添加用户
	$(".right .add").click(function(){

	});
	// 业绩查询函数
	// 循环函数
	function round(){
		var m;
		for(var n=0;n<12;n++){
			m=n+1;
			if(n==b){
				$(".right>li:eq(5)").css("display","block");
			}else{
				$(".left>li:eq("+n+")>img").attr('src','/css/images/list'+m+'.png');
				$(".left>li").removeClass('on');
				$(".right>li:eq("+n+")").css("display","none");
			}
		}
	}
	
	function performanceQuery(){

		
	};
	// 数据中心函数

	$(".performance").click(function(){
		performanceQuery();
	});
	// 详情
	$(".query .moredetail").click(function(){
		var m;
		for(var n=0;n<6;n++){
			m=n+1;
			$(".left>li:eq("+n+")>img").attr('src','/css/images/list'+m+'.png');
			$(".left>li").removeClass('on');
			$(".right>li:eq("+n+")").css("display","none");
			$(".right>li:eq(6)").css("display","block");
		}
	});
		// var app = angular.module('myApp', []);
		// app.controller('dataCtrl', function($scope,$http) {
		// 	$scope.data={
		// 		'signingPer':'',
		// 		'focus':'',
		// 		'customer':'',
		// 		'source':''
		// 	}
		// });
});		
		
        
