@extends("auth._layout.layout")

@section("content")
<p class="login-box-msg">Change your password.</p>

<form action="{{route('admin.profile.change_password_confirm')}}" method="post">
    @csrf
    <div class="input-group mb-3">
        <input 
            name="old_password"
            type="password" 
            class="form-control @if($errors->has('old_password')) is-invalid @endif" 
            placeholder="Old Password">
        @include('admin._layout.partials.form_errors', ['fieldName' => 'old_password'])
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock-open"></span>
            </div>
        </div>
    </div>
    <div class="input-group mb-3">
        <input 
            name="new_password"
            type="password" 
            class="form-control @if($errors->has('new_password')) is-invalid @endif" 
            placeholder="New Password">
        @include('admin._layout.partials.form_errors', ['fieldName' => 'new_password'])
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div>
    <div class="input-group mb-3">
        <input 
            name="new_password_confirm"
            type="password" 
            class="form-control @if($errors->has('new_password_confirm')) is-invalid @endif" 
            placeholder="Confirm New Password">
        @include('admin._layout.partials.form_errors', ['fieldName' => 'new_password_confirm'])
        <div class="input-group-append">
            <div class="input-group-text">
                <span class="fas fa-lock"></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Confirm Password Change</button>
        </div>
        <!-- /.col -->
    </div>
</form>

<p class="mt-3 mb-1">
    <a href="{{ route('password.request') }}">I forgot my password</a>
</p>
@endsection