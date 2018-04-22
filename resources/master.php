<?php
require('mato/lib/php/global.php');
require('mato/lib/php/mail/mailer.php');

class Register{
	private $db;
	private $user_details;
	
	 function __construct($input){
		 $this->db = new database();//initiate the database connection
		 $user = $input; //pass the array
		 $user['user_id'] = time() + rand(1000,9999);
		 $user['ref_code'] = $this->getReferalCode();
		 $user['pin'] = $this->getPIN();
		 $user['timestamp'] = time();
		 
		 $this->user_details = $user;
	 }
	 
	 
	 public function addNewUser(){
		 $user = $this->user_details;
		 $register = 999;
		 
		 if($user['password01'] == $user['password02']){
			 if(!$this->emailAlreadyExist()){
				 
			$user['password_hash'] = SHA1($user['password02']);
			 $user['token'] = SHA1(MD5(uniqid()));
			 
		$stmt = $this->db->prepare_statement("INSERT INTO users (user_id,first_name,last_name,email,password,password_hash,token,referal_code,refree,date_registered,timestamp,pin)
							VALUES(:user_id,:f_name,:l_name,:email,:password,:pass_hash,:token,:ref_code,:refree,NOW(),:timestamp,:pin)");
		$stmt->bindValue(':user_id', $user['user_id'], PDO::PARAM_INT);
		$stmt->bindValue(':f_name', $user['first_name'], PDO::PARAM_STR);
		$stmt->bindValue(':l_name', $user['last_name'], PDO::PARAM_STR);
		$stmt->bindValue(':email', $user['email'], PDO::PARAM_STR);
		$stmt->bindValue(':password', $user['password02'], PDO::PARAM_STR);
		$stmt->bindValue(':pass_hash', $user['password_hash'], PDO::PARAM_STR);
		$stmt->bindValue(':token', $user['token'], PDO::PARAM_STR);
		$stmt->bindValue(':ref_code', $user['ref_code'], PDO::PARAM_STR);
		$stmt->bindValue(':refree', $user['refree_code'], PDO::PARAM_STR);
		$stmt->bindValue(':timestamp', $user['timestamp'], PDO::PARAM_INT);
		$stmt->bindValue(':pin', $user['pin'], PDO::PARAM_INT);
		$stmt->execute();
		
		if($stmt->rowCount() == 1){//If data is added to the database, send a verification email
			$regMail = new EMAIL($user['first_name'],$user['email']);
			if($regMail->sendVerification($user['pin'])){
			$register = 000;
			}
		}
		else{
			$register = 101; //couldn't add record to the database
		}
			 }
		 else{
			$register = 102;	 //email already exist
		 }
	}
	else{
			$register = 103; //inconsistent password
	}
	
return $register;
	 }
	 
	 private function getReferalCode(){
		 $referalCode = uniqid('zen');
		 if($this->db->query_object("SELECT user_id FROM users WHERE referal_code = '$referalCode'")->rowCount() > 0){
			 $this->getReferalCode();// if the referal code already exist for a user, run this function again
		 }
		 else{
		return $referalCode; 
		 }
	 }
	 
	 private function getPIN(){
		$pin = rand(100000,999999);
		 if($this->db->query_object("SELECT pin FROM users WHERE pin = $pin")->rowCount() > 0){
			 $this->getPIN();// if the PIN exist for a user, run this function again
		 }
		 else{
		return $pin; 
		 }
	 }
	 
	 private function emailAlreadyExist(){
		 $email = $this->user_details['email'];
		 if($this->db->query_object("SELECT user_id FROM users WHERE email = '$email'")->rowCount() > 0){
			 return true;
		 }
		 else{
			 return false;
		 }
	 }
	 
}



class Login{
	private $db;
	private $credentials;
	
	function __construct($input){
		 $this->db = new database();//initiate the database connection
		 $this->credentials = $input;
	}
	
	public function verify(){
		$loginReport = 999;
		$email = $this->credentials['email'];
		$password = $this->credentials['password'];
		$passwordHash = SHA1($this->credentials['password']);
		$stayLoggedIn = $this->credentials['stay_logged_in'];
		
		$getEmail = $this->db->query_object("SELECT user_id,password,password_hash,token,verification FROM users WHERE (email = '$email')");
		if($getEmail->rowCount() == 1){
			$db_credentials = $getEmail->fetch(PDO::FETCH_ASSOC);
			if($db_credentials['password'] == $password && $db_credentials['password_hash'] == $passwordHash){
				if($db_credentials['verification'] == 1){
				$loginReport = 000;//Login successful
				if($stayLoggedIn == 1){
				setcookie('zen',$db_credentials['token'], time()+(86400 * 30),'/'); // The user token is used to remember returning user, the cookie expires in 30 days if user chooses to remained logged in; 
				}
				else if($stayLoggedIn == 0){
					setcookie('zen',$db_credentials['token'],0,'/'); // log out when browser session ends
				}
			}
			else{
				$loginReport = 100; //account not verified yet
			}
		}
			else{
				$loginReport = 101;// Incorrect password
			}
		}
		else{
			$loginReport = 102; // email does not exist
		}
		
		return $loginReport;
	}
}

class USER{
	public $id;
	public $firstName;
	public $lastName;
	public $fullName;
	public $email;
	public $refCode;
	public $zentToken;
	public $token;
	public $timestamp;
	public $avatar;
	private $passwordHash;
	public $verification;
	public $pin;
	public $KYCcompleted;
	public $referalLink;
	public $referred;
	public $whatsappShareLink;
	public $facebookShareLink;
	public $twitterShareLink;
	public $linkedinShareLink;
	public $googlePlusShareLink;

