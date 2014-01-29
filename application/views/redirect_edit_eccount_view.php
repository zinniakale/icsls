<HTML>
	<HEAD>
		<TITLE>ICS Library System | Edit Account</TITLE>
	</HEAD>

	<BODY>
		<H1><B>CHANGES SAVED!</B></H1>

		ID No. <?php $account->id?>
		Employee Number: <?php ($account->employee_number != NULL ? $account->employee_number : "--")?>
		Student Number: <?php ($account->student_number != NULL ? $account->student_number : "--")?>
		Last Name: <?php $account->last_name?>
		First Name: <?php $account->first_name?>
		Middle Name: <?php $account->middle_name?>
		User Type: <?php 
									if($account->user_type == 'A'){
										echo "Administrator";
									}else if($account->user_type == 'L'){
										echo "Librarian";
									}else if($account->user_type == 'F'){
										echo "Faculty";
									}else if($account->user_type == 'S'){
										echo "Student";
									}
								?>
		College Address: <?php $row->collegeaddress?>
		Email Address: <?php $row->email?>
		Contact Number: <?php $row->contact?>
		Borrow Limit: <?php $row->blimit?>
		Waitlist Limit: <?php $row->wlimit?>
		College: <?php $row->college?>
		Degree: <?php $row->degree?>
	</BODY>

<?php $this->load->view('includes/footer')?>
</HTML>