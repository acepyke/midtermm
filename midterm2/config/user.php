<?php include "db.php"; ?>

<?php
// CREATE USER
if (isset($_POST['create_user'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    $check = $conn->query("SELECT * FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        echo "Email already exists!";
    } else {
        $conn->query("INSERT INTO users (name, email, password)
        VALUES ('$name','$email','$password')");
        echo "User Created!";
    }
}

// DELETE USER
if (isset($_GET['delete_user'])) {
    $id = $_GET['delete_user'];
    $conn->query("DELETE FROM users WHERE id=$id");
}

// GET USERS
$users = $conn->query("SELECT * FROM users");
?>

<h2>User System</h2>

<form method="POST">
    Name: <input name="name"><br>
    Email: <input name="email"><br>
    Password: <input name="password"><br>
    <button name="create_user">Add User</button>
</form>

<hr>

<table border="1">
<tr><th>ID</th><th>Name</th><th>Email</th><th>Action</th></tr>

<?php while($u = $users->fetch_assoc()) { ?>
<tr>
    <td><?= $u['id'] ?></td>
    <td><?= $u['name'] ?></td>
    <td><?= $u['email'] ?></td>
    <td><a href="?delete_user=<?= $u['id'] ?>">Delete</a></td>
</tr>
<?php } ?>

</table>