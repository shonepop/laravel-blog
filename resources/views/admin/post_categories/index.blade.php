@extends("admin._layout.layout")

@section("seo_title", __("Post Categories"))

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
                <h1>@lang("Post Categories")</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.posts.index')}}">@lang("Home")</a></li>
                    <li class="breadcrumb-item active">@lang("Post Categories")</li>
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
                        <h3 class="card-title">@lang("All Post Categories")</h3>
                        <div class="card-tools">
                            <form style="display:none" action="{{route('admin.post_categories.change_priorities')}}" method="post" class="btn-group" id="change-priority-form">
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
                            <a href="{{route('admin.post_categories.add')}}" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                @lang("Add New Category")
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <table class="table table-bordered" id="entities-list-table">
                            <thead>                                 
                                <tr>
                                    <th style="width: 10%">#</th>
                                    <th style="width: 30%;">@lang("Name")</th>
                                    <th style="width: 30%;">@lang("Description")</th>
                                    <th class="text-center">@lang("Created At")</th>
                                    <th class="text-center">@lang("Updated At")</th>
                                    <th class="text-center">@lang("Actions")</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-list">
                                @foreach($postCategories as $postCategory)
                                <tr data-id="{{$postCategory->id}}">
                                    <td>
                                        <span style="display:none;" class="btn btn-outline-secondary handle">
                                            <i class="fas fa-sort"></i>
                                        </span>
                                        #{{$postCategory->id}}
                                    </td>
                                    <td>
                                        <strong>{{$postCategory->name}}</strong>
                                    </td>
                                    <td>
                                        {{$postCategory->description}}
                                    </td>
                                    <td class="text-center">{{$postCategory->created_at}}</td>
                                    <td class="text-center">{{$postCategory->updated_at}}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{$postCategory->getFrontUrl()}}" class="btn btn-info" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{route('admin.post_categories.edit', ['postCategory' => $postCategory->id])}}" class="btn btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button 
                                                type="button" 
                                                class="btn btn-info" 
                                                data-toggle="modal" 
                                                data-target="#delete-modal"
                                                data-action="delete"
                                                data-id="{{$postCategory->id}}"
                                                data-name="{{$postCategory->name}}"
                                                >
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
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

<form action="{{route('admin.post_categories.delete')}}" method="post" class="modal fade" id="delete-modal">
    @csrf
    <input type="hidden" name="id" value="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("Delete Category")</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang("Are you sure you want to delete category?")</p>
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
@endsection



@push("footer_javascript")

<script src="{{url('/themes/admin/plugins/jquery-ui/jquery-ui.min.js')}}" type="text/javascript"></script>
<script type="text/javascript">


$("#entities-list-table").on("click", "[data-action='delete']", function () {

    let id = $(this).attr("data-id");
    let name = $(this).attr("data-name");

    $("#delete-modal [name='id']").val(id);
    $("#delete-modal [data-container='name']").html(name);
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


</script>
@endpush