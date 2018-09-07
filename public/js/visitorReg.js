$('button').click(function () {
    $.ajax({
        //几个参数需要注意一下
        type: "POST",//方法类型
        dataType: "json",//预期服务器返回的数据类型
        url: "" ,//url
        data: $('input').serialize(),
        success: function (data) {
            alert("提示："+data.msg);
        }
    });
})