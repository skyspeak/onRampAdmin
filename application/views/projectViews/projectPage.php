<?php /* This is the edit page for individual projects*/?>

<div class="row">

    <div class="col-md-12">
      <?php if(isset($uploadInfo)):?>
      <!--If the image is uploaded  -->
          <div <?php echo ($uploadInfo['success'])?  'class="form-error alert-success"': 'class="form-error alert-danger"'?>>

          <?php echo $uploadInfo['msg']?>

          </div>
      <?php endif ?>

      <?php if(isset($partCreated)):?>
      <!--If the infor is uploaded  -->
          <div <?php echo ($partCreated['success'])?  'class="form-error alert-success"': 'class="form-error alert-danger"'?>>

          <?php echo $partCreated['msg']?>

          </div>
      <?php endif ?>

      <?php if(isset($updateStatus)):?>
      <!--If the infor is uploaded  -->
          <div <?php echo ($updateStatus['success'])?  'class="form-error alert-success"': 'class="form-error alert-danger"'?>>

          <?php echo $updateStatus['msg']?>

          </div>
      <?php endif ?>

      <?php if(validation_errors()):?>
            <div class="form-error alert-danger"><?php echo validation_errors();?></div>
            <?php endif?>
    </div>

</div>

<div class="row">

<div class="col-md-8">
<!--Edit Project Section  -->
<section id="editProjectSection">
<?php echo form_open("admin/projects/edit/" . $projectInfoData['project_id']);?>

<div class="well well-lg editProject">
<div class="row">
<div class="col-md-6">
  <div class="form-group">
    <label for="projectname">Project Name:</label>
    <input type="text" class="form-control" value="<?php echo $projectInfoData['project_name']?>"name="name" id="projectName">
  </div>
</div>
<div class="col-md-6">
 <div class="form-group">
    <label for="fields">Field:</label>
    
    <select name="fields" id="fields" class="form-control">
        <?php foreach ($projectFields as $field):?>
             <option <?php /*select the already entered*/ echo($projectInfoData['project_fields'] == $field['field_name'])? "selected":""?> value="<?php echo $field['field_id']?>"><?php echo $field['field_name']?></option>        
        <?php endforeach;?>
   </select>
  </div>
</div>
</div>
<div class="row">
<div class="col-md-6">  <div class="form-group">
    <label for="timeline">Timeline:</label>
    <input type="timeline" class="form-control" value="<?php echo $projectInfoData['project_timeline']?>"id="timeline" name="timeline">
  </div></div>
<div class="col-md-6">
  <div class="form-group">
    <label for="location">Location:</label>
    <input type="timeline" class="form-control" id="location" value="<?php echo $projectInfoData['project_location']?>" name="location">
  </div>
</div>
</div>
<div class="row">
    <div class="col-md-12">
   
     <div class="form-group">
    <label for="">Desciption:</label>
    <textarea class="form-control" id="textarea-editor" name="description"><?php echo  $projectInfoData['project_description'];?></textarea>
  </div>
    </div>
</div>
<div class="row">
<div class="col-md-12">
<button type="submit" class="btn btn-default pull-right">Update Project</button>

</div>
  
</div>

<?php echo form_close();?>

</section>

</div>

<!--Upload cover image  -->

<div class="col-md-4">

<section id="imageUpload">

<div class="well well-lg">
<?php echo form_open_multipart("admin/projects/projectimage/" . $projectInfoData['project_id']);?>

    <div class="row">
      <div class="col-md-12">
          <div class="form-group">
        <label for="imgInp">Update Image</label>
        <div class="project-thumbnail">
          <img src="<?php echo $projectInfoData['project_thumb']; ?>" class="thumbnail img-responsive" alt="<?php echo $projectInfoData['project_name'];?>">
          <!-- <img src="<?php echo base_url("data/thumbs/" . $projectInfoData['project_thumb']); ?>" class="thumbnail img-responsive" alt="<?php echo $projectInfoData['project_name'];?>"> -->
        </div>
        <div class="input-group">
            <span class="input-group-btn">
                <span class="btn  btn-file">
                  <input type="file" name="userfile" class="form-control"id="imgInp">
                </span>
            </span>
 
        </div>
        
    </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
          <button type="submit" class="btn btn-default pull-right">Update Project</button>
      </div>
    </div>

</div>

<?php echo form_close();?>

</section>
</div>

<!-- end of upload cover image  -->

</div>


<!-- Start of Part Listing  -->
<section class="well well-lg" id="partListing">
<div class="row">


<!-- This is there the add form comes  -->
<div class="col-md-12">
  <h1>Project Parts</h1><span class="addParts">(<a href="<?php echo base_url("admin/projects/parts/create/" . $projectInfoData['project_id'])?>">Add Parts</a>)</span>
</div>

<!--This is where the listing comes  -->
<div class="col-md-12">

  <?php if(isset($projectParts)):?>

    <table class="table  table-bordered">
      <tr>
          <th>Part Name</th>
          <th>Number of Reading List</th>
          <th>Number of Tasks</th>
          <th></th>
      </tr>

      <?php foreach($projectParts['partData'] as $part):?>
          
          <!--This where all the loop detail comes in  -->
           <tr>
          <td><?php echo $part['part_name']?></td>
          <td><?php echo count($part['readingList']);?></td>
          <td><?php echo count($part['taskList']);?></td>
          <td><a href="<?php echo base_url("admin/projects/parts/edit/".$projectInfoData['project_id'] . "/" . $part['part_id']); ?>">edit</a></td>

      </tr>
          
      <?php endforeach;?>

    </table>

  <?php else: echo "No Parts Added"; endif;?>



</div>

</div>

</section>