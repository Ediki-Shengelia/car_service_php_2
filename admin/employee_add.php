<?php
require_once __DIR__ . '/partials/header.php';

if (User::find_by_id($session->get_user_id())->role != "admin") {
    Redirect("index.php");
}

if (isset($_POST['add_member'])) {
    $staff = new Staff();
    $staff->user_id = (int) $_POST['user_id'];
    $user = new User();
    $user = User::find_by_id($_POST['user_id']); // load existing user by ID
    $user->role = "employee";
    $user->update();
    $staff->phone = trim($_POST['phone']);
    $staff->specialization = trim($_POST['specialization']);
    $staff->role = trim($_POST['role']);
    $staff->salary = (int)$_POST['salary'];
    $staff->status = "active";
    $staff->hire_date = date("Y-m-d");
    if ($staff->create()) {
        Working_hours::create_working_hours_for_worker($staff->id);
        Redirect("index.php");
    }
}
$users = User::find_all();
?>
<h1 style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #2c3e50; font-size: 1.75rem; margin-bottom: 1rem;">Employess ADding</h1>

<div style="max-width: 450px; background-color: #ffffff; padding: 24px; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <form action="" method="post">
        <select name="user_id" id="">
            <option value="">Select Member</option>
            <?php foreach ($users as $user): ?>
                <?php if ($user->role == "user"): ?>
                    <option value="<?= $user->id ?>"><?= $user->name; ?></option>

                <?php endif; ?>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="phone" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-bottom: 6px;">Phone</label>
        <input type="tel" name="phone" id="phone" required style="width: 100%; padding: 10px 12px; font-size: 0.95rem; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; outline: none;">
        <br>
        <label for="specialization" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-top: 14px; margin-bottom: 6px;">specialization</label>
        <input type="text" name="specialization" id="specialization" required style="width: 100%; padding: 10px 12px; font-size: 0.95rem; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; outline: none;">
        <br>
        <label for="role" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-top: 14px; margin-bottom: 6px;">Role</label>
        <input type="text" name="role" id="role" required style="width: 100%; padding: 10px 12px; font-size: 0.95rem; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; outline: none;">
        <br>
        <label for="salary" style="display: block; font-size: 0.875rem; font-weight: 600; color: #374151; margin-top: 14px; margin-bottom: 6px;">Salary</label>
        <input type="number" name="salary" id="salary" required min="500" style="width: 100%; padding: 10px 12px; font-size: 0.95rem; border: 1px solid #d1d5db; border-radius: 6px; box-sizing: border-box; outline: none;">
        <br>
        <input type="submit" value="Add Member" name="add_member" style="margin-top: 20px; width: 100%; background-color: #4f46e5; color: #ffffff; padding: 12px; font-size: 0.95rem; font-weight: 600; border: none; border-radius: 6px; cursor: pointer;">
    </form>
</div>
<?php
require_once __DIR__ . '/partials/footer.php';
