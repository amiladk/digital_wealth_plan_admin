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
        <!-- start Form section   -->
        <div class="col-12">
        <div class="card">
            
            <div class="card-body p-4">
            <form method='post' action="{{url('/action/edit-user-role')}}" id="group-create-form">
                @csrf
                <div class="row">
                    <div class="col-lg-6">
                        <div>
                            <div class="mb-3">
                                <label for="example-text-input" class="form-label">Role Name*</label>
                                <input class="form-control" type="text" name="role_name" value="{{$user_role->user_role}}" id="example-text-input">
                                <input type="hidden" type="text" name="role_id" value="{{$user_role->id}}" >
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="mt-3 mt-lg-0">
                            <div class="mb-3">
                                <label for="example-text-input" class="form-label">Description</label>
                                <input class="form-control" type="text" name="description" value="{{$user_role->description}}" id="example-text-input">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end Form section   -->
    <!-- start table section -->
    
<div>
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table mb-0" id="user-role">

                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Modules</th>
                            <th>Select All</th>
                            <th>Specific Permission</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach(getAllPermissions() as $key => $item)
                        <tr>
                            <th scope="row">{{$key+1}}</th>
                            <td>{{$item['group']}}</td>
                            <td> <input  type="checkbox" class="select-all" value="" onclick="selectAll(this)" >
                                <label class="form-check-label" for="flexCheckDefault">
                                    Select All
                                </label>
                            </td>
                            <td class="cheack-all">
                                @foreach($item['data'] as $data)
                              
                                <input class="form-check-input" type="checkbox" name="permission[]" value="{{$data['permission']}}" id="flexCheckDefault" <?php if(in_array($data['permission'], json_decode($user_permission))){ echo 'checked'; } ?>>
                                <label >
                                    {{$data['title']}}
                                </label>
                                <br>
                                @endforeach
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </div>
        </div>
                <div class="mt-4">
                <button type="submit" class="btn btn-dark w-md">Submit</button>
                </div>
    <!-- end card body -->
    </div>
    <!-- end card -->
</div>
<!-- end table section -->
</form>
<!-- end card body -->

</div>