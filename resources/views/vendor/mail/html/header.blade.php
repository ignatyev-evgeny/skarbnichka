<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="https://charity.ignatyev.pro/dev/logo.png" class="{{ env('APP_NAME') }}" alt="{{ env('APP_NAME') }}">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