	private $db;
	function __construct($id){
		 $this->db = new database();//initiate the database connection
		
		$getUser = $this->db->query_object("SELECT * FROM users WHERE user_id = $id");
		if($getUser->rowCount() == 1){
			$user = $getUser->fetch(PDO::FETCH_ASSOC);
			$this->id = $user['user_id'];
			$this->firstName = $user['first_name'];
			$this->lastName = $user['last_name'];
			$this->fullName = $user['first_name'].' '.$user['last_name'];
			$this->email = $user['email'];
			$this->refCode = $user['referal_code'];
			$this->zentToken = $user['zent_token'];
			$this->token = $user['token'];
			$this->pin = $user['pin'];
			$this->timestamp = $user['timestamp'];
			$this->passwordHash = $user['password_hash'];
			$this->verification = $user['verification'];
			$this->referred = $this->db->query_object("SELECT user_id FROM users WHERE refree = '".$this->refCode."'")->rowCount();
			
			$this->referalLink = "https://zenithcard.io/register/?ref=".$this->refCode;
			$this->whatsappShareLink = "whatsapp://send?text=".$this->referalLink;
			$this->facebookShareLink = "https://www.facebook.com/sharer/sharer.php?u=https%3A//zenithcard.io/register/?ref=".$this->refCode;
			$this->twitterShareLink = "https://twitter.com/home?status=Hey%there,%I%20am%20currently%20participating%20in%20the%20the%20ZenithCard%20ICO,%20you%20can%20come%20along%20to,%20join%20with%20this%20link%20https%3A//zenithcard.io/register/?ref=".$this->refCode;
			$this->linkedinShareLink = "https://www.linkedin.com/shareArticle?mini=true&url=https%3A//zenithcard.io/register/?ref=".$this->refCode."&title=ZenithCard%20ICO&summary=&source=";
			$this->googlePlusShareLink = "https://plus.google.com/share?url=https%3A//zenithcard.io/register/?ref=".$this->refCode;
			
			if($user['avatar'] == '' ){
				$this->avatar = 'avatar-default-unisex.png';
			}
			else if(file_exists('../images/avatar/'.$user['avatar'])){//if the file still exist
				$this->avatar = $user['avatar'];
			}
			else{
				$this->avatar = 'avatar-default-unisex.png';
			}
			if($this->db->query_object("SELECT user_id FROM kyc_individual WHERE user_id = ".$this->id."")->rowCount() == 1){
				$this->KYCcompleted = "Individual";
			}
			else if($this->db->query_object("SELECT user_id FROM kyc_legal WHERE user_id = ".$this->id."")->rowCount() == 1){
				$this->KYCcompleted = "Legal Entity";
			}
			else{
				$this->KYCcompleted = "None";
			}
		}
	}
	 
	public function changePassword($oldpassword,$newpassword1,$newpassword2){
	if(SHA1($oldpassword) == $this->passwordHash){
			if($newpassword1 == $newpassword2){
			$id = $this->id;
			$newpasswordHash = SHA1($newpassword2);
			$newToken = SHA1(MD5(uniqid()));
			$q = "UPDATE users SET password = :pass, password_hash = :pass_hash, token=:token WHERE user_id = $id";
			$update= $this->db->prepare_statement($q);
			$update->bindValue(':pass', $newpassword2, PDO::PARAM_STR);
			$update->bindValue(':pass_hash', $newpasswordHash, PDO::PARAM_STR);
			$update->bindValue(':token', $newToken, PDO::PARAM_STR);
			$update->execute();
			if($update->rowCount() == 1){
				$passwordChangingReport = 111;//password changed successfully
				$this->logout();// Log user out immmediately!
			}
			else{
				$passwordChangingReport = 000; //password not changed
				}
			}
			else{
				$passwordChangingReport = 999; //new passwords do not match
			}
		}
		else{
				$passwordChangingReport = 888; //Incorrect old password
		}
		return $passwordChangingReport;
	}
	
	public function logout(){
		setcookie('zen','', time()-(86400 * 30),'/'); // expire the cookie
	}
}

class Avatar{
	private $db;
	private $userId;
	public $avatarId;

