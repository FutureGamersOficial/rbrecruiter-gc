@include('breadcrumbs.header')

	<body>
        <!-- This section is global -->
        @if (session()->has('error'))

            <script>
                toastr.error('{{session()->get('error')}}', '{{__('messages.global_error')}}')
            </script>

        @elseif (session()->has('success'))

            <script>
                toastr.success('{{session()->get('success')}}', '{{__('messages.global_success')}}')
            </script>

        @endif

		@yield('content')

    @include('breadcrumbs.footer')
    <script>
        $('.dropdown-toggle').dropdown()
    </script>
	</body>

</html>
