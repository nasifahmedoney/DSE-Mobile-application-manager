<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">Branch</th>
      <th scope="col">Initiated by</th>
      <th scope="col">Bo Id</th>
      <th scope="col">Status</th>
      <th scope="col">View Application</th>
    </tr>
  </thead>


<?php
$query = "SELECT * FROM documents WHERE branch = '$branch' AND status = 'Pending'";
$result = mysqli_query($link,$query);

if($result)
{
    while($row = $result->fetch_array(MYSQLI_ASSOC))
    {
        if(is_array($row))
        {
            //php end html start
            ?>
            
            <tbody>
                <tr>
                    <td><?php echo $row['branch']; ?></th>
                    <td><?php echo $row['email']; ?></th>
                    <td><?php echo $row['bo_id']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>View Application [link]</td>
                </tr>
            </tbody>
            
            <?php
            //html end php start
        }
        else
        {
            header("Location:error.php");
        }
    }
}
else
{
    header("Location:error.php");
}

//php end
?>
  
</table>