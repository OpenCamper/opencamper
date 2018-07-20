<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-body">
                <div class="col-md-6">
                    <h4><i class="fa fa-pencil"></i> &nbsp; Edit Configuration</h4>
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
                    <?php if (isset($msg) || validation_errors() !== ''): ?>
                        <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                            <?= validation_errors(); ?>
                            <?= isset($msg) ? $msg : ''; ?>
                        </div>
                    <?php endif; ?>

                    <?php echo form_open(base_url('admin/configuration/'), 'class="form-horizontal" id="editor"'); ?>
                        <input type="hidden" id="hiddeninput" name="hiddeninput" />
                    <?php echo form_close(); ?>
                    <div id="res" class="alert"></div>

                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>
</section>

<script type="text/javascript" src="<?= base_url() ?>public/plugins/jsonform/deps/underscore.js"></script>
<script type="text/javascript" src="<?= base_url() ?>public/plugins/jsonform/deps/opt/jsv.js"></script>
<script type="text/javascript" src="<?= base_url() ?>public/plugins/jsonform/lib/jsonform.js"></script>
<script type="text/javascript">
    $('#editor').jsonForm({
        "schema": <?=$json_schema?>,
        "value": <?=$json_string?>,
        "form": [
            "*",
            {
                "type": "submit",
                "title": "Save",
                "activeClass": "btn-success",
            }
        ],
        onSubmit: function (errors, values) {
            if (errors) {
                $('#res').html('<p>Errors in Form</p>');
            } else {
                $('#hiddeninput').val(JSON.stringify(values, null, 2));
                $.submit();
            }
        }
    });
</script>