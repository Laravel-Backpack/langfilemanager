<ul class="nav nav-tabs " >
    @foreach ($fileArray as $key => $item)
        <li class="nav-item">
            <a class="nav-link {{($key==$first_key ? 'active' : '')}}" data-toggle="tab" data-target="#{{$key}}">{{$key}}</a>
        </li>
    @endforeach
</ul>
<div class="tab-content">
@foreach ($fileArray as $key => $item)
        <div class="tab-pane {{($key==$first_key ? 'active' : '')}}"  id="{{$key}}">
            @php
                if (is_array($item)) {
                    echo $langfile->displayInputs($item, $parents, $header, $level);
                } else {
                    echo view()->make('langfilemanager::language_inputs', [
                        'key' => $key,
                        'item' => $item,
                        'parents' => $parents,
                        'lang_file_name' => $lang_file_name,
                    ])->render();
                }
            @endphp
        </div>
@endforeach
</div>
