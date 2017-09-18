
<div class="row">

    <div class="col-md-6 col-md-offset-3">

           <?php if(validation_errors()):?>
            <div class="form-error alert-danger"><?php echo validation_errors();?></div>
            <?php endif?>
        <?php if(isset($createError)):?>
               
        <div class="form-error alert-danger"><?php $createError['msg']?></div>

        <?php endif;?>

        <?php echo form_open("admin/projects/parts/create/" . $project_id,'class="well well-lg"');?>
  <div class="form-group">
    <label for="part_name">Part Title:</label>
    <input type="text" class="form-control" name="part_name" id="name">
  </div>
  <div class="form-group">
    <label for="textarea-editor">Description:</label>
    <textarea class="form-control" id="textarea-editor" name="part_description"></textarea>
  </div>

  <button type="submit" class="btn btn-default btn-block">Create</button>
<?php echo form_close();?>

    </div>



</div>