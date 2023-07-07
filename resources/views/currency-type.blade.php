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
                <h4 class="card-title">Add New Currency Type</h4>
            </div><!-- end card header-->
            <div class="card-body p-4">
                <form method='post' action="{{url('/action/currency-type-create')}}" id="currency-type-create-form">
                @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" placeholder="Enter Title">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4 form-group">
                                <label class="form-label">Network</label>
                                <select class="form-select select2" id="cypto_network" name="cypto_network[]" multiple required>
                                <option value="">Select Crypto Network</option>
                                    @foreach($crypto_network as $key=>$data)
                                        <option value="{{$data->id}}">{{$data->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="is_active" name="is_active">
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                    </div>
                    <div class="mt-2 text-end">
                        <button type="submit" class="btn btn-dark w-md">Submit</button>
                    </div>
                </form>
            </div>
        </div>    


        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Currency Types</h4>
            </div><!-- end card header-->
            <div class="card-body p-4">
                <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap w-100">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Current Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($currency_types as $key => $data)
                            <tr>
                                <td>{{ $data->title }}</td>
                                <td>{{ $data->is_active ? 'Active' : 'Inactive' }}</td>
                                <td><a type="button"  onclick="editCurrencyTypeModal({{ $key }})" class="btn btn-dark waves-effect waves-light btn-sm"><i class="fas fa-edit"></i></a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>  


    </div>
</div>

<!-- End Form Layout -->

<div class="modal fade" id="edit-currency-type" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Currency Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method='post' action="{{url('/action/currency-type-edit')}}" id="currency-type-edit-form">
                @csrf
                <input type="hidden" class="form-control" name="id" id="id-1">
                <div class="mb-3 form-group">
                    <label class="form-label" for="title">Title</label>
                    <input type="text" class="form-control" name="title" id="title-1">
                </div>
                <div class="mb-4 form-group selec_custom">
                    <label class="form-label">Network</label>
                    <select class="form-select select2" id="cypto_network-1" name="cypto_network[]" multiple required>
                    <option value="">Select Crypto Network</option>
                        @foreach($crypto_network as $key=>$data)
                            <option value="{{$data->id}}">{{$data->title}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" id="is_active-1" name="is_active">
                    <label class="form-check-label" for="is_active-1">
                        Active
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
    var currency_types   = <?php echo json_encode($currency_types); ?>;
</script>