<?php require '../templates/header.php'; ?>
<!-- Your homepage content goes here -->


<?php
if(isset($_POST['submit'])){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=$_POST['password'];

    $rules = [
        'name' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8'
    ];

    $data = [
        'name' => $name,
        'email' => $email,
        'password' => $password
    ];

    $errors = validate($data, $rules);

    if (empty($errors)) {
        echo 'ok';
    } else {
        // Validation failed, display errors to the user
        foreach ($errors as $field => $fieldErrors) {
            foreach ($fieldErrors as $error) {
                echo $error . '<br>';
            }
        }
    }
}

?>
<form method="post">
    <input type="text" name="name" id="" placeholder="name">
    <input type="text" name="email" id="" placeholder="email">
    <input type="text" name="password" id="" placeholder="password">
    <input type="submit" name="submit" value="Submit"> <!-- Fixed submit button name -->

</form>
<?php require '../templates/footer.php'; ?>
