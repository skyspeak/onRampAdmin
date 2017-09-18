<!-- Start of Part Listing  -->
<section class="well well-lg" id="partListing">
<div class="row">


<!-- This is there the add form comes  -->
<div class="col-md-12">
  <h1>Projects</h1><span class="addParts">(<a href="<?php echo base_url("admin/projects/create/") ?>">Create Projects</a>)</span>
</div>

<!--This is where the listing comes  -->
<div class="col-md-12">

  <?php if(isset($projects['data'])):?>

    <table class="table  table-bordered">
      <tr>
          <th>Project Name</th>
          <th></th>
      </tr>

      <?php foreach($projects['data'] as $project):?>
          
          <!--This where all the loop detail comes in  -->
           <tr>
          <td><?php echo $project['project_name']?></td>

          <td><a href="<?php echo base_url("admin/projects/edit/".$project['project_id'])?>">edit</a></td>

      </tr>
          
      <?php endforeach;?>

    </table>

  <?php else: echo "No Projects Added"; endif;?>



</div>

</div>

</section>
