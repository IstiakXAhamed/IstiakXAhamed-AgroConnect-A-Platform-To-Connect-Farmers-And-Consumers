<!DOCTYPE html>
<html>

<head>
    <title>Manage Users</title>
    <link rel="stylesheet" href="../../View/admin/css/adminDashBoard.css">
    <script>
        function updateStatus(userId, action) {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "manageUsersController.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    try {
                        let jsObj = JSON.parse(xhr.responseText);
                        if (jsObj.success) {
                            alert(jsObj.message);
                            location.reload();
                        } else {
                            alert(jsObj.message);
                        }
                    } catch (e) {
                        alert("Server error");
                    }
                }
            }

            xhr.send("userId=" + userId + "&action=" + action);
        }
    </script>
</head>

<body>

    <!-- Header -->
    <div class="header">
        <h2>Manage Users</h2>
        <div class="header-links">
            <a href="../../Controller/admin/adminDashboardController.php">Dashboard</a>
            <a href="../../Controller/admin/configController.php">Configuration</a>
            <a href="../../Controller/AuthControl/logoutController.php" class="logout">Logout</a>
        </div>
    </div>

    <div class="main-content">

        <!-- Users Table -->
        <div class="section">
            <h3>All Users</h3>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php
                if ($users && mysqli_num_rows($users) > 0) {
                    while ($user = mysqli_fetch_assoc($users)) {
                        $statusClass = ($user['status'] == 1) ? "status-active" : "status-pending";
                        $statusText = ($user['status'] == 1) ? "Active" : "Inactive";
                        echo "<tr>
                            <td>{$user['id']}</td>
                            <td>{$user['name']}</td>
                            <td>{$user['email']}</td>
                            <td>{$user['role']}</td>
                            <td class='{$statusClass}'>{$statusText}</td>
                            <td>
                                <button class='btn-approve' onclick=\"updateStatus({$user['id']}, 'approve')\">Approve</button>
                                <button onclick=\"updateStatus({$user['id']}, 'block')\">Block</button>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No users found</td></tr>";
                }
                ?>
            </table>
        </div>

    </div>

</body>

</html>