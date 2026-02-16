@extends('v1.web.layouts.master')

@section('additional_styles')
    <link rel="stylesheet" href="{{ asset('web-assets/css/faq.css') }}" />
@endsection

@section('content')
    <div class="container">
        <div class="page-header">
            <h1 class="page-title d-flex justify-content-center">Frequently Asked
                <div class="page-title-special">
                    <p>Questions</p>
                </div>
            </h1>
            <p class="page-subtitle d-flex justify-content-center text-center ">
                Lorem ipsum dolor sit amet consectetur. Nisl amet neque molestie non ut elementum enim aenean vitae. Turpis
                sit sed non eget id diam. Tortor aliquam aenean in enim. </p>
        </div>
        <div class="page-content">
            <div class="faq-content">
                <div id="accordion">
                    @foreach ($faqs as $key => $faq)
                        <div class="card faq-card">
                            <div class="faq-question d-flex justify-content-between align-items-center"
                                data-toggle="collapse" data-target="#collapse{{ $key }}" aria-expanded="true"
                                aria-controls="collapse{{ $key }}" id="heading{{ $key }}">
                                <div>{{ $faq->title }}</div>
                                <div class="faq-question-icon"></div>
                            </div>
                            <div id="collapse{{ $key }}" class="collapse{{ $key === 0 ? ' show' : '' }}"
                                aria-labelledby="heading{{ $key }}" data-parent="#accordion">
                                <p class="faq-answer">
                                    {{ $faq->description }}
                                </p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection
