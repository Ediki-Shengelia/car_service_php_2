<?php
require_once __DIR__ . '/partials/header.php';

$staffs = Staff::find_all();
?>

<h1>Services</h1>
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
    <input type="submit" value="Add Service" name="service_addd">
</form>
<?php
require_once __DIR__ . '/partials/footer.php';
