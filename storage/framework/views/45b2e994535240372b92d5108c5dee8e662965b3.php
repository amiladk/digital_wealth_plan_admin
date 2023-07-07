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

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body p-4">
                <form method='post' action="<?php echo e(url('/action/user-edit')); ?>" id="user-edit-form">
                <?php echo csrf_field(); ?>
                    <input type="hidden" class="form-control" name="id" id="id" value="<?php echo e($selected_user->id); ?>">
                    <div class="mb-3 form-group">
                        <label class="form-label" for="name">Full Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Full Name" value="<?php echo e($selected_user->name); ?>">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label" for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address" value="<?php echo e($selected_user->address); ?>">
                    </div>
                    <div class="row"> 
                        <div class="col-md-12">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="user_role">User Role</label>
                                <select class="form-select" id="user_role" name="user_role">
                                    <option value="">Select</option>
                                    <?php $__currentLoopData = $user_role; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option <?php if($selected_user->user_role == $data->id){ echo 'selected'; } ?> value="<?php echo e($data->id); ?>"><?php echo e($data->user_role); ?></option>  
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">  
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="nic">NIC</label>
                                <input type="text" class="form-control" id="nic" name="nic" placeholder="Enter NIC" value="<?php echo e($selected_user->nic); ?>">
                            </div>
                        </div>                                                          
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your Email" value="<?php echo e($selected_user->email); ?>">
                            </div>
                        </div>
                    </div>  
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="change_login_details" name="change_login_details">
                            <label class="form-check-label" for="change_login_details">Change Password</label>
                        </div>
                    </div>
                    <div class="row" id="disableDiv">                                                            
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" class="form-control" id="password" disabled name="password" placeholder="Enter your password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="password_confirmation">Re Enter Password</label>
                                <input type="password" class="form-control" id="password_confirmation" disabled name="password_confirmation" placeholder="Re enter your password">
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-dark w-md">Submit</button>
                    </div>
                </form>
            </div>
        </div>    
    </div>
</div>

<!-- End Form Layout --><?php /**PATH C:\wamp64\www\lemaconet_admin\resources\views/user_edit.blade.php ENDPATH**/ ?>