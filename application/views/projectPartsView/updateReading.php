
<div class="row">

    <div class="col-md-6 col-md-offset-3">

           <?php if(validation_errors()):?>
            <div class="form-error alert-danger"><?php echo validation_errors();?></div>
            <?php endif?>
        <?php if(isset($updateError)):?>
               
        <div <?php echo ($updateError['success'])?  'class="form-error alert-success"': 'class="form-error alert-danger"'?>><?php echo $updateError['msg']?></div>

        <?php endif;?>

        <?php echo form_open("admin/projects/parts/update/". $project_id ."/".$part_id."/". $reading_id ."/".$post_type ,'class="well well-lg"');?>
  <div class="form-group">
    <label for="link">Link:</label>
    <input type="text" class="form-control" name="readingList_link" id="link" value="<?php echo $readingDetails['readingList_link'];?>">
  </div>
  <div class="form-group">
    <label for="name">Anchor Text:</label>
    <input type="text"  class="form-control" id="name" name="readingList_name" value="<?php echo $readingDetails['readingList_name'];?>">
  </div>

  <button type="submit" class="btn btn-default btn-block">Update</button>
<?php echo form_close();?>

    </div>



</div>