	function __construct($userId,$firstName){
		 $this->db = new database();//initiate the database connection
		 $this->avatarId = $firstName.'-'.time();
		 $this->userId = $userId;
	}
	
	public function avatarIsImage($filetype){
		$allowedImageFormats = array ('image/pjpeg','image/jpeg', 'image/JPG','image/X-PNG', 'image/PNG','image/png', 'image/x-png');
		if (in_array($filetype,$allowedImageFormats)){
			return true;
		}
		else{
			return false;
		}
	}
	
	public function updateAvatar($format){
		$avatar = $this->avatarId.$format;
		$userId = $this->userId;
		$u = $this->db->query_object("UPDATE users SET avatar = '$avatar' WHERE user_id = $userId");
		return $u->rowCount();
	}
}

class KYC{
	private $db;
	private $user_id;
	
	function __construct($id){
		$this->user_id = $id;
		$this->db = new database();//initiate the database connection
	}
	
	public function isKYCI(){ //Check if the KYC individual  exist
		if($this->db->query_object("SELECT user_id FROM kyc_individual WHERE user_id = ".$this->user_id."")->rowCount() == 0){
			return false;
		}
		else{
			return true;
		}
	}
		
	public function isKYCL(){ //Check if the KYC individual  exist
		if($this->db->query_object("SELECT user_id FROM kyc_legal WHERE user_id = ".$this->user_id."")->rowCount() == 0){
			return false;
		}
		else{
			return true;
		}
	}
		
}



class myKYCI{
	private $db;
	private $u_id;
	
	public $id;
	public $firstName;
	public $lastName;
	public $email;
	public $phone;
	public $address;
	public $postalCode;
	public $city;
	public $country;
	public $nationality;
	public $dob;
	public $wallet;
	public $_15ETHplus;
	public $idType;
	public $idNumber;
	public $idIssueDate;
	public $idExpireDate;
	public $idPhotoFront;
	public $idPhotoBack;
	public $ultilityBillPhoto;
	public $selfie;
	public $tcp;
	public $ocp;
	
	function __construct($id){
		$this->u_id = $id;
		$this->db = new database();//initiate the database connection
	}
	
		public function getKYCI(){
			$getKYC = $this->db->query_object("SELECT * FROM kyc_individual WHERE user_id = ".$this->u_id."");
			$kyc = $getKYC->fetch(PDO::FETCH_ASSOC);
			$this->id = $kyc['user_id'];
			$this->firstName = $kyc['first_name'];
			$this->lastName = $kyc['last_name'];
			$this->email = $kyc['email'];
			$this->phone = $kyc['mobile_phone'];
			$this->address = $kyc['address'];
			$this->postalCode = $kyc['postal_code'];
			$this->city = $kyc['city'];
			$this->country = $kyc['country'];
			$this->nationality = $kyc['nationality'];
			$this->dob = $kyc['date_of_birth'];
			$this->wallet = $kyc['wallet_address'];
			$this->_15ETHplus = $kyc['contribute_more_than_15ETH'];
			$this->idType = $kyc['id_type'];
			$this->idNumber = $kyc['id_number'];
			$this->idIssueDate = $kyc['id_issue_date'];
			$this->idExpireDate = $kyc['id_expire_date'];
			$this->idPhotoFront = $kyc['id_photo_front'];
			$this->idPhotoBack = $kyc['id_photo_back'];
			$this->ultilityBillPhoto = $kyc['ultility_bill_photo'];
			$this->selfie = $kyc['selfie'];
			$this->tcp = $kyc['transaction_contact_permission'];
			$this->ocp = $kyc['occasional_contact_permission'];
		}
}

class KYCI{
	private $data;
	function __construct($kyc){
		 $this->db = new database();//initiate the database connection
		 $this->data = $kyc;
		 //set values for radio buttons and checkboxes
		 $this->data['_15ETHplus'] = (isset($this->data['contribute_more_than_15ETH']) ? $this->data['contribute_more_than_15ETH'] : '');
		 $this->data['tcp'] = (isset($this->data['transaction_com_permission']) ? $this->data['transaction_com_permission'] : '');
		 $this->data['ocp'] = (isset($this->data['occasional_com_permission']) ? $this->data['occasional_com_permission'] : '');
	}
	
	
		public function KYCexists(){ //Check if the KYC already exist
			if($this->db->query_object("SELECT user_id FROM kyc_individual WHERE user_id = ".$this->data['user_id']."")->rowCount() == 0){
				return false;
			}
			else{
				return true;
			}
		}
		
