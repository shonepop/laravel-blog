@extends("admin._layout.layout")

@section("seo_title", __("Edit User"))

@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang("Your Profile")</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.posts.index')}}">@lang("Home")</a></li>
                    <li class="breadcrumb-item active">@lang("Your Profile")</li>
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
                        <h3 class="card-title">@lang("Change your profile info")</h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.profile.change_password') }}" class="btn btn-outline-warning">
                                <i class="fas fa-lock-open"></i>
                                @lang("Change Password")
                            </a>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form action="{{route('admin.profile.update')}}" method="post" role="form" enctype="multipart/form-data" id="entity-form">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">


                                    <div class="form-group">
                                        <label>@lang("Email")</label>
                                        <div><strong>{{ $user->email }}</strong></div>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang("Name")</label>
                                        <input 
                                            name="name"
                                            value="{{old('name', $user->name)}}"
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
                                                value="{{old('phone', $user->phone)}}"
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
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label>@lang("Photo")</label>

                                                <div class="text-right">
                                                    <button 
                                                        data-action="delete-photo"                                                        data-action="delete"
                                                        type="button" 
                                                        class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-remove"></i>
                                                        @lang("Delete Photo")
                                                    </button>
                                                </div>
                                                <div class="text-center">
                                                    <img src="{{$user->getPhotoUrl()}}" 
                                                         alt="" 
                                                         class="img-fluid" 
                                                         data-container="photo">
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

   
    $("#entity-form").on("click", "[data-action='delete-photo']", function (e) {

        e.preventDefault();

        $.ajax({
            "url": "{{ route('admin.profile.delete_photo') }}",
            "type": "post",
            "data": {
                "_token": "{{csrf_token()}}"
            }

        }).done(function (response) {
            toastr.success(response.system_message);
            $("[data-container='photo']").attr("src", response.photo_url);
        }).fail(function () {
            toastr.error("An error occur while deleting user photo!");
        });
    });


    $('#entity-form').validate({
        rules: {
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