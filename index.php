

<?php
session_start();
?>
<?php

        if(!empty($_GET["jazyk"])){
            $_SESSION["jazyk"]=$_GET["jazyk"];
        }
        else{
            $_SESSION["jazyk"]="sk";
        }
        var_dump($_SESSION["jazyk"]);

?>

<a href=index.php?jazyk=sk>sk</a>
<a href=index.php?jazyk=en>en</a>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "toth1";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
if(!empty($_GET["trieda"])){
    $where = " WHERE rozvrh.trieda = '".$_GET["trieda"]."'";
}
else{
    $where = "";
}

$sql = "SELECT * FROM rozvrh".$where;
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
        $rozvrh[$row["den"]][$row["hodina"]] = $row["predmet"];
    }
} else {
    echo "0 results";
}

//mysqli_close($conn);
?>

<?php

$dni = array("Pondelok", "Utorok", "Streda", "Stvrtok", "Pondelok");
$hodiny = array(0, 1, 2, 3, 4, 5,6,7);

?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> tabulka</title>
</head>
</html>


<table border=1 >
    <tr>
        <td>Den</td>
        <? foreach ($hodiny as $i => $hodina): ?>
            <td><? echo $hodina; ?></td>
        <? endforeach; ?>
    </tr>

    <? foreach ($dni as $i => $den): ?>
        <tr>
            <td><? echo $den; ?></td>
            <? foreach ($hodiny as $j => $hodina): ?>
                <td><small><? echo $j." ";?></small><? echo @$rozvrh[$i][$j]; ?></td>
            <? endforeach; ?>
        </tr>
    <? endforeach; ?>
</table>

<?php
    $sql = "SELECT trieda FROM rozvrh GROUP BY trieda ORDER BY TRIEDA";
    $result = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_assoc($result)){
        echo "<a href=index.php?trieda=".$row["trieda"].">".$row["trieda"]."</a><br>";
    }
    ?>

</body>
</html>






