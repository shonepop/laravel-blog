@extends("admin._layout.layout")

@section("seo_title", __("Add New Post"))

@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang("Blog Posts Slider Form")</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.posts.index')}}">@lang("Home")</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.slider.index')}}">@lang("Blog Posts Slider")</a></li>
                    <li class="breadcrumb-item active">@lang("Add New Post")</li>
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">@lang("Add New Post")</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{route('admin.slider.insert')}}" method="post" id="entity-form" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label>@lang("Title")</label>
                                <input 
                                    name="title"
                                    value="{{old('title')}}"
                                    type="text" 
                                    class="form-control @if($errors->has('title')) is-invalid @endif" 
                                    placeholder="Enter post title">
                                @include("admin._layout.partials.form_errors", ["fieldName" => "title"])
                            </div>
                            <div class="form-group">
                                <label>@lang("Button Name")</label>
                                <input 
                                    name="button_name"
                                    value="{{old('button_name')}}"
                                    type="text" 
                                    class="form-control @if($errors->has('button_name')) is-invalid @endif" 
                                    placeholder="Enter button name">
                                @include("admin._layout.partials.form_errors", ["fieldName" => "button_name"])
                            </div>
                            <div class="form-group">
                                <label>@lang("Button Url")</label>
                                <input 
                                    name="button_url"
                                    value="{{old('button_url')}}"
                                    type="text" 
                                    class="form-control @if($errors->has('button_url')) is-invalid @endif" 
                                    placeholder="Enter button url">
                                @include("admin._layout.partials.form_errors", ["fieldName" => "button_url"])
                            </div>
                            <div class="form-group">
                                <label>@lang("Choose Post Photo (min:2000x2000)")</label>
                                <input 
                                    type="file" 
                                    class="form-control @if($errors->has('photo')) is-invalid @endif" 
                                    name="photo">
                                @include("admin._layout.partials.form_errors", ["fieldName" => "photo"])
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">@lang("Save")</button>
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
<script type="text/javascript">

$('#entity-form').validate({
    rules: {
        "title": {
            required: true,
            minlength: 5,
            maxlength: 255
        },
        "button_name": {
            required: true,
            minlength: 2,
            maxlength: 255
        },
        "button_url": {
            required: true
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

</script>
@endpush