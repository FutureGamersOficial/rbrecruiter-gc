@extends('adminlte::page')

@section('title', config('app.name') . ' | ' . __('Profile'))

@section('content_header')

    <h4>{{__('Profile')}} / {{__('Settings')}}</h4>

@stop

@section('css')

    <link rel="stylesheet" href="/css/profile.css">

@stop

@section('js')

    @if (session()->has('success'))

        <script>
            toastr.success("{{session('success')}}")
        </script>

    @elseif(session()->has('error'))

        <script>
            toastr.error("{{session('error')}}")
        </script>

    @endif

@stop

@section('content')


    <div class="row">

        <div class="col">

        </div>

        <div class="col">

            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        @if($profile->avatarPreference == 'gravatar')
                            <img class="profile-user-img img-fluid img-circle" src="https://gravatar.com/avatar/{{md5(Auth::user()->email)}}" alt="{{ __('User profile picture') }}">
                        @else
                            <img class="profile-user-img img-fluid img-circle" src="https://crafatar.com/avatars/{{Auth::user()->uuid}}" alt="{{ __('User profile picture') }}">
                        @endif
                    </div>

                    <h3 class="profile-username text-center">{{Auth::user()->name}}</h3>

                    <p class="text-muted text-center">{{$profile->profileShortBio}}</p>

                    <div class="text-center">

                        <button type="button" class="btn btn-sm btn-success" onclick="window.location.href='{{route('showSingleProfile', ['user' => Auth::user()->id])}}'"><i class="fas fa-eye"></i></button>

                    </div>
                </div>

                <div class="card-footer text-center">

                    <a href="https://github.com/{{$github}}" class="pr-2 pl-2"><i class="fab fa-github fa-2x"></i></a>
                    <a href="#" onclick="toastr.info('{{__('messages.profile.discord_tag', ['discordTag' => $discord])}}')" class="pr-2 pl-2"><i class="fab fa-discord fa-2x"></i></a>
                    <a href="https://twitter.com/{{$twitter}}" class="pr-2 pl-2"><i class="fab fa-twitter fa-2x"></i></a>
                    <a href="https://instagram.com/{{$insta}}" class="pr-2 pl-2"><i class="fab fa-instagram fa-2x"></i></a>

                </div>

                <!-- /.card-body -->
            </div>

        </div>


        <div class="col">


        </div>

    </div>


   <form method="POST" action="{{route('saveProfileSettings')}}" id="saveProfileSettings">

       @method('PATCH')
       @csrf

       <div class="row mt-3">

           <div class="col">

               <div class="card">

                   <div class="card-header">

                       <div class="card-title"><h3>{{__('Basic Information')}}</h3></div>

                   </div>

                   <div class="card-body">

                       <div class="row">

                           <div class="col">

                               <label for="firstName">{{__('First / Last name')}}</label>
                               <input disabled type="text" class="form-control" id="firstName" value="{{Auth::user()->name}}">

                           </div>

                       </div>

                       <div class="form-group mt-3">

                           <label for="shortBio">{{__('Short bio')}}</label>
                           <input  type="text" name="shortBio" id="shortBio" class="form-control" value="{{$profile->profileShortBio}}">

                       </div>

                       <div class="form-group mt-3">

                           <label for="aboutMe">{{__('About me')}}</label>
                           <textarea name="aboutMe" id="aboutMe" rows="8" class="form-control">{{$profile->profileAboutMe}}</textarea>
                           <p class="text-muted"><a href="https://github.com/adam-p/markdown-here/wiki/Markdown-Cheatsheet">{{__('Markdown supported')}}</a></p>

                       </div>

                   </div>

               </div>

           </div>

           <div class="col">

                <div class="card">

                    <div class="card-header">
                        <div class="card-title"><h3>{{__('Preferences & Media')}}</h3></div>
                    </div>

                    <div class="card-body">

                        <label>{{__('Retrieve avatar from: ')}} </label>

                        <div class="form-group mb-3">

                            <label>
                                <input type="radio" name="avatarPref" value="MOJANG" {{($profile->avatarPreference == 'crafatar') ? 'checked' : ''}}>
                                <img alt="{{ __('Mojang Logo (Minecraft)') }}" height="150px" width="150px" src="data:image/svg+xml;utf8;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iVVRGLTgiIHN0YW5kYWxvbmU9Im5vIj8+CjxzdmcgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iMjUwMCIgaGVpZ2h0PSIzODQiIHZpZXdCb3g9IjAgMCAzNzggNTgiPjxwYXRoIGQ9Ik0wIDBoMTUuNjZDNy44MyAxLjA0LjgxIDcuMDkgMCAxNS4xOVYweiIgZmlsbD0iI2ZmZiIvPjxwYXRoIGQ9Ik0xNS42NiAwaDQyLjYxYy4wNSAxNCAuMTEgMjgtLjAxIDQyLS4wMjEgOC4wNC02LjcxIDE0LjgyLTE0LjQ4IDE2SDBWMTUuMTlDLjgxIDcuMDkgNy44MyAxLjA0IDE1LjY2IDB6IiBmaWxsPSIjZGIyMzMxIi8+PHBhdGggZD0iTTU4LjI3IDBoOTEuMDZjLTcuMzEgMS0xNC40MiA0LjM3LTE5LjIgMTAuMDktNi40MiA3LjM1LTguNzMgMTguMDMtNS43OCAyNy4zNCAzLjI1IDExLjA4IDEzLjUyIDE5LjQ0IDI0Ljk5IDIwLjU3SDQzLjc4YzcuNzcxLTEuMTggMTQuNDYtNy45NiAxNC40OC0xNiAuMTItMTQgLjA2LTI4IC4wMS00MnoiIGZpbGw9IiNmZmYiLz48cGF0aCBkPSJNMTQ5LjMzIDBoNS40M2M5LjU4Ljk4IDE4LjYyIDYuNjkgMjMuMTEgMTUuMyA1Ljc4IDEwLjMxIDQuMTUgMjQuMDMtMy43NCAzMi44MS00LjY2IDUuNTMxLTExLjUzIDguNzUtMTguNTkgOS44OTFoLTYuMmMtMTEuNDctMS4xMy0yMS43NC05LjQ5LTI0Ljk5LTIwLjU3LTIuOTUtOS4zMS0uNjQtMTkuOTkgNS43OC0yNy4zNEMxMzQuOTEgNC4zNyAxNDIuMDIgMSAxNDkuMzMgMHoiIGZpbGw9IiMwNDA3MDciLz48cGF0aCBkPSJNMTU0Ljc2IDBoMTkxLjU0MWMtOS41NyAxLTE4LjYwMiA2LjctMjMuMDcgMTUuMzEtNS42MzEgMTAuMDctNC4yNCAyMy40MTEgMy4yMjkgMzIuMTkgNC42NCA1Ljg1OSAxMS42OSA5LjM0IDE4Ljk4OSAxMC41SDE1NS41NGM3LjA2LTEuMTQxIDEzLjkzLTQuMzU5IDE4LjU5LTkuODkxIDcuODktOC43NzkgOS41Mi0yMi41IDMuNzQtMzIuODFDMTczLjM4IDYuNjkgMTY0LjM0Ljk4IDE1NC43NiAweiIgZmlsbD0iI2ZmZiIvPjxwYXRoIGQ9Ik0zNDYuMzAxIDBoNS4zNEMzNjEuODcgMS4wNiAzNzEgNy42NSAzNzUuNSAxNi44NWMtNC4wMS4wNC04LjAxLjA0LTEyLjAxIDAtMy4zMDEtMy4zNy03LjUtNi4xMS0xMi4zMDEtNi41OC02LjkxLTEtMTMuOTkgMi40NS0xNy44ODkgOC4xMy00LjcwMSA2LjU2LTQuMzQxIDE2LjIyLjg4OSAyMi4zNyA0Ljc1IDYuMDUxIDEzLjMyIDguNzMgMjAuNjIxIDYuMTUgNi4xNDktMS45MiAxMC42MDktNy4xOTkgMTIuNTY5LTEzLjE5OS03LjE3LS4wNjEtMTQuMzI5LS4wMjEtMjEuNDg5LS4wMzEtLjAxMS0zLjM3OS0uMDExLTYuNzUtLjAyMS0xMC4xMjkgMTAuNTc5IDAgMjEuMTU5LS4wMSAzMS43NS4wMS4wOS43My4yOCAyLjE4LjM4IDIuOTF2NS4yMmMtMS4yNzkgMTMuNTUtMTIuNzMgMjUuMDY5LTI2LjMyIDI2LjNoLTYuMjNjLTcuMjk5LTEuMTYtMTQuMzUtNC42NDEtMTguOTg5LTEwLjUtNy40Ny04Ljc3OS04Ljg2LTIyLjEyLTMuMjI5LTMyLjE5QzMyNy42OTkgNi43IDMzNi43MyAxIDM0Ni4zMDEgMHoiIGZpbGw9IiMwNDA3MDciLz48cGF0aCBkPSJNMzUxLjY0MSAwSDM3OHYyNi40OGMtLjEtLjczLS4yOS0yLjE4LS4zOC0yLjkxLTEwLjU5MS0uMDItMjEuMTcxLS4wMS0zMS43NS0uMDEuMDEgMy4zOC4wMSA2Ljc1LjAyMSAxMC4xMjkgNy4xNi4wMTEgMTQuMzE5LS4wMjkgMjEuNDg5LjAzMS0xLjk2IDYtNi40MiAxMS4yNzktMTIuNTY5IDEzLjE5OS03LjMwMSAyLjU4LTE1Ljg3MS0uMS0yMC42MjEtNi4xNS01LjIyOS02LjE0OS01LjU5LTE1LjgxLS44ODktMjIuMzcgMy44OTgtNS42OCAxMC45NzktOS4xMyAxNy44ODktOC4xMyA0LjgwMS40NyA5IDMuMjEgMTIuMzAxIDYuNTggNCAuMDQgOCAuMDQgMTIuMDEgMEMzNzEgNy42NSAzNjEuODcgMS4wNiAzNTEuNjQxIDB6IiBmaWxsPSIjZmZmIi8+PHBhdGggZD0iTTY2LjY5Ljk0YzIuNyAwIDUuNDEuMDEgOC4xMS4wNSA1Ljc5IDguNCAxMS40MzkgMTYuODkgMTcuMzggMjUuMTggNS42OS04LjM5IDExLjU0LTE2LjY2IDE3LjE1LTI1LjEgMi43LS4xIDUuNC0uMTUgOC4xMS0uMTl2NTYuMTljLTMuMzUuMDUtNi43LS4wMy0xMC4wNS0uMTQxLjA3LTExLjY4OS4wOS0yMy4zOC0uMDEtMzUuMDctNC4zMiA1Ljk0LTguMjkgMTIuMTIxLTEyLjQ3IDE4LjE1QzkzLjAxIDQwIDkxLjEgNDAgODkuMiAzOS45OWMtNC4xLTYuMDQtOC4xMDktMTIuMTQtMTIuMzctMTguMDctLjE3IDExLjY4OS0uMDQgMjMuMzgtLjA2IDM1LjA2MS0zLjM2LjA4LTYuNzIuMS0xMC4wOC4wNDktLjAxLTE4LjcgMC0zNy4zOSAwLTU2LjA5ek0xODMuMTIgMS4wNmgzMWMtLjAxMSAxMC42NC4wMyAyMS4yOS0uMDExIDMxLjkzLS4wMzkgNS42OC0xLjExOSAxMS43Mi00LjkxIDE2LjE2LTYuNDc5IDcuMjI5LTE3LjAyOSA3LjgxLTI2LjA3OSA3Ljg5IDAtMy4xNyAwLTYuMzQuMDItOS41MTEgNS42OC0uMTI5IDExLjk2OS0uMTA5IDE2Ljc0LTMuNjU5IDMuMzE5LTIuNTMgNC4xNi02Ljk2IDQuMTYtMTAuODk5LjAyMS03LjU2MS4wOS0xNS4xMjEtLjA2LTIyLjY4MS02Ljk2MS4wNC0xMy45MS4wMi0yMC44Ni4wMlYxLjA2ek0yMzcuNzkgMS40NWMyLjEwMS0xLjM5IDUuMzctLjQyIDcuOTItLjU3IDcuNDQgMTguNzIgMTQuOTc5IDM3LjQxIDIyLjQ1IDU2LjEyLTMuNjMxLjEyLTcuMjcuMDktMTAuOS0uMDYxLTEuNjE5LTQuNTEtMy40Mi04Ljk0OS01LjA1LTEzLjQ1OS02Ljg3LS4wOS0xMy43MjktLjAyMS0yMC42MDEtLjA1MS0xLjkzIDQuNDUtMy4yMDkgOS4yNi01LjUxIDEzLjQ5LTMuNTQ5LjMxMS03LjExOS4xNDEtMTAuNjguMTNDMjIyLjkxIDM4LjUyOSAyMzAuMTUgMTkuOSAyMzcuNzkgMS40NXpNMjcxLjgxMS45NWMyLjYyOS4wMSA1LjI2LjA0IDcuODk5LjA5IDguMTQgMTEuNzMgMTYuMjI5IDIzLjUyIDI0LjYwMSAzNS4wOS4xMTktMTEuNjkuMDYtMjMuMzkuMDI5LTM1LjA5IDMuMzQtLjA3IDYuNjg5LS4xMSAxMC4wMy0uMDkuMDEgMTguNzEgMCAzNy40MiAwIDU2LjE0LTIuNjktLjAyOS01LjM4LS4wNy04LjA2OS0uMTZhMjUzOC44NzcgMjUzOC44NzcgMCAwIDAtMjQuMzYxLTM0LjljLS4xMzkgMTEuNjYtLjAyOSAyMy4zMS0uMDYgMzQuOTYtMy4zNi4wNi02LjcxLjA2LTEwLjA2OS4wMjlWLjk1eiIgZmlsbD0iIzA0MDcwNyIvPjxwYXRoIGQ9Ik0zOC44NiAxNC4xMmMuMTYtMi44OC42LTYuMSAyLjk4LTguMDUuOTUgMyAyLjY0OSA2LjI2IDEuNjIgOS40NC0xLjQ0IDEuNjctNC41NS45Ny00LjYtMS4zOXpNMTQ3LjUyIDEwLjdjNi41MS0xLjc1IDEzLjguNDQgMTguMzkgNS4zMyA0LjA4IDQuMTkgNS45NSAxMC4zNSA0Ljk0IDE2LjEtMS4wNSA2Ljc5LTYuMjEgMTIuNjgxLTEyLjczIDE0Ljc4LTYuNCAyLjI1LTEzLjkxLjU0LTE4Ljc2LTQuMTgtNC4zNS0zLjkxLTYuNjItOS45NTEtNS45My0xNS43Ni43MS03LjY1IDYuNzEtMTQuMzQgMTQuMDktMTYuMjd6IiBmaWxsPSIjZmZmIi8+PHBhdGggZD0iTTkuMjggMTcuMDFjMS44OS00LjU5IDcuOS0yLjc4IDExLjc4LTMuMTggNC43My0uNSA5LjA2IDEuNjQgMTIuNiA0LjU3LjMyLTEuODEuNjItMy42Mi45OS01LjQzIDEuOTcgMi4wOCAzLjU0IDQuNTYgNS44MSA2LjM0IDEuNjkgMS41MyAzLjk1LTIuMDYgNS4xOC0uMDggMi41MyA1LjIxIDIuNDYgMTEuMjA5IDMuMjUgMTYuODUtMS41OS0uNzUtMy4xNy0xLjQ5LTQuNzUtMi4yNUM0MS41OSAyNSAzMC45IDE4LjI2IDIyLjA0IDIyLjA4Yy03LjggMy41Ny02Ljk3IDE1Ljk4LjM2IDE5LjYyIDguMTYgNC4yMzkgMTcuOCAzLjA3OSAyNi41NSAxLjc2LS40MiAyLjU0LTIuMDUgNS4yNC01LjAzIDQuOTItOS45NC4xMi0xOS45LjA5MS0yOS44NC4wMTEtMy4wMi4zMy01LjM0LTIuNDktNS4wNS01LjM3MS4wOS04LjY2MS0uMzctMTcuMzcuMjUtMjYuMDF6TTI0MS44MDEgMTcuMDJjMi4zODkgNS41NSA0LjM5OCAxMS4yNCA2LjYgMTYuODYtNC4zNC0uMDEtOC42OC0uMDEtMTMuMDMuMDExIDIuMTA5LTUuNjQxIDQuMzI4LTExLjIzMSA2LjQzLTE2Ljg3MXpNMzUxLjY4IDU4YzEzLjU5LTEuMjMgMjUuMDQxLTEyLjc1IDI2LjMyLTI2LjNWNThoLTI2LjMyeiIgZmlsbD0iI2ZmZiIvPgoJPG1ldGFkYXRhPgoJCTxyZGY6UkRGIHhtbG5zOnJkZj0iaHR0cDovL3d3dy53My5vcmcvMTk5OS8wMi8yMi1yZGYtc3ludGF4LW5zIyIgeG1sbnM6cmRmcz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC8wMS9yZGYtc2NoZW1hIyIgeG1sbnM6ZGM9Imh0dHA6Ly9wdXJsLm9yZy9kYy9lbGVtZW50cy8xLjEvIj4KCQkJPHJkZjpEZXNjcmlwdGlvbiBhYm91dD0iaHR0cHM6Ly9pY29uc2NvdXQuY29tL2xlZ2FsI2xpY2Vuc2VzIiBkYzp0aXRsZT0ibW9qYW5nLWNvbXBhbnktYnJhbmQtbG9nbyIgZGM6ZGVzY3JpcHRpb249Im1vamFuZy1jb21wYW55LWJyYW5kLWxvZ28iIGRjOnB1Ymxpc2hlcj0iSWNvbnNjb3V0IiBkYzpkYXRlPSIyMDE3LTA3LTEyIiBkYzpmb3JtYXQ9ImltYWdlL3N2Zyt4bWwiIGRjOmxhbmd1YWdlPSJlbiI+CgkJCQk8ZGM6Y3JlYXRvcj4KCQkJCQk8cmRmOkJhZz4KCQkJCQkJPHJkZjpsaT5JY29uIE1hZmlhPC9yZGY6bGk+CgkJCQkJPC9yZGY6QmFnPgoJCQkJPC9kYzpjcmVhdG9yPgoJCQk8L3JkZjpEZXNjcmlwdGlvbj4KCQk8L3JkZjpSREY+CiAgICA8L21ldGFkYXRhPjwvc3ZnPgo=">
                            </label>

                            <label>
                                <input type="radio" name="avatarPref" value="GRAVATAR" {{($profile->avatarPreference == 'gravatar') ? 'checked' : ''}}>
                                <img alt="{{ __('Gravatar logo') }}" src="/img/gravatar.png">
                            </label>

                        </div>

                        <label>{{__('Social Media')}}</label>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fab fa-github"></i></span>
                            </div>
                            <input name="socialGithub" type="text" class="form-control" placeholder="{{__('GitHub Username')}}" value="{{$github}}">
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fab fa-discord"></i></span>
                            </div>
                            <input name="socialDiscord" type="text" class="form-control" placeholder="{{__('Discord Handle')}}" value="{{$discord}}">
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                            </div>
                            <input name="socialTwitter" type="text" class="form-control" placeholder="{{__('Twitter Username')}}" value="{{$twitter}}">
                        </div>

                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                            </div>
                            <input name="socialInsta" type="text" class="form-control" placeholder="{{__('Instagram Username')}}" value="{{$insta}}">
                        </div>

                    </div>

                </div>

           </div>

       </div>

       <div class="row mt-3">

           <div class="col text-center">

               <button type="button" class="btn btn-success" onclick="document.getElementById('saveProfileSettings').submit()">{{__('Update Profile')}}</button>

           </div>

       </div>

   </form>

@stop
@section('footer')
    @include('breadcrumbs.dashboard.footer')
@stop
