@extends('front.layouts.base')

@section('content')
    @if (!empty($page))
        <?php $item = $page; ?>
        @if (\View::exists('front.pages.dynamic.' . $page['slug']))
            @include('front.pages.dynamic.' . $page['slug'])
        @else
            @include('front.pages.dynamic.default-page')
        @endif      
    @else
        @include('front.pages.dynamic.default-page')
    @endif
@endsection
