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

if (!empty($first_name)  && !empty($last_name))
{
  $query = "SELECT c.`CDD_id`, CAST(AES_DECRYPT(c.`CDD_forename`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) AS forename, CAST(AES_DECRYPT(c.`CDD_surname`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) AS surname FROM candidate c WHERE CAST(AES_DECRYPT(c.`CDD_forename`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) LIKE '%$first_name%' AND CAST(AES_DECRYPT(c.`CDD_surname`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) LIKE '%$last_name%' ORDER BY surname ASC; ";
}
else if (!empty($first_name))
{
$query = "SELECT c.`CDD_id`, CAST(AES_DECRYPT(c.`CDD_forename`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) AS forename, CAST(AES_DECRYPT(c.`CDD_surname`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) AS surname FROM candidate c WHERE CAST(AES_DECRYPT(c.`CDD_forename`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) LIKE '%$first_name%' ORDER BY forename ASC; ";
}
else if (!empty($last_name))
{
$query = "SELECT c.`CDD_id`, CAST(AES_DECRYPT(c.`CDD_forename`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) AS forename, CAST(AES_DECRYPT(c.`CDD_surname`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) AS surname FROM candidate c WHERE CAST(AES_DECRYPT(c.`CDD_surname`, '1aaf45c0ab29b50e5bbbdcaf56c3df59') AS CHAR) LIKE '%$last_name%' ORDER BY surname ASC; ";
}
else if (empty($first_name) && empty($last_name))
{

 $query = "No records.";
}

$result = mysqli_query($dbc,$query) or die('Please enter a first name or last name');
if(!empty($result))
{
echo "Here are your results <br/>";
}
/*echo 'Here are your results'.':'.'<br/>';
//echo $result;
while ($row = mysqli_fetch_array($result))
{
echo  $row['CDD_id'] . ' ' .$row['forename']. ' ' .$row['surname'] . '<br />';
}
*/
?>

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
  
    <td>
        <form method="post" action="searchDetails.php">
          <input type="hidden" name="firstname" value=<?php echo $row['forename'];?>>
          <input type="hidden" name="lastname" value=<?php echo $row['surname'];?>>
          <input type="hidden" name="cddid" value=<?php echo $row['CDD_id'];?>>
          <input type="submit" value="Details" name="Details"/>
       </form>
    </td>
  </tr>
  <?php 
  }?>
</table>

<?php 
if(empty($result))

{

  echo "No results found.";
}
mysqli_close($dbc);

?>


</body>
</html>