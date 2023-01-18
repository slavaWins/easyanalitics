@php

    use SlavaWins\EasyAnalitics\Models\EasyAnaliticsSetting;

      $voronkaData  = EasyAnaliticsSetting::VoronkaGen($inds);

@endphp

@if($voronkaData)


    <style>
        .voronkaCol {
            display: block;
            padding: 9px;
            border-radius: 3px;
            color: #fff;
            font-size: 11px;
            background: #222;
        }
    </style>

    <div class="card mb-4 ">
        <div class="card-body   p-4 border-dark " style="min-height: 170px;">
            <H3>{{$name ?? "Воронка"}}</H3>
            <div class="" style="position: absolute; right: 19px;top: 19px; width: 60%; text-align: right; z-index: 2;">
                <span class="float-end b" style="background: #ffffffab; padding: 5px;">
                      @foreach($voronkaData as $ind=>$data)
                        <BR>  <small>  {{$data['name']}} {{$data['percent']}}%</small>

                    @endforeach
                </span>
            </div>

            <div class="col-12">
                @foreach($voronkaData as $ind=>$data)
                    <div class="col-12 p2 voronkaCol mb-2" style="width: {{$data['percent']}}%;">
                        {{$data['name']}} / <small> {{$ind}}</small>  | {{$data['val']}} шт. / {{$data['percent']}}%
                    </div>
                @endforeach
            </div>


        </div>
    </div>

@else
    Not found  {{$ind}} analitics!
@endif
