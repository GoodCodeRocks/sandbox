<?php
class Login_Model extends CI_Model{
	function __construct()
	{
		parent::__construct();
		$this->load->driver('session');
		$this->load->library('session');
	}

	/*---------------	Admin login Functions	------------------*/

	public function passwordHash($p)
	{
		$options = [
				'cost' => 12,
				//'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
		];
	
		$pass = password_hash($p,PASSWORD_BCRYPT, $options);
		return $pass;
	}
	
	public function checkLogin($post)
	{
		$sql ="";
		$sql .="select u.username, p.password -- , u.Status
				from users u
				join password p on p.users_id = u.id
				where u.username = '".$post['username']."' ";
		$userInfo = $this->db->query($sql)->result_array();
		
		foreach ($userInfo as $key=> $value) {
			$password = $value['password'];
			$username = $value['UserName'];
			//$status = $value['Status'];
				
		}
		
		if($post['password'] == $password)
		{
			echo "Access Granted!";
			$sql ="";
			$sql .="select u.ID, u.FirstName, u.LastName, ud.departments_ID
					, d.Department_Type_ID, ua.access_ID, u.isAdmin
					from users u
					join users_departments ud on ud.users_ID = u.ID
					join departments d on d.ID = ud.departments_ID
                   	join users_access ua on ua.users_ID = u.ID
					where u.UserName ='".$post['username']."' ";
			$uInfo = $this->db->query($sql)->result_array();
			foreach ($uInfo as $key=> $value) {
				$ID = $value['ID'];
				$FirstName = $value['FirstName'];
				$LastName = $value['LastName'];
				$departments_ID = $value['departments_ID'];
				$Department_Type_ID = $value['Department_Type_ID'];
				$access_ID = $value['access_ID'];
				$isAdmin = $value['isAdmin'];
			}
			//echo $FirstName." ".$LastName." ".$departments_ID." ".$Department_Type_ID."  Access ID: ".$access_ID;
			$_SESSION['department'] = $departments_ID;
			$_SESSION['department_type'] = $Department_Type_ID;
			$_SESSION['user'] = $FirstName." ".$LastName;
			$_SESSION['id'] = $ID;
			$_SESSION['aID'] = $access_ID;
			$_SESSION['isAdmin'] = $isAdmin;
			redirect('dashboard/index/');
		} else 
		{
			redirect('login/index');
		}
	}
	
	public function checkLogin1($post)
	{
		
		$sql ="";
		$sql .="select u.UserName, p.password
				from users u
				join passwords p on p.users_ID = u.ID
				where u.UserName = '".$post['username']."' ";
		$userInfo = $this->db->query($sql)->result_array();
		
		foreach ($userInfo as $key=> $value) {
			$password = $value['password'];
			$username = $value['UserName'];
			
		}
		
		 //echo $password," ". $username;
		 
		/* if(!password_verify($post['password'], $password)){
			error_log('Unsuccessful login attempt('.$post['username'].')');
			

			return false;
		} */
	/* 	echo $password."  ".$post['password']."   ";
		 echo $this->passwordHash($post['password']); */
		if(password_verify($post['password'], $password))
		{
				echo "help";
			$sql ="";
			$sql .="select u.ID, u.FirstName, u.LastName, ud.departments_ID, d.Department_Type_ID
					from users u
					join users_departments ud on ud.users_ID = u.ID
					join departments d on d.ID = u.departments_ID
					where u.UserName ='".$post['username']."' ";
			$uInfo = $this->db->query($sql)->result_array();
			foreach ($uInfo as $key=> $value) {
				$FirstName = $value['FirstName'];
				$LastName = $value['LastName'];
				$departments_ID = $value['departments_ID'];
				$Department_Type_ID = $value['Department_Type_ID'];
					
			}
			
			echo $FirstName." ".$LastName." ".$departments_ID." ".$Department_Type_ID;
		
			//$user['userInfo'] = $uInfo;
		
			$this->session->set_userdata('user',$user);
		
			redirect('requisition/index',$userInfo);
		
		}else
		{
			/* echo error_log('Unsuccessful login attempt('.$post['username'].')'); */
			echo "Invalid Password";
		}
		//unset($userInfo->password);
	return $userInfo;
	}
	
	public function changePassword(){
		$this->db->select('*');
		$this->db->where('users_ID', '183');
		$query = $this->db->get('passwords');
		$userInfo = $query->row();
		$pword='accessGranted';
	
		$msg = array();
	
		if($pword === $userInfo->password)
		{
			/* if($this->passCheck($d['new_password'], $d['passconf']) == TRUE)
				{ */
			$options = [
					'cost' => 12,
					//'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
			];
			$newpassword = $this->passwordHash($pword,PASSWORD_BCRYPT, $options);
			$pass = array(
					'password' => $newpassword,
			);
	
			$this->db->where('users_ID', '183');
			$this->db->update('passwords',$pass);
			$this->db->update('passwords',$pass,array('id'=>$userInfo->id));
			redirect(base_url().'index.php/login/login');

		}
		else {
			echo $this->session->set_flashdata('flash_message', 'Invalid Password!');
			//$msg['exist'] = false;
			redirect(base_url());
	
	
	
		}
	
		//$msg['userInfo'] = $userInfo;
		unset($userInfo->password);
		return $userInfo;
	
	}
}