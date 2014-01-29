<?php

class Administrator extends CI_Controller{
	public function Administrator(){
		parent::__construct();
		$this->load->model("administrator_model");
	}

	public function index(){
		$data["title"] = "Administrator Home - ICS Library System";
		$this->load->view("administrator_home_view", $data);
	}

	public function view_accounts(){
		$data["title"] = "View Accounts - ICS Library System";
		$this->load->library('pagination');
		
		//Check if the value of hidden input tag is submitted
		$searchText = isset($_POST["hidden_search_text"]) ? $_POST["hidden_search_text"] : '';
		$searchCategory = isset($_POST["hidden_category"]) ? str_replace(" ", "_", $_POST["hidden_category"]) : '';
		$sortCategory = isset($_POST["sort_category"]) ? $_POST["sort_category"] : 'last_name';
		
		$itemsPerPage = 10; //Limit of query output
		$uriSegment = $this->uri->segment(3);
		//Check if the value of uri segment 3 is NULL or less than 0
		$offset = ($uriSegment == NULL || $uriSegment < 0 ? 0 : $uriSegment);

		//Condition if the user specified a search text and category
		if($searchText != '' && $searchCategory != ''){
			$accounts = $this->administrator_model->get_limited_search_accounts($searchCategory, $searchText, $sortCategory, $itemsPerPage, $offset);
			$accountCount = $this->administrator_model->get_search_accounts($searchCategory, $searchText)->num_rows();
		}else{
			$accounts = $this->administrator_model->get_all_limited_accounts($sortCategory, $itemsPerPage, $offset);
			$accountCount = $this->administrator_model->get_all_accounts($sortCategory)->num_rows();
		}

		if($accountCount > 0){
			$data["accounts"] = $accounts->result();
			$data["accountCount"] = $accountCount;
		}else{
			$data["accountCount"] = 0;
		}

		//Initialize pagination if the output count is greater than 10
		if($accountCount > 10){
			$config['base_url'] = base_url().'index.php/administrator/view_accounts';
			$config['per_page'] = $itemsPerPage;
			$config['prev_link'] = '&lt; &lt; Previous';
			$config['next_link'] = 'Next &gt; &gt;';
			$config['total_rows'] = $accountCount;
			$config['num_links'] = ceil($accountCount/$itemsPerPage);

			$this->pagination->initialize($config);
		}

		$data["searchText"] = $searchText;
		$data["searchCategory"] = str_replace("_", " ", $searchCategory);
		$data["sortCategory"] = $sortCategory;

		$this->load->view("view_accounts_view", $data);
	}

	public function search_accounts(){
		$data["title"] = "Search Accounts Result - ICS Library System";
		$this->load->library('pagination');
		
		//Get the user input from the form
		$searchText = $_POST["search_text"];
		$searchCategory = $_POST["category"];
		
		$orderBasis = 'last_name';
		$itemsPerPage = 10; //Limit of query output
		$uriSegment = $this->uri->segment(3);
		//Check if the value of uri segment 3 is NULL or less than 0
		$offset = ($uriSegment == NULL || $uriSegment < 0 ? 0 : $uriSegment);

		$accounts = $this->administrator_model->get_limited_search_accounts($searchCategory, $searchText, $orderBasis, $itemsPerPage, $offset);
		$accountCount = $this->administrator_model->get_search_accounts($searchCategory, $searchText)->num_rows();
		
		if($accountCount > 0){
			$data["accounts"] = $accounts->result();
			$data["accountCount"] = $accountCount;
		}else{
			$data["accountCount"] = 0;
		}

		//Initialize pagination if the output count is greater than 10
		if($accountCount > 10){
			$config['base_url'] = base_url().'index.php/administrator/search_accounts';
			$config['per_page'] = $itemsPerPage;
			$config['prev_link'] = '&lt; &lt; Previous';
			$config['next_link'] = 'Next &gt; &gt;';
			$config['total_rows'] = $accountCount;
			$config['num_links'] = ceil($accountCount/$itemsPerPage);

			$this->pagination->initialize($config);
		}

		$data["searchText"] = $searchText;
		$data["searchCategory"] = str_replace("_", " ", $searchCategory);
		$data["sortCategory"] = $orderBasis;
		
		$this->load->view("view_accounts_view", $data);
	}

