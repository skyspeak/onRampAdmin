
<div class="row">

    <div class="col-md-6 col-md-offset-3">

            <?php if(validation_errors()):?>
            <div class="form-error alert-danger"><?php echo validation_errors();?></div>
            <?php endif?>
        <?php if(isset($updateError)):?>
               
        <div <?php echo ($updateError['success'])?  'class="form-error alert-success"': 'class="form-error alert-danger"'?>><?php echo $updateError['msg']?></div>

        <?php endif;?>

        <?php echo form_open("admin/projects/parts/update/". $project_id ."/".$part_id."/".$task_id ."/". $post_type ,'class="well well-lg"');?>
  <div class="form-group">
    <label for="task_name">Task Name:</label>
    <input type="text" class="form-control" name="task_name" id="name" value="<?php echo $taskDetails['task_name'];?>">
  </div>
  <div class="form-group">
    <label for="details">Task Details:</label>
    <textarea class="form-control" id="textarea-editor" name="textarea-editor"><?php echo $taskDetails['task_details'];?></textarea>
  </div>

  <button type="submit" class="btn btn-default btn-block">Update</button>
<?php echo form_close();?>

    </div>



</div>