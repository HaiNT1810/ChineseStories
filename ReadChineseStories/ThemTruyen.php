<?php
include "defaul_tren.php";
if(isset($_COOKIE['dangnhap'])){
?>
<form method="POSt" action="ThemTruyen.php">
	<div class="chiatrang_ThemTruyen">
		<h2 style="text-align:center">Trang thêm truyện mới</h2>
		<b>Tên truyện:</b><span class="batbuoc">*</span>
		<input type="text" name="tentruyen" placeholder="Nhập tên truyện" size=50px>
		<p style="float:right;margin-top:20px"><b>Thể loại:</b><span class="batbuoc">*</span>
		<select name="theloai">
			<option value="">--Chọn--</option>
			<?php
				include "connect.php";
				$sql="SELECT ID,tentheloai FROM tbl_theloai";
				$kq =mysqli_query($con,$sql);
				while($r=mysqli_fetch_array($kq)){
			?>
			<option value="<?php echo $r[0]; ?>"><?php echo $r[1]; ?></option>
			<?php
				}
			?> 
		</select>
		<!--<input list="theloai" placeholder="Chọn thể loại"/>
			<datalist id="theloai">
				
					<option value='<1?php echo "$r[tentheloai]";?>'></option>
				
			</datalist>-->
		</p>
		<p style="clear:both"></p>
			<span style="float:left">
				<b>Chọn ảnh:</b>
				<span class="batbuoc">*</span>
				<input type="file" name="file" ID="file" />
			</span>
			<!-- <script type="text/javascript">
				$(document).ready(function (e) {
					$("#uploadimage").on('submit',(function(e) {
						e.preventDefault();
						$.ajax({
							url: "ThemTruyen_uploadanh.php",
							type: "POST",
							data: new FormData(this),
							contentType: false,
							cache: false,
							processData:false,
							success: function(data)
						});
					}));
					$(function() {
							$("#file").change(function() {
							var file = this.files[0];
							var imagefile = file.type;
							var match= ["image/jpeg","image/png","image/jpg"];
							if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2]))){
								$('#previewing').attr('src','noimage.png');
								return false;
							}else{
								var reader = new FileReader();
								reader.onload = imageIsLoaded;
								reader.readAsDataURL(this.files[0]);
							}
						});
					});
					// function imageIsLoaded(e) {
						$("#file").css("color","green");
						$('#image_preview').css("display", "block");
						$('#previewing').attr('src', e.target.result);
						$('#previewing').attr('width', '250px');
						$('#previewing').attr('height', '230px');
					};
				});
			</script>-->
			<!-- <span style="float:right;width:400px">
					<table><tr><td><image name="anhupload" src="noimage.png" width=150px height=200px /></td>
						<td><b>Tên ảnh:</b> < ?php if(isset($_POST['anhupload'])){ echo $_POST['anhupload'];} ?></td>
					</table>
			</span>-->
		<p style="clear:both"></p>
		<p>
			<b>Tác giả:</b>
			<span class="batbuoc">*</span>
			<input type="text" name="tacgia" size=50px>
		</p>
		<p>
			<b>Mô tả:</b>
			<span class="batbuoc">*</span>
			<textarea style="width:100%; height:100px;" name="mota"></textarea>
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
		if(isset($_POST['theloai'])&&$_POST['theloai']!=null){
			$sql="SELECT ID FROM tbl_theloai WHERE tentheloai=N'$_POST[theloai]'";
			$row=mysqli_fetch_array(mysqli_query($con,$sql));
			$theloai=(int)$row[0];
		}else{
			$i++;
			$_error[$i] = "Bạn chưa chọn thể loại truyện";
		}
		if(!isset($_POST['file'])){
			if (!(isset($_POST['file'])&&$_POST['file']!=null)){
				if( $_FILES['file']['name'] != NULL){ 
					if($_FILES['file']['type'] == "image/jpeg" || $_FILES['file']['type'] == "image/png"|| $_FILES['file']['type'] == "image/gif"||$_FILES['file']['type'] == "image/jpg"){
						if($_FILES['file']['size'] > 1048576){
							$_error = $_error."File không được lớn hơn 1mb";
						}else{
							$path = "img/";
							$tmp_name = $_FILES['file']['tmp_name'];
							$name = $_FILES['file']['name'];
							$type = $_FILES['file']['type']; 
							$size = $_FILES['file']['size']; 
							move_uploaded_file($tmp_name,$path.$name);
					   }
					}else{
						$i++;
						$_error[$i] = "Kiểu file không hợp lệ";
					}
				}else{
					$i++;
					$_error[$i] = "Vui lòng chọn file";
				}
			}
		}
		if(isset($_POST['tacgia'])&&$_POST['tacgia']!=null){
			$tacgia=$_POST['tacgia'];
		}else{
			$i++;
			$_error[$i] = "Bạn chưa nhập tác giả";
		}
		if ($_POST['tentruyen']!=null&&$_POST['theloai']!=null&&$_POST['file']!=null&&$_POST['tacgia']!=null&&$_COOKIE['dangnhap']!=null){
			$sql="INSERT INTO tbl_danhmuctruyen (tentruyen, loai, tacgia, nguoidang, trangthai, mota, img, ngaydang) VALUES (N'$tentruyen', $theloai, N'$tacgia', N'".$_COOKIE['dangnhap']."' , N'Còn tiếp', N'".$_POST['mota']."', N'img/".$_POST['file']."', CURRENT_DATE)";
			if (mysqli_query($con,$sql)){
				echo "<script language='javascript' type='text/javascript' >";
				echo "alert('Thêm truyện $tentruyen thành công ^0^');";    
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