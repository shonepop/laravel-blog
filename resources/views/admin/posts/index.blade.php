@extends("admin._layout.layout")

@section("seo_title", __("Blog Posts"))

@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang("Blog Posts")</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('front.index.index')}}">@lang("Home")</a></li>
                    <li class="breadcrumb-item active">@lang("Blog Posts")</li>
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
                        <h3 class="card-title">@lang("Search Posts")</h3>
                        <div class="card-tools">
                            <a href="{{route('admin.posts.add')}}" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                @lang("Add New Post")
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <form id="entities-filter-form">
                            <div class="row">
                                <div class="col-md-2 form-group">
                                    <label>@lang("Title")</label>
                                    <input
                                        name="title"
                                        type="text" 
                                        class="form-control" 
                                        placeholder="Search by name">
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>@lang("Category")</label>
                                    <select class="form-control" name="post_category_id">
                                        <option value="">--Choose Category --</option>
                                        @foreach($postCategories as $postCategory)
                                        <option value="{{$postCategory->id}}">
                                            {{$postCategory->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>@lang("Author")</label>
                                    <select class="form-control" name="author_id">
                                        <option value="">--Choose Author --</option>
                                        @foreach($authors as $author)
                                        <option value="{{$author->id}}">
                                            {{$author->name}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>@lang("Important")</label>
                                    <select class="form-control" name="index_page">
                                        <option value="">-- All --</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>@lang("Status")</label>
                                    <select class="form-control" name="status">
                                        <option value="">-- All --</option>
                                        <option value="1">Enabled</option>
                                        <option value="0">Disabled</option>
                                    </select>
                                </div>
                                <div class="col-md-2 form-group">
                                    <label>@lang("Tags")</label>
                                    <select class="form-control" multiple name="tags">
                                        @foreach($tags as $tag)
                                        <option value="{{$tag->id}}">
                                            {{$tag->name}}
                                        </option>
                                        @endforeach
                                    </select>
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
                        <h3 class="card-title">@lang("All Products")</h3>
                        <div class="card-tools">

                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered" id="entities-list-table">
                            <thead>                  
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th class="text-center">@lang("Photo")</th>
                                    <th class="text-center">@lang("Status")</th>
                                    <th class="text-center">@lang("Important")</th>
                                    <th style="width: 20%;">@lang("Title")</th>
                                    <th style="width: 10%;">@lang("Category")</th>
                                    <th style="width: 10%;">@lang("Tags")</th>
                                    <th style="width: 10%;">@lang("Author")</th>
                                    <th class="text-center">@lang("Comments Count")</th>
                                    <th class="text-center">@lang("Visit Count")</th>
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

<form action="{{route('admin.posts.delete')}}" method="post" class="modal fade" id="delete-modal">
    @csrf
    <input type="hidden" name="id" val="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("Delete Post")</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang("Are you sure you want to delete this post?")</p>
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
<form action="{{route('admin.posts.enable')}}" method="post" class="modal fade" id="enable-modal">
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
<form action="{{route('admin.posts.disable')}}" method="post" class="modal fade" id="disable-modal">
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
<!-- /.modal -->
<form action="{{route('admin.posts.important')}}" method="post" class="modal fade" id="important-modal">
    @csrf
    <input type="hidden" name="id" val="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("Important Post")</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang("Are you sure you want to mark this post as important?")</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang("Cancel")</button>
                <button type="submit" class="btn btn-danger">@lang("Important")</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<!-- /.modal -->
<form action="{{route('admin.posts.regular')}}" method="post" class="modal fade" id="regular-modal">
    @csrf
    <input type="hidden" name="id" val="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("Regular Post")</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang("Are you sure you want to mark this post as regular?")</p>
                <strong data-container="name"></strong>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">@lang("Cancel")</button>
                <button type="submit" class="btn btn-danger">@lang("Regular")</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</form>
<!-- /.modal -->
@endsection

@push("footer_javascript")


<script>

    $("#entities-filter-form [name='tags']").select2({
        "theme": "bootstrap4"
    });
    $("#entities-filter-form [name='post_category_id']").select2({
        "theme": "bootstrap4"
    });
    $("#entities-filter-form [name='author_id']").select2({
        "theme": "bootstrap4"
    });

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
            "url": "{{route('admin.posts.datatable')}}",
            "type": "post",
            "data": function (dtData) {
                dtData["_token"] = "{{csrf_token()}}";
                dtData["title"] = $("#entities-filter-form [name='title']").val();
                dtData["post_category_id"] = $("#entities-filter-form [name='post_category_id']").val();
                dtData["author_id"] = $("#entities-filter-form [name='author_id']").val();
                dtData["index_page"] = $("#entities-filter-form [name='index_page']").val();
                dtData["status"] = $("#entities-filter-form [name='status']").val();
                dtData["tags"] = $("#entities-filter-form [name='tags']").val();
            }
        },
        "pageLength": 10,
        "lengthMenu": [5, 10, 25, 50, 100, 250, 500, 1000],

        "columns": [
            {"name": "id", "data": "id"},
            {"name": "photo", "data": "photo", "orderable": false, "searchable": false},
            {"name": "status", "data": "status", "orderable": false, "searchable": false},
            {"name": "important", "data": "index_page", "orderable": false, "searchable": false},
            {"name": "title", "data": "title", "orderable": false},
            {"name": "post_category_name", "data": "post_category_name", "orderable": false},
            {"name": "tags", "data": "tags", "orderable": false},
            {"name": "author_name", "data": "author_name", "orderable": false},
            {"name": "comments", "data": "comments_count", "orderable": false, "searchable": false},
            {"name": "visit_count", "data": "visit_count", "searchable": false},
            {"name": "created_at", "data": "created_at", "searchable": false},
            {"name": "actions", "data": "actions", "orderable": false, "searchable": false},
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

    $("#entities-list-table").on("click", "[data-action='important']", function () {

        let id = $(this).attr("data-id");
        let name = $(this).attr("data-name");

        $("#important-modal [name='id']").val(id);
        $("#important-modal [data-container='name']").html(name);
    });

    $("#important-modal").on("submit", function (e) {
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
            toastr.error("@lang('An error occurred while marking a post as important')");
        });
    });

    $("#entities-list-table").on("click", "[data-action='regular']", function () {

        let id = $(this).attr("data-id");
        let name = $(this).attr("data-name");

        $("#regular-modal [name='id']").val(id);
        $("#regular-modal [data-container='name']").html(name);
    });

    $("#regular-modal").on("submit", function (e) {
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
            toastr.error("@lang('An error occurred while marking a post as regular')");
        });
    });


</script>
@endpush