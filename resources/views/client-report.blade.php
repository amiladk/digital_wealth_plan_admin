<div class="row">
    <div class="mb-3 col-md-6">
        <label class="form-label">Date Range</label>
        <input type="text"  class="form-control flatpickr-input" id="date-range" value="{{$selected_date_rage}}" name="dater_ange">
    </div>
    <div class="mb-3 col-md-6 client-report">
        <label class="form-label">Client</label>
        <select class="form-select select2" id="client" name="client"  required>
        <option value="">Select Client</option>
            @foreach($client as $key=>$data)
                 <option @if($selected_client == $data->id) {{'selected'}}  @endif value="{{$data->id}}">{{$data->membership_no}} - {{$data->full_name}}</option>
            @endforeach
        </select>
    </div>
</div>



    <div class="row">
        <div class="col-xl-3 col-lg-3 col-md-3">
            <!-- card -->
            <div class="card border border-success card-h-100">
                <!-- card body -->
                <div class="card-body text center">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h4 class="mb-3 lh-1 d-block text-truncate ">Left Chain Heads Count</h4>
                            <h5 class="mb-3">
                             {{$clientReportCounts['left_chain_heads_count']}}  (Direct {{$clientReportCounts['left_direct']}})
                            </h5>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->  
        <div class="col-xl-3 col-lg-3 col-md-3">
            <!-- card -->
            <div class="card border border-success card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h4 class="mb-3 lh-1 d-block text-truncate">Right Chain Heads Count</h4>
                            <h5 class="mb-3" >
                            {{$clientReportCounts['rigth_chain_heads_count']}} (Direct {{$clientReportCounts['rigth_direct']}})
                            </h5>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col --> 
        <div class="col-xl-3 col-lg-3 col-md-3">
            <!-- card -->
            <div class="card border border-primary card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h4 class="mb-3 lh-1 d-block text-truncate">Left Chain BV</h4>
                            <h5 class="mb-3" >
                               {{$clientReportCounts['left_chain_bv'][0]->value}}
                            </h5>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div>  
        <div class="col-xl-3 col-lg-3 col-md-3">
            <!-- card -->
            <div class="card border border-primary card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h4 class="mb-3 lh-1 d-block text-truncate">Right Chain BV</h4>
                            <h5 class="mb-3" >
                               {{$clientReportCounts['rigth_chain_bv'][0]->value}}
                            </h5>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3">
            <!-- card -->
            <div class="card border border-warning card-h-100">
                <!-- card body -->
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-12">
                            <h4 class="mb-3 lh-1 d-block text-truncate">Left Funds</h4>
                            <ul>
                                <li><h5 class="mb-3" > Initial Funds: {{$clientReportCounts['left_initial_funds'][0]->value}}</h5></li>
                                <li><h5 class="mb-3" > Top Ups: {{$clientReportCounts['left_top_ups_funds'][0]->value}}</h5></li>
                                <li><h5 class="mb-3" > Withdrawals:: {{$clientReportCounts['left_withdrawals_funds'][0]->value}}</h5></li>
                            </ul>
                           
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3">
            <!-- card -->
            <div class="card border border-warning card-h-100">
                <!-- card body -->
                <div class="card-body">
                <div class="row align-items-center">
                        <div class="col-12">
                            <h4 class="mb-3 lh-1 d-block text-truncate">Right Funds</h4>
                            <ul>
                                <li><h5 class="mb-3" > Initial Funds: {{$clientReportCounts['rigth_initial_funds'][0]->value}}</h5></li>
                                <li><h5 class="mb-3" > Top Ups: {{$clientReportCounts['rigth_top_ups_funds'][0]->value}}</h5></li>
                                <li><h5 class="mb-3" > Withdrawals: {{$clientReportCounts['rigth_withdrawals_funds'][0]->value}}</h5></li>
                            </ul>
                            
                        </div>
                </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3">
            <!-- card -->
            <div class="card border border-info  card-h-100">
                <!-- card body -->
                <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4 class="mb-3 lh-1 d-block text-truncate">Left Service Charge</h4>
                        <ul>
                            <li><h5 class="mb-3" > Initial Funds: {{$clientReportCounts['left_initial_service_charge'][0]->value}}</h5></li>
                            <li> <h5 class="mb-3"> Top Ups: {{$clientReportCounts['left_top_ups_service_charge'][0]->value}}</h5></li>
                            <li><h5 class="mb-3" > Withdrawals: {{$clientReportCounts['left_withdrawals_service_charge'][0]->value}}</h5></li>
                        </ul>
                    </div>
                </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div>
        <div class="col-xl-3 col-lg-3 col-md-3">
            <!-- card -->
            <div class="card border border-info  card-h-100">
                <!-- card body -->
                <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-12">
                        <h4 class=" mb-3 lh-1 d-block text-truncate">Right Service Charge</h4>
                        <ul>
                            <li><h5 class="mb-3" > Initial Funds: {{$clientReportCounts['rigth_initial_service_charge'][0]->value}}</h5></li>
                            <li><h5 class="mb-3" > Top Ups: {{$clientReportCounts['rigth_top_ups_service_charge'][0]->value}}</h5></li>
                            <li><h5 class="mb-3" > Withdrawals: {{$clientReportCounts['rigth_withdrawals_service_charge'][0]->value}}</h5></li>
                        </ul>
                        
                    </div>
                </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div>
    </div><!-- end row-->


    
    

