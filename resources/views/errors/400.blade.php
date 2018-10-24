@extends('errors::illustrated-layout')

@section('code', '400')
@section('title', __('Forbidden'))

@section('image')
<div style="background-image: url('/svg/403.svg');" class="absolute pin bg-cover bg-no-repeat md:bg-left lg:bg-center">
</div>
@endsection

@section('message')
{{ $exception->getMessage() }}
@endsection
