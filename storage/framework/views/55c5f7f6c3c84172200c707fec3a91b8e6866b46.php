<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18 text-uppercase"><?php echo e($title); ?> </h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item active"><?php echo e($title); ?> </li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->


<form method='post' action="<?php echo e(url('/action/client-edit')); ?>" class="needs-validation">
    <?php echo csrf_field(); ?>
    <div class="row">
        <input type="text" class="form-control" hidden id="id" name="id" value="<?php echo e($client->id); ?>">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Basic Info</h4>
                </div>
                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="first_name">First name</label>
                                <input type="text" required class="form-control" id="first_name" name="first_name"
                                    placeholder="Enter Name" value="<?php echo e($client->first_name); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="last_name">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name"
                                    placeholder="Last Name" value="<?php echo e($client->last_name); ?>">
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="country" class="form-label"> Country </label>
                        <input class="form-control" id="country" data-dropdown="true" name="country"
                            placeholder="Please select..." value="<?php echo e($client->getCountry->name); ?>" />
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="change_email">
                                    <label class="form-check-label" for="change_email">Change Email</label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3 form-group">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="is_active" name="is_active"
                                        <?php if($client->is_active==1){ echo 'checked';} ?>>
                                    <label class="form-check-label" for="is_active">Active</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3 form-group email" id="readOnlyDiv">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" required class="form-control" id="email" name="email" readonly
                            placeholder="Enter email" value="<?php echo e($client->email); ?>">
                        <!-- <div class="pristine-error id= "email-error" text-help" style="">Email Allrady Taken</div> -->
                        <!-- <input type="email" required data-pristine-required-message="Please Enter a Email" class="form-control" placeholder="Enter your Email" />       -->
                    </div>
                    <div class="mb-3 form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="change_login_details"
                                name="change_login_details">
                            <label class="form-check-label" for="change_login_details">Change Login Details</label>
                        </div>
                    </div>
                    <div id="disableDiv">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label for="userpassword" class="form-label">Password</label>
                                    <input type="password" class="form-control" disabled id="password" name="password"
                                        placeholder="Enter password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" disabled id="password_confirmation"
                                        name="password_confirmation" placeholder="Enter password">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">KYC Verification</h4>
                </div>
                <div class="card-body p-4">
                    <div class="mb-3 radio-custom">
                        <?php $__currentLoopData = $client_titles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$client_title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-check mb-1">
                            <input class="form-check-input"
                                <?php if($client_title->id == $client->client_title){ echo 'checked';} ?> type="radio"
                                name="client_title" id="client-title-<?php echo e($key); ?>" value="<?php echo e($client_title->id); ?>"
                                value="<?php echo e($client->full_name); ?>">
                            <label class="form-check-label" for="client-title-<?php echo e($key); ?>">
                                <?php echo e($client_title->title); ?>

                            </label>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="full_name">Full name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name"
                            value="<?php echo e($client->full_name); ?>" placeholder="Enter Name">
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="mb-3">
                                    <label for="dob">Date of Birth </label>
                                    <input class="form-control" type="date" name="dob" id="dob"
                                        value="<?php echo e($client->dob); ?>">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <div class="form-group">
                                    <label for="phone_number">Contact No</label>
                                    <input type="hidden" name="phone_number" id="phone_number"
                                        value="<?php echo e($client->phone_number); ?>">
                                    <input type="tel" class="form-control" id="phone" name="phone"
                                        placeholder="Enter your Phone No" value="<?php echo e($client->phone_number); ?>">
                                </div>
                                <p id="phone_number_error"></p>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="address">Address (As per the Identity Verification Document) <span
                                class="required-color">*</span></label>
                        <textarea id="address" class="form-control" rows="2" name="address"
                            placeholder="Enter your address"><?php echo e($client->address); ?></textarea>
                    </div>
                    <div class="mb-3 radio-custom">
                        <?php $__currentLoopData = $client_fund_sources; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$client_fund_source): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="form-check mb-1">
                            <input class="form-check-input"
                                <?php if($client_fund_source->id == $client->client_fund_source){ echo 'checked';} ?>
                                type="radio" name="client_fund_source" id="fund_source-<?php echo e($key); ?>"
                                value="<?php echo e($client_fund_source->id); ?>">
                            <label class="form-check-label" for="fund_source-<?php echo e($key); ?>">
                                <?php echo e($client_fund_source->title); ?>

                            </label>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">KYC Verification</h4>
            </div>
            <div class="col-lg-6 mb-6">
                <div class="mb-3">
                    <label class="form-label">Document Type </label>
                    <select class="form-select" id="identity_doc_type" name="identity_doc_type">
                        <option value="">Please Select</option>
                        <?php $__currentLoopData = $identity_doc_types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option <?php if($client->identity_doc_type == $data->id){ echo 'selected'; } ?>
                            value="<?php echo e($data->id); ?>"><?php echo e($data->title); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
            </div>
            <div class="row col-lg-12" id="identity_doc_type_chooser_area">

                <?php if($client->identity_doc_type == 1): ?>
                <div class="col-lg-3 mb-3">
                    <label class="form-label" for="default-input">Identity Front Image <span
                            class="required-color">*</span></label>
                    <div>
                        <button id="upload-img-btn-1" onclick="showCropModal(1)"
                            class="btn btn-primary <?php if($client->id_front != null): ?> is-valid <?php endif; ?>"
                            type="button">Identity Front
                            Image
                            <span class="required-color">*</span> </button>
                        <span id="upload-img-msg-1"> <?php if($client->id_front != null): ?> <i id="upload-img-msg-fa-1"
                                class="fa fa-check text-success" aria-hidden="true"></i> <?php endif; ?> </span>
                    </div>
                    <?php if($client->getBackImage != null): ?>
                    <div class="row mt-2">
                        <div class="col-md-4" id="proof_image-1">
                            <a href="<?php echo e(config('site-specific.image_url_client')); ?>image/<?php echo e($client->getFrontImage->image_name); ?>"
                                data-fancybox="proof_document">
                                <img src="<?php echo e(config('site-specific.image_url_client')); ?>image/<?php echo e($client->getFrontImage->image_name); ?>" alt=""
                                    class="img-fluid">
                            </a>
                        </div>
                        <div id="result-row-1" class="mt-2" style="padding-right: 30px;">
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="col-lg-6 mb-3">
                    <label class="form-label" for="default-input">Identity Back Image <span
                            class="required-color">*</span></label>
                    <div>
                        <button id="upload-img-btn-2" onclick="showCropModal(2)"
                            class="btn btn-primary <?php if($client->id_back != null): ?> is-valid <?php endif; ?>" type="button">Identity
                            Back Image
                            <span class="required-color">*</span> </button>
                        <span id="upload-img-msg-2"> <?php if($client->id_back != null): ?> <i id="upload-img-msg-fa-2"
                                class="fa fa-check text-success" aria-hidden="true"></i> <?php endif; ?> </span>
                    </div>
                    <?php if($client->getBackImage != null): ?>
                    <div class="row mt-2">
                        <div class="col-md-4" id="proof_image-2">
                            <a href="<?php echo e(config('site-specific.image_url_client')); ?>image/<?php echo e($client->getBackImage->image_name); ?>"
                                data-fancybox="proof_document">
                                <img src="<?php echo e(config('site-specific.image_url_client')); ?>image/<?php echo e($client->getBackImage->image_name); ?>" alt=""
                                    class="img-fluid">
                            </a>
                        </div>
                        <div id="result-row-2" class="mt-2" style="padding-right: 30px;">
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if($client->identity_doc_type == 2): ?>
                <div class="col-lg-6 mb-3">
                    <label class="form-label" for="default-input">License Front Image <span
                            class="required-color">*</span></label>
                    <div>
                        <button id="upload-img-btn-3" onclick="showCropModal(3)"
                            class="btn btn-primary <?php if($client->id_front != null): ?> is-valid <?php endif; ?>" type="button">License
                            Front
                            Image
                            <span class="required-color">*</span> </button>
                        <span id="upload-img-msg-3"> <?php if($client->id_front != null): ?> <i id="upload-img-msg-fa-3"
                                class="fa fa-check text-success" aria-hidden="true"></i> <?php endif; ?> </span>
                    </div>
                    <?php if($client->getFrontImage != null): ?>
                    <div class="row ">
                        <div class="col-md-4 mt-2" id="proof_image-3">
                            <a href="<?php echo e(config('site-specific.image_url_client')); ?>image/<?php echo e($client->getFrontImage->image_name); ?>"
                                data-fancybox="proof_document">
                                <img src="<?php echo e(config('site-specific.image_url_client')); ?>image/<?php echo e($client->getFrontImage->image_name); ?>" alt=""
                                    class="img-fluid">
                            </a>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <?php endif; ?>

                <?php if($client->identity_doc_type == 3): ?>
                <div class="col-lg-6 mb-3">
                    <label class="form-label" for="default-input">Passport Image <span
                            class="required-color">*</span></label>
                    <div>
                        <button id="upload-img-btn-5" onclick="showCropModal(5)"
                            class="btn btn-primary <?php if($client->id_front != null): ?> is-valid <?php endif; ?>"
                            type="button">Passport Image
                            <span class="required-color">*</span> </button>
                        <span id="upload-img-msg-5"> <?php if($client->id_front != null): ?> <i id="upload-img-msg-fa-5"
                                class="fa fa-check text-success" aria-hidden="true"></i> <?php endif; ?> </span>
                    </div>
                    <?php if($client->getFrontImage != null): ?>
                    <div class="row" id="proof_image">
                        <div class="col-md-4 mt-2" id="proof_image-5">
                            <a href="<?php echo e(config('site-specific.image_url_client')); ?>image/<?php echo e($client->getFrontImage->image_name); ?>"
                                data-fancybox="proof_document">
                                <img src="<?php echo e(config('site-specific.image_url_client')); ?>image/<?php echo e($client->getFrontImage->image_name); ?>" alt=""
                                    class="img-fluid">
                            </a>
                        </div>
                        </div> <div id="result-row-6" class="mt-2" style="padding-right: 30px;">
                    </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-lg-3 mb-3">
                <label class="form-label" for="default-input">Selfie Photo <span class="required-color">*</span></label>
                <div>
                    <button id="upload-img-btn-6" onclick="showCropModal(6)"
                        class="btn btn-primary <?php if($client->selfie != null): ?> is-valid <?php endif; ?>"
                        type="button">Selfie Image <span
                            class="required-color">*</span> </button>
                    <span id="upload-img-msg-6"><?php if($client->selfie != null): ?> <i id="upload-img-msg-fa-6"
                            class="fa fa-check text-success" aria-hidden="true"></i> <?php endif; ?></span>
                    <div id="result-row-6" class="mt-2" style="padding-right: 30px;">
                    </div>
                </div>
                <?php if($client->getSelfieImage != null): ?>
                <div class="row">
                    <div class="col-md-4" id="proof_image-5">
                        <a href="<?php echo e(config('site-specific.image_url_client')); ?>image/<?php echo e($client->getSelfieImage->image_name); ?>"
                            data-fancybox="proof_document">
                            <img src="<?php echo e(config('site-specific.image_url_client')); ?>image/<?php echo e($client->getSelfieImage->image_name); ?>" alt=""
                                class="img-fluid">
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="mt-3 mb-3 text-end">
        <button type="submit" class="btn btn-primary w-md">Submit</button>
    </div>
    </div>
</form>

<!-- Modal -->
<div class="modal fade" id="image_crop_modal" tabindex="-1" role="dialog" aria-labelledby="image_crop_modalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="image_crop_modal_title">Modal title</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <div>
                        <div class="fallback">
                            <input name="file" type="file" id="image_chooser">
                        </div>
                    </div>

                    <div class="img-container cropper-custom mt-3">
                        <img id="canvace_image" src="">
                    </div>
                </div>

            </div>
            <div class="modal-footer" id="image_crop_modal_footer">
                <button type="button" class="btn btn-secondary" onclick="closeCrop()">Close</button>
                <button type="button" class="btn btn-primary" onclick="cropImage(this)">Upload</button>
            </div>
        </div>
    </div>
</div>
<!-- End Form Layout -->


<script>
var client = <?php echo json_encode($client); ?>;
</script><?php /**PATH C:\wamp64\www\lemaconet_admin\resources\views/edit_client.blade.php ENDPATH**/ ?>