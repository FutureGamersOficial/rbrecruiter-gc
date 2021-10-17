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
    <script src="https://cdn.jsdelivr.net/combine/npm/lightgallery@2.2.1,npm/lightgallery@2.2.1/plugins/zoom/lg-zoom.umd.min.js,npm/lightgallery@2.2.1/plugins/fullscreen/lg-fullscreen.umd.min.js"></script>
	</body>

</html>
