<!-- Footer -->
<footer class="page-footer font-small footer-grad">

    <!-- Copyright - DO NOT REMOVE WITHOUT PERMISSION -->
    <div class="footer-copyright text-center py-3">
        {!! __('<a href=":appUrlConfigValue"> :appNameConfigValue :appReleaseConfigValue &copy; :currentYear - All Rights Reserved. Took :pageLoadTimeMillis seconds.</a>', [
            'appUrlConfigValue' => config('app.url'),
            'appNameConfigValue' => config('app.name'),
            'appReleaseConfigValue' => config('app.release'),
            'currentYear' => now()->year,
            'pageLoadTimeMillis' => round(microtime(true) - LARAVEL_START, 3)
        ]) !!}
    </div>
    <!-- Copyright -->
    <!-- GNU General Public License (https://www.gnu.org/licenses/gpl-3.0.en.html) Built by Miguel N. -->

</footer>
<!-- Footer -->
