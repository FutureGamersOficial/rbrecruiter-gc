<span>

    @if ($user->isBanned())
        <span class="badge badge-danger"><i class="fa fa-ban"></i> {{__('Suspended')}}</span>
    @else
        <span class="badge badge-success">{{__('Active')}}</span>
    @endif

    @if(!is_null($user->email_verified_at))
        <span class="badge badge-success"><i class="fas fa-check-square"> </i> {{ __('Verified Email') }}</span>
    @else
        <span class="badge badge-danger"><i class="fas fa-exclamation-circle"></i>  {{ __('Unverified Email') }}</span>
    @endif

</span>
