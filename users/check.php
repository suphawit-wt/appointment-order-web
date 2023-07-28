<?php
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    require_once('../db/connect.php');

    $username = $_GET['username'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $dbconn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    $user = $result->fetch_assoc();
?>
    <?php if (!empty($user)) : ?>
        <span class="text-danger">*Username "<?php echo $user['username'] ?>" is already in use!</span>
    <?php endif; ?>
<?php
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();
    require_once('../db/connect.php');

    $username = $_POST['username'];
    $passwd = md5($_POST['password']);

    if (empty($username) || empty($_POST['password'])) {
        echo "<script type='text/javascript'>alert('*Username and Password field is required.');history.go(-1);</script>";
    } else {
        $sql = "SELECT u.*, ps_name, dep_name
                FROM users u
                INNER JOIN persons p ON u.persons_id = p.id
                INNER JOIN departments d ON p.departments_id = d.id
                WHERE username = ? AND passwd = ?";

        $stmt = $dbconn->prepare($sql);
        $stmt->bind_param("ss", $username, $passwd);
        $stmt->execute();
        $result = $stmt->get_result();

        $user = $result->fetch_assoc();

        if (!empty($user)) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $user['username'];
            $_SESSION['pID'] = $user['persons_id'];
            $_SESSION['pName'] = $user['ps_name'];
            $_SESSION['uGroup'] = $user['user_group'];
            $_SESSION['dName'] = $user['dep_name'];
            header("location: /login.php");
            exit(0);
        } else {
            echo "<script type='text/javascript'>alert('*Username or Password is invalid!');history.go(-1);</script>";
        }
    }
} else {
    header("location: /");
} ?>