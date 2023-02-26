@if($comment->isEnabled())
<span class="text-success">@lang('enabled')</span>
@endif
@if($comment->isDisabled())
<span class="text-danger">@lang('disabled')</span>
@endif