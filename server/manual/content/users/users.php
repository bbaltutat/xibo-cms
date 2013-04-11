<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<?php include('../../template.php'); ?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title><?php echo PRODUCT_NAME; ?> Documentation</title>
		<link rel=stylesheet type="text/css" href="../../css/doc.css">
		<meta http-equiv="Content-Type" content="text/html" />
		<meta name="keywords" content="digital signage, signage, narrow-casting, <?php echo PRODUCT_NAME; ?>, open source, agpl" />
		<meta name="description" content="<?php echo PRODUCT_NAME; ?> is an open source digital signage solution. It supports all main media types and can be interfaced to other sources of data using CSV, Databases or RSS." />

		<link href="img/favicon.ico" rel="shortcut icon"/>
		<!-- Javascript Libraries -->
		<script type="text/javascript" src="lib/jquery.pack.js"></script>
		<script type="text/javascript" src="lib/jquery.dimensions.pack.js"></script>
		<script type="text/javascript" src="lib/jquery.ifixpng.js"></script>
	</head>
	<body>
		<h1>User Administration</h1>
		<p>This section refers to Users Adminstration from the built in "General" user module. For information on any of the User module plugins refer
		to the appropriate page within this section (an overview of the available user modules can be found 
		<a href="overview.php" title="Overview Page">here</a>).</p>
		
		<h2>User Administration Page</h2>
		<p>The user admin page can be accessed from either the "Users" dashboard button - or the "Administration > Users" nagivation menu button. 
	    An example of the user page is show below.</p>
		
	   	<p><img alt="User Administration Page" src="user_admin_page.png"
	   	style="display: block; text-align: center; margin-left: auto; margin-right: auto"
	   	width="847" height="244"></p>
	   
	    <ul>
			<li>
				<h3>User Name</h3>
				<p>This is the name the user will have to enter to log into <?php echo PRODUCT_NAME; ?>.</p>
			</li>
			<li>
				<h3>Homepage</h3>
				<p>Once a user has successfully entered their user name and password they will be taken to the homepage set here. The homepage
				is automatically generated from the selections on the edit user form.</p>
			</li>
			<li>
				<h3>Email</h3>
				<p>The users email address will be used to send them important information from <?php echo PRODUCT_NAME; ?>. For example if they forget their password.</p>
			</li>
			<li>
				<h3>Add User Button</h3>
				<p>Loads the "Add User" form - the details on the form will need to be entered before a user can be added to <?php echo PRODUCT_NAME; ?>.</p>
			</li>
			<li>
				<h3>Edit / Delete Buttons</h3>
				<p>Opens the edit or delete form respectively. Allows the modification of user details after they have been created.</p>
			</li>
			<li>
				<h3>Page Security Button</h3>
				<p>Define user access right to the various pages on the server.</p>
			</li>
			<li>
				<h3>Menu Security Button</h3>
				<p>Show or hide menu access for the specific user.</p>
			</li>
			<li>
				<h3>Set Homepage Button</h3>
				<p>Set user Homepage to either dashboard or mediamanager.</p>
			</li>
		</ul>

		<a name="Add_User" id="Add_User"></a><h2>Adding Users - The Add Form</h2>
		<p>To add a user click on the "Add User" button found at the top left of the User Administration page. Fill in <strong>all</strong> the 
		fields and click "Save" to add the user.</p>

		<p><img alt="Add User Form" src="user_admin_add.png"
		style="display: block; text-align: center; margin-left: auto; margin-right: auto"
	    width="558" height="328"></p>
     
    	<a name="Edit_User" id="Edit_User"></a><h2>Editing Users - The Edit Form</h2>
		<p>To edit a user click on the "Edit" button on the row belonging to the user for editing. Correct the details on the form as necessary
		and click save to commit those changes.</p>

	  	<p><img alt="Edit User Form" src="user_admin_edit.png"
	   	style="display: block; text-align: center; margin-left: auto; margin-right: auto"
	   	width="559" height="328"></p>
     	
		<a name="Delete_User" id="Delete_User"></a><h2>Deleting Users</h2>
		<p>To delete a user click on the delete button on the row belonging to the unwanted user. A confirm form will be opened up.</p>
		<p><strong>Note:</strong> Deleting a user that has media would create "orphaned" content, playlist and schedule records if that user has
		been active in the system. For this reason any "orphaned" items will be associated with the "<?php echo PRODUCT_NAME; ?>_admin" user created during the install process.</p>
	
		<?php include('../../template/footer.php'); ?>
	</body>
</html>
