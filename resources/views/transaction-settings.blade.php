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
            <div class="card-body p-4">
                <form method='post' action="{{url('/action/transaction-setting-edit')}}" id="transaction-setting-edit-form">
                @csrf
                    <div class="table-responsive">
                        <table class="table table-nowrap align-middle table-settings">
                            <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Value</th>
                                    {{-- <th></th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaction_settings as $key => $data)
                                    <tr>
                                        <td>{{ $data->description  }}</td>
                                        <td>
                                            <input type="hidden" class="form-control" name="id[]" id="id" value="{{ $data->id }}">
                                            <input type="text"class="form-control" name="value[]" id="value" value="{{ $data->value }}">
                                        </td>
                                        {{-- <td style="width: 100px">
                                            <a class="btn btn-outline-secondary btn-sm edit" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4 text-end">
                        <button type="submit" class="btn btn-dark w-md">Submit</button>
                    </div>
                </form>
            </div>
        </div>  
    </div>
</div>

<!-- End Form Layout -->