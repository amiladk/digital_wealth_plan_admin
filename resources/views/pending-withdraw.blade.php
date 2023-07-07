
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0 font-size-18 header">{{ $title }}</h4>

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
                    <table id="pending-withdrawls" class="table table-bordered dt-responsive nowrap w-100">
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
                            <th>Status</th>
                            <th>Approved Date</th>
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
