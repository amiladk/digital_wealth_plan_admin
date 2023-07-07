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
                <form method='post' action="<?php echo e(url('/action/transaction-setting-edit')); ?>" id="transaction-setting-edit-form">
                <?php echo csrf_field(); ?>
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle table-settings">
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Value</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $transaction_settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($data->description); ?></td>
                                        <td>
                                            <input type="hidden" class="form-control" name="id[]" id="id" value="<?php echo e($data->id); ?>">
                                            <input type="text"class="form-control" name="value[]" id="value" value="<?php echo e($data->value); ?>">
                                        </td>
                                        
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-dark w-md">Submit</button>
                    </div>
                </form>
            </div>
        </div>  
    </div>
</div>

<!-- End Form Layout --><?php /**PATH C:\wamp64\www\lemaconet_admin\resources\views/transaction-settings.blade.php ENDPATH**/ ?>