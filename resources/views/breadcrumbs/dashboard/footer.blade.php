<div class="dashboard-footer">

  <div class="row">

    <div class="col">
        <a href="https://www.gnu.org/licenses/gpl-3.0.en.html" target="_blank"><img src="{{ asset('img/gplv3-with-text-84x42.png') }}" alt="gnu gpl v3 logo"></a>
        &nbsp;
        <a href="{{ config('app.source_repo') }}" target="_blank"><img src="{{ asset('img/GitHub-Mark-32px.png') }}" alt="github wordmark repo link"></a>
    </div>


    <div class="col-4 d-inline-block">

        <p>{!! __('Copyright &copy; :currentYear :authorName &mdash; <a href="licenseTextURL">:licenseFullName</a>', ['authorName' => 'Miguel Nogueira', 'currentYear' => now()->year, 'licenseTextURL' => 'https://www.gnu.org/licenses/gpl-3.0.en.html', 'licenseFullName' => 'GNU GPL v3']) !!}</p>

    </div>

  </div>

</div>
