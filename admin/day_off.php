<?php
require_once __DIR__ . '/partials/header.php';

if (User::find_by_id($session->get_user_id())->role != "admin") {
    Redirect("index.php");
}

if (empty($_GET['staff_id'])) {
    Redirect("index.php");
}

$staff_id = (int) $_GET['staff_id'];

if (isset($_POST['submit_day_off'])) {
    $date = trim($_POST['day_off']);
    $reason = trim($_POST['reason']);

    if (empty($date) || !strtotime($date)) {
        Redirect("index.php");
    }

    $day = date('l', strtotime($date));

    Working_hours::add_day_off_day($staff_id, $day, $date);

    $day_off_obj = new Day_off();
    $day_off_obj->date_time = $date;
    $day_off_obj->reason = $reason;
    $day_off_obj->staff_id = $staff_id;

    if ($day_off_obj->create()) {
        Redirect("index.php");
    }
}
?>

<div>
    <form action="" method="post">
        <label for="day_off">Choose Day off day:</label>
        <input type="date" id="day_off" name="day_off" required>
        <br>
        <textarea name="reason" placeholder="Reason"></textarea>
        <br>
        <input type="submit" value="choose day_off" name="submit_day_off">
    </form>
</div>

<?php
require_once __DIR__ . '/partials/footer.php';