		public function addKYCIndividual(){
			if(isset($this->data['data_confirmation']) && $this->data['data_confirmation'] == 'Yes'){//If user confirmed data
		/*$query = "INSERT INTO kyc_individual 
				(user_id,first_name,last_name,email,mobile_phone,address,postal_code,city,country,nationality,date_of_birth,wallet_address,contribute_more_than_15ETH,id_type,id_number,id_issue_date,id_expire_date,id_photo_front,id_photo_back,ultility_bill_photo,selfie,transaction_contact_permission,occasional_contact_permission) 
				VALUES
				(:id,:f_name,:l_name,:email, :phone, :address, :poster_code, :city, :country,:nationality,:dob,:wallet,:eth, :id_type, :id_no, :isd, :ied, :ipf,:ipb,:ubp,:sp,:tcp,:ocp )";
		*/
		$query = "INSERT INTO kyc_individual 
				(user_id,first_name,last_name,email,mobile_phone,address,postal_code,city,country,nationality,date_of_birth,wallet_address,contribute_more_than_15ETH,id_type,id_number,id_issue_date,id_expire_date,transaction_contact_permission,occasional_contact_permission) 
				VALUES
				(:id,:f_name,:l_name,:email, :phone, :address, :poster_code, :city, :country,:nationality,:dob,:wallet,:eth, :id_type, :id_no, :isd, :ied,:tcp,:ocp )";
		try{
		$stmt = $this->db->prepare_statement($query);
		
				$stmt->bindValue(':id', $this->data['user_id'], PDO::PARAM_INT);
				$stmt->bindValue(':f_name', $this->data['first_name'], PDO::PARAM_STR);
				$stmt->bindValue(':l_name', $this->data['last_name'], PDO::PARAM_STR);
				$stmt->bindValue(':email', $this->data['email'], PDO::PARAM_STR);
				$stmt->bindValue(':phone', $this->data['phone'], PDO::PARAM_STR);
				$stmt->bindValue(':address', $this->data['address'], PDO::PARAM_STR);
				$stmt->bindValue(':poster_code', $this->data['postal_code'], PDO::PARAM_STR);
				$stmt->bindValue(':city', $this->data['city'], PDO::PARAM_STR);
				$stmt->bindValue(':country', $this->data['country'], PDO::PARAM_STR);
				$stmt->bindValue(':nationality', $this->data['nationality'], PDO::PARAM_STR);
				$stmt->bindValue(':dob', $this->data['dob'], PDO::PARAM_STR);
				$stmt->bindValue(':wallet', $this->data['eth_wallet'], PDO::PARAM_STR);
				$stmt->bindValue(':eth', 	$this->data['_15ETHplus'], PDO::PARAM_STR);
				$stmt->bindValue(':id_type', $this->data['id_type'], PDO::PARAM_STR);
				$stmt->bindValue(':id_no', $this->data['id_doc_no'], PDO::PARAM_STR);
				$stmt->bindValue(':isd', $this->data['id_issue_date'], PDO::PARAM_STR);
				$stmt->bindValue(':ied', $this->data['id_expire_date'], PDO::PARAM_STR);
				
				/*$stmt->bindValue(':ipf', $this->data['id_front_photo_name'], PDO::PARAM_STR);
				$stmt->bindValue(':ipb', $this->data['id_back_photo_name'], PDO::PARAM_STR);
				$stmt->bindValue(':ubp', $this->data['ultility_bill_photo'], PDO::PARAM_STR);
				$stmt->bindValue(':sp', $this->data['selfie_name'], PDO::PARAM_STR); */
				
				$stmt->bindValue(':tcp', $this->data['tcp'], PDO::PARAM_STR);
				$stmt->bindValue(':ocp', $this->data['ocp'], PDO::PARAM_STR);
				
				$stmt->execute();

				if($stmt->rowCount() == 1){
					return 000;
				}
				else{
					return 999;
				}
			}
		catch (PDOException $e) {
					//echo "<script>alert('".$e->getMessage()."')</script>";
			}
			}
			else{
				return 111;
			}
				
	}
	
