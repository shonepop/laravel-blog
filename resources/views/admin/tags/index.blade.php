@extends("admin._layout.layout")

@section("seo_title", __("Post Tags"))

@section("content") 
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang("Post Tags")</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.posts.index')}}">@lang("Home")</a></li>
                    <li class="breadcrumb-item active">@lang("Post Tags")</li>
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
                        <h3 class="card-title">@lang("All Post Tags")</h3>
                        <div class="card-tools">

                            <a href="{{route('admin.tags.add')}}" class="btn btn-success">
                                <i class="fas fa-plus-square"></i>
                                @lang("Add New Tag")
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
                                    <th class="text-center">@lang("Created At")</th>
                                    <th class="text-center">@lang("Updated At")</th>
                                    <th class="text-center">@lang("Actions")</th>
                                </tr>
                            </thead>
                            <tbody id="sortable-list">
                                @foreach($tags as $tag)
                                <tr>
                                    <td>         
                                        #{{$tag->id}}
                                    </td>
                                    <td>
                                        <strong>{{$tag->name}}</strong>
                                    </td>
                                    <td class="text-center">{{$tag->created_at}}</td>
                                    <td class="text-center">{{$tag->updated_at}}</td>
                                    <td class="text-center">
                                        <div class="btn-group">
                                            <a href="{{$tag->getFrontUrl()}}" class="btn btn-info" target="_blank">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{route('admin.tags.edit', ['tag' => $tag->id])}}" class="btn btn-info">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button 
                                                type="button" 
                                                class="btn btn-info" 
                                                data-toggle="modal" 
                                                data-target="#delete-modal"
                                                data-action="delete"
                                                data-id="{{$tag->id}}"
                                                data-name="{{$tag->name}}"
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

<form action="{{route('admin.tags.delete')}}" method="post" class="modal fade" id="delete-modal">
    @csrf
    <input type="hidden" name="id" value="">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang("Delete Tag")</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>@lang("Are you sure you want to delete tag?")</p>
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


</script>
@endpush