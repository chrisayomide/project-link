<?php
// Fetch all feedbacks
$result = $conn->query("SELECT f.id, f.feedback, f.created_at, 
    CONCAT(s.firstname, ' ', s.lastname) AS student_name, 
    CONCAT(l.firstname, ' ', l.lastname) AS lecturer_name 
    FROM feedback f 
    JOIN student_list s ON f.student_id = s.id 
    JOIN faculty_list l ON f.lecturer_id = l.id 
    ORDER BY f.created_at DESC");
?>

<h2>Feedback List</h2>
<table>
    <thead>
        <tr>
            <th>Feedback ID</th>
            <th>Student Name</th>
            <th>Lecturer Name</th>
            <th>Feedback</th>
            <th>Date Submitted</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['student_name']; ?></td>
                <td><?php echo $row['lecturer_name']; ?></td>
                <td><?php echo $row['feedback']; ?></td>
                <td><?php echo $row['created_at']; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
