
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
                                        <a type="button" href="/pending-purchases/0" class="btn btn-info waves-effect waves-light">Pending</a>
                                        <a type="button" href="/pending-purchases/1" class="btn btn-success waves-effect waves-light">Approved</a>
                                        <a type="button" href="/pending-purchases/2" class="btn btn-danger waves-effect waves-light">Disapproved</a>
                                    </div>

                                    <div class="card-body">
                                        <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Client ID</th>
                                                <th>Client Name</th>
                                                <th>Available Balance ($)</th>
                                                <th>Purchase Amount ($)</th>
                                                
                                                <th>Funding Payment Method</th>
                                                <th>Trading Amount</th>
                                                <th>Type</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
        
        
                                            <tbody>
                                                <?php $__currentLoopData = $funding_payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=> $funding): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td><?php echo e($funding->created_at); ?></td>
                                                        <td><?php echo e($funding->getClient->membership_no); ?></td>
                                                        <td><?php echo e($funding->getClient->first_name); ?></td>
                                                        <td class="rigth-aligment"><?php echo number_format( $funding->getClient->wallet, 2, '.', ',');?></td>
                                                        <td class="rigth-aligment"><?php echo number_format( $funding->funding_amount, 2, '.', ',');?></td>
                                                        
                                                        <td><?php echo e($funding->getFundingPaymentMethod->title); ?></td>
                                                        <td class="rigth-aligment"><?php echo number_format( $funding->trading_amount, 2, '.', ',');?></td>
                                                        <td><?php echo e($funding->fundingTypeName()); ?></td>
                                                        <td>
                                                            <?php if($funding->status == 0): ?>
                                                                <button type="button" class="btn btn-info waves-effect waves-light btn-sm actionBtn_<?php echo e($funding->id); ?>" data-bs-toggle="modal" data-bs-target="#fundingModal" onclick="showPurchaseModal(<?php echo e($key); ?>)">View</button>
                                                                <button type="button" class="btn btn-success btn-sm actionBtn_<?php echo e($funding->id); ?>" onclick="approveFundingPurchase(<?php echo e($funding->id); ?>)">Approve</button>
                                                                <button type="button" class="btn btn-danger btn-sm actionBtn_<?php echo e($funding->id); ?>" onclick="disapprovePurchase(<?php echo e($funding->id); ?>)">Disapprove</button>
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
 
<div class="modal fade bs-example-modal-center" id="fundingModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Pending KYC</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div id="proof_image"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
    var funding_payments   = <?php echo json_encode($funding_payments); ?>;
</script><?php /**PATH C:\wamp64\www\lemaconet_admin\resources\views/pending-purchases.blade.php ENDPATH**/ ?>