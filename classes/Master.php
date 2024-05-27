<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function delete_img(){
		extract($_POST);
		if(is_file($path)){
			if(unlink($path)){
				$resp['status'] = 'success';
			}else{
				$resp['status'] = 'failed';
				$resp['error'] = 'failed to delete '.$path;
			}
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = 'Unkown '.$path.' path';
		}
		return json_encode($resp);
	}
	function save_category(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `category_list` where `name` = '{$name}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Category Name đã tồn tại.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `category_list` set {$data} ";
		}else{
			$sql = "UPDATE `category_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$bid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "Thêm mới thành công.";
			else
				$resp['msg'] = " Cập nhật thành công.";
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_category(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `category_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Đã xóa thành công.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}

	function save_attribute(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `attributes` where delete_flag=0 AND `name` = '{$name}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Thuộc tính đã tồn tại.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `attributes` set {$data} ";
		}else{
			$sql = "UPDATE `attributes` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$bid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "Đã được lưu thành công.";
			else
				$resp['msg'] = " Đã được cập nhật thành công.";
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_attribute(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `attributes` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Đã xóa thành công.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}

	function save_product(){
		extract($_POST);
		$data = "";
		$priceArr = $_POST['price'];
		// if(isset($_POST['price']) && count($_POST['price']) > 1){
		// 	unset($_POST['price']);
		// }
		if(isset($_POST['attribute_category'])){
			$data .= "`attribute_category`='".json_encode($_POST['attribute_category'])."'";
			unset($_POST['attribute_category']);
		}
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `product_list` where `name` = '{$name}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "Món đã tồn tại.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `product_list` set {$data} ";
		}else{
			$sql = "UPDATE `product_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			// if(count($priceArr) > 1){
			// 	foreach($priceArr as $attr_id => $val){
			// 		if(isset($id)){
			// 			$query = $this->conn->query("SELECT `price` from `product_attributes` where product_id='".$id."' and attribute_id='".$attr_id."' and delete_flag=0");
			// 			if ($query->num_rows > 0) {
			// 				while($check = $query->fetch_assoc()){
			// 					$sqlAttr = "UPDATE `product_attributes` set `price`=$val where `product_id`=".$id." AND attribute_id=$attr_id AND delete_flag=0";
			// 				}
			// 			}else{
			// 				$sqlAttr = "INSERT INTO `product_attributes` set `product_id`=".$id.", attribute_id=$attr_id, `price`=$val";
			// 			}
			// 		}else{
			// 			$pro = $this->conn->query("SELECT id FROM `product_list` where delete_flag=0 order by id desc");
			// 			if ($qry->num_rows > 0) {
			// 				foreach ($pro->fetch_assoc() as $k => $v) {
			// 					$sqlAttr = "INSERT INTO `product_attributes` set `product_id`=".$pro['id'].", attribute_id=$attr_id, `price`=$val";
			// 				}
			// 			}
			// 		}
			// 		$this->conn->query($sqlAttr);
			// 	}
			// }
			$pid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "Đã thêm thành công.";
			else
				$resp['msg'] = " Đã cập nhật thành công.";
			if(!empty($_FILES['img']['tmp_name'])){
				$dir = 'uploads/products/';
				if(!is_dir(base_app.$dir))
				mkdir(base_app.$dir);
				$ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
				$fname = $dir.$pid.".png";
				$accept = array('image/jpeg','image/png');
				if(!in_array($_FILES['img']['type'],$accept)){
					$resp['msg'] .= "Image file type is invalid";
				}
				if($_FILES['img']['type'] == 'image/jpeg')
					$uploadfile = imagecreatefromjpeg($_FILES['img']['tmp_name']);
				elseif($_FILES['img']['type'] == 'image/png')
					$uploadfile = imagecreatefrompng($_FILES['img']['tmp_name']);
				if(!$uploadfile){
					$resp['msg'] .= "Image is invalid";
				}
				list($width, $height) = getimagesize($_FILES['img']['tmp_name']);
				if($width > 640 || $height > 480){
					if($width > $height){
						$perc = ($width - 640) / $width;
						$width = 640;
						$height = $height - ($height * $perc);
					}else{
						$perc = ($height - 480) / $height;
						$height = 480;
						$width = $width - ($width * $perc);
					}
				}
				$temp = imagescale($uploadfile,$width,$height);
				if(is_file(base_app.$fname))
				unlink(base_app.$fname);
				$upload =imagepng($temp,base_app.$fname,6);
				if($upload){
					$this->conn->query("UPDATE `product_list` set image_path = CONCAT('{$fname}', '?v=',unix_timestamp(CURRENT_TIMESTAMP)) where id = '{$pid}' ");
				}
				imagedestroy($temp);
			}
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_product(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `product_list` set `delete_flag` = 1 where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Product successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_sale(){
		if(empty($_POST['id'])){
			$_POST['user_id'] = $this->settings->userdata('id');
			$prefix = date("Ymd");
			$code = sprintf("%'.04d", 1);
			while(true){
				$check = $this->conn->query("SELECT * FROM `sale_list` where code = '{$prefix}{$code}' ")->num_rows;
				if($check > 0){
					$code = sprintf("%'.04d", abs($code) + 1);
				}else{
					$_POST['code'] = $prefix.$code;
					break;
				}
			}
		}
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id')) && !is_array($_POST[$k])){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(isset($_POST['amount']) && isset($_POST['tendered']) && $_POST['amount'] <= $_POST['tendered']){
			$data .= ", `status`=1 ";
		}else{
			$data .= ", `status`=0 ";
		}
		if(empty($id)){
			$data .= ',date_created="'.date('Y-m-d H:i:s').'"';
			$data .= ',date_updated="'.date('Y-m-d H:i:s').'"';
			$sql = "INSERT INTO `sale_list` set {$data} ";
		}else{
			$data .= ',date_updated="'.date('Y-m-d H:i:s').'"';
			$sql = "UPDATE `sale_list` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$sid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['sid'] = $sid;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "Thêm mới thành công.";
			else
				$resp['msg'] = " Cập nhật thành công.";
			if(isset($product_id)){
				$data = "";
				foreach($product_id as $k =>$v){
					if($v){
						$pid = $v;
						$price = $this->conn->real_escape_string($product_price[$k]);
						$qty = $this->conn->real_escape_string($product_qty[$k]);
						$attr_id = $this->conn->real_escape_string($attribute_id[$k]);
						if(!empty($data)) $data .= ", ";
						$data .= "('{$sid}', '{$pid}', '{$qty}', '{$price}', '{$attr_id}')";
					}
				}
				if(!empty($data)){
					$this->conn->query("DELETE FROM `sale_products` where sale_id = '{$sid}'");
					$sql_product = "INSERT INTO `sale_products` (`sale_id`, `product_id`,`qty`, `price`, `attribute_id`) VALUES {$data}";
					$save_products = $this->conn->query($sql_product);
					if(!$save_products){
						$resp['status'] = 'failed';
						$resp['sql'] = $sql_product;
						$resp['error'] = $this->conn->error;
						if(empty($id)){
							$resp['msg'] = "Lỗi lưu thông tin hóa đơn.";
							$this->conn->query("DELETE FROM `sale_products` where sale_id = '{$sid}'");
						}else{
							$resp['msg'] = "Sale Transaction has failed update.";
						}
						return json_encode($resp);
					}
				}
			}
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_sale(){
		extract($_POST);
		$del = $this->conn->query("UPDATE `sale_list` set `deleted_flag` = 1 where id = '{$id}'");
		//$del = $this->conn->query("DELETE FROM `sale_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Sale successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function update_status(){
		extract($_POST);
		$update = $this->conn->query("UPDATE `sale_list` set `status` = '{$status}' where id = '{$id}'");
		if($update){
			$resp['status'] = 'success';
		}else{
			$resp['status'] = 'failed';
			$resp['msg'] = "sale's status has failed to update.";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success', 'sale\'s Status has been updated successfully.');
		return json_encode($resp);
	}
	//promotion_code
	function save_promotion_code(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		// if(isset($_POST['from_date']) && $_POST['from_date']){
		// 	$data .= ", `from_date`='".date('Y-m-d', strtotime($_POST['from_date']))."' ";
		// }
		// if(isset($_POST['to_date']) && $_POST['to_date']){
		// 	$data .= ", `to_date`='".date('Y-m-d', strtotime($_POST['to_date']))."' ";
		// }
		$check = $this->conn->query("SELECT * FROM `promotion_code` where `code` = '{$code}' and delete_flag!=1")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0 && !empty($id)){
			$resp['status'] = 'failed';
			$resp['msg'] = "Code đã tồn tại.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `promotion_code` set {$data} ";
		}else{
			$sql = "UPDATE `promotion_code` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$bid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "Thêm mới thành công.";
			else
				$resp['msg'] = " Cập nhật thành công.";
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_promotion_code(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `sale_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Sale successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	
	//promotion
	function save_promotion(){
		extract($_POST);
		$data = "";
		if(isset($_POST['product_ids']) && $_POST['product_ids']){
			$data .= "`product_ids`='".json_encode($_POST['product_ids'])."'";
			unset($_POST['product_ids']);
		}
		if(isset($_POST['category_apply']) && $_POST['category_apply']){
			if(!empty($data)) $data .=",";
			$data .= "`category_apply`='".json_encode($_POST['category_apply'])."'";
			unset($_POST['category_apply']);
		}
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				if(!empty($data)) $data .=",";
				$v = $this->conn->real_escape_string($v);
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(empty($id)){
			$sql = "INSERT INTO `promotion` set {$data} ";
		}else{
			$sql = "UPDATE `promotion` set {$data} where id = '{$id}' ";
		}
			$save = $this->conn->query($sql);
		if($save){
			$bid = !empty($id) ? $id : $this->conn->insert_id;
			$resp['status'] = 'success';
			if(empty($id))
				$resp['msg'] = "Thêm mới thành công.";
			else
				$resp['msg'] = " Cập nhật thành công.";
			
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		if($resp['status'] == 'success')
			$this->settings->set_flashdata('success',$resp['msg']);
			return json_encode($resp);
	}
	function delete_promotion(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `sale_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success'," Sale successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'delete_img':
		echo $Master->delete_img();
	break;
	case 'save_category':
		echo $Master->save_category();
	break;
	case 'delete_category':
		echo $Master->delete_category();
	break;
	case 'save_attribute':
		echo $Master->save_attribute();
	break;
	case 'delete_attribute':
		echo $Master->delete_attribute();
	break;
	case 'save_product':
		echo $Master->save_product();
	break;
	case 'delete_product':
		echo $Master->delete_product();
	break;
	case 'save_sale':
		echo $Master->save_sale();
	break;
	case 'delete_sale':
		echo $Master->delete_sale();
	break;
	case 'update_status':
		echo $Master->update_status();
	break;
	case 'save_promotion':
		echo $Master->save_promotion();
	break;
	case 'delete_promotion_code':
		echo $Master->delete_promotion_code();
	break;
	case 'save_promotion_code':
		echo $Master->save_promotion_code();
	break;
	case 'delete_promotion':
		echo $Master->delete_promotion();
	break;
	default:
		// echo $sysset->index();
		break;
}