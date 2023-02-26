@extends("admin._layout.layout")

@section("seo_title", __("Users"))

@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang("Users")</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.posts.index')}}">@lang("Home")</a></li>
                    <li class="breadcrumb-item active">@lang("Users")</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang("Search Users")</h3>
                        <div class="card-tools">
                            <a href="{{route('admin.users.add')}}" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                @lang("Add New User")
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="entities-filter-form">
                            <div class="row">
                                <div class="col-md-1 form-group">
                                    <label>@lang("Status")</label>
                                    <select class="form-control" name="status">
                                        <option value="">@lang("-- All --")</option>
                                        <option value="1">@lang("enabled")</option>
                                        <option value="0">@lang("disabled")</option>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>@lang("Email:")</label>
                                    <input 
                                        name="email"
                                        type="text" class="form-control" placeholder="Search by email">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>@lang("Name")</label>
                                    <input 
                                        name="name"
                                        type="text" class="form-control" placeholder="Search by name">
                                </div>
                                <div class="col-md-3 form-group">
                                    <label>@lang("Phone")</label>
                                    <input 
                                        name="phone"
                                        type="text" class="form-control" placeholder="Search by phone">
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">

                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@lang("All Users")</h3>
                        <div class="card-tools">

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered" id="entities-list-table">
                            <thead>                  
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th style="width: 20px">@lang("Status")</th>
                                    <th class="text-center">@lang("Photo")</th>
                                    <th>@lang("Email")</th>
                                    <th>@lang("Name")</th>
                                    <th>@lang("Phone")</th>
                                    <th class="text-center">@lang("Created At")</th>
                                    <th class="text-center">@lang("Actions")</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer clearfix">

                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

<!-- /.modal -->
<form action="{{route('admin.users.disable')}}" method="post" class="modal fade" id="disable-modal">
    @csrf
    <input type="hidden" name="id" val="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("Disable User")</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang("Are you sure you want to disable user?")</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang("Cancel")</button>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-minus-circle"></i>
                    @lang("Disable")
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<!-- /.modal -->

<form action="{{route('admin.users.enable')}}" method="post" class="modal fade" id="enable-modal">
    @csrf
    <input type="hidden" name="id" val="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("Enable User")</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang("Are you sure you want to enable user?")</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang("Cancel")</button>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-check"></i>
                    @lang("Enable")
                </button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<!-- /.modal -->
@endsection

@push("footer_javascript")
<script type="text/javascript">

    $("#entities-filter-form [name]").on("change keyup", function () {
        $("#entities-filter-form").trigger("submit");
    });

    $("#entities-filter-form").on("submit", function (e) {
        e.preventDefault();
        entitiesDataTable.ajax.reload(null, true);
    });

    let entitiesDataTable = $("#entities-list-table").DataTable({

        "serverSide": true,
        "processing": true,

        "ajax": {
            "url": "{{route('admin.users.datatable')}}",
            "type": "post",
            "data": function (dtData) {
                dtData["_token"] = "{{csrf_token()}}";
                dtData["status"] = $('#entities-filter-form [name="status"]').val();
                dtData["email"] = $('#entities-filter-form [name="email"]').val();
                dtData["name"] = $('#entities-filter-form [name="name"]').val();
                dtData["phone"] = $('#entities-filter-form [name="phone"]').val();
            }
        },
        "columns": [
            {"name": "id", "data": "id"},
            {"name": "status", "data": "status","orderable": false, "className": "text-center"},
            {"name": "photo", "data": "photo", "orderable": false, "searchable": false, "className": "text-center"},
            {"name": "email", "data": "email", "orderable": false},
            {"name": "name", "data": "name", "orderable": false},
            {"name": "phone", "data": "phone", "orderable": false},
            {"name": "created_at", "data": "created_at", "className": "text-center"},
            {"name": "actions", "data": "actions", "orderable": false, "searchable": false, "className": "text-center"}
        ]

    });


    $("#entities-list-table").on("click", "[data-action='enable']", function () {

        let id = $(this).attr("data-id");
        let name = $(this).attr("data-name");

        $("#enable-modal [name='id']").val(id);
        $("#enable-modal [data-container='name']").html(name);
    });

    $("#enable-modal").on("submit", function (e) {
        e.preventDefault();

        $(this).modal("hide");

        $.ajax({
            "url": $(this).attr("action"),
            "type": $(this).attr("method"),
            "data": $(this).serialize()
        }).done(function (response) {
            toastr.success(response.system_message);
            entitiesDataTable.ajax.reload(null, false);
        }).fail(function (xhr) {
            let systemError = "@lang('An error occured while enabling user')";

            if (xhr.responseJSON && xhr.responseJSON["system_error"]) {
                systemError = xhr.responseJSON["system_error"];
            }

            toastr.error(systemError);
        });
    });


    $("#entities-list-table").on("click", "[data-action='disable']", function () {

        let id = $(this).attr("data-id");
        let name = $(this).attr("data-name");

        $("#disable-modal [name='id']").val(id);
        $("#disable-modal [data-container='name']").html(name);
    });

    $("#disable-modal").on("submit", function (e) {
        e.preventDefault();

        $(this).modal("hide");

        $.ajax({
            "url": $(this).attr("action"),
            "type": $(this).attr("method"),
            "data": $(this).serialize()
        }).done(function (response) {
            toastr.success(response.system_message);
            entitiesDataTable.ajax.reload(null, false);
        }).fail(function (xhr) {
            let systemError = "@lang('An error occured while disabling user')";

            if (xhr.responseJSON && xhr.responseJSON["system_error"]) {
                systemError = xhr.responseJSON["system_error"];
            }

            toastr.error(systemError);
        });
    });




</script>
@endpush