<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <title>Search Results</title>
</head>
<body>
  <h2>Search Results</h2>

<?php

  $first_name = $_POST['firstname'];
  $last_name = $_POST['lastname'];


$dbc = mysqli_connect('localhost','clegga','test','matchjob_manc') or die('Error connecting to SQL database');


if ((isset($first_name)&& !empty($first_name))  && (isset($last_name)&& !empty($last_name)))
{
$query = "SELECT c.`CDD_id`, CAST(AES_DECRYPT(c.`CDD_forename`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) AS forename, CAST(AES_DECRYPT(c.`CDD_surname`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) AS surname FROM candidate c WHERE CAST(AES_DECRYPT(c.`CDD_forename`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) = '$first_name' AND CAST(AES_DECRYPT(c.`CDD_surname`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) = '$last_name' ORDER BY surname ASC; ";
}
else
{
$query = "SELECT c.`CDD_id`, CAST(AES_DECRYPT(c.`CDD_forename`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) AS forename, CAST(AES_DECRYPT(c.`CDD_surname`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) AS surname FROM candidate c WHERE CAST(AES_DECRYPT(c.`CDD_forename`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) = '$first_name' OR CAST(AES_DECRYPT(c.`CDD_surname`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) = '$last_name' ORDER BY surname ASC; ";
}

$result = mysqli_query($dbc,$query) or die('Error querying the database');

echo 'Here are your results'.':'.'<br/>';
//echo $result;
while ($row = mysqli_fetch_array($result))
{
echo  $row['CDD_id'] . ' ' .$row['forename']. ' ' .$row['surname'] . '<br />';
}

echo 'Here are your results'.':'.'<br/>';
echo "<table>
<tr>
<th>ID</th>
<th>Firstname</th>
<th>Lastname</th>
<th>View Match Details</th>
</tr>";
while ($row = mysqli_fetch_array($result))
/*{
echo  $row['CDD_id'] . ' ' .$row['forename']. ' ' .$row['surname'] . '<br />';

}*/
  /*{
  echo "<tr>";
  echo "<td>" . $row['CDD_id'] . "</td>";
  echo "<td>" . $row['forename'] . "</td>";
  echo "<td>" . $row['surname'] . "</td>";
  echo $first_name;
  echo $last_name;
  echo "<td>" . '<form method="post" action="searchDetails.php"><input type="hidden" name="firstname2" value=<?php echo $first_name?>/>
  <input type="hidden" name="lastname2" value=<?php echo $first_name?>/>
  <input type="submit" value="Details" name="Details"/></form>';
  echo "</tr>";
  }
echo "</table>";

 {
  echo "<tr>";
  echo "<td>" . $row['CDD_id'] . "</td>";
  echo "<td>" . $row['forename'] . "</td>";
  echo "<td>" . $row['surname'] . "</td>";
  echo $first_name;
  echo $last_name;
  echo "<td>" . '<form method="post" action="searchDetails.php"><input type="hidden" name="firstname2" value=<?php echo $first_name?>/>
  <input type="hidden" name="lastname2" value=<?php echo $first_name?>/>
  <input type="submit" value="Details" name="Details"/></form>';
  echo "</tr>";
  }
echo "</table>";

  mysqli_close($dbc);

?>

</body>
</html>
*/
/*echo 'Here are your results'.':'.'<br/>';
//echo $result;
while ($row = mysqli_fetch_array($result))
{
echo  $row['CDD_id'] . ' ' .$row['forename']. ' ' .$row['surname'] . '<br />';
}
*/
?>
Here are your results <br/>
<table>
  <tr>
    <th>ID</th>
    <th>Firstname</th>
    <th>Lastname</th>
    <th>View Match Details</th>
  </tr>
<?php
while ($row = mysqli_fetch_array($result))
/*{
echo  $row['CDD_id'] . ' ' .$row['forename']. ' ' .$row['surname'] . '<br />';

}*/
{?>
  <tr>
    <td><?php echo $row['CDD_id'];?></td>
    <td><?php echo $row['forename'];?></td>
    <td><?php echo $row['surname'];?></td>
  
  <?php echo $first_name;?>
  <?php echo $last_name;?>
  
    <td>
        <form method="post" action="searchDetails.php">
          <input type="hidden" name="firstname2" value=<?php echo $first_name;?>/>
          <input type="hidden" name="lastname2" value=<?php echo $last_name;?>/>
          <input type="submit" value="Details" name="Details"/>
       </form>
    </td>
  </tr>
  <?php 
  }?>
</table>

<?php mysqli_close($dbc);?>
</body>
</html>