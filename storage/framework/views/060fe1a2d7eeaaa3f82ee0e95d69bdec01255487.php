
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18 header"><?php echo e($title); ?></h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active header"><?php echo e($title); ?></li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                    <div class="mb-3">
                                        <a id="pending" type="button"  class="btn btn-info waves-effect waves-light">Pending</a>
                                        <a id="approved" type="button"  class="btn btn-success waves-effect waves-light">Approved</a>
                                        <a id="disapproved" type="button"  class="btn btn-danger waves-effect waves-light">Disapproved</a>
                                    </div>

                                        <table id="pending-kyc" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Client ID</th>
                                                <th>Client Name</th>
                                                <th>Status</th>
                                                <th>Approved Date</th>
                                                <th>Approved By</th>
                                                <th>Actions</th>
                                                
                                            </tr>
                                            </thead>
        
        
                                            <tbody>
                                                
                                            </tbody>
                                        </table>

                                        
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                             </div> 
                        </div> 
                    </div> 
                </div>


                
<div class="modal fade bs-example-modal-center" id="kycModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">View Pending KYC</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <dl class="row mb-1">
                        <dt class="col-sm-3">Name:</dt>
                        <dd class="col-sm-9" id="kyc_name"></dd>
                    </dl>
                    <dl class="row mb-1">
                        <dt class="col-sm-3">Email:</dt>
                        <dd class="col-sm-9" id="kyc_email"></dd>
                    </dl>
                    <dl class="row mb-1">
                        <dt class="col-sm-3">Phone Number: </dt>
                        <dd class="col-sm-9" id="kyc_number"></dd>
                    </dl>
                    <dl class="row mb-1">
                        <dt class="col-sm-3">Address: </dt>
                        <dd class="col-sm-9" id="kyc_address"></dd>
                    </dl>
                    <dl class="row mb-1">
                        <dt class="col-sm-3">Country: </dt>
                        <dd class="col-sm-9" id="kyc_country"></dd>
                    </dl>
                    <dl class="row mb-3">
                        <dt class="col-sm-12">Verification Document</dt>
                    </dl>
                    <div class="row" id="proof_image">
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


  


<?php /**PATH C:\Pradeep\bitbucket\lemaconet_admin\resources\views/pending-kyc.blade.php ENDPATH**/ ?>