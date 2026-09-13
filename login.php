<?php
require_once __DIR__  . '/partials/header.php';
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user_found = User::verify_user($email, $password);
    if ($user_found) {
        $session->login($user_found);
        Redirect("admin/index.php");
    } else {
        $message = "Userrrr Not found";
    }
}
?>

<h1>Login</h1>
<?php if (!empty($message)): ?>
    <p style="color: red;"><?= $message; ?></p>
<?php endif; ?>
<form action="" method="post">
    <input type="email" name="email" placeholder="Email" id="" required>
    <br>
    <input type="password" name="password" id="" required>
    <br>
    <input type="submit" value="Login" name="login">
</form>

<?php
require_once __DIR__ . '/partials/footer.php';
