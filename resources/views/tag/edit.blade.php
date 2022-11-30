@extends('layouts.app')

@section('content')

        <!-- Errors-->
        @include('layouts.shared.errors')

        <!-- Main Content-->
        @include('tag.shared.edit-tag-form')

        <!-- Footer-->
        @include('blog.shared.footer')

@endsection
