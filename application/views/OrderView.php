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
                    <li class="active"><a href="/admin/order/list">订单管理</a></li>
                    <li><a href="/admin/customer/info">客户管理</a></li>
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
                        <th>日期</th>
                        <th>内部订单号</th>
                        <th>支付流水</th>
                        <th>金额</th>
                        <th>客户名称</th>
                        <th>购买服务</th>
                        <th>状态</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!$data) : ?>
                        <tr>
                            <td colspan="7">暂无数据</td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($data as $item):?>
                            <tr>
                                <td><?php echo $item['create_time'];?></td>
                                <td><?php echo $item['order_id'];?></td>
                                <td><?php echo $item['trade_no'];?></td>
                                <td><?php echo $item['total_price'];?></td>
                                <td><?php echo $item['username'];?></td>
                                <td><?php echo $item['goods_name'];?></td>
                                <td><?php if($item['status'] == 1) echo '成功'; else echo '失败';?></td>
                            </tr>
                        <?php endforeach;?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div><!-- /.container -->
</body>
</html>
