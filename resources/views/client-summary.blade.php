<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18 text-uppercase">{{$title}} </h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{$title}} </li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->


<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active summary-tab" data-bs-toggle="tab" href="#summary" role="tab">
                            <span class="d-block d-sm-none">
                                Client Summary
                                {{-- <i class="fas fa-home"></i> --}}
                            </span>
                            <span class="d-none d-sm-block">Client Summary</span>    
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link summary-tab" data-bs-toggle="tab" href="#client-top-up" role="tab">
                            <span class="d-block d-sm-none">
                                Client Top-Ups
                                {{-- <i class="far fa-user"></i> --}}
                            </span>
                            <span class="d-none d-sm-block">Client Top-Ups</span>    
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link summary-tab" data-bs-toggle="tab" href="#client-withdrawals" role="tab">
                            <span class="d-block d-sm-none">
                                Client Withdrawals
                                {{-- <i class="far fa-user"></i> --}}
                            </span>
                            <span class="d-none d-sm-block">Client Withdrawals</span>    
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link summary-tab" data-bs-toggle="tab" href="#p2p-send" role="tab">
                            <span class="d-block d-sm-none">
                                P2P Sent
                                {{-- <i class="far fa-user"></i> --}}
                            </span>
                            <span class="d-none d-sm-block">P2P Send</span>    
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link summary-tab" data-bs-toggle="tab" href="#p2p-received" role="tab">
                            <span class="d-block d-sm-none">
                                P2P Received
                                {{-- <i class="far fa-user"></i> --}}
                            </span>
                        <span class="d-none d-sm-block">P2P Received</span>    
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link summary-tab" data-bs-toggle="tab" href="#funding" role="tab">
                            <span class="d-block d-sm-none">
                                Uni-Level Funding Rewards
                                {{-- <i class="far fa-user"></i> --}}
                            </span>
                            <span class="d-none d-sm-block">Uni-Level Funding Rewards</span>    
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link summary-tab" data-bs-toggle="tab" href="#top-up" role="tab">
                            <span class="d-block d-sm-none">
                                Uni-Level Top-Up Rewards
                                {{-- <i class="far fa-envelope"></i> --}}
                            </span>
                            <span class="d-none d-sm-block">Uni-Level Top-Up Rewards</span>    
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link summary-tab" data-bs-toggle="tab" href="#bv" role="tab">
                            <span class="d-block d-sm-none">
                                BV Rewards
                                {{-- <i class="fas fa-cog"></i> --}}
                            </span>
                            <span class="d-none d-sm-block">BV Rewards </span>    
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link summary-tab" data-bs-toggle="tab" href="#daily" role="tab">
                            <span class="d-block d-sm-none">
                                Daily Rewards
                                {{-- <i class="fas fa-cog"></i> --}}
                            </span>
                            <span class="d-none d-sm-block"> Daily Rewards </span>    
                        </a>
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active" id="summary" role="tabpanel">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="card border border-primary card-h-100">
                                    <div class="card-body">
                                        <div class="row mb-1">
                                            <label for="horizontal-firstname-input" class="col-sm-4 col-form-label"><b> Membership No </b></label>
                                            <div class="col-sm-8">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$client->membership_no}} </label>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="horizontal-firstname-input" class="col-sm-4 col-form-label"><b> Client Name  </b></label>
                                            <div class="col-sm-8">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$client->first_name}} {{$client->last_name}} </label>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="horizontal-firstname-input" class="col-sm-4 col-form-label"><b> Email </b></label>
                                            <div class="col-sm-8">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$client->email}} </label>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="horizontal-firstname-input" class="col-sm-4 col-form-label"><b> Registered Date </b></label>
                                            <div class="col-sm-8">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$client->created_at}} </label>
                                            </div>
                                        </div>
                                        <!-- <div class="row mb-1">
                                            <label for="horizontal-firstname-input" class="col-sm-4 col-form-label"><b> Last Update Date </b></label>
                                            <div class="col-sm-8">
                                                <label for="horizontal-firstname-input" class="col-form-label">:  </label>
                                            </div>
                                        </div> -->
                                        <!-- <div class="row mb-1">
                                            <label for="horizontal-firstname-input" class="col-sm-4 col-form-label"><b> Gainer Type </b></label>
                                            <div class="col-sm-8">
                                                <label for="horizontal-firstname-input" class="col-form-label">:  </label>
                                            </div>
                                        </div> -->
                                        <div class="row mb-1">
                                            <label for="horizontal-firstname-input" class="col-sm-4 col-form-label"><b> Side </b></label>
                                            <div class="col-sm-8">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$client->getSponsorSide()}} </label>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="horizontal-firstname-input" class="col-sm-4 col-form-label"><b> BV Elegibility </b></label>
                                            <div class="col-sm-8">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$bv_elegibilty}} </label>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="horizontal-firstname-input" class="col-sm-4 col-form-label"><b> Head Status </b></label>
                                            <div class="col-sm-8">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$client->headStatus()}} </label>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="horizontal-firstname-input" class="col-sm-4 col-form-label"><b> Sponsor ID  </b></label>
                                            <div class="col-sm-8">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$client->getSponsor->membership_no}} </label>
                                            </div>
                                        </div>
                                        <div class="row mb-1">
                                            <label for="horizontal-firstname-input" class="col-sm-4 col-form-label"><b> Sponsor Name  </b></label>
                                            <div class="col-sm-8">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$client->getSponsor->first_name}} {{$client->getSponsor->last_name}}</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- end col -->
                            <div class="col-md-12 col-lg-6">
                                <div class="card border border-primary">
                                    <div class="card-body text-center">
                                        <h5 class="card-title"><b> Total Available Balance </b></h5>
                                        <h3 class="summary-text">{{$total_available_balance}}</h3>
                                        <h5 class="summary-text2"><b> Holding Balance: {{$total_holding_balance}} </b></h5>
                                    </div>
                                </div>
                                <div class="row">
                                <div class="col-md-6">
                                        <div class="card border border-success">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">Main Head Fund</h5>
                                                <h4>{{$main_head_investment}} </h4>
                                            </div>
                                        </div>
                                        <div class="card border border-success">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">Total Top-Up Funds</h5>
                                                <h4>{{$total_top_up_Investments}}</h4> 
                                            </div>
                                        </div>
                                        <div class="card border border-success">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">Total Funds</h5> 
                                                <h4> {{$total_investments}}</h4>
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                    <div class="col-md-6">
                                        <div class="card border border-info">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">Total Daily Rewards</h5>
                                                <h4>{{$reward_counts['daily_rewards']}}</h4>  
                                            </div>
                                        </div>
                                        <div class="card border border-info">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">Total BV Rewards</h5>
                                                <h4>{{$reward_counts['bv_rewards']}}</h4>
                                            </div>
                                        </div>
                                        <div class="card border border-info">
                                            <div class="card-body text-center">
                                                <h5 class="card-title">Total Referral Rewards </h5>
                                                <h4>{{$reward_counts['referral_rewards']}}</h4>
                                            </div>
                                        </div>
                                    </div><!-- end col -->
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="card border border-primary">
                                    <div class="card-body">
                                        <div class="row">
                                            <label for="horizontal-firstname-input" class="col-sm-6 col-form-label"><b>Total Left Chain Heads Count  </b></label>
                                            <div class="col-sm-6">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$client->left_head_count}} (Direct: {{$left_user_direct_count}}) </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="horizontal-firstname-input" class="col-sm-6 col-form-label"><b> Total Right Chain Heads Count  </b></label>
                                            <div class="col-sm-6">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$client->right_head_count}} (Direct: {{$right_user_direct_count}})</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="horizontal-firstname-input" class="col-sm-6 col-form-label"><b> Total Left Chain BV </b></label>
                                            <div class="col-sm-6">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$total_left_chain_bv}} </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="horizontal-firstname-input" class="col-sm-6 col-form-label"><b> Total Right Chain BV  </b></label>
                                            <div class="col-sm-6">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$total_right_chain_bv}}  </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="horizontal-firstname-input" class="col-sm-6 col-form-label"><b> Total Balanced BV </b></label>
                                            <div class="col-sm-6">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$blance_bv}}  </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="horizontal-firstname-input" class="col-sm-6 col-form-label"><b> Left Chain Balance after BV balance </b></label>
                                            <div class="col-sm-6">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$left_after_bv_balance}} </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="horizontal-firstname-input" class="col-sm-6 col-form-label"><b> Right Chain Balance after BV balance </b></label>
                                            <div class="col-sm-6">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$right_after_bv_balance}} </label>
                                            </div>
                                        </div>
                                        <!-- Dummy rows to match height -->
                                        <div class="row">
                                            <label for="horizontal-firstname-input" class="col-sm-6 col-form-label"><b> &nbsp </b></label>
                                            <div class="col-sm-6">
                                                <label for="horizontal-firstname-input" class="col-form-label">&nbsp </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="horizontal-firstname-input" class="col-sm-6 col-form-label"><b> &nbsp </b></label>
                                            <div class="col-sm-6">
                                                <label for="horizontal-firstname-input" class="col-form-label">&nbsp </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="horizontal-firstname-input" class="col-sm-6 col-form-label"><b> &nbsp </b></label>
                                            <div class="col-sm-6">
                                                <label for="horizontal-firstname-input" class="col-form-label">&nbsp </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="card border border-primary card-h-100">
                                    <div class="card-body">
                                        <div class="row">
                                            <label for="horizontal-firstname-input" class="col-sm-6 col-form-label"><b>Total Earnings  </b></label>
                                            <div class="col-sm-6">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$reward_counts['total_earnings']}}  </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="horizontal-firstname-input" class="col-sm-6 col-form-label"><b> Total Top-Ups by Wallet  </b></label>
                                            <div class="col-sm-6">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$top_upsby_wallet}} </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="horizontal-firstname-input" class="col-sm-6 col-form-label"><b> Total Withdrawals  </b></label>
                                            <div class="col-sm-6">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$total_withdrawals}}  </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="horizontal-firstname-input" class="col-sm-6 col-form-label"><b> Total Top-Up Service Charges </b></label>
                                            <div class="col-sm-6">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$total_service_charge}}</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="horizontal-firstname-input" class="col-sm-6 col-form-label"><b> Total Withdrawal Service Charges by Wallet</b></label>
                                            <div class="col-sm-6">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$total_withdrawl_service_charge}} </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="horizontal-firstname-input" class="col-sm-6 col-form-label"><b> P2P Sent</b></label>
                                            <div class="col-sm-6">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$p2p_sent}} </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="horizontal-firstname-input" class="col-sm-6 col-form-label"><b> P2P Received</b></label>
                                            <div class="col-sm-6">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$p2p_received}} </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="horizontal-firstname-input" class="col-sm-6 col-form-label"><b> Total Available Balance </b></label>
                                            <div class="col-sm-6">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$total_available_balance}}  </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <label for="horizontal-firstname-input" class="col-sm-6 col-form-label"><b> Total Holding Balance</b></label>
                                            <div class="col-sm-6">
                                                <label for="horizontal-firstname-input" class="col-form-label">: {{$total_holding_balance}}  </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-12">
                                <div class="card border border-primary kyc-details">
                                    <div class="card-body">
                                        <div class="row mb-4">
                                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label"><b> Full Name </b></label>
                                            <div class="col-sm-9">
                                                <label for="horizontal-firstname-input" class="col-form-label">{{ isset($user_details->getClientTitle) ? $user_details->getClientTitle->title : '' }} {{ $user_details->full_name }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label"><b> Date of Birth </b></label>
                                            <div class="col-sm-9">
                                                <label for="horizontal-firstname-input" class="col-form-label">{{ $user_details->dob }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label"><b> Contact Number </b></label>
                                            <div class="col-sm-9">
                                                <label for="horizontal-firstname-input" class="col-form-label">{{ $user_details->phone_number }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label"><b> Country </b></label>
                                            <div class="col-sm-9">
                                                <label for="horizontal-firstname-input" class="col-form-label">{{ $user_details->getCountry->name }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label"><b> Postal Address </b></label>
                                            <div class="col-sm-9">
                                                <label for="horizontal-firstname-input" class="col-form-label">{{ $user_details->address }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label"><b> Source of Funds </b></label>
                                            <div class="col-sm-9">
                                            <label for="horizontal-firstname-input" class="col-form-label">{{ isset($user_details->getClientFundSource) ? $user_details->getClientFundSource->title : '' }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                                            <label for="horizontal-firstname-input" class="col-sm-3 col-form-label"><b> NIC Number </b></label>
                                            <div class="col-sm-9">
                                                <label for="horizontal-firstname-input" class="col-form-label">{{ $user_details->nic_no }}</label>
                                            </div>
                                        </div>
                                        <div class="row mb-4">
                        
                                            <h5 class="col-sm-3 col-form-label">Document Type</h5>
                                            <div class="col-sm-9">
                                                <label for="horizontal-firstname-input" class="col-form-label">{{ isset($user_details->getIdentityDocType) ? $user_details->getIdentityDocType->title : '' }}</label>
                                            </div>
                        
                                            <div class="row mb-2 mt-4">
                                                    <div class="col-md-3">
                                                        <div class="card border border-success">
                                                            <div class="card-body text-center doc_type">
                                                                @if($user_details->selfie)
                                                                    <!-- <i class="fas fa-check-double mb-2"></i> -->
                                                                    <img alt="Avatar" class="img-fluid" src="https://mytrader.biz/image/{{$user_details->getSelfieImage->image_name}}">
                                                                @endif
                                                                <h6 class="mt-2">Selfie Image</h6>
                                                            </div>
                                                        </div>
                                                    </div><!-- end col -->
                                                @if($user_details->identity_doc_type == 1 || $user_details->identity_doc_type == 2)
                                                    <div class="col-md-3">
                                                        <div class="card border border-success">
                                                            <div class="card-body text-center doc_type">
                                                                @if($user_details->id_front)
                                                                    <!-- <i class="fas fa-check-double mb-2"></i>     -->
                                                                @endif
                                                                @if($user_details->identity_doc_type == 1)
                                                                    <img alt="Avatar" class="img-fluid" src="https://mytrader.biz/image/{{$user_details->getFrontImage->image_name}}">
                                                                    <h6 class="mt-2">Identity Front Image</h6>
                                                                @else
                                                                    <img alt="Avatar" class="img-fluid" src="https://mytrader.biz/image/{{$user_details->getFrontImage->image_name}}">
                                                                    <h6 class="mt-2">Drivers License Front Image</h6>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div><!-- end col -->
                                                    <div class="col-md-3">
                                                        <div class="card border border-success">
                                                            <div class="card-body text-center doc_type">
                                                                @if($user_details->id_back)
                                                                    <!-- <i class="fas fa-check-double mb-2"></i> -->
                                                                @endif
                                                                @if($user_details->identity_doc_type == 1)
                                                                <img alt="Avatar" class="img-fluid" src="https://mytrader.biz/image/{{$user_details->getBackImage->image_name}}">
                                                                    <h6 class="mt-2">Identity Back Image</h6>
                                                                @else
                                                                <img alt="Avatar" class="img-fluid" src="https://mytrader.biz/image/{{$user_details->getBackImage->image_name}}">
                                                                    <h6 class="mt-2">Drivers License Front Image</h6>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div><!-- end col -->
                                                @else
                                                    <div class="col-md-3">
                                                        <div class="card border border-success">
                                                            <div class="card-body text-center doc_type">
                                                                @if($user_details->id_front)
                                                                    <!-- <i class="fas fa-check-double mb-2"></i> -->
                                                                    <img alt="Avatar" class="img-fluid" src="https://mytrader.biz/image/{{$user_details->getFrontImage->image_name}}">
                                                                @endif
                                                                <h6 class="mt-2">Passport Image</h6>
                                                            </div>
                                                        </div>
                                                    </div><!-- end col -->
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="client-top-up" role="tabpanel">
                        <h4 class="card-title mt-3 mb-4">Client Top-Up - Total: ${{$total_client_top_up}} </h4>
                        <div class="table-responsive custom-responsive">
                            <table id="datatable-client-top-up" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Approved Date</th>
                                        <th>Approval</th>
                                        <th>Status</th>
                                        <th>Funding Method</th>
                                        <th>Funding Payment Method</th>
                                        <th>Capital</th>
                                        <th>Days Count</th>
                                        <th>Daily Gain</th>
                                        <th>Achieved Gain</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($client_top_ups as $key=>$data )
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{{ $data->created_at}} </td>
                                        <td class="status-badge">
                                            @if($data->status == 0)
                                                <span class="badge bg-info">Pending</span>
                                            @elseif($data->status == 1)
                                                <span class="badge bg-success">Approved</span>
                                            @else
                                                <span class="badge bg-danger"> Not Approved</span>
                                            @endif
                                        </td>
                                        @if($data->other_rewards_completed ==0)
                                            @if($data->status == 1)
                                                <td>Active</td>
                                            @else
                                                <td></td>
                                            @endif
                                        @elseif($data->other_rewards_completed == 1)
                                            @if($data->status == 1)
                                                <td>Inactive</td>
                                            @else
                                                <td></td>
                                            @endif
                                        @else
                                            <span></span>
                                        @endif
                                        <td>{{$data->fundingTypeName()}}</td>
                                        <td>{{ $data->getFundingPaymentMethod->title }}</td>
                                        <td class="rigth-aligment"><?php echo number_format( $data->trading_amount, 2, '.', ',');?> </td>
                                        <td class="rigth-aligment">{{ $data->getDaysCount()}} </td>
                                        <td class="rigth-aligment"><?php echo number_format( $data->daily_reward_amount, 2, '.', ',');?></td>
                                        <td class="rigth-aligment"><?php echo number_format( $data->achieved_rewards, 2, '.', ',');?></td></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="client-withdrawals" role="tabpanel">
                        <h4 class="card-title mt-3 mb-4">Client Withdrawals - Total: $ {{$total_withdrawals}}</h4>
                        <div class="table-responsive custom-responsive">
                            <table id="datatable-client-withdrawals" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Approved Date</th>
                                        <th>Status </th>
                                        <th>Withdraw Amount</th>
                                        <th>Transaction Fee</th>
                                        <th>Recieving Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($client_withdrawals as $key=>$data )
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $data->created_at}} </td>
                                            <td>{{ $data-> withdrawStatus()}} </td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->withdraw_amount, 2, '.', ',');?> </td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->transaction_fee, 2, '.', ',');?> </td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->recieving_amount, 2, '.', ',');?></td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="p2p-send" role="tabpanel">
                        <h4 class="card-title mt-3 mb-4">P2P Sent - Total: {{$p2p_sent}}</h4>
                        <div class="table-responsive">
                            <table id="datatable-p2p-send" class="table table-bordered dt-responsive nowrap w-100 table-custom-padding">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Sent to</th>
                                        <th>Sent to Member Id</th>
                                        <th>Transfer Amount</th>
                                        <th>Transaction Fee</th>
                                        <th>Sent Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($p2p_sent_details as $key=>$data )
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $data->created_at}} </td>
                                            <td>{{$data->getTo->full_name }} </td>
                                            <td>{{$data->getTo->membership_no }} </td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->transfer_amount, 2, '.', ',');?></td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->transaction_fee, 2, '.', ',');?></td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->received_amount, 2, '.', ',');?></td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="p2p-received" role="tabpanel">
                        <h4 class="card-title mt-3 mb-4">P2P Received - Total: {{$p2p_received}}</h4>
                        <div class="table-responsive">
                            <table id="datatable-p2p-received" class="table table-bordered dt-responsive nowrap w-100 table-custom-padding">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
                                        <th>Received From</th>
                                        <th>Received From Member Id</th>
                                        <th>Transfer Amount</th>
                                        <th>Transaction Fee</th>
                                        <th>Sent Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($p2p_received_details as $key=>$data )
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $data->created_at}} </td>
                                            <td>{{$data->getFrom->full_name }} </td>
                                            <td>{{$data->getFrom->membership_no }} </td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->transfer_amount, 2, '.', ',');?></td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->transaction_fee, 2, '.', ',');?></td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->received_amount, 2, '.', ',');?></td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="funding" role="tabpanel">
                        <h4 class="card-title mt-3 mb-4">Direct/Indirect - Uni-Level Rewards - Total: $<?php echo number_format( $unilevel_funding_rewards->sum('amount'), 2, '.', ',');?> </h4>
                        <div class="table-responsive custom-responsive">
                            <table id="datatable-funding" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invessted Client</th>
                                        <th>Invested Date</th>
                                        <th>Invested Amount</th>
                                        <th>Reward %</th>
                                        <th>Reward Amount</th>
                                    </tr>
                                </thead>
                                <tbody>

                                @foreach($unilevel_funding_rewards as $key=>$data )
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $data->membership_no}} </td>
                                            <td>{{ $data->approved_date}} </td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->trading_amount, 2, '.', ',');?> </td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->earning_percentage, 2, '.', ',');?>%</td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->amount, 2, '.', ',');?> </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="top-up" role="tabpanel">
                        <h4 class="card-title mt-3 mb-4">Direct/Indirect - Uni-Level Top-Up Rewards - Total: ${{$unilevel_topup_rewards->sum('amount')}} </h4>
                        <div class="table-responsive custom-responsive">
                            <table id="datatable-top-up" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invessted Client</th>
                                        <th>Invested Date</th>
                                        <th>Invested Amount</th>
                                        <th>Reward %</th>
                                        <th>Reward Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($unilevel_topup_rewards as $key=>$data )
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $data->membership_no}} </td>
                                            <td>{{ $data->approved_date}} </td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->trading_amount, 2, '.', ',');?> </td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->earning_percentage, 2, '.', ',');?>%</td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->amount, 2, '.', ',');?> </td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="bv" role="tabpanel">
                        <h4 class="card-title mt-3 mb-4">Direct/Indirect - BV Rewards - Total: ${{$reward_counts['bv_rewards']}}</h4>
                        <div class="table-responsive custom-responsive">
                            <table id="datatable-bv" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invessted Client</th>
                                        <th>Invested Date</th>
                                        <th>Invested Amount</th>
                                        <th>Type</th>
                                        <th>Side</th>
                                        <th>Left Bv </th>
                                        <th>Right Bv </th>
                                        <th>Balanced BV</th>
                                        <th>Reward %</th>
                                        <th>Reward Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($bv_rewards as $key=>$data )
                                <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td>{{ $data->membership_no}} </td>
                                            <td>{{ $data->approved_date}} </td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->trading_amount, 2, '.', ',');?> </td>
                                            <td>@php echo $data->funding_type==1 ? 'Funding' : 'Top-Up'; @endphp</td>
                                            <td>@php echo $data->funding_side==0 ? 'Left' : 'Right'; @endphp</td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->left_bv_rewards, 2, '.', ',');?></td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->right_bv_rewards, 2, '.', ',');?></td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->balanced_amount, 2, '.', ',');?> </td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->earning_percentage, 2, '.', ',');?>%</td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->amount, 2, '.', ',');?> </td>  
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="tab-pane" id="daily" role="tabpanel">
                        <h4 class="card-title mt-3 mb-4">Daily Rewards - $ {{$reward_counts['daily_rewards']}}</h4>
                        <div class="table-responsive custom-responsive">
                            <table id="datatable-daily" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="text-center">Date (Y-M-D) </th>
                                        <th>Capital</th>
                                        <th>Daily Gain</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach($daily_rewards as $key=>$data )
                                        <tr>
                                            <td>{{ $key+1 }}</td>
                                            <td class="text-center">{{ $data->reward_date}} </td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->trading_amount, 2, '.', ',');?>  </td>
                                            <td class="rigth-aligment"><?php echo number_format( $data->amount, 2, '.', ',');?> </td>
                                            
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- end card-body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>