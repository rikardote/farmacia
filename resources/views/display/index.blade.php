@extends('layouts.mainappqueue')

@section('title', trans('messages.display.display'))

@section('content')
    <style type="text/css">
    body {
        overflow:hidden;
    }
    </style>

    <div id="callarea" class="row" style="line-height:1.23">
        <div class="col m5">
            <!-- <h4 style="color:red">Previous Number</h4> -->
            <div class="card-panel center-align" style="margin-bottom:0">
            
                <div style="border-bottom:1px solid #ddd">
                    <span id="num1" style="font-size:85px;font-weight:bold;line-height:1.45">{{ $data[1]['number'] }}</span><br>
                    <small id="cou1" style="font-size:35px">{{ $data[1]['counter'] }}</small>
                </div>
                <div style="border-bottom:1px solid #ddd">
                    <span id="num2" style="font-size:85px; font-weight:bold;line-height:1.45">{{ $data[2]['number'] }}</span><br>
                    <small id="cou2" style="font-size:35px">{{ $data[2]['counter'] }}</small>
                </div>
                <div style="border-bottom:1px solid #ddd">
                    <span id="num3" style="font-size:85px;font-weight:bold;line-height:1.45">{{ $data[3]['number'] }}</span><br>
                    <small id="cou3" style="font-size:35px">{{ $data[3]['counter'] }}</small>
                </div>

            </div>
        </div>
        <div class="col m7">
        <!-- <h4 style="color:red">Current Number</h4> -->
            <div class="card-panel center-align" style="margin-bottom:0">
                <span style="font-size:45px">NUMERO</span><br>
                <span id="num0" style="font-size:185px;color:red;font-weight:bold;line-height:1.5">{{ $data[0]['number'] }}</span><br>
                <span style="font-size:40px">PROCEDER A </span><br>
                <span id="cou0" style="font-size:80px; color:red;line-height:1.5">{{ $data[0]['counter'] }}</span>
            </div>
        </div>
    </div>
    <h1>DE MOMENTO NO HAY ESTOS MEDICAMENTOS:</h1>
     <div class="row" style="margin-bottom:0;font-size:56px;color:#000">
        

        <marquee>ALPRAZOLAM, RIVOTRIL, ACIDO FOLICO, ENALAPRIL</marquee>

                    
    </div> 
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('assets/js/voice.min.js') }}"></script>
    <script>
        $(function() {
            $('#main').css({'min-height': $(window).height()-114+'px'});
        });
        $(window).resize(function() {
            $('#main').css({'min-height': $(window).height()-114+'px'});
        });

        (function($){
            $.extend({
                playSound: function(){
                  return $("<embed src='"+arguments[0]+".mp3' hidden='true' autostart='true' loop='false' class='playSound'>" + "<audio autoplay='autoplay' style='display:none;' controls='controls'><source src='"+arguments[0]+".mp3' /><source src='"+arguments[0]+".ogg' /></audio>").appendTo('body');
                }
            });
        })(jQuery);

        function checkcall() {
            $.ajax({
                type: "GET",
                url: "{{ url('assets/files/display') }}",
                cache: false,
                success: function(response) {
                    s = JSON.parse(response);
                    if (curr!=s[0].call_id) {
                        $("#callarea").fadeOut(function(){
                            $('#num0').html(s[0].number);
                            $("#cou0").html(s[0].counter);
                            $('#num1').html(s[1].number);
                            $("#cou1").html(s[1].counter);
                            $('#num2').html(s[2].number);
                            $("#cou2").html(s[2].counter);
                            $('#num3').html(s[3].number);
                            $("#cou3").html(s[3].counter);
                        });
                        $("#callarea").fadeIn();
                        if (curr!=0) {
                            var bleep = new Audio();
                            bleep.src = '{{ url('assets/sound/sound1.mp3') }}';
                            bleep.play();

                            window.setTimeout(function() {
                                msg1 = 'Número '+s[0].call_number+' '+"."+'  {!! trans('messages.display.proceed_to') !!} '+s[0].counter;
                                responsiveVoice.speak(msg1, "Spanish Latin American Female", {rate: 0.85});
                            }, 800);
                        }
                        curr = s[0].call_id;
                    }
                }
            });
        }

        window.setInterval(function() {
            checkcall();
        }, 3000);

        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "{{ url('assets/files/display') }}",
                cache: false,
                success: function(response) {
                    s = JSON.parse(response);
                    curr = s[0].call_id;
                }
            });
            checkcall();
        });
    </script>
@endsection
