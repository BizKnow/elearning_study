<div class="row">
    <div class="col-md-4">
        <form action="" id="fetch-stduent">
            <div class="{card_class}">
                <div class="card-header collapsible cursor-pointer rotate" data-bs-toggle="collapse"
                    data-bs-target="#kt_docs_card_collapsible">
                    <h3 class="card-title">Search Student</h3>
                    <div class="card-toolbar rotate-180">
                        <i class="ki-duotone ki-down fs-1"></i>
                    </div>
                </div>
                <div id="kt_docs_card_collapsible" class="collapse show">
                    <div class="card-body">
                        <!-- <div class="form-group">
                            <label for="roll_no" class="form-label required">Enter Roll No.</label>
                            <input type="text" autofocus class="form-control" id="roll_no" placeholder="Enter Roll No."
                                name="roll_no">
                        </div> -->
                        <div class="form-group">
                          <select name="student_id" data-control="select2" data-placeholder="Select Student"
                                class="form-select first m-h-100px" data-allow-clear="true">
                                <option></option>
                                <option value="0" 
                                    data-kt-rich-content-subcontent="roll-np" 
                                    data-kt-rich-content-icon="aa">Ajay Kumar</option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="card-footer">
                        {search_button}                        
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-md-8">
        <div class="card card-image card-body record-show fade  border-info border shadow" id="nx">


        </div>
    </div>
</div>