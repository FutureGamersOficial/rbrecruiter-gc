<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{ config('adminlte.logo_img') }}" height="100px" style="border-radius: 100px" class="logo" alt="App Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
