<?php
require_once __DIR__ . '/partials/header.php';

$staffs = Staff::find_all();


if (isset($_POST['service_add'])) {
    $staff_id = (int)$_POST['staff_id'];
    $service_type = $_POST['service'];
    $description = $_POST['description'];
    $allowed_services = ['Engine_service', 'Fuel_service', 'Item_service', 'Electrical'];
    $error = "";
    if (!$staff_id && !$service_type) {
        $error = "Plase Choose Our Team Member and Service";
    } elseif (!in_array($service_type, $allowed_services, true)) {
        $error = "We don't have this service";
    } elseif (Service::check_service_status($staff_id)) {
        $error = "This team Member already has an in-progress service";
    } else {
        $service = new Service();
        $service->staff_id = $staff_id;
        $service->status = "in_progress";
        $service->service = $service_type;
        $service->description = $description;
        $service->create_and_calculate_time_of_service();
        $service->created_at = date("Y-m-d H:i:s");
        if ($service->create()) {
            Redirect("../admin/index.php");
        } else {
            $error = "We have some problems to create service";
        }
    }
}
?>

<h1>Services</h1>

<?php if (!empty($error)): ?>
    <p style="color: red;"><?= $error; ?></p>
<?php endif; ?>
<form action="" method="post">
    <div>
        <select name="staff_id" id="">
            <option value="">select Member</option>
            <?php foreach ($staffs as $staff): ?>
                <?php if (User::find_by_id($staff->user_id)->role != "admin"): ?>
                    <option value="<?= $staff->id; ?>"><?= User::find_by_id($staff->user_id)->name; ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
    <div>
        <select name="service" required>
            <option value="">Select service</option>
            <option value="Engine_service">Engine service</option>
            <option value="Fuel_service">Fuel service</option>
            <option value="Item_service">Item service</option>
            <option value="Electrical">Electrical</option>
        </select>
    </div>
    <label for="description">description</label>
    <textarea name="description" id="description"></textarea>
    <br>
    <input type="submit" value="Add Service" name="service_add">
</form>
<?php
require_once __DIR__ . '/partials/footer.php';
