<?php
require_once __DIR__ . '/partials/header.php';

$services = Service::find_all();


$working_hours = Working_hours::find_all();

foreach ($working_hours as $wh) {
    // ვამოწმებთ, რომ თარიღი მითითებულია და ის წარსულშია (<)
    if (!empty($wh->date_for_day_off) && $wh->date_for_day_off < date("Y-m-d")) {
        Working_hours::refresh_day_off($wh->staff_id, $wh->day_of_week, $wh->date_for_day_off);
    }
}
?>

<h1 style="font-family: Arial, sans-serif; font-size: 24px; font-weight: bold; margin-bottom: 16px;">Index for admin</h1>

<?php if (User::find_by_id($session->get_user_id())->role == "admin"): ?>
    <div style="margin-bottom: 16px;">
        <a href="employee_add.php" style="display: inline-block; padding: 6px 12px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 4px; font-family: Arial, sans-serif; font-size: 14px; margin-right: 8px;">Add member</a>
        <a href="users.php" style="display: inline-block; padding: 6px 12px; background-color: #6c757d; color: #fff; text-decoration: none; border-radius: 4px; font-family: Arial, sans-serif; font-size: 14px; margin-right: 8px;">Users</a>
        <a href="employees.php" style="display: inline-block; padding: 6px 12px; background-color: #6c757d; color: #fff; text-decoration: none; border-radius: 4px; font-family: Arial, sans-serif; font-size: 14px;">Members</a>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse; font-family: Arial, sans-serif; font-size: 14px; text-align: left;">
            <thead>
                <tr style="background-color: #f8f9fa; border-bottom: 2px solid #dee2e6;">
                    <th style="padding: 10px; border: 1px solid #dee2e6;">Id</th>
                    <th style="padding: 10px; border: 1px solid #dee2e6;">Usenrame</th>
                    <th style="padding: 10px; border: 1px solid #dee2e6;">email</th>
                    <th style="padding: 10px; border: 1px solid #dee2e6;">service</th>
                    <th style="padding: 10px; border: 1px solid #dee2e6;">Status</th>
                    <th style="padding: 10px; border: 1px solid #dee2e6;">created_at</th>
                    <th style="padding: 10px; border: 1px solid #dee2e6;">Time for finish</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($services as $service): ?>
                    <tr style="border-bottom: 1px solid #dee2e6;">
                        <td style="padding: 10px; border: 1px solid #dee2e6;"><?= $service->id; ?></td>
                        <?php $user = User::find_by_id(Staff::getUserInfo($service->staff_id)); ?>
                        <td style="padding: 10px; border: 1px solid #dee2e6;"><?= $user ? htmlspecialchars($user->name) : '—'; ?></td>
                        <td style="padding: 10px; border: 1px solid #dee2e6;"><?= $user ? htmlspecialchars($user->email) : '—'; ?></td>
                        <td style="padding: 10px; border: 1px solid #dee2e6;"><?= $service->service; ?></td>
                        <td style="padding: 10px; border: 1px solid #dee2e6;">
                            <?= $service->status; ?>
                            <div>
                                <?php Service::check_status($service->id); ?>
                            </div>
                        </td>
                        <td style="padding: 10px; border: 1px solid #dee2e6;">
                            <span style="color: red;">
                                <?= diffForHumans($service->created_at); ?>
                            </span>
                        </td>
                        <td style="padding: 10px; border: 1px solid #dee2e6;">
                            <span style="color: green;">
                                <?= diffForHumans($service->completed_at); ?>
                            </span>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<?php if (User::find_by_id($session->get_user_id())->role == "user"): ?>
    <div style="margin-top: 16px;">
        <a href="../service/index.php" style="display: inline-block; padding: 6px 12px; background-color: #007bff; color: #fff; text-decoration: none; border-radius: 4px; font-family: Arial, sans-serif; font-size: 14px;">Service</a>
    </div>
<?php endif; ?>
<?php

require_once __DIR__ . '/partials/footer.php';
