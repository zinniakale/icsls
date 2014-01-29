<html>
<head>
	<title>ICS Library System | Edit User Profile</title>
</head>

	<body>
			<form action="<?=base_url().'index.php/administrator/user_profile_view'?>" method='post'>

			<?php 
				foreach ($account as $row){
				}
			?>

				Employee No: <input type='text' name='employee_no' value="hello <?php echo $row->employee_number; ?>"/> <br/>
				Student Number: <input type='text' name='stud_no' value='<?php echo $row->student_number; ?>' /><br/>
				Last name: <input type='text' name='last_name' value='<?php echo $row->last_name; ?>' /><br/>
				First name: <input type='text' name='first_name' value='<?php echo $row->first_name; ?>' /><br/>
				Middle name: <input type='text' name='middle_name' value='<?php echo $row->middle_name; ?>' /><br/>
				User type: <input type='text' name='user_type' value='<?php echo $row->user_type; ?>' /><br/>
				Username: <input type='text' name='username' value= '<?php echo $row->username; ?>' /> <br/>
				Password: <input type='password' name='password' value= '<?php echo $row->password; ?>' /><br/>
				College Address: <input type='text' name='college_address' value='<?php echo $row->college_address; ?>' /><br/>
				Email Address: <input type='email' name='email_address' value='<?php echo $row->email_address;?>' /><br/>
				Contact Number: <input type='text' name='contact' value='<?php echo $row->contact_number; ?>' /><br/>
				Borrow Limit: <?php echo $row->borrow_limit; ?> <br/>
				Waitlist Limit: <?php echo $row->waitlist_limit; ?> <br/>
				College: <input type='text' name='college' value='<?php echo $row->college; ?>' /><br/>
				Degree: <input type='text' name='degree' value='<?php echo $row->degree; ?>' /><br/>

			<input type="submit" name="submit" value="Save Changes"/>
			</form>

		<!--
		Redirects to another view with edited account

		(ie. redirect to "view_profile_view")
		-->
		<!--
			<a href="<?=base_url().'application/views/redirect_edit_eccount_view.php'.$row->username?>"></a>
		-->
			
	</body>
<?=$this->load->view('includes/footer')?>

</html>

<!--
	
	
	
-->