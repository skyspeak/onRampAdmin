
<div class="row">

    <div class="col-md-6 col-md-offset-3">

           <?php if(validation_errors()):?>
            <div class="form-error alert-danger"><?php echo validation_errors();?></div>
            <?php endif?>
        <?php if(isset($status) && !empty($status)):?>
               
        <div <?php echo ($updateError['success'])?  'class="form-error alert-success"': 'class="form-error alert-danger"'?>><?php echo $updateError['msg']?></div>

        <?php endif;?>

        <?php echo form_open("admin/category/create" ,'class="well well-lg"');?>
  <div class="form-group">
    <label for="name">Category Title:</label>
    <input type="text" class="form-control" name="name" id="name">
  </div>


  <button type="submit" class="btn btn-default btn-block">Update</button>
<?php echo form_close();?>

    </div>



</div>