<?php
require_once __DIR__ . '/partials/header.php';

if (User::find_by_id($session->get_user_id())->role != "admin") {
    Redirect("index.php");
}

$staffs = Staff::find_all();

?>
<h1>Employess</h1>

<table style="width: 100%; max-width: 1100px; border-collapse: separate; border-spacing: 0; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <thead>
        <tr style="background-color: #4f46e5; color: #ffffff;">
            <th style="padding: 12px 14px; text-align: left; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">Id</th>
            <th style="padding: 12px 14px; text-align: left; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">username</th>
            <th style="padding: 12px 14px; text-align: left; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">email</th>
            <th style="padding: 12px 14px; text-align: left; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">phone</th>
            <th style="padding: 12px 14px; text-align: left; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">status</th>
            <th style="padding: 12px 14px; text-align: left; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">specialization</th>
            <th style="padding: 12px 14px; text-align: left; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">Role</th>
            <th style="padding: 12px 14px; text-align: left; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">salary</th>
            <th style="padding: 12px 14px; text-align: left; font-weight: 600; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">Hire Date</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($staffs as $index => $staff): ?>
            <tr style="background-color: <?= $index % 2 === 0 ? '#ffffff' : '#f9fafb'; ?>;">
                <td style="padding: 12px 14px; text-align: left; font-size: 0.9rem; color: #374151; border-bottom: 1px solid #e5e7eb;"><?= $staff->id; ?></td>
                <td style="padding: 12px 14px; text-align: left; font-size: 0.9rem; color: #374151; border-bottom: 1px solid #e5e7eb;"><?= User::find_by_id($staff->user_id)->name; ?></td>
                <td style="padding: 12px 14px; text-align: left; font-size: 0.9rem; color: #374151; border-bottom: 1px solid #e5e7eb;"><?= User::find_by_id($staff->user_id)->email; ?></td>
                <td style="padding: 12px 14px; text-align: left; font-size: 0.9rem; color: #374151; border-bottom: 1px solid #e5e7eb;"><?= $staff->phone; ?></td>
                <td style="padding: 12px 14px; text-align: left; font-size: 0.9rem; color: #374151; border-bottom: 1px solid #e5e7eb;"><?= $staff->status; ?></td>
                <td style="padding: 12px 14px; text-align: left; font-size: 0.9rem; color: #374151; border-bottom: 1px solid #e5e7eb;"><?= $staff->specialization; ?></td>
                <td style="padding: 12px 14px; text-align: left; font-size: 0.9rem; color: #374151; border-bottom: 1px solid #e5e7eb;"><?= $staff->role; ?></td>
                <td style="padding: 12px 14px; text-align: left; font-size: 0.9rem; color: #374151; border-bottom: 1px solid #e5e7eb;"><?= $staff->salary; ?></td>
                <td style="padding: 12px 14px; text-align: left; font-size: 0.9rem; color: #374151; border-bottom: 1px solid #e5e7eb;">
                    <?= $staff->hire_date; ?>

                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php
require_once __DIR__ . '/partials/footer.php';
