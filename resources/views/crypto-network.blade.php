<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active">{{ $title }}</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-lg-12">


        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add New Network Type</h4>
            </div><!-- end card header-->
            <div class="card-body p-4">
                <form method='post' action="{{url('/action/crypto-network-create')}}" id="crypto-network-create-form">
                @csrf
                    <div class="mb-3 form-group">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="network_fee">Network Fee</label>
                                <input type="text" class="form-control" name="network_fee" id="network_fee" placeholder="Enter Network Fee">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="withdrawal_fee">Withdrawal Fee</label>
                                <input type="text" class="form-control" name="withdrawal_fee" id="withdrawal_fee" placeholder="Enter Withdrawal Fee">
                            </div>
                        </div>
                    </div>
                    <!-- <div class="mb-3 form-group">
                        <label class="form-label" for="client_wallet">Client Wallet</label>
                        <input type="text" class="form-control" name="client_wallet" id="client_wallet" placeholder="Enter Client Wallet">
                    </div> -->
                    <div class="mb-3 form-group">
                        <label class="form-label" for="company_wallet_address">Company Wallet Address</label>
                        <input type="text" class="form-control" name="company_wallet_address" id="company_wallet_address" placeholder="Enter Company Wallet Address">
                    </div>
                    <div class="mb-3 form-check">
                        <input class="form-check-input" type="checkbox" id="client_wallet" name="client_wallet">
                        <label class="form-check-label" for="client_wallet">
                            Show in Client Wallet
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active">
                        <label class="form-check-label" for="is_active">
                            Active
                        </label>
                    </div>
                    <div class="mt-2 text-end">
                        <button type="submit" class="btn btn-dark w-md">Submit</button>
                    </div>
                </form>
            </div>
        </div>  
        
        
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Network Types</h4>
            </div><!-- end card header-->
            <div class="card-body p-4">
                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Network Fee</th>
                            <th>Withdrawal Fee</th>
                            <th>Current Status</th>
                            <th>Show in Client Wallet</th>
                            <th>Company Wallet Address</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($crypto_networks as $key => $data)
                            <tr>
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->network_fee }}</td>
                                <td>{{ $data->withdrawal_fee }}</td>
                                <td>{{ $data->is_active ? 'Active' : 'Inactive' }}</td>
                                <td>{{ $data->client_wallet ? 'Yes' : 'No' }}</td>
                                <td>{{ $data->company_wallet_address }}</td>
                                <td><a type="button" data-bs-toggle="modal" data-bs-target="#edit-crypto-network" onclick="editCryptoNetworkModal({{ $key }})" class="btn btn-dark waves-effect waves-light btn-sm"><i class="fas fa-edit"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>  


    </div>
</div>

<!-- End Form Layout -->



<div class="modal fade" id="edit-crypto-network" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Crypto Network</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method='post' action="{{url('/action/crypto-network-edit')}}" id="crypto-network-edit-form">
                @csrf
                    <input type="hidden" class="form-control" name="id" id="id">
                    <div class="mb-3 form-group">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" class="form-control" name="title" id="title-1">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="network_fee">Network Fee</label>
                                <input type="text" class="form-control" name="network_fee" id="network_fee-1">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="withdrawal_fee">Withdrawal Fee</label>
                                <input type="text" class="form-control" name="withdrawal_fee" id="withdrawal_fee-1">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label" for="company_wallet_address">Company Wallet Address</label>
                        <input type="text" class="form-control" name="company_wallet_address" id="company_wallet_address-1">
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="client_wallet-1" name="client_wallet">
                        <label class="form-check-label" for="client_wallet-1">
                        Show in Client Wallet
                        </label>
                    </div>
                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" id="is_active-1" name="is_active">
                        <label class="form-check-label" for="is_active-1">
                            Is Active
                        </label>
                    </div>
                    <div class="mt-2 text-end">
                        <button type="submit" class="btn btn-dark w-md">Submit</button>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<script>
    var crypto_networks   = <?php echo json_encode($crypto_networks); ?>;
</script>