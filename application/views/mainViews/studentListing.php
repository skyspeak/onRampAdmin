<!-- Start of Part Listing  -->
<section class="well well-lg" id="partListing">
<div class="row">


<!-- This is there the add form comes  -->
<div class="col-md-12">
  <h1>Student Details</h1>
  <!-- <span class="addParts">(<a href="<?php echo base_url("admin/projects/create/") ?>">Add Parts</a>)</span> -->
</div>

<!--This is where the listing comes  -->
<div class="col-md-12">

  <?php if(isset($users['data'])):?>
  

    <table class="table  table-bordered">
      <tr>
          <th>Student ID</th>
          <th>First Name</th>
          <th>Last Name </th>
          <th>Auth Type</th>
          <th>Email</th>
          <!-- <th></th> -->
      </tr>

      <?php foreach($users['data'] as $user):?>
          
          <!--This where all the loop detail comes in  -->
           <tr>
          <td><?php echo $user['userClient_id']?></td>
          <td><?php echo $user['userClient_firstName']?></td>
          <td><?php echo $user['userClient_lastName']?></td>
          <td><?php echo $user['userClient_authtype']?></td>
          <td><?php echo $user['userClient_email']?></td>

           <!-- <td><a href="<?php echo base_url("admin/projects/edit/".$project['project_id'])?>">edit</a></td>  -->

      </tr>
          
      <?php endforeach;?>

    </table>

  <?php else: echo "No Users Registered"; endif;?>



</div>

</div>

</section>