	/*public function view_accounts(){
		$data["title"] = "View Accounts - ICS Library System";
		$this->load->view("view_accounts_view", $data);
	}

	public function search_accounts(){
		$searchText = $_POST["search_text"];
		$searchCategory = $_POST["category"];

		$accounts = $this->administrator_model->get_search_accounts($searchCategory, $searchText);
		
		if($accounts->num_rows() > 0){
			$data["accounts"] = $accounts->result();
			$data["accountCount"] = $accounts->num_rows();

			$this->load->library('pagination');
			$config['base_url'] = base_url().'administrator/search_accounts';
			$config['total_rows'] = $accounts->num_rows();
			$config['per_page'] = 10; 

			$this->pagination->initialize($config);
		}else{
			$data["accountCount"] = 0;
		}

		if($searchCategory == 'student_number'){
			$searchCategory = "student number";
		}else if($searchCategory == 'employee_number'){
			$searchCategory = "employee number";
		}else if($searchCategory == 'first_name'){
			$searchCategory = "first name";
		}else if($searchCategory == 'last_name'){
			$searchCategory = "last name";
		}

		$data["searchText"] = $searchText;
		$data["searchCategory"] = $searchCategory;
		$data["title"] = "Search Accounts Result - ICS Library System";
 
		$this->load->view("view_accounts_view", $data);
	}*/

	public function create_account(){				//Erika Kimhoko, January 22,2014 , call this function to invoke  create account function
		$this->load->view("create_account_view");
	}
	
	public function view_user_profile($username){//function for viewing a user profile
		$this->load->model('administrator_model');	//load administrator model
		if($this->administrator_model->user_exists($username)==1){//if user exists(assuming the admin messes up with the url)
			$data['results']=$this->administrator_model->getProfile($username); //creates a data array that accepts the return value of getProfile
																				// function of administrator model
			$this->load->view('user_profile_view',$data); //load the user_profile view
		}
		else{										//if not found/does not exists
			$this->load->view('not_found_view.html');
		}
	}

	//	ZKA MALABUYOC
	public function edit_account(){
		$data["title"]	= "Edit Account - ICS Library System";

		// gets username of account to be edited through the URI
		$uname = $this->uri->segment(3);

		// checks if user exist
		//$this->view_user_profile($uname);

		// PARAMETER: $uname
		// array $account contains result of query when model for edit_account is called
		// (i.e., $account contains all information for user with username $uname)
		$data['account'] = $this->administrator_model->get_existing_account($uname);

		$this->load->view("edit_accounts_view", $data);
		
	}
	
	public function insert_create(){				//Erika Kimhoko, January 22,2014 , this function inserts the values to the database
		$employee_no = $_POST["employee_no"];
		$last_name = $_POST["last_name"];
		$first_name = $_POST["first_name"];
		$middle_name = $_POST["middle_name"];
		$user_type = $_POST["user_type"];
		$username = $_POST["username"];
		$password = $_POST["password"];
		$college_address = $_POST["college_address"];
		$email_address = $_POST["email_address"];
		$contact = $_POST["contact"];
		
		
		//call the method in the model to insert the data
		$accounts = $this->administrator_model->insert_account( $employee_no , $last_name, $first_name , $middle_name,
			$user_type , $username, $password, $college_address, $email_address ,$contact );
			
		//if database already contains the same username or password  or email call the create view again
		if($accounts == 0){
				
			echo '<script> alert("Your username or password or email has already been used. Enter another one") </script>';

			//data to fill the forms automatically except username, password and email
			$data['employee_no'] = $employee_no;
			$data['last_name'] = $last_name;
			$data['first_name'] = $first_name;
			$data['middle_name'] = $middle_name;
			$data['user_type'] = $user_type;
			$data['college_address'] = $college_address;
			$data['contact'] = $contact;
			
			//redirect to fill out username, password, email which has the same values
			$this->load->view("create_account_redirect_view" , $data);
		}
		else{
			echo '<script> alert("You successfully created the account") </script>';
	
			//load the page where the user should be redirected after creating an account
			$this->load->view("administrator_home_view");
		}
		
	}
}

?>