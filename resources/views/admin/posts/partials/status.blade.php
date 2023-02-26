@if($post->isEnabled())
<span class="text-success">@lang('enabled')</span>
@endif
@if($post->isDisabled())
<span class="text-danger">@lang('disabled')</span>
@endif