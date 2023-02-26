@extends("admin._layout.layout")

@section("seo_title", __("Add New Tag"))

@section("content")
<!-- Content Header (Page header) -->
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>@lang("Post Tags Form")</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('admin.posts.index')}}">@lang("Home")</a></li>
                    <li class="breadcrumb-item"><a href="{{route('admin.tags.index')}}">@lang("Post Tags")</a></li>
                    <li class="breadcrumb-item active">@lang("Add New Tag")</li>
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
                        <h3 class="card-title">@lang("Add New Tag")</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form role="form" action="{{route('admin.tags.insert')}}" method="post">
                        @csrf
                        <div class="card-body">
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