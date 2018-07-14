<section class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="box box-body with-border">
        <div class="col-md-6">
          <h4><i class="fa fa-plus"></i> &nbsp; Add New Group</h4>
        </div>
        <div class="col-md-6 text-right">
          <a href="<?= base_url('admin/group'); ?>" class="btn btn-success"><i class="fa fa-list"></i> Group List</a>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="box border-top-solid">
        <!-- /.box-header -->
        <!-- form start -->
        <div class="box-body my-form-body">
          <?php if(isset($msg) || validation_errors() !== ''): ?>
              <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                  <?= validation_errors();?>
                  <?= isset($msg)? $msg: ''; ?>
              </div>
            <?php endif; ?>
           
            <?php echo form_open(base_url('admin/group/add'), 'class="form-horizontal"');  ?> 
              <div class="form-group">
                <label for="group_name" class="col-sm-2 control-label">Group Name</label>

                <div class="col-sm-9">
                  <input type="text" name="group_name" class="form-control" id="group_name" placeholder="">
                </div>
              </div>
           
              <div class="form-group">
                <div class="col-md-11">
                  <input type="submit" name="submit" value="Add Group" class="btn btn-info pull-right">
                </div>
              </div>
            <?php echo form_close( ); ?>
          </div>
          <!-- /.box-body -->
      </div>
    </div>
  </div>  

</section> 


<script>
  $("#users").addClass('active');
  $("#user_group").addClass('active');
  </script>