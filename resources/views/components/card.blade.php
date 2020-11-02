<div class="card" id="{{$id}}">
    <!-- Let all your things have their places; let each part of your business have its time. - Benjamin Franklin -->

    <div class="card-header">

        <div class="card-title">
            <h3>{{$cardTitle}}</h3>
        </div>

        {{$cardHeader}}

    </div>

    <div class="card-body">

        {{$slot}}

    </div>


    <div class="card-footer {{$footerStyle}}">

        {{$cardFooter}}

    </div>

</div>
