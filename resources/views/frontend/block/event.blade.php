<?php
    $last = date("t", time());
    $numofrow = 7;
    $totalrow = ceil($last / 7);
?>

<div class="calendar-cus {{ $nation }}">
    <table>
        <caption class="cal-caption">
            <h4>EVENT IN MONTH {{ date("m", time()) }}</h4>
            <a href="index.html" class="readmore">Readmore</a>
            <div class="note">

            </div>
        </caption>
        <tbody class="cal-body">
        @for($i = 0 ; $i < $totalrow ; $i++)
        <tr>
            @for($y = $i * 7 + 1 ; $y <= $i * 7 + 7 ; $y++)
            @if(isset($data) && count($data) > 0)
            @foreach($data as $val)
                @if(strtotime(date('Y-m-', time()) . $y) == strtotime($val->startdate))
                <td>
                    <a href="{{ route('posts',$val->alias) }}">{{ $y }}</a>
                    <p><i class="fa fa-star"></i> <b>{{ ucfirst($val->name) }}</b>: {{ ucfirst($val->description) }}.</p>
                </td>
                @else
                <td><span>@if($y <= $last){{ $y }}@endif</span></td>
                @endif
            @endforeach
            @else
            <td><span>@if($y <= $last){{ $y }}@endif</span></td>
            @endif
            @endfor
        </tr>
        @endfor
        </tbody>
    </table>
</div>