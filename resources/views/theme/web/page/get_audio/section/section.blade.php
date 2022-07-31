@foreach($users as $key_user => $user)
<div class="block-user">
    <div class="name-user">{{$key_user}} - {{$user['dethi']}}</div>
    <div class="content-exam pd-l-20 pd-t-20">
        @foreach($user['phanthi'] as $key_phanthi => $phanthi)
            <p class="phanthi-user">{{$key_phanthi}}</p>
            @foreach($phanthi as $key_cau => $cau)
                <p class="cau-user">{{$cau['cau']}}</p>
                <audio controls src="{{asset('audio/'.$cau['basename'])}}" style="width: 80%"></audio>
            @endforeach
        @endforeach
    </div>
</div>
@endforeach