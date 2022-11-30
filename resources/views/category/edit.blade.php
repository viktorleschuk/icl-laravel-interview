@extends('layouts.app')

@section('content')

        <!-- Errors-->
        @include('layouts.shared.errors')

        <!-- Main Content-->
        @include('category.shared.edit-category-form')

        <!-- Footer-->
        @include('blog.shared.footer')

@endsection
