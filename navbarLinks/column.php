<?php
    require "../databaseConnect.php";
    require "../detection.php";
    $sql = "SHOW COLUMNS FROM `groups`";
$result = mysqli_query($conn,$sql);


// while($row = mysqli_fetch_array($result)){
//     // echo $row['Field']."<br>";
// }
echo "<br>";
while($row = mysqli_fetch_array($result))
{
    if($row['Field'] == 'id' || $row['Field'] == 'username' || $row['Field'] == 'all')
    {
        echo "Hello";
    }
    else
    {
    echo $row['Field']."<br>";
    }
    // echo "Hello";
}
?>
<script>
        function check_session()
        {
            let session_id = "<?php echo $_SESSION['token']; ?>"
            fetch('../detection.php').then(function(response){
                return response.json();
            }).then(function(responseData){
                console.log(responseData);
                if(responseData.output == 'logout'){
                    window.location.href = "logout.php"
                }
            })
        }

        setInterval(function(){
            check_session();
        }, 10000);
    </script>