@if(Auth::user()->id != $user->id)
<div class="btn-group">
    <a href="{{route('admin.users.edit', ["user" => $user->id])}}" class="btn btn-info">
        <i class="fas fa-edit"></i>
    </a>
    <!-- Enabled user -->
    @if($user->isEnabled())
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#disable-modal"
        data-action="disable"
        data-id="{{$user->id}}"
        data-name="{{$user->name}}">
        <i class="fas fa-minus-circle"></i>
    </button>
    @endif
    <!-- Disabled user -->
    @if($user->isDisabled())
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#enable-modal"
        data-action="enable"
        data-id="{{$user->id}}"
        data-name="{{$user->name}}">    
        <i class="fas fa-check"></i>
    </button>
    @endif
</div>
@else
<div>Logged In User!</div>
@endif

