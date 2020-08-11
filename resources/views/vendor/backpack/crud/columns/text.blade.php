{{-- regular object attribute --}}
@php
	$value = data_get($entry, $column['name']);
    $value = is_array($value) ? json_encode($value) : $value;

    $column['escaped'] = $column['escaped'] ?? true;
    $column['limit'] = $column['limit'] ?? 40;
    $column['text'] = Str::limit($value, $column['limit'], '[...]');

    // check if prefix is a callback or attribute. Process callback if needed
    if (isset($column['prefix'])) {
        $value = $column['prefix'];
        $column['prefix'] = !is_string($value) && is_callable($value) ? $value($crud, $column, $entry) : $value ?? '';
    }

@endphp

<span>
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_start')
        @if(isset($column['prefix']))
            {!! $column['prefix'] !!}
        @endif
        @if($column['escaped'])
            {{ $column['text'] }}
        @else
            {!! $column['text'] !!}
        @endif
    @includeWhen(!empty($column['wrapper']), 'crud::columns.inc.wrapper_end')
</span>
