<template>
    <div class="tabs-container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#tab-1">Loan Matrix</a></li>
            <li class=""><a data-toggle="tab" href="#tab-2">Pre-Queue</a></li>
            <li class=""><a data-toggle="tab" href="#tab-3">Queue</a></li>
            <li class=""><a data-toggle="tab" href="#tab-4">Pending</a></li>
            <li class=""><a data-toggle="tab" href="#tab-5">Approved</a></li>
            <li class=""><a data-toggle="tab" href="#tab-6">Correction</a></li>
            <li class=""><a data-toggle="tab" href="#tab-7">Disapproved</a></li>
        </ul>
        <div class="tab-content">
            <div id="tab-1" class="tab-pane active">
                <div class="panel-body col-lg-12">

                    <div class="col-lg-4">
                        <div class="box-body" id="loanmatrixform">
                            <div class="form-group">
                                <h4>Approved Loan Amount</h4>
                                <input type="text" readonly class="form-control input-sm" id="monthlyPayment" style="background-color: #f7e1b5; font-weight: bold; font-size: large;" >
                            </div>

                            <div class="form-group">
                                <label>States</label>
                                <select class="form-control input-sm">
                                    <option v-for="selectedCountry in selectedCountries" :value="selectedCountry.id" >{{ selectedCountry.name }}</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Portfolio Name</label>
                                <select class="form-control input-sm" id="Port">
                                    <option selected></option>
                                    <option value="NPF">Northern Plains Funding - (NPF)</option>
                                    <option value="SLS">Send Loan - (SLS)</option>
                                    <option value="INBX">Inbox Loan - (INBX)</option>
                                    <option value="SOF">Solid Oak Finance - (SOF)</option>
                                </select>
                                <span id="portfolioRequired" style="color:#a94442; display: none;">Please Select Portfolio Name</span>
                            </div>

                            <div class="form-group">
                                <label>Net Monthly Income</label>
                                <input type="number" placeholder="0"  class="form-control input-sm" id="annualInterestRate">
                            </div>

                            <!--Start INBX-->
                            <div id="showInbox" style="display: none;">
                                <div class="form-group">
                                    <label>Pay Frequency</label>
                                    <select class="form-control input-sm" id="PF">
                                        <option selected></option>
                                        <option value="W">Weekly</option>
                                        <option value="B">Bi-Weekly</option>
                                        <option value="S">Semi-Monthly</option>
                                    </select>
                                    <span id="FrequencyRequired" style="color:#a94442; display: none;">Please Select Pay Frequency</span>
                                </div>
                                <div class="form-group" id="balance1">
                                    <label>Payroll Ending Balance 1</label>
                                    <div class="input-group" id="group1">
                                        <input type="number" class="form-control input-sm" id="DD1">
                                        <span class="input-group-btn" id="btn1">
                                          <button type="button" id="addBalance1" class="btn btn-success btn-sm" >+</button>
                                       </span>
                                    </div>
                                </div>
                                <div class="form-group" id="balance2">
                                    <label>Payroll Ending Balance 2</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control input-sm" id="DD2">
                                        <span class="input-group-btn">
                                            <button type="button" id="addBalance2" class="btn btn-success btn-sm">+</button>
                                            <button type="button" id="removeBalance2"  class="btn btn-danger btn-sm">x</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group" id="balance3">
                                    <label>Payroll Ending Balance 3</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control input-sm" id="DD3">
                                        <span class="input-group-btn">
                                            <button type="button" id="addBalance3" class="btn btn-success btn-sm">+</button>
                                            <button type="button" id="removeBalance3" class="btn btn-danger btn-sm">x</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group" id="balance4">
                                    <label>Payroll Ending Balance 4</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control input-sm" id="DD4">
                                        <span class="input-group-btn">
                                            <button type="button" id="addBalance4" class="btn btn-success btn-sm">+</button>
                                            <button type="button" id="removeBalance4" class="btn btn-danger btn-sm">x</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group" id="balance5">
                                    <label>Payroll Ending Balance 5</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control input-sm" id="DD5">
                                        <span class="input-group-btn">
                                            <button type="button" id="addBalance5" class="btn btn-success btn-sm">+</button>
                                            <button type="button" id="removeBalance5" class="btn btn-danger btn-sm">x</button>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group" id="balance6">
                                    <label>Payroll Ending Balance 6</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control input-sm" id="DD6">
                                        <span class="input-group-btn">
                                            <button type="button" id="removeBalance6" class="btn btn-danger btn-sm">x</button>
                                         </span>
                                    </div>
                                </div>
                            </div>
                            <!--End INBX-->
                            <div class="form-group">
                                <label>Number of Open Loans</label>
                                <select class="form-control" id="numberOfYears">
                                    <option selected value="0">0</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4+</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Open Loan Amount</label>
                                <input type="number" placeholder="0"   class="form-control input-sm" id="loanAmount">
                            </div>

                            <div class="form-group">
                                <label>Number of Paid Off Loans</label>
                                <select class="form-control input-sm" id="loan">
                                    <option selected value="0">New Customer</option>
                                    <option value="1">1 Loan Repay</option>
                                    <option value="2">2 Loan Repay</option>
                                    <option value="3">3 Loan Repay</option>
                                    <option value="4">4+ Loan Repay</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>With DL Or NOT</label>
                                <select class="form-control input-sm" id="DL">
                                    <option selected value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Is Exception</label>
                                <select class="form-control input-sm" id="EXP">
                                    <option selected value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Negative Balance</label>
                                <input type="number" placeholder="0" class="form-control input-sm" id="na">
                            </div>

                        </div>
                        <div class="box-footer">
                            <button type="button" class="ladda-button btn btn-primary btn-sm"  data-style="zoom-in" id="matrixResult" >Compute Loan Size</button>
                            <button type="button" class="ladda-button btn btn-danger btn-sm"  data-style="zoom-in" id="matrixClear" >Clear</button>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>Date</label>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-sm" type="text"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-sm" type="text"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-sm" type="text"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-sm" type="text"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-sm" type="text"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-sm" type="text"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>DDL</label>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-sm" type="text"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-sm" type="text"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-sm" type="text"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-sm" type="text"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-sm" type="text"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-sm" type="text"/>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label>EOD</label>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-sm" type="text"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-sm" type="text"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-sm" type="text"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-sm" type="text"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-sm" type="text"/>
                            </div>
                            <div class="form-group">
                                <input class="form-control input-sm" type="text"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>

            <div id="tab-2" class="tab-pane">
                <div class="panel-body"></div>
            </div>
            <div class="clearfix"></div>

            <div id="tab-3" class="tab-pane">
                <div class="panel-body"></div>
            </div>
            <div class="clearfix"></div>

            <div id="tab-4" class="tab-pane">
                <div class="panel-body"></div>
            </div>
            <div class="clearfix"></div>

            <div id="tab-5" class="tab-pane">
                <div class="panel-body"></div>
            </div>
            <div class="clearfix"></div>

            <div id="tab-6" class="tab-pane">
                <div class="panel-body"></div>
            </div>
            <div class="clearfix"></div>
            
            <div id="tab-7" class="tab-pane">
                <div class="panel-body"></div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</template>
<script>
    export default {
        data: function () {
            return {
                selectedCountries: [],
            };
        },
        created() {
            this.$constants.Country_API.get("/")
                .then(response => {
                    this.selectedCountries = response.data;
                });
        }
    }
</script>