@php
    function is_assoc(array $arr)
    {
        return (array() === $arr) ? false:
            (array_keys($arr) !== range(0, count($arr) - 1));
    }
@endphp

@foreach ($form as $input)
    
@endforeach