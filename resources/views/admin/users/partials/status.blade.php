@if($user->isEnabled())
<span class="text-success">@lang('enabled')</span>
@endif
@if($user->isDisabled())
<span class="text-danger">@lang('disabled')</span>
@endif