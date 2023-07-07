<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18"><?php echo e($title); ?></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                    <li class="breadcrumb-item active"><?php echo e($title); ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <div class ="table-responsive">
                    <table id="liability-report" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Invested Date</th>
                                <th>Client Id</th>
                                <th>Client Name</th>
                                <th>Investment</th>
                                <th>Earning Eligibility</th>
                                <th>Total Payble</th>
                                <th>Daily Due Amount</th>
                                <th>Accumalated up to date</th>
                                <th>Balance to be accumalated</th>
                                <!-- <th>Available Balances</th> -->
                                <th>Paid more than 1:3 (5x & 4x)</th>
                                <th>Date Range Due Report</th>
                                <!-- <th>Holding Balances in the Wallets</th> -->
                            </tr>
                        </thead>
                        <!-- <tfoot>
                                <tr>
                                <td>Sum</td>
                                <td>$180</td>
                                </tr>
                            </tfoot> -->
                        <tbody>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="4" style="text-align:right">Total</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                    <!-- <div>
                        <label class="form-label" for="default-input">Total Balance to be accumalated : <span id="total-balance-to-be-accumalated"></span></label><br>
                        <label class="form-label" for="default-input">Total Paid more than : <span id="total-paid-more-than"></span></label>
                    </div> -->
                
            </div>

        </div>
    </div>
</div>
</div>
</div><?php /**PATH C:\Pradeep\bitbucket\lemaconet_admin\resources\views/liability-report.blade.php ENDPATH**/ ?>