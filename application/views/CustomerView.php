<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>tigerwell后台</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport"/>
    <meta content="" name="description"/>
    <meta content="" name="author"/>

    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="../../application/public/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="../../application/public/css/temp.css" rel="stylesheet" type="text/css"/>

    <script src="../../application/public/js/jquery.min.js" type="text/javascript"></script>
    <script src="../../application/public/js/bootstrap.min.js" type="text/javascript"></script>
</head>
<body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">Tigerwell后台</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="/admin/order/list">订单管理</a></li>
                    <li class="active"><a href="/admin/customer/info">客户管理</a></li>
                </ul>
                <ul class="nav navbar-nav" style="float: right;">
                    <li><a href="/admin/auth/logout">退出登录</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </nav>

    <div class="container">
        <div class="starter-template">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>客户名称</th>
                    <th>手机号码</th>
                    <th>余额</th>
                    <th>订购服务</th>
                    <th>密码</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!$data) : ?>
                    <tr>
                        <td colspan="6">暂无数据</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($data as $item):?>
                        <tr>
                            <td class="id"><?php echo $item['id'];?></td>
                            <td><?php echo $item['username'];?></td>
                            <td><?php echo $item['phone'];?></td>
                            <td><?php echo $item['balance'];?></td>
                            <td><?php echo $item['goods_name'];?></td>
                            <td><button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#myModal" onclick="getUserId(this)">重置密码</button></td>
                        </tr>
                    <?php endforeach;?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div><!-- /.container -->

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">重置密码</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="exampleInputEmail1">请输入密码</label>
                        <input type="text" class="form-control" id="password" placeholder="请输入密码">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary resetPassword" onclick="resetPassword(this)">重置</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script>
    //获取customer id
    function getUserId(obj)
    {
        var customerId = $(obj).parents("tr").eq(0).children(".id").text();
        $('.resetPassword').attr("customerId",customerId);
    }
    //密码重置
    function resetPassword(obj)
    {
        var customerId = $(obj).attr("customerId");
        var password = $('#password').val();
        $.ajax({
            type: "POST",
            url: "/admin/customer/resetPassword",
            data: 'id='+customerId+'&password='+password,
            success: function(msg){
                var data = $.parseJSON(msg);
//                console.log(data);
                if(data.is_succ === true){
                    location.reload();
                }else{
                    alert('操作失败');
                }
            }
        });
    }
</script>
