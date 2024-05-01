<?php
include 'src/config/config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['id'])) {
    $user_id = $_SESSION['id'];
    $sql = "SELECT users.username, users.name, users.profile_picture, subscriptions.user_id FROM users INNER JOIN subscriptions ON users.id = subscriptions.user_id WHERE subscriptions.subscriber_id = '$user_id'";
    $result = $conn->query($sql);
    $rows = array();
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $subscription_sql = "SELECT * FROM subscriptions WHERE subscriber_id = $user_id AND user_id = " . $row['user_id'];
            $subscription_result = $conn->query($subscription_sql);
            $isSubscribed = $subscription_result && $subscription_result->num_rows > 0;

            $row['isSubscribed'] = $isSubscribed;
            $rows[] = $row;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TikTok</title>
    <link rel="stylesheet" href="src/style/style.css" />
    <link rel="stylesheet" href="style/css/responsive.css" />
    <link rel="icon" type="image/png" href="src/assets/photo/icontiktok.jpg" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body key="jaki">
    <header>
        <?php include 'components/navbar.php' ?>
    </header>
    <content>
        <div class="content">
            <div class="center-content">
                <div class="center-content-left">
                    <?php include 'components/sidebar.php' ?>
                </div>
                <div class="center-content-subs">
                    <div class="content-sub">
                        <div class="container-subs">
                            <?php
                            if (isset($_SESSION['id'])) {
                                if (!empty($rows)) {
                                    foreach ($rows as $index => $row) : ?>
                                        <div class="content-subs">
                                            <div class="user-profile">
                                                <img src="<?php echo $row['profile_picture']; ?>" alt="Profile Photo">
                                                <span class="username"><?php echo $row['username']; ?></span>
                                                <span class="name"><?php echo $row['name']; ?></span>
                                                <button class="subscribe-button <?php echo $row['isSubscribed'] ? 'subscribed' : ''; ?>" onclick="toggleSubscribe(this, <?php echo $row['user_id']; ?>)">
                                                    <?php echo $row['isSubscribed'] ? "Unsubscribe" : "Subscribe"; ?>
                                                </button>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                            <?php } else {
                                    echo "<div class='center-content-subs'><h2>Belum ada pengguna yang Anda Subscribed</h2></div>";
                                }
                            } else {
                                echo "<div class='center-content-subs'><h2>Silakan Login untuk melakukan Subscribe</h2></div>";
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </content>
    <script src="src/js/subscribe.js"></script>
    <script src="src/js/login.js"></script>
    <script>
        function toggleSubscribe(button, userId) {
            const isSubscribed = !button.classList.contains('subscribed');

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'subscribe.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            const data = `user_id=${userId}&is_subscribed=${isSubscribed}`;
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const responseData = JSON.parse(xhr.responseText);
                    if (isSubscribed) {
                        button.textContent = 'Unsubscribe';
                        button.classList.add('subscribed');
                    } else {
                        button.textContent = 'Subscribe';
                        button.classList.remove('subscribed');
                    }
                } else {
                    console.error('Failed to toggle subscribe: Server returned status ' + xhr.status);
                }
            };
            xhr.send(data);
        }
    </script>
</body>

</html>