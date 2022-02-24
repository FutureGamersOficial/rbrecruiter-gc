<span>

    @if ($user->isBanned())
        <span class="badge badge-danger ml-2"><i class="fa fa-ban"></i> {{__('Suspended')}}</span>
    @else
        <span class="badge badge-success ml-2"><i class="fas fa-check"></i>{{__('Active')}}</span>
    @endif

    @if (Auth::user()->hasRole('admin'))
       @if ($user->has2FA())
            <span class="badge badge-success ml-2"><i class="fas fa-lock"> </i> {{ __('MFA Active') }}</span>
       @else
           <span class="badge badge-danger ml-2"><i class="fas fa-lock-open"> </i> {{ __('MFA Inactive') }}</span>
       @endif

           @if(!is_null($user->email_verified_at))
               <span class="badge badge-success ml-2"><i class="fas fa-check-square"> </i> {{ __('Verified Email') }}</span>
           @else
               <span class="badge badge-danger ml-2"><i class="fas fa-exclamation-circle"></i>  {{ __('Unverified Email') }}</span>
           @endif
    @endif

</span>
