<!DOCTYPE html>
<html>

<head>
    <title>Manage Users</title>
    <script>
        function updateStatus(userId, action) {


            let xhr = new XMLHttpRequest();


            xhr.open("POST", "../../Controller/admin/manageUsersController.php", true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
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
                        console.log(xhr.responseText);
                    }
                }
            }

            xhr.send("userId=" + userId + "&action=" + action);
        }
    </script>
</head>


<body>
    <h2>User Management</h2>
    <table border="1" cellpadding="10">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td><?php echo $user['role']; ?></td>
                <td><?php echo $user['status'] == 1 ? 'Active' : 'Inactive'; ?></td>
                <td>
                    <button onclick="updateStatus(<?php echo $user['id']; ?>, 'approve')">Approve</button>
                    <button onclick="updateStatus(<?php echo $user['id']; ?>, 'block')">Block</button>
                </td>
            </tr>
        <?php } ?>
    </table>

    <br>
    <a href="../../View/admin/dashBoard.php">Back to Dashboard</a>
</body>

</html>