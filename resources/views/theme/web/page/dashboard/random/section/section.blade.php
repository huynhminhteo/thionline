<div class="row pd-l-40 row-random">
    @for($i = 1; $i <= $count_test; $i++)
        <div class="count-test" id="count_test_{{$i}}">
            {{$i}}
        </div>
    @endfor
</div>
<div style="text-align: center;">
    <button style="margin-top: 20px; padding: 5px 20px;" id="btn_random">ランダム</button>
</div>