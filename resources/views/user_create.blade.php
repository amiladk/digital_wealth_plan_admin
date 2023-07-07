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
                <form method='post' action="{{url('/action/user-create')}}" id="user-create-form">
                @csrf
                    <div class="mb-3 form-group">
                        <label class="form-label" for="name">Full Name</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Enter Full Name">
                    </div>
                    <div class="mb-3 form-group">
                        <label class="form-label" for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Enter Address">
                    </div>
                    <div class="row"> 
                        <div class="col-md-12">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="user_role">User Role</label>
                                <select class="form-select" id="user_role" name="user_role">
                                    <option value="">Select</option>
                                    @foreach($user_role as $key=>$data)
                                        <option value="{{ $data->id }}">{{ $data->user_role }}</option>  
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">  
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="nic">NIC</label>
                                <input type="text" class="form-control" id="nic" name="nic" placeholder="Enter NIC">
                            </div>
                        </div>                                                          
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your Email">
                            </div>
                        </div>
                    </div>  
                    <div class="row">                                                            
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="password_confirmation">Re Enter Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Re enter your password">
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-dark w-md">Submit</button>
                    </div>
                </form>
            </div>
        </div>    
    </div>
</div>

<!-- End Form Layout -->