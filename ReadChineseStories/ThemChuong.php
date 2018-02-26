<?php
 include "defaul_tren.php";
if(isset($_COOKIE['dangnhap'])&&$_COOKIE['dangnhap']!=''){
?>
<form action="ThemChuong.php" method="POST">
	<div class="chiatrang_ThemTruyen">
		<h2 style="text-align:center">Trang thêm chương truyện</h2>
		<br>
		<p>
			<b>Tên truyện:</b><span class="batbuoc" style="margin-right:25px">*</span>
			<select name="tentruyen">
				<option value="">--Chọn--</option>
				<?php
					$sql="SELECT ID_truyen,tentruyen FROM tbl_danhmuctruyen WHERE nguoidang=N'".$_COOKIE['dangnhap']."'";
					$kq =mysqli_query($con,$sql);
					while($r=mysqli_fetch_array($kq)){
				?>
						<option value="<?php echo $r[0]; ?>"><?php echo $r[1]; ?></option>
					<?php
					}
					?> 
			</select>
		<p>
			<b>Chương số:</b><span class="batbuoc">*</span>
			<input type="number" name="sochuong" size=50px placeholder="Nhập số chương"/> <!--value="<1?php $sql="SELECT MAX(chuong) FROM tbl_noidungtruyen inner join tbl_danhmuctruyen on tbl_noidungtruyen.ID_truyen= tbl_danhmuctruyen.ID_truyen WHERE ID_truyen=(SELECT ID_truyen FROM tbl_danhmuctruyen WHERE tentruyen="..")"; ?>"-->
		</p>
		<p>
			<b>Tên chương:</b><span class="batbuoc">*</span>
			<input type="text" name="tenchuong" size=50px placeholder="Nhập tên chương"/>
		</p>
		<p>
			<p><b>Nội dung:</b><span class="batbuoc">*</span></p>
			<textarea name="noidung" style="width:100%; height:300px;" placeholder="Nhập nội dung truyện tại đây"></textarea>
		</p>
		<p>
			<input type="submit" name="submit_all" value="Đăng truyện" class="buttonsuccess" style="text-align:center">
		</p>
	</div>
	
</form>
<?php
	if(isset($_POST['submit_all'])){
		$i=0;
		$_error[$i]='';
		if(isset($_POST['tentruyen'])&&$_POST['tentruyen']!=null){
			$tentruyen=$_POST['tentruyen'];
		}else{
			$i++;
			$_error[$i] = "Bạn chưa nhập tên truyện";
		}
		if(isset($_POST['sochuong'])&&$_POST['sochuong']!=null){
			$sochuong = $_POST['sochuong'];
		}else{
			$i++;
			$_error[$i] = "Bạn chưa điền số chương";
		}
		if(isset($_POST['tenchuong'])&&$_POST['tenchuong']!=null){
			$tenchuong=$_POST['tenchuong'];
		}else{
			$i++;
			$_error[$i] = "Bạn chưa nhập tên chương";
		}
		if ($_POST['tentruyen']!=null&&$_POST['sochuong']!=null&&$_POST['tenchuong']!=null&&$_COOKIE['dangnhap']!=null){
			$sql="INSERT INTO tbl_noidungtruyen (ID_truyen, chuong, tenchuong, noidung, ngaydang) VALUES ($tentruyen, $sochuong, N'$tenchuong', N'".$_POST['noidung']."', CURRENT_DATE)";
			if (mysqli_query($con,$sql)){
				echo "<script language='javascript' type='text/javascript' >";
				echo "alert('Thêm chương $tenchuong thành công ^0^');";    
				echo "</script>";
			}else{	
				$i++;
				$_error[$i] = "Lỗi khi tạo INSERT truyện $tentruyen:".mysqli_error($con)."<br>";
			}
		}
		if($i!=0){
			echo "<script language='javascript' type='text/javascript' >";
			echo "alert('";
			foreach ($_error as $loi){
				echo $loi.'\n';
			}
			echo"');";    
			echo "</script>";
		}
	}
}
else{ 
	echo "<script language='javascript' type='text/javascript' >";
	echo "alert('Bạn chưa đăng nhập quay lại đăng nhập!!!');";    
	echo "</script>";
}
?>
<?php
 include "defaul_duoi.php";
?>