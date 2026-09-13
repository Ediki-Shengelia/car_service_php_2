<?php
require_once __DIR__  . '/partials/header.php';

if (isset($_POST['register'])) {
    $password = trim($_POST['password']);
    $confirm_passowrd = trim($_POST['confirm_passsword']);

    if ($password !== $confirm_passowrd) {
        $errors[] = "Passwords do not match.";
    }
    // !
    if (empty($errors)) {

        $user = new User();
        $user->name = trim($_POST['name']);
        $user->email = trim($_POST['email']);
        $user->role = "user";
        $user->created_at = date("Y-m-d H:i:s");
        $user->password = trim($_POST['confirm_passsword']);
        if (!empty($_FILES['user_image'])) {
            $user->set_file($_FILES['user_image']);
            $user->save_user_with_photo();
        }
        if ($user->save()) {
            $session->login($user);
            Redirect("admin/index.php");
        } else {
            $errors[] = "Registration failed. Please try again.";
        }
    }
}
?>

<h1>Register page</h1>
<?php if (!empty($errors)): ?>
    <?php foreach ($errors as $error): ?>
        <p style="color: red;"><?= $error; ?></p>
    <?php endforeach; ?>
<?php endif; ?>
<form action="" method="post" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Enter Your Name " required id="">
    <br>
    <input type="email" name="email" placeholder="Enter Email" required id="">
    <br>
    <input type="password" name="password" placeholder="Enter Your Password" id="" required>
    <br>
    <input type="password" name="confirm_passsword" placeholder="Confirm Password" id="" required>
    <br>
    <input type="file" name="user_image" id="">
    <br>
    <input type="submit" value="Register" name="register">
</form>

<?php
require_once __DIR__ . '/partials/footer.php';
