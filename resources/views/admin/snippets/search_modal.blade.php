<button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#search_modal">
    Search
</button>

<div class="modal fade" id="search_modal" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Search</h4>
            </div>
            <div class="modal-body">
                <div class="search-form">
                        <input type="text" class="form-control" id="search" placeholder="Search...">
                </div>

                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#people" data-toggle="tab">People</a></li>
                        {{-- <li><a href="#timeline" data-toggle="tab">Timeline</a></li>
                        <li><a href="#settings" data-toggle="tab">Settings</a></li> --}}
                    </ul>
                    <div class="tab-content">
                        <div class="active tab-pane  table-responsive" id="people">
                            <table class="table">
                                    <thead>
                                            <tr>
                                                <th class="image">Image</th>
                                                <th> Name</th>
                                                <th>Role</th>
                                                <th> Username</th>
                                                <th>Email</th>
                                                <th>Phone No.</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                <tbody id="search_result">

                                </tbody>
                            </table>
                        </div>

                        {{-- <div class="tab-pane" id="timeline">

                        </div>

                        <div class="tab-pane" id="settings">

                        </div> --}}

                    </div>
                </div>

            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
