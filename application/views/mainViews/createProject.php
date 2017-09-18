<div class="row">

    <div class="col-md-6 col-md-offset-3">
         <?php if(validation_errors()):?>
            <div class="form-error alert-danger"><?php echo validation_errors();?></div>
            <?php endif?>
        <?php echo form_open("admin/projects/create",'class="well well-lg"');?>
        <h3>Create Project</h3>
  <div class="form-group">
    <label for="projectname">Project Name:</label>
    <input type="text" class="form-control" name="name" id="projectName">
  </div>
  <div class="form-group">
    <label for="timeline">Timeline:</label>
    <input type="timeline" class="form-control" id="timeline" name="timeline">
  </div>
 <div class="form-group">
    <label for="fields">Field:</label>
    
    <select name="fields" id="fields" class="form-control">
        <?php foreach ($projectFields as $field):?>
             <option value="<?php echo $field['field_id']?>"><?php echo $field['field_name']?></option>        
        <?php endforeach;?>
   </select>
  </div>
  <div class="form-group">
    <label for="location">Location:</label>
    <input type="timeline" class="form-control" id="location" name="location">
  </div>
  <button type="submit" class="btn btn-default btn-block">Create</button>
<?php echo form_close();?>

    </div>



</div>