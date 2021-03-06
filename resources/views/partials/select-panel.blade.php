{{-- actions refering to records --}}
    <?php
        $p = "partials/select_panel.";
    ?>
    <?php
        /* check which tab is selected */
        $basic_selected = '';
        $medical_selected = '';
        $legal_selected = '';
        $social_selected = '';
        if(isset($tab)){
            if($tab === "medical"){
                $medical_selected = 'selected';
            } else if($tab === "legal"){
                $legal_selected = 'selected';
            } else if($tab === "social"){
                $social_selected = 'selected';
            }
        } else {
            $basic_selected = 'selected';
        }
        /* if benefiter id is not set, set it to '-1' */
        if($benefiter->id == null){
            $benefiter->id = -1;
        }
    ?>

    <div class="no-margin light-green-background width-100-percent" id="actions">
    {{--<div style="width: 100%; background-color: red;">--}}
        <div class="row width-100-percent">
            <div class="col-xs-3 record-panel-title">
                <a id="benefiter-basic-info" class="white {{ $basic_selected }}" href="{{ url('/benefiter') }}/{{ $benefiter->id }}/basic-info">@lang($p.'basic_details')</a>
            </div>

            <div class="col-xs-3 record-panel-title">
                <a id="benefiter-medical-folder" class="white {{ $medical_selected }} @if($benefiter->id == -1) disable-anchor @endif" href="{{ url('/benefiter') }}/{{ $benefiter->id }}/medical-folder">@lang($p.'medical_folder')</a>
            </div>

            <div class="col-xs-3 record-panel-title">
                <a id="benefiter-legal-folder" class="white {{ $legal_selected }} @if($benefiter->id == -1) disable-anchor @endif" href="{{ url('/benefiter') }}/{{ $benefiter->id }}/legal-folder">@lang($p.'legal_folder')</a>
            </div>

            <div class="col-xs-3 record-panel-title">
                <a id="benefiter-social-folder" class="white {{ $social_selected }} @if($benefiter->id == -1) disable-anchor @endif" href="{{ url('/benefiter')}}/{{ $benefiter->id }}/social-folder">@lang($p.'social_foder')</a>
            </div>
        </div>
        {{-- The abone three options will be removed in order to be added dynamically from another view. --}}

    </div>
