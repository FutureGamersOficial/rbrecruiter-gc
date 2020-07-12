@foreach($form['fields'] as $fieldName => $field)

    @switch ($field['type'])

        @case('textarea')

        <div class="form-group mt-2 mb-2">

            <label for="{{$fieldName}}">{{$field['title']}}</label>
            <textarea class="form-control" rows="7" name="{{$fieldName}}" id="{{$fieldName}}" {{ ($disableFields) ? 'disabled' : '' }}>

         </textarea>

        </div>

        @break

        @case('textbox')

        <div class="form-group mt-2 mb-2">

            <label for="{{$fieldName}}">{{$field['title']}}</label>
            <input type="text" name="{{$fieldName}}" id="{{$fieldName}}" {{ ($disableFields) ? 'disabled' : '' }} class="form-control">


        </div>

        @break

    @endswitch

@endforeach
