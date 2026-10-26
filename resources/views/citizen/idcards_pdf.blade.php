<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Senior Citizen's Identification Cards</title>
{{-- OSCA 2026 ID cards on 8.5" x 13" paper. Layout constants live in App\Services\SeniorIdCards. --}}
<style>
@font-face {
    font-family: 'Carlito';
    font-weight: bold;
    src: url('{{ str_replace('\\', '/', resource_path('fonts/Carlito-Bold.ttf')) }}') format('truetype');
}
@page { margin: 0; }
body { margin: 0; }
.sheet { position: relative; width: 612pt; height: 936pt; overflow: hidden; page-break-after: always; }
.sheet-last { page-break-after: auto; }
.card { position: absolute; width: {{ \App\Services\SeniorIdCards::CARD_WIDTH }}pt; height: {{ \App\Services\SeniorIdCards::CARD_HEIGHT }}pt; }
.card-art { position: absolute; left: 0; top: 0; width: 100%; height: 100%; }
.photo { position: absolute; }
.v { position: absolute; white-space: nowrap; line-height: 1; font-family: 'Carlito'; font-weight: bold; color: #000; }
</style>
</head>
<body>
@php
    $n = fn ($v) => rtrim(rtrim(sprintf('%.2F', $v), '0'), '.');
    $front = str_replace('\\', '/', public_path('template/img/osca-id-front.jpg'));
    $back = str_replace('\\', '/', public_path('template/img/osca-id-back.jpg'));
    $lastSheet = count($sheets) - 1;
@endphp

@foreach ($sheets as $s => $cards)
    {{-- Fronts --}}
    <div class="sheet {{ $s === $lastSheet && ! $withBacks ? 'sheet-last' : '' }}">
        @foreach ($cards as $card)
            <div class="card" style="left:{{ $n($card['origin']['x']) }}pt;top:{{ $n($card['origin']['y']) }}pt">
                <img class="card-art" src="{{ $front }}" alt="">
                @if ($card['photo'])
                    <img class="photo" src="{{ $card['photo']['file'] }}" alt="" style="left:{{ $n($card['photo']['x']) }}pt;top:{{ $n($card['photo']['y']) }}pt;width:{{ $n($card['photo']['width']) }}pt;height:{{ $n($card['photo']['height']) }}pt">
                @endif
                @foreach ($card['fields'] as $field)
                    @continue($field['text'] === '')
                    @php
                        $top = $field['baseline'] - \App\Services\SeniorIdCards::BASELINE_RATIO * $field['fitted'];
                        $left = $field['x'] - $field['max'] / 2;
                    @endphp
                    <div class="v" style="left:{{ $n($left) }}pt;top:{{ $n($top) }}pt;width:{{ $n($field['max']) }}pt;font-size:{{ $n($field['fitted']) }}pt;text-align:center">{{ $field['text'] }}</div>
                @endforeach
            </div>
        @endforeach
    </div>

    {{-- Backs, mirrored so each lines up behind its front when the sheet is flipped on the long edge --}}
    @if ($withBacks)
        <div class="sheet {{ $s === $lastSheet ? 'sheet-last' : '' }}">
            @foreach ($cards as $card)
                @php $origin = \App\Services\SeniorIdCards::origin($card['slot'], true); @endphp
                <div class="card" style="left:{{ $n($origin['x']) }}pt;top:{{ $n($origin['y']) }}pt">
                    <img class="card-art" src="{{ $back }}" alt="">
                </div>
            @endforeach
        </div>
    @endif
@endforeach
</body>
</html>
