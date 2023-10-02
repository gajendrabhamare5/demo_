<?php
$this->load->view('admin/header');
?>

<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Categories</h1>
            </div><!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo base_url().'admin/category/index';?>">Categories</a></li>
                    <li class="breadcrumb-item active">Edit Category</li>
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <div class="card-title">
                            Edit Category "<?php echo $category['name']?>"

                        </div>

                    </div>
                    <div class="card-body">
                        <form action="<?php echo base_url() . 'admin/category/edit/'.$category['id']; ?>" name="categoryForm" id="categoryForm" method="post" enctype="multipart/form-data">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" id="name" value="<?php echo set_value('name',$category['name']);?>" class="form-control <?php echo (form_error('name') != "") ? 'is-invalid' : '';?>">
                                    <?php echo form_error('name');
                                    ?>
                                </div>

                                <div class="form-group">
                                    <label>Image</label> <br>
                                    <input type="file" name="image" id="image" class="<?php echo (!empty($errorImageUpload)) ? 'is-invalid' : '';?>"><br>
                                    <?php echo (!empty($errorImageUpload)) ? $errorImageUpload : '';?>
                                    <?php if($category['image'] != ""){?>
                                        <img width="25%" height="25%" class="mt-3" src="<?php echo base_url().'public/uploads/category/'.$category['image']?>" alt="<?php echo $category['name'] ?>">
                                        <?php }else{
                                            echo $category['name'];
                                            } ?>
                                </div>

                                <div class="custom-control custom-radio float-left">
                                    <input class="custom-control-input" value="1" type="radio" id="statusActive" name="status" <?php echo ($category['status'] == 1) ? 'checked' : '';?>>
                                    <label for="statusActive" class="custom-control-label">Active</label>
                                </div>

                                <div class="custom-control custom-radio float-left ml-3">
                                    <input class="custom-control-input" value="0" type="radio" id="statusBlock" name="status" <?php echo ($category['status'] == 0) ? 'checked' : '';?>>
                                    <label for="statusBlock" class="custom-control-label">Block</label>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button name="submit" type="submit" class="btn btn-primary">Submit </button>
                                <a href="<?php echo base_url().'admin/category/index';?>" class="btn btn-secondary">Back</a>
                            </div>
                        </form>
                    </div>

                </div>

            </div>


            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<!-- /.content -->
</div>
<?php
$this->load->view('admin/footer');
?>