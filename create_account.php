<!DOCTYPE html>
<html lang="en">
<?php 
session_start();
include('./db_connect.php'); 
?>

<head>
    <title>Create Account</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden; /* Prevent scrolling */
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative; /* Position relative for the pseudo-element */
        }

        body:before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('https://technext24.com/wp-content/uploads/2020/05/Nigerian-Unversities-Lecture-room.png') no-repeat center center fixed;
            background-size: cover;
            filter: blur(15px); /* Apply blur effect */
            z-index: -1; /* Place behind the content */
        }

        .account-box {
            position: relative; /* Position relative for the backdrop */
            z-index: 1; /* Ensure it's above the blurred background */
            padding: 30px;
            width: 400px; /* Set a fixed width */
            border-radius: 10px;
            text-align: center;
            background: rgba(255, 255, 255, 0.7); /* Slightly transparent */
        }

        .account-box h2 {
            margin-bottom: 20px;
        }

        .btn-primary {
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            border: none;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #2575fc, #6a11cb);
        }
    </style>
</head>
<body>
    <div class="account-box">
        <h2>Create Account</h2>
        <div id="alert-container"></div> <!-- Notification container -->
        <form action="" id="create-account-form">
            <div class="form-group">
                <label for="role">Create As</label>
                <select name="role" class="form-control" required>
                    <option value="student">Student</option>
                   
                </select>
            </div>
            <div class="form-group">
                <label for="school_id">School ID</label>
                <input type="text" class="form-control" name="school_id" required>
            </div>
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" class="form-control" name="firstname" required>
            </div>
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" class="form-control" name="lastname" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="form-group">
                <label for="class_id">Class</label>
                <select name="class_id" class="form-control" required>
                    <option value="">Select Class</option>
                    <?php
                    $qry = $conn->query("SELECT *, concat(curriculum, ' ', level, '-', section) as class FROM class_list ORDER BY class ASC");
                    while ($row = $qry->fetch_assoc()) {
                        echo "<option value='{$row['id']}'>{$row['class']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Create Account</button>
        </form>
    </div>

    <script>
        $(document).ready(function(){
            $('#create-account-form').submit(function(e){
                e.preventDefault();
                $.ajax({
                    url: 'ajax.php?action=save_student',
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(resp){
                        if(resp == 1){
                            $('#alert-container').html('<div class="alert alert-success">Account created successfully.</div>');
                            setTimeout(function() {
                                location.href = 'index.php?page=home';
                            }, 1500);
                        } else if(resp == 2) {
                            $('#alert-container').html('<div class="alert alert-danger">An account with this email already exists.</div>');
                        } else {
                            $('#alert-container').html('<div class="alert alert-danger">Error creating account: ' + resp + '</div>');
                        }
                    }
                });
            });
        });
    </script>
</body>
</html>
