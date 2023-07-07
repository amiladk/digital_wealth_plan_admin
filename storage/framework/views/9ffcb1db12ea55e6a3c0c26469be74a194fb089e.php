<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18"><?php echo e($title); ?></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active"><?php echo e($title); ?></li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
        <!-- start Form section   -->
        <div class="col-12">
        <div class="card">
            
            <div class="card-body p-4">
            <form method='post' action="<?php echo e(url('/action/edit-user-role')); ?>" id="group-create-form">
                <?php echo csrf_field(); ?>
                <div class="row">
                    <div class="col-lg-6">
                        <div>
                            <div class="mb-3">
                                <label for="example-text-input" class="form-label">Role Name*</label>
                                <input class="form-control" type="text" name="role_name" value="<?php echo e($user_role->user_role); ?>" id="example-text-input">
                                <input type="hidden" type="text" name="role_id" value="<?php echo e($user_role->id); ?>" >
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mt-3 mt-lg-0">
                            <div class="mb-3">
                                <label for="example-text-input" class="form-label">Description</label>
                                <input class="form-control" type="text" name="description" value="<?php echo e($user_role->description); ?>" id="example-text-input">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end Form section   -->
    <!-- start table section -->
    
<div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-0" id="user-role">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Modules</th>
                            <th>Select All</th>
                            <th>Specific Permission</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $__currentLoopData = getAllPermissions(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <th scope="row"><?php echo e($key+1); ?></th>
                            <td><?php echo e($item['group']); ?></td>
                            <td> <input  type="checkbox" class="select-all" value="" onclick="selectAll(this)" >
                                <label class="form-check-label" for="flexCheckDefault">
                                    Select All
                                </label>
                            </td>
                            <td class="cheack-all">
                                <?php $__currentLoopData = $item['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              
                                <input class="form-check-input" type="checkbox" name="permission[]" value="<?php echo e($data['permission']); ?>" id="flexCheckDefault" <?php if(in_array($data['permission'], json_decode($user_permission))){ echo 'checked'; } ?>>
                                <label >
                                    <?php echo e($data['title']); ?>

                                </label>
                                <br>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>

            </div>
        </div>
                <div class="mt-4">
                <button type="submit" class="btn btn-dark w-md">Submit</button>
                </div>
    <!-- end card body -->
    </div>
    <!-- end card -->
</div>
<!-- end table section -->
</form>
<!-- end card body -->

</div><?php /**PATH C:\Pradeep\bitbucket\lemaconet_admin\resources\views/user_role_edit.blade.php ENDPATH**/ ?>