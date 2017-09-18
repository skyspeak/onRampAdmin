<div class="row">
    
    <div class="col-md-6 col-md-offset-3">
       <?php if(validation_errors()):?>
       <div class="form-error alert-danger"><?php echo validation_errors();?></div>
        <?php endif?>
             <?php if(isset($registerStatus)):?>
      <!--If the register error is uploaded  -->
          <div <?php echo ($registerStatus['success'])?  'class="form-error alert-success"': 'class="form-error alert-danger"'?>>

          <?php echo $registerStatus['msg']?>

          </div>
      <?php endif ?>

            <?php if(isset($loginStatus)):?>
      <!--If the infor is uploaded  -->
          <div <?php echo ($loginStatus['success'])?  'class="form-error alert-success"': 'class="form-error alert-danger"'?>>

          <?php echo $loginStatus['msg']?>

          </div>
      <?php endif ?>


        <?php echo form_open("admin/login",'class="well well-lg"');?>
  <div class="form-group">
    <label for="email">Email:</label>
    <input type="email" class="form-control" name="email" id="email">
  </div>
  <div class="form-group">
    <label for="password">Password:</label>
    <input type="password" class="form-control" id="password" name="password">
  </div>

  <button type="submit" class="btn btn-default btn-block">Login</button>
<?php echo form_close();?>

    </div>



</div>