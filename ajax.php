<?php
ob_start();
date_default_timezone_set("Asia/Manila");
include './db_connect.php';
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}

if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'update_user'){
	$save = $crud->update_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'save_subject'){
	$save = $crud->save_subject();
	if($save)
		echo $save;
}
if($action == 'delete_subject'){
	$save = $crud->delete_subject();
	if($save)
		echo $save;
}
if($action == 'save_class'){
	$save = $crud->save_class();
	if($save)
		echo $save;
}
if($action == 'delete_class'){
	$save = $crud->delete_class();
	if($save)
		echo $save;
}
if($action == 'save_academic'){
	$save = $crud->save_academic();
	if($save)
		echo $save;
}
if($action == 'delete_academic'){
	$save = $crud->delete_academic();
	if($save)
		echo $save;
}
if($action == 'make_default'){
	$save = $crud->make_default();
	if($save)
		echo $save;
}
if($action == 'save_criteria'){
	$save = $crud->save_criteria();
	if($save)
		echo $save;
}
if($action == 'delete_criteria'){
	$save = $crud->delete_criteria();
	if($save)
		echo $save;
}
if($action == 'save_question'){
	$save = $crud->save_question();
	if($save)
		echo $save;
}
if($action == 'delete_question'){
	$save = $crud->delete_question();
	if($save)
		echo $save;
}

if($action == 'save_criteria_question'){
	$save = $crud->save_criteria_question();
	if($save)
		echo $save;
}
if($action == 'save_criteria_order'){
	$save = $crud->save_criteria_order();
	if($save)
		echo $save;
}

if($action == 'save_question_order'){
	$save = $crud->save_question_order();
	if($save)
		echo $save;
}
if($action == 'save_faculty'){
	$save = $crud->save_faculty();
	if($save)
		echo $save;
}
if($action == 'delete_faculty'){
	$save = $crud->delete_faculty();
	if($save)
		echo $save;
}
if($action == 'save_student'){
	$save = $crud->save_student();
	if($save)
		echo $save;
}
if($action == 'delete_student'){
	$save = $crud->delete_student();
	if($save)
		echo $save;
}
if($action == 'save_restriction'){
	$save = $crud->save_restriction();
	if($save)
		echo $save;
}
if($action == 'save_evaluation'){
	$save = $crud->save_evaluation();
	if($save)
		echo $save;
}

if($action == 'get_class'){
	$get = $crud->get_class();
	if($get)
		echo $get;
}
if($action == 'get_report'){
	$get = $crud->get_report();
	if($get)
		echo $get;
}

if (isset($_POST['action']) && $_POST['action'] == 'save_student') {
    $email = $_POST['email'];
    
    // Check if email already exists
    $checkEmail = $conn->query("SELECT * FROM student_list WHERE email = '$email'");
    if ($checkEmail->num_rows > 0) {
        echo 2; // Email already exists
        exit;
    }

    // Hash password
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Prepare the insert statement
    $stmt = $conn->prepare("INSERT INTO student_list (school_id, firstname, lastname, email, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $_POST['school_id'], $_POST['firstname'], $_POST['lastname'], $email, $password);

    // Execute the statement and handle errors
    if ($stmt->execute()) {
        echo 1; // Success
    } else {
        error_log("Error: " . $stmt->error); // Log error
        echo "Error: " . $stmt->error; // Show specific error
    }

    $stmt->close(); // Close the statement
}

// ... (rest of your action handling code)
if ($_GET['action'] == 'save_faculty') {
    $school_id = $_POST['school_id'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $checkEmail = $conn->query("SELECT * FROM faculty_list WHERE email = '$email'");
    if ($checkEmail->num_rows > 0) {
        echo 2; // Email already exists
        exit;
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO faculty_list (school_id, firstname, lastname, email, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $school_id, $firstname, $lastname, $email, $password);

    if ($stmt->execute()) {
        echo 1; // Success
    } else {
        echo "Error: " . $stmt->error; // Show specific error
    }
    $stmt->close();
}
if ($_GET['action'] == 'save_feedback') {
    $lecturer_id = $_POST['lecturer_id'];
    $school_id = $_POST['school_id'];  // Change this from student_id
    $feedback = $_POST['feedback'];

    // Debugging: Log values
    error_log("Lecturer ID: $lecturer_id, School ID: $school_id, Feedback: $feedback");

    // Prepare and execute the insert statement
    $stmt = $conn->prepare("INSERT INTO feedback (lecturer_id, school_id, feedback) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $lecturer_id, $school_id, $feedback);

    try {
        if ($stmt->execute()) {
            echo "Feedback submitted successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }
    } catch (mysqli_sql_exception $e) {
        echo "SQL Error: " . $e->getMessage();
    }
    $stmt->close();
}


ob_end_flush();
?>