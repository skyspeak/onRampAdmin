 <?php if(isset($approvalStatus)):?>
      <!--If the register error is uploaded  -->
          <div <?php echo ($approvalStatus['success'])?  'class="form-error alert-success"': 'class="form-error alert-danger"'?>>

          <?php echo $approvalStatus['msg']?>

          </div>
      <?php endif ?>
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

  <?php if(isset($submissions['data'])): $submission = $submissions['data'];?>

    <div class="row">

        <div class="col-md-6">
        <div class="submission-item">
            <div class="submission-label">Student Name</div>
            <div class="submission-value"><?php  echo  $submission['student_name'];?></div>
        </div>
        <div class="submission-item">
            <div class="submission-label">Project Name</div>
            <div class="submission-value"><?php  echo  $submission['project_name'];?></div>
        </div>
        <div class="submission-item">
            <div class="submission-label">Part Name</div>
            <div class="submission-value"><?php  echo  $submission['part_name'];?></div>
        </div>
        <div class="submission-item">
            <div class="submission-label">Task Name</div>
            <div class="submission-value"><?php  echo  $submission['task_name'];?></div>
        </div>

        </div>
        
        <div class="col-md-6">
        <div class="submission-item">
            <div class="submission-label">Submission Link</div>
            <div class="submission-value"><a href="<?php  echo  $submission['submission_link'];?>"  target="_blank"><?php  echo  $submission['submission_link'];?></a></div>
        </div>
        <div class="submission-item">
            <div class="submission-label">Submission Comment</div>
            <div class="submission-value"><?php  echo  $submission['submission_comment'];?></div>
        </div>

          <div class="submission-approval">
                <div class="row">

                        
                    <div class="col-md-6">
                           

                            <?php echo form_open();?>
                                <input type="text" name="approved" class="hidden"value="true">

                                <button type="submit" class="btn btn-success">Mark As Completed</button>
                            <?php echo form_close();?>
                    </div>

                    
                    <div class="col-md-6">
                             <?php echo form_open();?>
                                <input type="text" name="approved" class="hidden"value="false">

                                <button type="submit" class="btn btn-danger">Reject Submission</button>
                            <?php echo form_close();?>
                    </div>
                
                </div>
                    

        </div>
        </div>

      

    </div>

  <?php else: echo "No Users Registered"; endif;?>



</div>

</div>

</section>
