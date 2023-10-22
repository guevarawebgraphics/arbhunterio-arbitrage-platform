@extends('front.layouts.basev2')
@section('content')

<style>
    .settings-nav.active {
        color: #2170A0;
        background-color: #13212F;
        border-radius: 5px;
        border: 1px solid #2170A0;
    }
    .settings-nav:hover {
        color: #2170A0;
        background-color: #13212F;
        border-radius: 5px;
        border: 1px solid #2170A0;
    }
    .settings-card {
        border-radius: 5px;
        background-color: #13212F;
        padding: 2%;
    }
    input {
        background-color: #202F42 !important;
        border: 1px solid #364558 !important;
        color: #fff !important;
    }
    select {
        background-color: #202F42 !important;
        border: 1px solid #364558 !important;
        color: #fff !important;
    }
    .saveChangesBtn {
        background-color: #156077;
    }
    .settingsColor {
        color: #2E6B92;
    }

    .settingsCard {
        border-radius: 5px;
        border: 1px solid #364558 !important;
        background-color: #202F42;
        padding: 2%;
    }

    .successBadge {
        background-color: #324E1C;
        padding: 5px;
        border-radius: 15px;
        border: 1px solid #B3DA7E !important;
        color: #B3DA7E;
        font-weight: bold;
    }

    .dangerBadge {
        background-color: #6F1313;
        padding: 5px;
        border-radius: 15px;
        border: 1px solid #FFADA2 !important;
        color: #FFADA2;
        font-weight: bold;
    }
    .settingsBtn {
        background-color: #1D2F41;
        border: 1px solid #0099D2;
        color: #0099D2;
        border-radius: 5px;
        padding: 5px;
    }
    .settingsBtn:hover {
        background-color: #09131E;
        transition-delay: 0.2s;
    }
    .settingsCard table tr td {
        padding: 10px;
    }
    .settingsCard table tr {
        border-bottom: 1px solid gray;
    }
</style>

<div class="flex">
    <!-- filter -->
    <div class="flex-none w-0 sm:w-14 ">
        @include('front.pages.dashboard.sections.profile-nav')
    </div>
    <!-- end filter -->

    <div class="flex-1">
        <div class="p-4 sm:ml-64">
            @include('front.pages.dashboard.profile.' . $view)
        </div>
    </div>
</div>
@endsection


@section('extra-script')
<script>
</script>

<script>
  
</script>


@endsection