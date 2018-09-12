$(function(){
	// 初始化
	$(".left>li:eq(2)>.customer").css("display","none");
	$(".left>li:eq(4)>.adviser").css("display","none");
	// 左边信息的点击
	$(".left>li").click(function(){
			var i=$(this).index();
			var d;
			if(i==2){
				$(".left>li:eq(2)>.customer").css("display","block");
				$(".left>li:eq(2)>a").addClass('on');
				$(".left>li:eq(2) img").attr('src','/css/images/list3-on.png');
				for(var k=0;k<5&&k!=2;k++){
					d=k+1;
					$(".left>li:eq("+k+") img").attr('src','/css/images/list'+d+'.png');
					$(".left>li:eq("+k+")>a").removeClass('on');
				}
			}else if(i==4){
				$(".left>li:eq(4)>.adviser").css("display","block");
				$(".left>li:eq(4)>a").addClass('on');
				$(".left>li:eq(4) img").attr('src','/css/images/list3-on.png');
				for(var k=0;k<5&&k!=4;k++){
					d=k+1;
					$(".left>li:eq("+k+") img").attr('src','/css/images/list'+d+'.png');
					$(".left>li:eq("+k+")>a").removeClass('on');
				}
			}else{
				$(".left>li:eq(2)>.customer").css("display","none");
				$(".left>li:eq(4)>.adviser").css("display","none");
				for(var m=0;m<5;m++){
					d=m+1;
					if(i==m){
						$(".left>li:eq("+m+") img").attr('src','/css/images/list'+d+'-on.png');
						$(".left>li:eq("+m+")>a").addClass('on');
					}else{
						$(".left>li:eq("+m+") img").attr('src','/css/images/list'+d+'.png');
						$(".left>li:eq("+m+")>a").removeClass('on');
					}
				}
			}
		});
	// 客户信息的点击
	$(".left>li:eq(2)>.customer>li").click(function(){
		var c=$(this).index();
		$(".left>li:eq(2)>.customer>li:eq("+c+")>a").addClass('color').parents().siblings().children('a').removeClass('color');
	});
	// 顾问管理的点击
	$(".left>li:eq(4)>.adviser>li").click(function(){
		var c=$(this).index();
		$(".left>li:eq(4)>.adviser>li:eq("+c+")>a").addClass('color').parents().siblings().children('a').removeClass('color');
	});
	// 游客信息操作的点击
	$(".change").click(function(){
		$(this).removeClass('change').addClass('dosomething');
	});
	// 页面内信息的点击
	function GoTo(g){
		$(".right>li:eq("+g+")").css("display","block").siblings().css("display","none");
	}
	// 信息页面
	$(".new").click(function(){
		GoTo(5);
	});
	// 业绩查询函数
	$(".performance").click(function(){
		GoTo(6);
	});
	// 详情
	$(".query .moredetail").click(function(){
		GoTo(7);
	});
	// 添加用户
	$(".right .add").click(function(){
		GoTo(8);
	});
	// 签约客户的备注
	$(".remark").click(function(){
		GoTo(13);
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
		
        
