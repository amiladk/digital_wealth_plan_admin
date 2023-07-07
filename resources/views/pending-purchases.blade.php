
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4  class="mb-sm-0 font-size-18 header">{{ $title }}</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                                            <li class="breadcrumb-item active header">{{ $title }}</li>
                                        </ol>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="card">

                                    <div class="mb-3">
                                        <a id="pending" type="button"  class="btn btn-info waves-effect waves-light">Pending</a>
                                        <a id="approved" type="button"  class="btn btn-success waves-effect waves-light">Approved</a>
                                        <a id="disapproved" type="button"  class="btn btn-danger waves-effect waves-light">Disapproved</a>
                                    </div>

                                    <div class="card-body">
                                        <table id="purchases" class="table table-bordered dt-responsive nowrap w-100">
                                            <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Client ID</th>
                                                <th>Client Name</th>
                                                <th>Available Balance ($)</th>
                                                <th>Purchase Amount ($)</th>
                                                {{-- <th>Service Charge</th>
                                                <th>Network Gas Fee</th> --}}
                                                <th>Funding Payment Method</th>
                                                <th>Trading Amount</th>
                                                <th>Type</th>
                                                <th>Status</th>
                                                <th id="approved-date">Approved Date</th>
                                                <th>Approved By</th>
                                                <th>Actions</th>
                                            </tr>
                                            </thead>
        
        
                                            <tbody>
                                                
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
                <h5 class="modal-title">View Funding</h5>
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


