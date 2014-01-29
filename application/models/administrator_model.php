<?php

class Administrator_model extends CI_Model{

	/* Parameters:
		a. $orderBases - Column sorting order
		Description: Returns the query result containing all users
		Return value: Array of information containing the result of the query
	*/
	public function get_all_accounts($orderBasis){
		return $this->db->query("SELECT * FROM users ORDER BY $orderBasis");
	}

	/* Parameters:
		a. $orderBases - Column sorting order
		b. $limit - Limit of the result
		c. $offset - Starting point
		Description: Returns the query result containing all users but limited for pagination
		Return value: Array of information containing the result of the query
	*/
	public function get_all_limited_accounts($orderBasis, $limit, $offset){
		// $this->db->order_by($orderBasis);
		return $this->db->query("SELECT * FROM users ORDER BY $orderBasis ASC LIMIT $limit OFFSET $offset");
	}

	public function getProfile($username){ //returns the profile of the chosen user
		$query=$this->db->query("SELECT * FROM users WHERE username='$username'");
		return $query->result();
	}

	public function user_exists($username){
		$userCount = $this->db->query("SELECT * FROM users WHERE username='$username'")->num_rows();

		return ($userCount == 1 ? true : false);
	}

	//	ZKA MALABUYOC
	public function get_existing_account($uname){
		// selects and returns user info with username = $uname
		//$account = $this->db->query("SELECT * FROM users WHERE username = '$uname'");
		//return $account->result();
		 $q = $this->db->query("SELECT * FROM users WHERE username = '$uname'");
		 foreach ($q->result() as $item){
		 	$data[] = $item;
		 }
		 return $data;
	}

	/* Parameters:
		a. $searchCategory - Column name to be checked
		b. $searchText - User input to be search
		Description: Returns all account information of the matching user/s
		Return value: Array of information containing the result of the query
	*/
	public function get_search_accounts($searchCategory, $searchText){
		if($searchCategory == "username"){
			return $this->db->query("SELECT * FROM users WHERE username='$searchText'");
		}else if($searchCategory == "student_number"){
			return $this->db->query("SELECT * FROM users WHERE student_number='$searchText'");
		}else if($searchCategory == "employee_number"){
			return $this->db->query("SELECT * FROM users WHERE employee_number='$searchText'");
		}else if($searchCategory == "first_name"){
			return $this->db->query("SELECT * FROM users WHERE first_name='$searchText'");
		}else if($searchCategory == "last_name"){
			return $this->db->query("SELECT * FROM users WHERE last_name='$searchText'");
		}
	}

	/* Parameters:
		a. $searchCategory - Column name to be checked
		b. $searchText - User input to be search
		c. $orderBasis - Column basis for sorting
		d. $limit - Result count limit
		e. $offset - Number of items to skip
		Description: Returns limited account information of the matching user/s
		Return value: Array of information containing the result of the query
	*/
	public function get_limited_search_accounts($searchCategory, $searchText, $orderBasis, $limit, $offset){
		$this->db->query("SELECT * FROM users ORDER BY $orderBasis ASC");

		if($searchCategory == "username"){
			return $this->db->query("SELECT * FROM users WHERE username='$searchText' LIMIT $limit OFFSET $offset");
		}else if($searchCategory == "student_number"){
			return $this->db->query("SELECT * FROM users WHERE student_number='$searchText' LIMIT $limit OFFSET $offset");
		}else if($searchCategory == "employee_number"){
			return $this->db->query("SELECT * FROM users WHERE employee_number='$searchText' LIMIT $limit OFFSET $offset");
		}else if($searchCategory == "first_name"){
			return $this->db->query("SELECT * FROM users WHERE first_name='$searchText'");
		}else if($searchCategory == "last_name"){
			return $this->db->query("SELECT * FROM users WHERE last_name='$searchText' LIMIT $limit OFFSET $offset");
		}
	}

	/* Parameters:
		a. $searchCategory - Column name to be checked
		b. $searchText - User input to be search
		c. $orderBasis - Column as basis for sorting
		Description: Returns all account information sorted based on category
		Return value: Array of information containing the result of the query
	*/
	public function get_sorted_search_accounts($searchCategory, $searchText, $orderBasis){
		if($searchCategory == "username"){
			return $this->db->query("SELECT * FROM users WHERE username='$searchText' ORDER BY $orderBasis ASC");
		}else if($searchCategory == "student_number"){
			return $this->db->query("SELECT * FROM users WHERE student_number='$searchText' ORDER BY $orderBasis ASC");
		}else if($searchCategory == "employee_number"){
			return $this->db->query("SELECT * FROM users WHERE employee_number='$searchText' ORDER BY $orderBasis ASC");
		}else if($searchCategory == "first_name"){
			return $this->db->query("SELECT * FROM users WHERE first_name='$searchText' ORDER BY $orderBasis ASC");
		}else if($searchCategory == "last_name"){
			return $this->db->query("SELECT * FROM users WHERE last_name='$searchText' ORDER BY $orderBasis ASC");
		}
	}

	/* Parameters:
		a. $searchCategory - Column name to be checked
		b. $searchText - User input to be search
		c. $orderBasis - Column as basis for sorting
		d. $limit - Limit of the result
		e. $offset - Starting point
		Description: Returns account information based on search text, category sorted based on category but limited for pagination
		Return value: Array of information containing the result of the query
	*/
	public function get_limited_sorted_search_accounts($searchCategory, $searchText, $orderBasis, $limit, $offset){
		$this->db->query("SELECT * FROM users ORDER BY $orderBasis ASC");

		if($searchCategory == "username"){
			return $this->db->query("SELECT * FROM users WHERE username='$searchText' LIMIT $limit OFFSET $offset");
		}else if($searchCategory == "student_number"){
			return $this->db->query("SELECT * FROM users WHERE student_number='$searchText' LIMIT $limit OFFSET $offset");
		}else if($searchCategory == "employee_number"){
			return $this->db->query("SELECT * FROM users WHERE employee_number='$searchText' LIMIT $limit OFFSET $offset");
		}else if($searchCategory == "first_name"){
			return $this->db->query("SELECT * FROM users WHERE first_name='$searchText' LIMIT $limit OFFSET $offset");
		}else if($searchCategory == "last_name"){
			return $this->db->query("SELECT * FROM users WHERE last_name='$searchText' LIMIT $limit OFFSET $offset");
		}
	}

	//Erika C. Kimhoko, January 22,2014, insert data to the database
	public function insert_account( $employee_no , $last_name, $first_name , $middle_name,
			$user_type , $username, $password, $college_address, $email_address ,$contact ){
		
			//check if there is the same username and password and email
			//to ensure no duplicates in username and password to avoid problems in log in
			//email should also be unique to avoid problems in email notifications
			
			$name =  $this->db->query("SELECT username FROM users WHERE username='$username' ");
			$pass =  $this->db->query("SELECT password FROM users WHERE password='$password' ");
			$mail =  $this->db->query("SELECT email_address FROM users WHERE email_address='$email_address' ");
			
			if($name->num_rows() == 0 && $pass->num_rows() == 0 && $mail->num_rows() == 0 ){
				//insert
				$this->db->query("INSERT INTO users 
				(employee_number, last_name, first_name, middle_name, user_type , username, password, college_address, email_address, contact_number) 
				VALUES 
				('$employee_no' , '$last_name', '$first_name' , '$middle_name','$user_type' , '$username', '$password', '$college_address', '$email_address' ,'$contact')");
				return 1;
			}
			else{
				return 0;
				// if there are the same values (email or password or username)
			}
			
			
	}
}

?>