	public function updateKYCIndividual(){
		$id = $this->data['user_id'];
		
		if(isset($this->data['data_confirmation']) && $this->data['data_confirmation'] == 'Yes'){//If user confirmed data
		/*$query = "UPDATE kyc_individual SET
					first_name = :f_name,
					last_name = :l_name,
					email = :email,
					mobile_phone = :phone,
					address = :address, 
					postal_code = :poster_code,
					city = :city,
					country = :country,
					nationality = :nationality, 
					date_of_birth = :dob,
					wallet_address = :wallet,
					contribute_more_than_15ETH = :eth,
					id_type = :id_type, 
					id_number = :id_no, 
					id_issue_date = :isd, 
					id_expire_date = :ied, 
					id_photo_front = :ipf, 
					id_photo_back = :ipb, 
					ultility_bill_photo = :ubp, 
					selfie = :sp, 
					transaction_contact_permission = :tcp, 
					occasional_contact_permission = :ocp 
					WHERE user_id = $id";
					*/
					
		$query = "UPDATE kyc_individual SET
					first_name = :f_name,
					last_name = :l_name,
					email = :email,
					mobile_phone = :phone,
					address = :address, 
					postal_code = :poster_code,
					city = :city,
					country = :country,
					nationality = :nationality, 
					date_of_birth = :dob,
					wallet_address = :wallet,
					contribute_more_than_15ETH = :eth,
					id_type = :id_type, 
					id_number = :id_no, 
					id_issue_date = :isd, 
					id_expire_date = :ied, 
					transaction_contact_permission = :tcp, 
					occasional_contact_permission = :ocp 
					WHERE user_id = $id";
					

			try{
		$stmt = $this->db->prepare_statement($query);
		
		$stmt->bindValue(':f_name', $this->data['first_name'], PDO::PARAM_STR);
		$stmt->bindValue(':l_name', $this->data['last_name'], PDO::PARAM_STR);
		$stmt->bindValue(':email', $this->data['email'], PDO::PARAM_STR);
		$stmt->bindValue(':phone', $this->data['phone'], PDO::PARAM_STR);
		$stmt->bindValue(':address', $this->data['address'], PDO::PARAM_STR);
		$stmt->bindValue(':poster_code', $this->data['postal_code'], PDO::PARAM_STR);
		$stmt->bindValue(':city', $this->data['city'], PDO::PARAM_STR);
		$stmt->bindValue(':country', $this->data['country'], PDO::PARAM_STR);
		$stmt->bindValue(':nationality', $this->data['nationality'], PDO::PARAM_STR);
		$stmt->bindValue(':dob', $this->data['dob'], PDO::PARAM_STR);
		$stmt->bindValue(':wallet', $this->data['eth_wallet'], PDO::PARAM_STR);
		$stmt->bindValue(':eth', $this->data['_15ETHplus'], PDO::PARAM_STR);
		$stmt->bindValue(':id_type', $this->data['id_type'], PDO::PARAM_STR);
		$stmt->bindValue(':id_no', $this->data['id_doc_no'], PDO::PARAM_STR);
		$stmt->bindValue(':isd', $this->data['id_issue_date'], PDO::PARAM_STR);
		$stmt->bindValue(':ied', $this->data['id_expire_date'], PDO::PARAM_STR);
	
	/*$stmt->bindValue(':ipf', $this->data['id_front_photo_name'], PDO::PARAM_STR);
		$stmt->bindValue(':ipb', $this->data['id_back_photo_name'], PDO::PARAM_STR);
		$stmt->bindValue(':ubp', $this->data['ultility_bill_photo'], PDO::PARAM_STR);
		$stmt->bindValue(':sp', $this->data['selfie_name'], PDO::PARAM_STR); */
		
		$stmt->bindValue(':tcp', $this->data['tcp'], PDO::PARAM_STR);
		$stmt->bindValue(':ocp', $this->data['ocp'], PDO::PARAM_STR);
		
		$stmt->execute();
				if($stmt->rowCount() == 1){
					return 000;
				}
				else{
					return 999;
				}
			}
		catch (PDOException $e) {
					echo "<script>alert('".$e->getMessage()."')</script>";
			}
		}
else{
	return 111;
}	

	}

}
class myKYCL{
	private $db;
	private $u_id;
	
	//Company information
	public $companyName;
	public $companyAddress;
	public $businessAddress;
	public $regNumber;
	public $legalRep;
	public $certificate;
	
	//Rep Information
	public $id;
	public $firstName;
	public $lastName;
	public $email;
	public $phone;
	public $address;
	public $postalCode;
	public $city;
	public $country;
	public $nationality;
	public $dob;
	public $wallet;
	public $_15ETHplus;
	public $idType;
	public $idNumber;
	public $idIssueDate;
	public $idExpireDate;
	public $idPhotoFront;
	public $idPhotoBack;
	public $ultilityBillPhoto;
	public $selfie;
	public $tcp;
	public $ocp;
	
	function __construct($id){
		$this->u_id = $id;
		$this->db = new database();//initiate the database connection
	}
	
