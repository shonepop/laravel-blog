@extends("admin._layout.layout")

@section("seo_title", __("Blog Posts Slider"))

@push("head_links")
<link href="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.css" rel="stylesheet')}}" type="text/css"/>
<link href="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet')}}" type="text/css"/>
@endpush

@section("content") 
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang("Blog Posts Slider")</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.posts.index')}}">@lang("Home")</a></li>
                    <li class="breadcrumb-item active">@lang("Blog Posts Slider")</li>
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
                        <h3 class="card-title">@lang("Blog Posts Slider")</h3>
                        <div class="card-tools">
                            <form style="display:none" action="{{route('admin.slider.change_priorities')}}" method="post" class="btn-group" id="change-priority-form">
                                @csrf
                                <input type="hidden" name="priorities" val="">
                                <button type="submit" class="btn btn-outline-success">
                                    <i class="fas fa-check"></i>
                                    @lang("Save Order")
                                </button>
                                <button type="button" class="btn btn-outline-danger" data-action="hide-order">
                                    <i class="fas fa-remove"></i>
                                    @lang("Cancel")
                                </button>
                            </form>
                            <button class="btn btn-outline-secondary" data-action="show-order">
                                <i class="fas fa-sort"></i>
                                @lang("Change Order")
                            </button>
                            <a href="{{route('admin.slider.add')}}" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                @lang("Add New Post")
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered" id="entities-list-table">
                            <thead>                                 
                                <tr>
                                    <th width="10%" class="text-center">#</th>
                                    <th class="text-center">@lang("Status")</th>
                                    <th class="text-center">@lang("Photo")</th>
                                    <th class="text-center">@lang("Title")</th>
                                    <th class="text-center">@lang("Button Name")</th>
                                    <th class="text-center">@lang("Button Url")</th>
                                    <th class="text-center">@lang("Created At")</th>
                                    <th class="text-center">@lang("Actions")</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-list">

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

<form action="{{route('admin.slider.delete')}}" method="post" class="modal fade" id="delete-modal">
    @csrf
    <input type="hidden" name="id" value="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("Delete Post")</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang("Are you sure you want to delete post?")</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang("Cancel")</button>
                <button type="submit" class="btn btn-danger">@lang("Delete")</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<!-- /.modal -->
<form action="{{route('admin.slider.enable')}}" method="post" class="modal fade" id="enable-modal">
    @csrf
    <input type="hidden" name="id" val="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("Enable Post")</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang("Are you sure you want to enable this post?")</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang("Cancel")</button>
                <button type="submit" class="btn btn-danger">@lang("Enable")</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<!-- /.modal -->
<form action="{{route('admin.slider.disable')}}" method="post" class="modal fade" id="disable-modal">
    @csrf
    <input type="hidden" name="id" val="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("Disable Post")</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang("Are you sure you want to disable this post?")</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang("Cancel")</button>
                <button type="submit" class="btn btn-danger">@lang("Disable")</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
@endsection



@push("footer_javascript")

<script src="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">

let entitiesDataTable = $("#entities-list-table").DataTable({
    "serverSide": true,
    "processing": true,
    "ajax": {
        "url": "{{route('admin.slider.datatable')}}",
        "type": "post",
        "data": function (dtData) {
            dtData["_token"] = "{{csrf_token()}}";
        }
    },
    'createdRow': function (row, data, dataIndex) {
        $(row).attr('data-id', data.data_id);
    },

    "pageLength": 10,
    "lengthMenu": [5, 10, 25, 50, 100, 250],

    "columns": [
        {"name": "id", "data": "id", "className": "text-center"},
        {"name": "status", "data": "status", "orderable": false, "searchable": false, "className": "text-center"},
        {"name": "photo", "data": "photo", "orderable": false, "searchable": false},
        {"name": "title", "data": "title", "orderable": false},
        {"name": "button_name", "data": "button_name", "searchable": false, "orderable": false},
        {"name": "button_url", "data": "button_url", "searchable": false, "orderable": false},
        {"name": "created_at", "data": "created_at", "searchable": false, "className": "text-center"},
        {"name": "actions", "data": "actions", "orderable": false, "searchable": false, "className": "text-center"},
    ],
});


$("#entities-list-table").on("click", "[data-action='delete']", function () {

    let id = $(this).attr("data-id");
    let name = $(this).attr("data-name");

    $("#delete-modal [name='id']").val(id);
    $("#delete-modal [data-container='name']").html(name);
});

$("#delete-modal").on("submit", function (e) {
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
        toastr.error("@lang('An error occurred while deleting a post')");
    });
});


$("#sortable-list").sortable({
    "handle": ".handle",
    "update": function (event, ui) {
        let priorities = $("#sortable-list").sortable("toArray", {
            "attribute": "data-id"
        });

        $("#change-priority-form [name='priorities']").val(priorities.join(","));
    }
});

$("[data-action='show-order']").on("click", function () {
    $("[data-action='show-order']").hide();
    $("#change-priority-form").show();
    $("#sortable-list .handle").show();
});
$("[data-action='hide-order']").on("click", function () {

    $("#change-priority-form").hide();
    $("[data-action='show-order']").show();
    $("#sortable-list .handle").hide();

    location.reload();
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