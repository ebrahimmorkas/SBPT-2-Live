<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="POST">
    <select name="g" id="">
        <option value="o">1</option>
        <option value="t">2</option>
    </select>
    <button type="submit">Ok</button>
    </form>

    <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $value = $_POST['g'];
            echo $value;
        }
    ?>
</body>
</html>

if($group == 'All')
                    {
                        // Check whether user is added in 'All' group
                        $selectGroup = "SELECT * FROM groups WHERE username = '$ITS' AND All='1'";
                        $selectGroupResult = mysqli_query($conn, $selectGroup);
                        $numberOfRows = mysqli_num_rows($selectGroupResult);
                        if($numberOfRows == 1)
                        {
                            // User is added and throw the message
                            header("location:addUser.php?added=1");
                        }
                        else
                        {
                            // User is not added in group All
                            $insertGroup = "INSERT INTO `groups` (`username`,All) VALUES ('$ITS','$1')";
                            $insertGroupResult = mysqli_query($conn, $insertGroup);
                        }
                    }