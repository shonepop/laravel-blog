@extends("admin._layout.layout")

@section("seo_title", __("Add New User"))

@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang("Users Form")</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.posts.index')}}">@lang("Home")</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.users.index')}}">@lang("Users")</a></li>
                    <li class="breadcrumb-item active">@lang("Add New User")</li>
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
                        <h3 class="card-title">@lang("Add New User")</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{route('admin.users.insert')}}" method="post" role="form" enctype="multipart/form-data" id="entity-form">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">


                                    <div class="form-group">
                                        <label>@lang("Email")</label>
                                        <div class="input-group">
                                            <input 
                                                name="email"
                                                value="{{old('email')}}"
                                                type="email" 
                                                class="form-control @if($errors->has('email')) is-invalid @endif" 
                                                placeholder="Enter email">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    @
                                                </span>
                                            </div>
                                            @include("admin._layout.partials.form_errors", ["fieldName" => "email"])
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang("Name")</label>
                                        <input 
                                            name="name"
                                            value="{{old('name')}}"
                                            type="text" 
                                            class="form-control @if($errors->has('name')) is-invalid @endif" 
                                            placeholder="Enter name">
                                        @include("admin._layout.partials.form_errors", ["fieldName" => "name"])
                                    </div>
                                    <div class="form-group">
                                        <label>@lang("Phone")</label>
                                        <div class="input-group">
                                            <input 
                                                name="phone"
                                                value="{{old('phone')}}"
                                                type="text" 
                                                class="form-control @if($errors->has('phone')) is-invalid @endif" 
                                                placeholder="Enter phone">
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fas fa-phone"></i>
                                                </span>
                                            </div>
                                            @include("admin._layout.partials.form_errors", ["fieldName" => "phone"])
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>@lang("Choose New Photo")</label>
                                        <input 
                                            name="photo"
                                            type="file" 
                                            class="form-control @if($errors->has('photo')) is-invalid @endif">
                                        @include("admin._layout.partials.form_errors", ["fieldName" => "photo"])
                                    </div>
                                </div>
                                <div class="offset-md-3 col-md-3">
                                 
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">@lang("Save")</button>
                            <a href="{{route('admin.users.index')}}" class="btn btn-outline-secondary">@lang("Cancel")</a>
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

@push('footer_javascript')
<script type="text/javascript">


    $('#entity-form').validate({
        rules: {
            "email": {
                "required": true,
                "maxlength": 255,
                "email": true
            },
            "name": {
                "required": true,
                "maxlength": 255
            },
            "phone": {
                "required": false,
                "maxlength": 255
            }
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