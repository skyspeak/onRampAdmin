<div class="row">

<!-- Section Containing Project Details and Updates -->
<div class="col-md-12">
            <!-- Result Displays  -->
             <?php if(validation_errors()):?>
            <div class="form-error alert-danger"><?php echo validation_errors();?></div>
            <?php endif?>

            <?php if(isset($editPart)):?>
                <!-- Edit Response  -->
                    <div <?php echo ($editPart['success'])?  'class="form-error alert-success"': 'class="form-error alert-danger"'?>>

            <?php echo $editPart['msg']?>

          </div>
      <?php endif ?>
  
    <div class="row">
    
    <!-- Part Edit Form  -->
    <div class="col-md-8">

        <section class="well well-lg">

            <div class="row">
                <h2>Edit Part</h2>
                <?php echo form_open("/admin/projects/parts/edit/" . $project_id."/".$part_id);?>
                <div class="col-md-12">
                
                <div class="form-group">
                    <label for="partName">Part Name:</label>
                    <input type="text" class="form-control" name="part_name" value="<?php echo $partDetails['partData']['part_name'];?>" id="projectName">
                </div>

                
                <div class="form-group">
                    <label for="textarea-editor">Part Description:</label>
                    <textarea type="text" class="form-control" name="part_description" id="textarea-editor"><?php echo $partDetails['partData']['part_description'];?></textarea>
                </div>
                
                </div>

                <div class="col-md-12">
                    <button type="submit" class="btn btn-default pull-right">Update Project</button>
                </div>
                <?php echo form_close(); ?>
        
            </div>

        </section>
        
    </div>

    
    <!-- Summary Listing -->
    <div class="col-md-4">

            <section class="well well-lg">
                <div class="row">
                    <div class="col-md-12">
                        <h2>Summary</h2>
                        <ul class="list-group">
                        <li class="list-group-item">Reading List : <?php echo count($partDetails['readingList']);?> </li>
                        <li class="list-group-item">Task List : <?php echo count($partDetails['taskList']);?> </li>
                        <li class="list-group-item">( Delete )</li>
                        </ul>
                    </div>
                </div>
            </section>
    
    
    </div>
    
    </div>


</div>


</div>

<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
        <!--Reading List  -->

        
        <section class="well well-lg" id="partListing">
            <div class="row">


            <!-- This is there the add form comes  -->
            <div class="col-md-12">

            <h1>Add Reading List</h1><span class="addParts">(<a href="<?php echo base_url("admin/projects/parts/add/" . $project_id."/".$part_id."/reading") ?>">Add</a>)</span>
            </div>

            <!--This is where the listing comes  -->
            <div class="col-md-12">

            <?php if(isset($partDetails['readingList']) && count($partDetails['readingList'])>0):?>

                <table class="table  table-bordered">
                <tr>
                    <th>Reading List Name</th>
                    <th></th>
                </tr>

                <?php foreach($partDetails['readingList'] as $reading):?>
                    
                    <!--This where all the loop detail comes in  -->
                    <tr>
                    <td><?php echo $reading['readingList_name']?></td>

                      <td><a href="<?php echo base_url("admin/projects/parts/update/" . $project_id."/".$part_id."/" .$reading['readingList_id'] . "/reading") ?>">edit</a></td>  

                    </tr>
                    
                        <?php endforeach;?>

                    </table>

                    <?php else: echo "No Reading List Added"; endif;?>



            </div>

            </div>

            </section>



        </div>

        <div class="col-md-6">

        <!-- Task List  -->

            <section class="well well-lg" id="partListing">
            <div class="row">


            <!-- This is there the add form comes  -->
            <div class="col-md-12">

            <h1>Add Task</h1><span class="addParts">(<a href="<?php echo base_url("admin/projects/parts/add/" . $project_id."/".$part_id."/task") ?>">Add</a>)</span>
            </div>

            <!--This is where the listing comes  -->
            <div class="col-md-12">

            <?php if(isset($partDetails['taskList']) && count($partDetails['taskList'])>0):?>

                <table class="table  table-bordered">
                <tr>
                    <th>Task List Name</th>
                    <th></th>
                </tr>

                <?php foreach($partDetails['taskList'] as $task):?>
                    
                    <!--This where all the loop detail comes in  -->
                    <tr>
                    <td><?php echo $task['task_name']?></td>

                     <td><a href="<?php echo base_url("admin/projects/parts/update/" . $project_id."/".$part_id."/" .$task['task_id'] . "/task") ?>">edit</a></td> 

                    </tr>
                    
                        <?php endforeach;?>

                    </table>

                    <?php else: echo "No Task Added"; endif;?>



            </div>

            </div>

            </section>
        </div>

    </div>

</div>