		public function getKYCL(){
			$getKYC = $this->db->query_object("SELECT * FROM kyc_legal WHERE user_id = ".$this->u_id."");
			$kyc = $getKYC->fetch(PDO::FETCH_ASSOC);
			//Company Info
			$this->companyName = $kyc['company_name'];
			$this->companyAddress = $kyc['company_address'];
			$this->businessAddress = $kyc['business_address'];
			$this->regNumber = $kyc['registration_number'];
			$this->legalRep = $kyc['representative'];
			$this->certificate = $kyc['certificate'];
			
			//Rep Info
			$this->id = $kyc['user_id'];
			$this->firstName = $kyc['first_name'];
			$this->lastName = $kyc['last_name'];
			$this->email = $kyc['email'];
			$this->phone = $kyc['mobile_phone'];
			$this->address = $kyc['address'];
			$this->postalCode = $kyc['postal_code'];
			$this->city = $kyc['city'];
			$this->country = $kyc['country'];
			$this->nationality = $kyc['nationality'];
			$this->dob = $kyc['date_of_birth'];
			$this->wallet = $kyc['wallet_address'];
			$this->_15ETHplus = $kyc['contribute_more_than_15ETH'];
			$this->idType = $kyc['id_type'];
			$this->idNumber = $kyc['id_number'];
			$this->idIssueDate = $kyc['id_issue_date'];
			$this->idExpireDate = $kyc['id_expire_date'];
			$this->idPhotoFront = $kyc['id_photo_front'];
			$this->idPhotoBack = $kyc['id_photo_back'];
			$this->ultilityBillPhoto = $kyc['ultility_bill_photo'];
			$this->selfie = $kyc['selfie'];
			$this->tcp = $kyc['transaction_contact_permission'];
			$this->ocp = $kyc['occasional_contact_permission'];
		}
}

class KYCL{
	private $data;
	function __construct($kyc){
		 $this->db = new database();//initiate the database connection
		 $this->data = $kyc;
		 //set values for radio buttons and checkboxes
		 $this->data['_15ETHplus'] = (isset($this->data['contribute_more_than_15ETH']) ? $this->data['contribute_more_than_15ETH'] : '');
		 $this->data['tcp'] = (isset($this->data['transaction_com_permission']) ? $this->data['transaction_com_permission'] : '');
		 $this->data['ocp'] = (isset($this->data['occasional_com_permission']) ? $this->data['occasional_com_permission'] : '');
		 
	}
	
		public function KYCexists(){ //Check if the KYC already exist
			if($this->db->query_object("SELECT user_id FROM kyc_legal WHERE user_id = ".$this->data['user_id']."")->rowCount() == 0){
				return false;
			}
			else{
				return true;
			}
		}
		
		public function addKYCLegal(){
			if(isset($this->data['data_confirmation']) && $this->data['data_confirmation'] == 'Yes'){//If user confirmed data
		/*$query = "INSERT INTO kyc_individual 
				(company_name,company_address,business_address,registration_number,representative,certificate,user_id,first_name,last_name,email,mobile_phone,address,postal_code,city,country,nationality,date_of_birth,wallet_address,contribute_more_than_15ETH,id_type,id_number,id_issue_date,id_expire_date,id_photo_front,id_photo_back,ultility_bill_photo,selfie,transaction_contact_permission,occasional_contact_permission) 
				VALUES
				(:c_name,:c_address,:b_address,:reg_num,:rep,:certificate, :id,:f_name,:l_name,:email, :phone, :address, :poster_code, :city, :country,:nationality,:dob,:wallet,:eth, :id_type, :id_no, :isd, :ied, :ipf,:ipb,:ubp,:sp,:tcp,:ocp )";
		*/
		$query = "INSERT INTO kyc_legal 
				(company_name,company_address,business_address,registration_number,representative,user_id,first_name,last_name,email,mobile_phone,address,postal_code,city,country,nationality,date_of_birth,wallet_address,contribute_more_than_15ETH,id_type,id_number,id_issue_date,id_expire_date,transaction_contact_permission,occasional_contact_permission) 
				VALUES
				(:c_name,:c_address,:b_address,:reg_num,:rep, :id,:f_name,:l_name,:email, :phone, :address, :poster_code, :city, :country,:nationality,:dob,:wallet,:eth, :id_type, :id_no, :isd, :ied,:tcp,:ocp )";
		try{
		$stmt = $this->db->prepare_statement($query);
		
				$stmt->bindValue(':c_name', $this->data['company_name'], PDO::PARAM_STR);
				$stmt->bindValue(':c_address', $this->data['company_address'], PDO::PARAM_STR);
				$stmt->bindValue(':b_address', $this->data['business_address'], PDO::PARAM_STR);
				$stmt->bindValue(':reg_num', $this->data['reg_number'], PDO::PARAM_STR);
				$stmt->bindValue(':rep', $this->data['legal_rep'], PDO::PARAM_STR);
				
				//$stmt->bindValue(':certificate','', PDO::PARAM_STR); 

				$stmt->bindValue(':id', $this->data['user_id'], PDO::PARAM_INT);
				$stmt->bindValue(':f_name', $this->data['first_name'], PDO::PARAM_STR);
				$stmt->bindValue(':l_name', $this->data['last_name'], PDO::PARAM_STR);
				$stmt->bindValue(':email', $this->data['email'], PDO::PARAM_STR);
				$stmt->bindValue(':phone', $this->data['phone'], PDO::PARAM_STR);
				$stmt->bindValue(':address', $this->data['address'], PDO::PARAM_STR);
				$stmt->bindValue(':poster_code', $this->data['postal_code'], PDO::PARAM_STR);
				$stmt->bindValue(':city', $this->data['city'], PDO::PARAM_STR);
				$stmt->bindValue(':country', $this->data['country'], PDO::PARAM_STR);
				$stmt->bindValue(':nationality', $this->data['nationality'], PDO::PARAM_STR);
				$stmt->bindValue(':dob', $this->data['dob'], PDO::PARAM_STR);
				$stmt->bindValue(':wallet', $this->data['eth_wallet'], PDO::PARAM_STR);
				$stmt->bindValue(':eth', 	$this->data['_15ETHplus'], PDO::PARAM_STR);
				$stmt->bindValue(':id_type', $this->data['id_type'], PDO::PARAM_STR);
				$stmt->bindValue(':id_no', $this->data['id_doc_no'], PDO::PARAM_STR);
				$stmt->bindValue(':isd', $this->data['id_issue_date'], PDO::PARAM_STR);
				$stmt->bindValue(':ied', $this->data['id_expire_date'], PDO::PARAM_STR);
				
				/*$stmt->bindValue(':ipf', '', PDO::PARAM_STR);
				$stmt->bindValue(':ipb', '', PDO::PARAM_STR);
				$stmt->bindValue(':ubp', '', PDO::PARAM_STR);
				$stmt->bindValue(':sp', '', PDO::PARAM_STR);*/
				
				$stmt->bindValue(':tcp', $this->data['tcp'], PDO::PARAM_STR);
				$stmt->bindValue(':ocp', $this->data['ocp'], PDO::PARAM_STR);
				
				$stmt->execute();

				if($stmt->rowCount() == 1){
					return 000;
				}
				else{
					return 999;
				}
			}
		catch (PDOException $e) {
					echo "<script>alert('".$e->getMessage()."')</script>";
			}
	}
		else{
			return 111;
		}			
	}
	
