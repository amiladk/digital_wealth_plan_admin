<div class="row col-md-6">
    <div class="mb-3">
        <label class="form-label">Date Range</label>
        <input type="text" class="form-control flatpickr-input" id="datepicker-range" value="" name="dater_ange">
    </div>
    

</div>
    <div class="row">
        <div class="col-xl-3 col-lg-4 col-md-6">
            <!-- card -->
            <div class="card border border-success card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">User Count</span>
                            <!-- <h4 class="mb-3">
                                <span class="counter-value">{{$total_users}}</span>
                            </h4> -->
                            <!-- <h4 class="mb-3" id = "daily_rewards">{{$total_users}}</h4> -->
                            <h3 class="mb-3" id = "total-users">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div> 
                            </h3>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->  
        <div class="col-xl-3 col-lg-4 col-md-6">
            <!-- card -->
            <div class="card border border-success card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Initial Funds Count</span>
                            <h4 class="mb-3" id="total-initial-funds">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->  
        <div class="col-xl-3 col-lg-4 col-md-6">
            <!-- card -->
            <div class="card border border-success card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Top-Ups Count</span>
                            <h4 class="mb-3" id="total-top-ups">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->  
        <div class="col-xl-3 col-lg-4 col-md-6">
            <!-- card -->
            <div class="card border border-primary card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <span class="text-muted mb-3 lh-1 d-block">Balance Funds to Trading </span>
                            <h4 class="mb-3" id="total-balance-funds">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </h4>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col --> 
        <div class="col-xl-3 col-lg-4 col-md-6">
            <!-- card -->
            <div class="card border border-primary card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <span class="text-muted mb-3 lh-1 d-block text-truncate">Initial Funds Up To Date</span>
                            <h4 class="mb-3" id="total-initial-funds-upto-date">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </h4>
                            <div class= row>
                                 <p>By Crypto : <span class="col-12" id="total-initial-funds-upto-date-by-crypto"></span></p>
                                 <p>By Wallet : <span class="col-12" id="total-initial-funds-upto-date-by-wallet"></span></p>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->  

        <div class="col-xl-3 col-lg-4 col-md-6">
            <!-- card -->
            <div class="card border border-primary card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <span class="text-muted mb-3 lh-1 d-block">Top-Up Funds Up To Date </span>
                            <h4 class="mb-3" id="total-top-up-funds-upto-date">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </h4>
                            <div class= row>
                                 <p>By Crypto : <span class="col-12" id="total-top-up-funds-upto-date-by-crypto"></span></p>
                                 <p>By Wallet : <span class="col-12" id="total-top-up-funds-upto-date-by-wallet"></span></p>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

  

        <div class="col-xl-3 col-lg-4 col-md-6">
            <!-- card -->
            <div class="card border border-primary card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <span class="text-muted mb-3 lh-1 d-block">Initial Funds Service Charges Up To Date </span>
                            <h4 class="mb-3" id="total-initial-funds-service-charges-up-to-date">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </h4>
                            <div class= row>
                                 <p>By Crypto : <span class="col-12" id="initial-funds-service-charges-up-to-date-by-crypto"></span></p>
                                 <p>By Wallet : <span class="col-12" id="initial-funds-service-charges-up-to-date-by-wallet"></span></p>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->

        <div class="col-xl-3 col-lg-4 col-md-6">
            <!-- card -->
            <div class="card border border-primary card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <span class="text-muted mb-3 lh-1 d-block">Top-Up Funds Service Charges Up To Date</span>
                            <h4 class="mb-3" id= "total-top-up-funds-service-charges-up-to-date">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </h4>
                            <div class= row>
                                 <p>By Crypto : <span class="col-12" id="top-up-funds-service-charges-up-to-date-by-crypto"></span></p>
                                 <p>By Wallet : <span class="col-12" id="top-up-funds-service-charges-up-to-date-by-wallet"></span></p>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->   

        <div class="col-xl-3 col-lg-4 col-md-6">
            <!-- card -->
            <div class="card border border-info card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <span class="text-muted mb-3 lh-1 d-block">Withdrawals Up To Date</span>
                            <h4 class="mb-3" id="total-withdrawals-up-to-date">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </h4>
                            
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col-->

        
        <div class="col-xl-3 col-lg-4 col-md-6">
            <!-- card -->
            <div class="card border border-info card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <span class="text-muted mb-3 lh-1 d-block">Transaction Fee  Up To Date</span>
                            <h4 class="mb-3" id="transaction-fee-up-to-date">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div> 
                            </h4>
                            <div class= row>
                                <p>P2P Service Charges : <span class="col-12" id="total-p2p-service-charges-up-to-date"></span></p>
                                <p>Withdrawal Service Charges : <span class="col-12" id="total-withdrawal-service-charges-up-to-date"></span></p>
                            </div>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->   

        <div class="col-xl-6 col-lg-4 col-md-6">
            <!-- card -->
            <div class="card card-h-100" style="border: none">
                <!-- card body -->
                <div class="card-body text-end disable-print">
                    <button type="button"  class="btn btn-info waves-effect waves-light" onclick="window.print()"><i class="fas fa-print"></i> Print </button>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col --> 

    </div><!-- end row-->


    
    <div class="row disable-print">  
        <div class="col-xl-4 col-lg-4 col-md-6">
            <div class="alert alert-primary" role="alert">
                <span class="mb-3 lh-1 d-block">Pending Purchases Count Today</span>
                <h4 class="mb-3" id ="funding-payments">
                    {{ $funding_payments }}
                </h4>
            </div>
        </div><!-- end col -->  
        <div class="col-xl-4 col-lg-4 col-md-6">
            <div class="alert alert-success" role="alert">
                <span class="mb-3 lh-1 d-block">Pending KYC Count Today </span>
                <h4 class="mb-3" id ="pending-kycs">
                    {{ $pending_kycs }}
                </h4>
            </div>
        </div><!-- end col --> 
        <div class="col-xl-4 col-lg-4 col-md-6">
            <div class="alert alert-info" role="alert">
                <span class="mb-3 lh-1 d-block">Pending Withdrawal Count Today</span>
                <h4 class="mb-3" id="pending-withdraws">
                    {{ $pending_withdraws }}
                </h4>
            </div>
        </div><!-- end col -->
    </div><!-- end row-->

