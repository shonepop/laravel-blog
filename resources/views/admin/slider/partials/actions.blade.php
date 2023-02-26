<div class="btn-group">
    <a href="{{route('admin.slider.edit', ['post' => $post->id])}}" class="btn btn-info">
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
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#delete-modal"
        data-action="delete"
        data-id="{{$post->id}}"
        data-name="{{$post->title}}"
        >
        <i class="fas fa-trash"></i>
    </button>
</div>