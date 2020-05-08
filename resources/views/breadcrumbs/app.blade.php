@include('breadcrumbs.header')

	<body>
        <!-- This section is global -->
        @if (session()->has('error'))

            <script>
                toastr.error('{{session()->get('error')}}', 'An error ocurred')
            </script>

        @elseif (session()->has('success'))

            <script>
                toastr.success('{{session()->get('success')}}', 'Success!')
            </script>

        @endif

		@yield('content')

        @include('breadcrumbs.footer')

	</body>

</html>
