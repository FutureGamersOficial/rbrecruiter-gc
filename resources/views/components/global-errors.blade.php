<!-- I begin to speak only when I am certain what I will say is not better left unsaid - Cato the Younger -->

@if (session()->has('success'))

    <script>
        toastr.success("{{session('success')}}")
    </script>

@elseif(session()->has('error'))

    <script>
        toastr.error("{{session('error')}}")
    </script>

@elseif($errors->any())

    @foreach($errors->all() as $error)
        <script>
            toastr.error('{{$error}}')
        </script>
    @endforeach

@endif
