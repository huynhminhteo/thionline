@foreach($questions as $key => $question)
<div class="row mg-t-40">
    @if (count($questions) > 1 && !$question->audio)
        {{$key + 1}}.&nbsp;
    @elseif (count($questions) > 1 && $question->audio)
        録音 {{$key + 1}} </div><div class="row mg-t-5 pd-l-10">
    @endif
    <div class="@if (count($questions) > 1) col-9 @else col-11 @endif content-exam @if ($question->audio) content-audio @endif pd-x-0" data-src="{{$question->content}}">
        {{$question->content}}
    </div>

    <div class="@if (count($questions) > 1) col-2 @else col-11 @endif pd-x-0 micro-exam" style="margin: auto; margin-left: 0; margin-right: 0; text-align: center">
        <img src="{{asset('assets/images/microphone.svg')}}" height="30"  class="microphone record" id="mic_{{$key + 1}}" data-id="{{$key + 1}}">
        <img src="{{asset('assets/images/icon-60.png')}}" height="30"  class="microphone stop d-none" id="unmic_{{$key + 1}}" data-id="{{$key + 1}}">
    </div>

    <section class="col-11 sound-clips pd-l-0" id="sound_{{$key + 1}}" data-id="{{$key + 1}}"></section>
</div>
@endforeach

<div class="row mg-t-40 mg-b-10" style="position: relative; width: 100%">
@if($next_group)
    <button id="btnNext" data-group="{{$next_group}}" style="padding: 3px 15px !important; position: absolute; right: 0px">Next ></button>
@endif
@if(!$next_group)
    <button id="btnFinish" style="padding: 3px 15px !important; margin: auto">Finish !</button>
@endif
</div>