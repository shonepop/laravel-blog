<div class="btn-group">
    <a href="{{$comment->getFrontUrl()}}" class="btn btn-info" target="_blank">
        <i class="fas fa-eye"></i>
    </a>
    <!-- Enabled user -->
    @if($comment->isEnabled())
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#disable-modal"
        data-action="disable"
        data-id="{{$comment->id}}"
        data-name="{{$comment->author_name}}">
        <i class="fas fa-minus-circle"></i>
    </button>
    @endif
    <!-- Disabled user -->
    @if($comment->isDisabled())
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#enable-modal"
        data-action="enable"
        data-id="{{$comment->id}}"
        data-name="{{$comment->author_name}}">    
        <i class="fas fa-check"></i>
    </button>
    @endif
</div>


