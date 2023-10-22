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