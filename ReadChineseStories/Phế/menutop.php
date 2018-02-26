<?php
	session_start();
?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Nguyễn Thanh Hải">

    <title>Truyện tàu online</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-theme.min.css" rel="stylesheet">
    <script src="js/ie-emulation-modes-warning.js"></script>
    <script src="js/ie10-viewport-bug-workaround.js"></script>
	<style type="text/css">
	body{
	margin:70px 20px 20px 70px;
	}
	
	.khungtruyen {
	width:190px;
	height:300px;
	box-shadow:3px 3px 3px 3px #EAEAEA;
	border-radius:10px;
	margin:12px;
	font-weight:bold;
	padding-top:10px;
	font-family:'consolas';
	text-decoration:none;
	}
	.khungtruyen a:link
	{
	text-decoration:none;
	}
	
	.chuong {
	clear:bottom;background-color:#FF9100;padding:3px 7px;border-radius:3px;color:white;font-weight:bold;
	}
	.menuphai
	{
		width:95%;
		height:auto;
		background-color:#F4F4F4;
		border-radius:10px;
	}
	</style>
</head>
<body>
	<div class="navbar navbar-default navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="truyen.php"><img width="150px" height="35px" src="img/Untitled.png"/></a>
        </div>
        <div class="navbar-collapse collapse">
		<ul class="nav navbar-nav">
          <li><a href="truyen.php"><i class="glyphicon glyphicon-home"></i> Trang chủ</a></li>
          <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-book"></i> Danh mục truyện<span class="caret"></span></a>
                  <ul class="dropdown-menu">
					<?php
						include 'connect.php';
						$sql1="SELECT * FROM tbl_theloai";
						$kq1 = mysqli_query($con,$sql1);
						while ($row=mysqli_fetch_array($kq1)){
					?>
					<li><a href='timkiem.php?theloai=<?php echo "$row[ID]"; ?>'><?php echo $row['tentheloai'];?></a></li>
					<?php
						}
					?>
                  </ul>
          </li>
		</ul>
          <div class="navbar-form navbar-right">
			<div class="navbar-collapse collapse" style="float:right">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php  ?><i class="glyphicon glyphicon-user"></i><span class="caret"></span></a>
						<ul class="dropdown-menu">
							<li><a href="dangnhap.php">Đăng nhập</a></li>
							<li><a href="taotk.php">Đăng ký</a></li>
						</ul>
					</li>
				</ul>
			</div>
			<form method="GET" action="timkiem.php" style="float:right">
			<div>
				<input type="text" class="form-control" placeholder="Tìm tên truyện..." name="key"/>
				<button type="submit" name="tk" class="btn btn-search"><i class="glyphicon glyphicon-search"></i></button>
			</div>
			</form>
          </div>
        </div>
      </div>
    </div>
</html>