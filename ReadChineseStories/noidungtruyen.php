<html>
	<head>
		<title>
			<?php
				include 'connect.php';
				$sql = "SELECT tentruyen FROM tbl_danhmuctruyen inner join tbl_theloai on loai=ID WHERE ID_truyen = $_GET[id]";
				$kq = mysqli_query($con,$sql);
				$row = mysqli_fetch_array($kq);
				echo $row[0];
			?>
		</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<script src="js/ie-emulation-modes-warning.js"></script>
		<script src="js/ie10-viewport-bug-workaround.js"></script>
		<link href="css/Style.css" rel="stylesheet" type="text/css">
		<style type="text/css">
		body{
			margin:100px 20px 20px 70px;
		}
		</style>
	</head>
	
	<body>
		<?php
			include 'defaul_tren.php';
		?>

    <div class="container-fluid">
		<div class="row">
			<div class="col-sm-2 col-md-2 sidebar">
				<ul class="nav nav-sidebar"><ul class="nav nav-sidebar">
					<li><a href="truyen.php">Trang chủ</a></li>
					<li><a href="#">Truyện mới nhất</a></li>
					<li><a href="#">Truyện hot nhất</a></li>
					<li><a href="#">Truyện hay nhất</a></li>
					<li><a href="#">Truyện đề cử</a></li>
					<li>----------------------------------</li>
				</ul>
			</div>
			<div class="col-sm-8">
				<?php
					$sql1 = "SELECT ID_truyen,tentruyen,tacgia,luotxem,trangthai,mota,img,ngaydang,tentheloai FROM tbl_danhmuctruyen inner join tbl_theloai on loai=ID WHERE ID_truyen = $_GET[id]";
					$kq1 = mysqli_query($con,$sql1);
					$row1 = mysqli_fetch_array($kq1);
					$sql = "UPDATE tbl_danhmuctruyen SET luotxem=luotxem+1 WHERE ID_truyen = $_GET[id]";
					$kq = mysqli_query($con,$sql);
				?>
				<div>
					<div class="col-sm-3"><img src="<?php echo $row1['img']; ?>" width="160px" height="210px" />
						<p>Tác giả: <?php echo $row1['tacgia']; ?></p> <p>Thể loại: <?php echo $row1['tentheloai']; ?></p> <p>Lượt xem: <?php echo $row1['luotxem']; ?></p> <p>Trạng thái: <?php echo $row1['trangthai']; ?></p>
					</div>
					<div class="col-sm-9">
						<h3 style="text-align:center;"><?php echo $row1['tentruyen']?></h3>
						<p><?php echo $row1['mota'] ?></p>
					</div>
				</div>
				<div style="clear:both;"></div>
				<table border=1 width=100% >
					<caption><h2 style="text-align:center">Danh sách chương</h2></caption>
					<tr>
						<td style="padding:10px">
							<?php
							//Phân trang
								$display =25;
								if ((isset($_GET['page']))&&((int)$_GET['page']))
								{
									$page = $_GET['page'];
								}
								$query="SELECT COUNT(chuong) FROM tbl_noidungtruyen WHERE ID_truyen=$_GET[id]";
								$res=mysqli_query($con,$query) or die ('Could not connection to tbl_noidungtruyen'.mysqli_error($con));
								$row=mysqli_fetch_array($res,MYSQLI_NUM);
								$record=$row[0];
								if($record>$display)
								{
									$page = ceil($record/$display);
								}
								else
								{
									$page=1;
								}
								$start = (isset($_GET['start'])&&(int)$_GET['start']) ? $_GET['start']:0;
								$stt =$_GET['start']*10;
								$idtruyen=$_GET['id'];
								$sql2 = "SELECT tbl_danhmuctruyen.ID_truyen,chuong,tenchuong FROM tbl_noidungtruyen inner join tbl_danhmuctruyen on tbl_danhmuctruyen.ID_truyen = tbl_noidungtruyen.ID_truyen WHERE tbl_danhmuctruyen.ID_truyen = $idtruyen GROUP BY chuong LIMIT $start,$display";
								$kq2 = mysqli_query($con,$sql2);
								$i = $_GET['start'];
								while ($row2=mysqli_fetch_array($kq2)){
									$i =$i+1;
							?>
							<p class="noidungtruyen_tentruyen"><a href='doctruyen.php?id1=<?php echo "$row2[ID_truyen]"; ?>&id2=<?php echo "$row2[chuong]"; ?>'target=_blank><?php echo $i;?>. <?php echo $row2['tenchuong']?></a></p>
								
							<?php
								}
								if($page>=1){
									$next=$start+$display;
									$prev=$start-$display;
									$current=($start/$display)+1;
									if($current!=1)
									{
										echo "<p class='noidungtruyen_phantrang'><a href='noidungtruyen.php?id=$idtruyen&start=$prev'><button>Previous</button></a></p>";
									}
									for($i=1;$i<=$page;$i++)
									{
										echo "<p class='noidungtruyen_phantrang'><a href='noidungtruyen.php?id=$idtruyen&start=".($display*($i-1))."'><button>$i</button></a></p>";
									}
									
									if($current!=$page)
									{
										echo "<p class='noidungtruyen_phantrang'><a href='noidungtruyen.php?id=$idtruyen&start=$next'><button>Next</button></a></p>";
									}
								}
								else{
									echo "<h3>Truyện hiện chưa có chương nào!!!</h3>";
								}
							?>
						</td>
					</tr>
				</table>
			</div>	
			<div class="col-sm-2 sidebar" style="margin-top:300px">
				<ul class="nav nav-sidebar">
					<li><h4>Truyện hay đề cử</h3></li>
					<li><a href="#">Truyện mới nhất</a></li>
					<li><a href="#">Truyện hot nhất</a></li>
					<li><a href="#">Truyện hay nhất</a></li>
					<li><a href="#">Truyện đề cử</a></li>
					<li>----------------------------------</li>
				</ul>
			</div>
		</div>
	<?php
		include "defaul_duoi.php";
	?>