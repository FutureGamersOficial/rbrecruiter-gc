@include('breadcrumbs.header')

	<body>
        <!-- Google Tag Manager (noscript) -->
        <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T47K5CG"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
        <!-- End Google Tag Manager (noscript) -->
        <!-- This section is global -->
        @if (session()->has('error'))

            <script>
                toastr.error('{{session()->get('error')}}', '{{__('Error')}}')
            </script>

        @elseif (session()->has('success'))

            <script>
                toastr.success('{{session()->get('success')}}', '{{__('Success')}}')
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
