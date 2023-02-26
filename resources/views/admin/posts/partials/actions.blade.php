<div class="btn-group">
    <a href="{{$post->getFrontUrl()}}" class="btn btn-info" target="_blank">
        <i class="fas fa-eye"></i>
    </a>
    <a href="{{route('admin.posts.edit', ["post" => $post->id])}}" class="btn btn-info">
        <i class="fas fa-edit"></i>
    </a>
    <!-- Enabled post -->
    @if($post->isEnabled())
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#disable-modal"
        data-action="disable"
        data-id="{{$post->id}}"
        data-name="{{$post->title}}">
        <i class="fas fa-minus-circle"></i>
    </button>
    @endif
    <!-- Disabled post -->
    @if($post->isDisabled())
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#enable-modal"
        data-action="enable"
        data-id="{{$post->id}}"
        data-name="{{$post->title}}">    
        <i class="fas fa-check"></i>
    </button>
    @endif
    <!-- Important post -->
    @if($post->isImportant())
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#regular-modal"
        data-action="regular"
        data-id="{{$post->id}}"
        data-name="{{$post->title}}">
        <i class="far fa-circle"></i>
    </button>
    @endif
    @if($post->isRegular())
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#important-modal"
        data-action="important"
        data-id="{{$post->id}}"
        data-name="{{$post->title}}">
        <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
    </button>
    @endif
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#delete-modal"
        data-id="{{$post->id}}"
        data-name="{{$post->title}}"
        data-action="delete">
        <i class="fas fa-trash"></i>
    </button>
</div>

