
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


    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="mb-3">
                    <a type="button" href="/pending-withdraw/0" class="btn btn-info waves-effect waves-light">Pending</a>
                    <a type="button" href="/pending-withdraw/1" class="btn btn-success waves-effect waves-light">Approved</a>
                    <a type="button" href="/pending-withdraw/2" class="btn btn-danger waves-effect waves-light">Disapproved</a>
                </div>

                <div class="card-body">
                    <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Client ID</th>
                            <th>Client Name</th>
                            <th>Available Balance ($)</th>
                            <th>Withdraw Amount ($)</th>
                            
                            <th>Receivable Amount ($)</th>
                            <th>Currency Type</th>
                            <th>Crypto Network</th>
                            <th>Wallet Address</th>
                            <th>Actions</th>
                        </tr>
                        </thead>


                        <tbody>
                            <?php $__currentLoopData = $pending_withdraws; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $withdraw_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($withdraw_data->created_at); ?></td>
                                    <td><?php echo e($withdraw_data->getClient->membership_no); ?></td>
                                    <td><?php echo e($withdraw_data->getClient->first_name); ?> <?php echo e($withdraw_data->getClient->last_name); ?></td>
                                    <td class="rigth-aligment"><?php echo number_format( $withdraw_data->getClient->wallet, 2, '.', ',');?></td>
                                    <td class="rigth-aligment"><?php echo number_format( $withdraw_data->withdraw_amount, 2, '.', ',');?></td>
                                    
                                    <td class="rigth-aligment"><?php echo number_format( $withdraw_data->recieving_amount, 2, '.', ',');?></td>
                                    <td class="rigth-aligment"> <?php echo e(isset($withdraw_data->currencyType) ? $withdraw_data->currencyType->title : ''); ?> </td>
                                    <td class="rigth-aligment"> <?php echo e(isset($withdraw_data->cyptoNetwork) ? $withdraw_data->cyptoNetwork->title : ''); ?> </td>
                                    <td class="rigth-aligment"> <?php echo e($withdraw_data->wallet_address); ?> </td>
                                    <td>
                                        <?php if($withdraw_data->status == 0): ?>
                                            <button type="button" class="btn btn-success btn-sm actionBtn_<?php echo e($withdraw_data->id); ?>" onclick="approvewithdraw(<?php echo e($withdraw_data->id); ?>)">Approve</button>
                                            <button type="button" class="btn btn-danger btn-sm actionBtn_<?php echo e($withdraw_data->id); ?>" onclick="disapproveWithdraw(<?php echo e($withdraw_data->id); ?>)">Disapprove</button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            </div> 
    </div> 
</div> 
</div>
<?php /**PATH C:\wamp64\www\lemaconet_admin\resources\views/pending-withdraw.blade.php ENDPATH**/ ?>