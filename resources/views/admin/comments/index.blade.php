@extends("admin._layout.layout")

@section("seo_title", __("Comments"))

@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang("Comments")</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.posts.index')}}">@lang("Home")</a></li>
                    <li class="breadcrumb-item active">@lang("Comments")</li>
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
                        <h3 class="card-title">@lang("All Comments")</h3>
                        <div class="card-tools">
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered" id="entities-list-table">
                            <thead>                  
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">@lang("Post ID")</th>
                                    <th class="text-center">@lang("Status")</th>
                                    <th class="text-center">@lang("Author Name")</th>
                                    <th class="text-center">@lang("Author Email")</th>
                                    <th class="text-center">@lang("Comment")</th>
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
<form action="{{route('admin.comments.disable')}}" method="post" class="modal fade" id="disable-modal">
    @csrf
    <input type="hidden" name="id" val="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("Disable Comment")</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang("Are you sure you want to disable the comment of this author?")</p>
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

<form action="{{route('admin.comments.enable')}}" method="post" class="modal fade" id="enable-modal">
    @csrf
    <input type="hidden" name="id" val="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("Enable Comment")</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang("Are you sure you want to enable the comment of this author?")</p>
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

    let entitiesDataTable = $("#entities-list-table").DataTable({

        "serverSide": true,
        "processing": true,

        "ajax": {
            "url": "{{route('admin.comments.datatable')}}",
            "type": "post",
            "data": function (dtData) {
                dtData["_token"] = "{{csrf_token()}}";
            }
        },
        "columns": [
            {"name": "id", "data": "id","orderable": false, "searchable": false, "className": "text-center"},
            {"name": "post_id", "data": "post_id", "orderable": false, "className": "text-center"},
            {"name": "status", "data": "status", "orderable": false, "searchable": false, "className": "text-center"},
            {"name": "author_name", "data": "author_name","orderable": false, "searchable": false, "className": "text-center"},
            {"name": "author_email", "data": "author_email","orderable": false, "searchable": false, "className": "text-center"},
            {"name": "comment", "data": "description","orderable": false, "searchable": false, "className": "text-center"},
            {"name": "created_at", "data": "created_at", "searchable": false, "className": "text-center"},
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
        }).fail(function () {
            toastr.error("@lang('An error occurred while enabling a post')");
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
        }).fail(function () {
            toastr.error("@lang('An error occurred while disabling a post')");
        });
    });




</script>
@endpush