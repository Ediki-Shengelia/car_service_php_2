<?php
require_once __DIR__ . '/partials/header.php';

if (User::find_by_id($session->get_user_id())->role != "admin") {
    Redirect("index.php");
}
$users = User::find_all();


?>

<h1 style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #2c3e50; font-size: 1.75rem; margin-bottom: 1rem;">Users</h1>

<table style="width: 100%; max-width: 900px; border-collapse: separate; border-spacing: 0; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;">
    <thead>
        <tr style="background-color: #4f46e5; color: #ffffff;">
            <th style="padding: 12px 16px; text-align: left; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em;">Id</th>
            <th style="padding: 12px 16px; text-align: left; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em;">Username</th>
            <th style="padding: 12px 16px; text-align: left; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em;">Email</th>
            <th style="padding: 12px 16px; text-align: left; font-weight: 600; font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em;">Joined</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($users as  $user): ?>
            <tr style="border-bottom: 1px solid #e5e7eb; background-color: <?= $index % 2 === 0 ? '#ffffff' : '#f9fafb'; ?>;">
                <td style="padding: 12px 16px; text-align: left; font-size: 0.95rem; color: #374151; border-bottom: 1px solid #e5e7eb;"><?= $user->id; ?></td>
                <td style="padding: 12px 16px; text-align: left; font-size: 0.95rem; color: #374151; border-bottom: 1px solid #e5e7eb;"><?= $user->name; ?></td>
                <td style="padding: 12px 16px; text-align: left; font-size: 0.95rem; color: #374151; border-bottom: 1px solid #e5e7eb;"><?= $user->email; ?></td>
                <td style="padding: 12px 16px; text-align: left; font-size: 0.95rem; color: #374151; border-bottom: 1px solid #e5e7eb;">
                    <?= $user->created_at; ?>
                    <span style="color: green;">
                        <?= diffForHumans($user->created_at); ?>
                    </span>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php

require_once __DIR__ . '/partials/footer.php';
