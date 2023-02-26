@if($post->isImportant())
<span class="text-success">@lang('important')</span>
@endif
@if($post->isRegular())
<span class="text-info">@lang('regular')</span>
@endif