	public function updateKYCLegal(){
	if(isset($this->data['data_confirmation']) && $this->data['data_confirmation'] == 'Yes'){//If user confirmed data
		$id = $this->data['user_id'];
		
		/*$query = "UPDATE kyc_legal SET
					first_name = :f_name,
					last_name = :l_name,
					email = :email,
					mobile_phone = :phone,
					address = :address, 
					postal_code = :poster_code,
					city = :city,
					country = :country,
					nationality = :nationality, 
					date_of_birth = :dob,
					wallet_address = :wallet,
					contribute_more_than_15ETH = :eth,
					id_type = :id_type, 
					id_number = :id_no, 
					id_issue_date = :isd, 
					id_expire_date = :ied, 
					id_photo_front = :ipf, 
					id_photo_back = :ipb, 
					ultility_bill_photo = :ubp, 
					selfie = :sp, 
					transaction_contact_permission = :tcp, 
					occasional_contact_permission = :ocp 
					WHERE user_id = $id";*/
					
		$query = "UPDATE kyc_legal SET
					company_name = :c_name,
					company_address = :c_address,
					business_address = :b_address,
					registration_number = :reg_num,
					representative = :rep,
					
					first_name = :f_name,
					last_name = :l_name,
					email = :email,
					mobile_phone = :phone,
					address = :address, 
					postal_code = :poster_code,
					city = :city,
					country = :country,
					nationality = :nationality, 
					date_of_birth = :dob,
					wallet_address = :wallet,
					contribute_more_than_15ETH = :eth,
					id_type = :id_type, 
					id_number = :id_no, 
					id_issue_date = :isd, 
					id_expire_date = :ied, 
					transaction_contact_permission = :tcp, 
					occasional_contact_permission = :ocp 
					WHERE user_id = $id";

			try{
		$stmt = $this->db->prepare_statement($query);
		
		$stmt->bindValue(':c_name', $this->data['company_name'], PDO::PARAM_STR);
		$stmt->bindValue(':c_address', $this->data['company_address'], PDO::PARAM_STR);
		$stmt->bindValue(':b_address', $this->data['business_address'], PDO::PARAM_STR);
		$stmt->bindValue(':reg_num', $this->data['reg_number'], PDO::PARAM_STR);
		$stmt->bindValue(':rep', $this->data['legal_rep'], PDO::PARAM_STR);
		
		//$stmt->bindValue(':certificate','', PDO::PARAM_STR); 

		$stmt->bindValue(':f_name', $this->data['first_name'], PDO::PARAM_STR);
		$stmt->bindValue(':l_name', $this->data['last_name'], PDO::PARAM_STR);
		$stmt->bindValue(':email', $this->data['email'], PDO::PARAM_STR);
		$stmt->bindValue(':phone', $this->data['phone'], PDO::PARAM_STR);
		$stmt->bindValue(':address', $this->data['address'], PDO::PARAM_STR);
		$stmt->bindValue(':poster_code', $this->data['postal_code'], PDO::PARAM_STR);
		$stmt->bindValue(':city', $this->data['city'], PDO::PARAM_STR);
		$stmt->bindValue(':country', $this->data['country'], PDO::PARAM_STR);
		$stmt->bindValue(':nationality', $this->data['nationality'], PDO::PARAM_STR);
		$stmt->bindValue(':dob', $this->data['dob'], PDO::PARAM_STR);
		$stmt->bindValue(':wallet', $this->data['eth_wallet'], PDO::PARAM_STR);
		$stmt->bindValue(':eth', $this->data['_15ETHplus'], PDO::PARAM_STR);
		$stmt->bindValue(':id_type', $this->data['id_type'], PDO::PARAM_STR);
		$stmt->bindValue(':id_no', $this->data['id_doc_no'], PDO::PARAM_STR);
		$stmt->bindValue(':isd', $this->data['id_issue_date'], PDO::PARAM_STR);
		$stmt->bindValue(':ied', $this->data['id_expire_date'], PDO::PARAM_STR);
		
		/*$stmt->bindValue(':ipf', $this->data['id_front_photo_name'], PDO::PARAM_STR);
		$stmt->bindValue(':ipb', $this->data['id_back_photo_name'], PDO::PARAM_STR);
		$stmt->bindValue(':ubp', $this->data['ultility_bill_photo'], PDO::PARAM_STR);
		$stmt->bindValue(':sp', $this->data['selfie_name'], PDO::PARAM_STR); */
		
		$stmt->bindValue(':tcp', $this->data['tcp'], PDO::PARAM_STR);
		$stmt->bindValue(':ocp', $this->data['ocp'], PDO::PARAM_STR);
		
		$stmt->execute();
					
				if($stmt->rowCount() == 1){
					return 000;
				}
				else{
					return 999;
				}
			}
		catch (PDOException $e) {
					//echo "<script>alert('".$e->getMessage()."')</script>";
			}
		}	
		else{
		return 111;
		}
	}

}

class ZENT{
	static $referalBonus = 100;
	private $siteRoot = "https://zenithcard.io";
	function __construct(){
		$this->db = new database();
	}
	
