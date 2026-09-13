<?php
require_once __DIR__ . '/partials/header.php';
?>

<h1>Index for admin</h1>

<?php if (User::find_by_id($session->get_user_id())->role == "admin"): ?>
    <a href="employee_add.php">Add member</a>
    <a href="users.php">Users</a>
    <a href="employees.php">Members</a>
<?php endif; ?>
<div>
    <a href="../service/index.php">Service</a>
</div>
<?php

require_once __DIR__ . '/partials/footer.php';
