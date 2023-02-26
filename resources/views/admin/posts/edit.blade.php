@extends("admin._layout.layout")

@section("seo_title", __("Edit Post"))

@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang("Blog Posts Form")</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.index.index')}}">@lang("Home")</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.posts.index')}}">@lang("Posts")</a></li>
                    <li class="breadcrumb-item active">Edit Post</li>
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
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">@lang("Edit Post")</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{route('admin.posts.update', ['post' => $post->id])}}" method="post" id="entity-form" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>@lang("Post Categories")</label>
                                        <select 
                                            class="form-control @if($errors->has('post_category_id')) is-invalid @endif" 
                                            name="post_category_id">
                                            @foreach($postCategories as $postCategory)
                                            <option 
                                                value="{{$postCategory->id}}"
                                                @if(old("post_category_id", $post->post_category_id) == $postCategory->id)
                                                selected
                                                @endif
                                                >
                                                {{$postCategory->name}}  
                                            </option>
                                            @endforeach
                                        </select>
                                        @include("admin._layout.partials.form_errors", ["fieldName" => "post_category_id"])
                                    </div>     
                                    <div class="form-group">
                                        <label>@lang("Title")</label>
                                        <input 
                                            name="title"
                                            value="{{old('title', $post->title)}}"
                                            type="text" 
                                            class="form-control @if($errors->has('title')) is-invalid @endif">
                                        @include("admin._layout.partials.form_errors", ["fieldName" => "title"])
                                    </div>
                                    <div class="form-group">
                                        <label>@lang("Author")</label>
                                        <input 
                                            name="author_name"
                                            type="text" 
                                            class="form-control" 
                                            value="{{$post->author_name}}"
                                            readonly>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang("Description")</label>
                                        <textarea 
                                            name="description"
                                            class="form-control @if($errors->has('description')) is-invalid @endif" 
                                            placeholder="Enter Description">{{old('description', $post->description)}}</textarea>
                                        @include("admin._layout.partials.form_errors", ["fieldName" => "description"])
                                    </div>

                                    <div class="form-group">
                                        <label>@lang("Details")</label>
                                        <textarea 
                                            name="details"
                                            class="form-control @if($errors->has('details')) is-invalid @endif">{{old("details", $post->details)}}</textarea>
                                        @include("admin._layout.partials.form_errors", ['fieldName' => 'details'])
                                    </div>

                                    <div class="form-group">
                                        <label>@lang("Tags")</label>
                                        <select 
                                            name="tag_id[]"
                                            class="form-control @if($errors->has('tag_id')) is-invalid @endif" 
                                            multiple>
                                            @foreach($tags as $tag)
                                            <option 
                                                value="{{$tag->id}}"
                                                @if(is_array(old("tag_id", $post->tags->pluck("id")->toArray())) && in_array($tag->id, old("tag_id", $post->tags->pluck("id")->toArray())))
                                                selected
                                                @endif
                                                >
                                                {{$tag->name}}
                                            </option>
                                            @endforeach
                                        </select>
                                        @include("admin._layout.partials.form_errors", ["fieldName" => "tag_id"])
                                    </div> 

                                    <div class="form-group">
                                        <label>@lang("Choose Post Photo")</label>
                                        <input 
                                            type="file" 
                                            class="form-control @if($errors->has('photo')) is-invalid @endif" 
                                            name="photo">
                                        @include("admin._layout.partials.form_errors", ["fieldName" => "photo"])
                                    </div>

                                </div>
                                <div class="offset-md-1 col-md-5">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>@lang("Photo")</label>

                                                <div class="text-right">
                                                    <button 
                                                        type="button" 
                                                        class="btn btn-sm btn-outline-danger"
                                                        data-action="delete-photo"
                                                        data-photo="photo"
                                                        >
                                                        <i class="fas fa-remove"></i>
                                                        @lang("Delete Photo")
                                                    </button>
                                                </div>
                                                <div class="text-center">
                                                    <img 
                                                        src="{{$post->getPhotoUrl()}}" 
                                                        alt="" 
                                                        class="img-fluid"
                                                        data-container="photo"
                                                        >
                                                </div>
                                            </div>
                                        </div>                 
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">@lang("Save")</button>
                            <a href="{{route('admin.posts.index')}}" class="btn btn-outline-secondary">@lang("Cancel")</a>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@push("footer_javascript")
<script src="{{url('/themes/admin/plugins/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
<script src="{{url('/themes/admin/plugins/ckeditor/adapters/jquery.js')}}" type="text/javascript"></script>
<script type="text/javascript">
$('#entity-form [name="details"]').ckeditor({
    "height": "400px",
    "filebrowserBrowseUrl": "{{ route('elfinder.ckeditor') }}"
});

$('#entity-form [name="post_category_id"]').select2({
    "theme": "bootstrap4"
});
$('#entity-form [name="tag_id[]"]').select2({
    "theme": "bootstrap4"
});

$('#entity-form').validate({
    rules: {
        "title": {
            required: true,
            minlength: 20,
            maxlength: 255
        },
        "description": {
            minlength: 50,
            maxlength: 500
        },
    },
    errorElement: 'span',
    errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
    }
});

$('#entity-form').on("click", "[data-action='delete-photo']", function(e){
   e.preventDefault();
   
   $.ajax({
       "url": "{{route('admin.posts.delete_photo', ['post' => $post->id])}}",
       "type": "post",
       "data": {
           "_token": "{{csrf_token()}}"
       }   
   }).done(function(response){
       toastr.success(response.system_message);
       $("#entity-form [data-container='photo']").attr("src", response.photo_url);
   }).fail(function(){
       toastr.error("An error occurred while deleting the photo");
   });
   
});                                                     
</script>
@endpush