	public function creditZent($amount,$userId,$r){// This function credit an account with ZENT
		$credit = false;
		switch($r){
			case 1:
			$reason = "<br/><br/><p>A user used your referal code to register a <strong>verified</strong> ZenithCard account, we are so proud of you, keep sharing your referal link and get more ZENT.</p>";
			break;
			case 2:
			$reason = "Reason 2 for adding $amount ZENT";
			default:
			$reason = "";
			break;
		}
		
	$getUser = $this->db->query_object("SELECT user_id,first_name,email,zent_token FROM users WHERE user_id = $userId");
	if($getUser->rowCount() == 1){//Confirm recipient existence
		$r = $getUser->fetch(PDO::FETCH_ASSOC);
		$id = $r['user_id'];
		$name = $r['first_name'];
		$email = $r['email'];
		$prevZent = $r['zent_token'];
		$newZent = $prevZent + $amount;
		
		if($this->db->query_object("UPDATE users SET zent_token = $newZent WHERE user_id = $id ")->rowCount() == 1){
			$mail = new EMAIL($name,$email); //Initaite an email to be sent to the ZENT recipient
			$notificationSubject = $amount." ZENT Added to your ZenithCard Account";
			$notificationBody = "<div style=\"padding: 0px 10px\">
									Congratulations $name, your ZenithCard account has been credited with $amount ZENT $reason
								</div>";
			$mail->sendNotification($notificationSubject,$notificationBody);
			$credit = true;
		}
	}
	return $credit;
}	


}
class emptyKYC{
	//Company information
	public $companyName;
	public $companyAddress;
	public $businessAddress;
	public $regNumber;
	public $legalRep;
	public $certificate;
	
	//Rep Information
	public $id;
	public $firstName;
	public $lastName;
	public $email;
	public $phone;
	public $address;
	public $postalCode;
	public $city;
	public $country;
	public $nationality;
	public $dob;
	public $wallet;
	public $_15ETHplus;
	public $idType;
	public $idNumber;
	public $idIssueDate;
	public $idExpireDate;
	public $idPhotoFront;
	public $idPhotoBack;
	public $ultilityBillPhoto;
	public $selfie;
	public $tcp;
	public $ocp;
	}


class Verification{
	private $db;
	function __construct(){
		 $this->db = new database();//initiate the database connection
	}
	//This is to verify if a user is logged on every page, it uses the COOKIE that was set at loggin to verify the user
	public function verifyUser(){
		$userStatus = 0;
		if(isset($_COOKIE['zen'])){
			$token = $_COOKIE['zen'];
			$checkUserToken = $this->db->query_object("SELECT user_id FROM users WHERE token = '$token'");
			if($checkUserToken->rowCount() == 1){
				$u = $checkUserToken->fetch(PDO::FETCH_ASSOC); //return the user id
				$userStatus = $u['user_id'];
			}
		}
		return $userStatus;
	}
}

$verify = new Verification();
$status = $verify->verifyUser();
//echo $status;
if($status == 0){
		$user = null;
}
else{
	$user = new USER($status); //Create an object for the user logged in
	if($user->verification == 0){ //log out all user that are currently logged in and have not verified their email
		$user->logout();
	}
}
$tool = new Tool(); //initialize the tool class for all scripts