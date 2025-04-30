@extends('panel.layout.master' , ['title' => $title])

@push('custom_css')
    <style>
        .alert-success {
            background-color: {{$color}} !important;
        }
    </style>
@endpush
{{--// css --}}
@section('content')

    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">

        <h3>{{$title}}</h3>
        {{--        if , for , foreach , can , dd , lang , auth,isset --}}
        <!--begin::Entry-->
        <div class="d-flex flex-column-fluid">
            <!--begin::Container-->
            <div class="container">
                <div class="alert alert-success" role="alert">
                    A simple success alert—check it out!
                </div>

            </div>

        </div>
    </div>

@endsection
{{--
@push('custom_js')
    <script>
        alert('we\'r done');
    </script>
@endpush--}}
