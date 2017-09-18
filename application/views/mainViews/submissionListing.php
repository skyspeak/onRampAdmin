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

  <?php if(isset($submissions['data'])):?>

    <table class="table  table-bordered">
      <tr>
          <th>Student Name</th>
          <th>Project Name</th>
          <th>Part Name </th>
          <th>Task Name</th>
          <th></th>
          <!-- <th></th> -->
      </tr>

      <?php foreach($submissions['data'] as $submission):?>
          
          <!--This where all the loop detail comes in  -->
           <tr>
          <td><?php echo $submission['student_name']?></td>
          <td><?php echo $submission['project_name']?></td>
          <td><?php echo $submission['part_name']?></td>
          <td><?php echo $submission['task_name']?></td>
          <td><a href="<?php echo base_url("admin/submissions/view/".$submission['submission_id'])?>">view</a></td>

           <!-- <td><a href="<?php echo base_url("admin/projects/edit/".$project['project_id'])?>">edit</a></td>  -->

      </tr>
          
      <?php endforeach;?>

    </table>

  <?php else: echo "No Users Registered"; endif;?>



</div>

</div>

</section>
