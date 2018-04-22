<style>
img{
	width: 300px;
	height: auto;
	border-radius: 5px;
}

p.upload-report{
	text-align: center;
	font-size: 14px;
}

p.upload-report.success{
	color: grey;
}

p.upload-report.failed{
	color: red;
}
input[type='submit']{
	background-color: #0d47a1;
	color: #fff;
	padding:5px 20px;
	border:none;
	border-radius:3px;
	box-shadow: 0px 3px 3px rgba(0,0,0,0.1) inset;
	cursor: pointer;
}
</style>
<?php
if(isset($_GET['kyc']) && isset($_GET['id']) && isset($_GET['photo']) && isset($_GET['photo_id'])){ // All these indexes must be set to run the script
	
	$Upload_kyc = $_GET['kyc'];
	$Upload_userId = $_GET['id'];
	$Upload_photo = $_GET['photo'];
	$Upload_photoId = $_GET['photo_id'];
	
		//Set the photo directory
	$photoDir = "../images/KYC/UNKNOWN/";
	if($Upload_kyc == 'individual'){
	$photoDir = '../images/KYC/KYCI/';
	}
	else if($Upload_kyc == 'legal'){
	$photoDir = '../images/KYC/KYCL/';
	}
	$templateDir = '../images/KYC/template/';

			switch ($Upload_photo){//Set the photo templates
				case 'certificate-of-incorporation':
				$photoTemplate = $templateDir.'cerfificate.png';
				break;
				case 'id-front':
				$photoTemplate = $templateDir.'id-doc-front-template.png';
				break;
				case 'id-back':
				$photoTemplate = $templateDir.'id-doc-back-template.png';
				break;
				case 'ultility-bill':
				$photoTemplate = $templateDir.'ultility-bill-template.png';
				break;
				case 'selfie':
				$photoTemplate = $templateDir.'selfie-template.png';
				break;
	}

	
require('../resources/mato/lib/php/global.php');

class PHOTO{
	private $db;
	
	private $user_id;
	private $kyc;
	private $photo;
	private $photoId;
	
	private $column;
	private $table;
	
	function __construct($kyc,$user_id,$photo,$photoId){
		$this->db = new database();
		$this->user_id = $user_id;
		$this->kyc = $kyc;
		$this->photo = $photo;
		$this->photoId = $photoId;
		
		switch ($photo){
				case 'certificate-of-incorporation':
				$this->column = 'cerfificate';
				break;
				case 'id-front':
				$this->column = 'id_photo_front';
				break;
				case 'id-back':
				$this->column = 'id_photo_back';
				break;
				case 'ultility-bill':
				$this->column = 'ultility_bill_photo';
				break;
				case 'selfie':
				$this->column = 'selfie';
				break;
			}
		if($kyc == 'individual'){
			$this->table = 'kyc_individual';
		}
		else if($kyc == 'legal'){
			$this->table = 'kyc_legal';
		}
	}
	public function KYCexistYet(){
		$q = "SELECT user_id FROM ".$this->table." WHERE user_id = ".$this->user_id."";
		if($this->db->query_object($q)->rowCount() == 1){
			return true;
		}
		return false;
	}
	
	public function formatValid($format){

	$allowedFormats = array ('image/jpeg', 'image/JPG','image/X-PNG', 'image/PNG','image/png', 'image/x-png');
		if (in_array($format,$allowedFormats)){
			return true;
		}
		else{
			return false;
		}
	}
	public function getFormat($filetype){
	$format = '.'.substr($filetype,1+strpos($filetype,'/'));
	return $format;
	}
	public function updateDB($photoId){
		$query = "UPDATE ".$this->table." SET ".$this->column." = :photoId WHERE user_id = ".$this->user_id." ";
		$stmt = $this->db->prepare_statement($query);
		$stmt->bindValue(':photoId', $photoId, PDO::PARAM_STR);
		$stmt->execute();
		if($stmt->rowCount() == 1){
			return true;
		}else{
			return false;
		}
	}
	
	public function haltScript(){
		unset($this->db);
		die();
	}
}


//This part is for uploading new avatar
	if(isset($_POST['photo_id']) && isset($_FILES['photo'])){
		//print_r($_FILES);
		$photo = new PHOTO($Upload_kyc,$Upload_userId,$Upload_photo,$Upload_photoId);
		
		if($photo->KYCexistYet()){
		$size = ($_FILES['photo']['size'])/1000000;
		if($_FILES['photo']['type'] != ''){
		$format = $photo->getFormat($_FILES['photo']['type']);
		
		//The function is_upload_image() is in master_script.php
		if($photo->formatValid($_FILES['photo']['type'])){
			$format = $photo->getFormat($_FILES['photo']['type']);
			$finalPhotoURL = $photoDir.$Upload_photoId.$format;
			if (!move_uploaded_file ($_FILES['photo']['tmp_name'],$finalPhotoURL)) {
			//$uploadReport = 'upload unsuccesful try again: '.$_FILES['photo']['error'];
			$uploadReport = 000; //Upload was not successfull
			}
		else{
			$photo->updateDB($Upload_photoId.$format);
			//discard the tmp file
			if(is_file($_FILES['photo']['tmp_name']) && file_exists($_FILES['photo']['tmp_name'])){
				unlink($_FILES['photo']['tmp_name']);
						}
				?>
				<p class="upload-report success">File upload successfull!</p>
				<img src="<?php echo $finalPhotoURL ?>">
				<?php
					$photo->haltScript();
					$uploadReport = 111; // upload was successfull
			}	
		}
		else{
			$uploadReport = 999; //file format not allowed
		}
		}
		else{
			$uploadReport = 222; //no file type
		}			
		}
else{
	$uploadReport = 333; //KYC never existed;
}
	}
	?>
	
	
	<?php if(isset($uploadReport)){
		switch($uploadReport){
			case 000:
			?>
			<p class="upload-report failed"> File failed to upload! </p>
			<?php
			break;
			case 111:
			?>
			<p class="upload-report success"> File upload successfull! </p>
			<?php
			break;
			case 222:
			?>
			<p class="upload-report failed"> No file selected! </p>
			<?php
			break;
			case 333:
			?>
			<p class="upload-report failed"> You need to have submitted some prior information before uploading any file </p>
			<?php
			break;
			case 999:
			?>
			<p class="upload-report failed"> File format <strong>(<?php echo $format ?>)</strong> is not allowed </p>
			<?php
			break;
		}
	}
	?>
<form enctype="multipart/form-data" action="<?php $_PHP_SELF ?>" method="POST" >
	<?php
	if($Upload_photo != 'certificate-of-incorporation'){//don't show any template for certificate of incorporation since there is no template available yet
	?>
	<img src="<?php echo $photoTemplate ?>">
	<?php
	}
	?>
	<input type="file" name="photo" class="form-control" >
	<input type="submit" name="photo_id" value="upload">
</form>

<?php
}
?>