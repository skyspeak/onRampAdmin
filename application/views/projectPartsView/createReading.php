
<div class="row">

    <div class="col-md-6 col-md-offset-3">

            <?php if(validation_errors()):?>
            <div class="form-error alert-danger"><?php echo validation_errors();?></div>
            <?php endif?>
        <?php if(isset($createError)):?>
               
        <div class="form-error alert-danger"><?php $createError['msg']?></div>

        <?php endif;?>

        <?php echo form_open("admin/projects/parts/add/". $project_id ."/".$part_id."/". $post_type ,'class="well well-lg"');?>
  <div class="form-group">
    <label for="link">Link:</label>
    <input type="text" class="form-control" name="readingList_link" id="link">
  </div>
  <div class="form-group">
    <label for="name">Anchor Text:</label>
    <input type="text"  class="form-control" id="name" name="readingList_name">
  </div>

  <button type="submit" class="btn btn-default btn-block">Create</button>
<?php echo form_close();?>

    </div>



</div>