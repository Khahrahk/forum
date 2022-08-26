@extends('admin.layout.app')
@section('administration-content')
    <h1>депресся для башки админа)</h1>
    <br>
    <!-- Основной блок слайдера -->
    <div class="slider">

        <!-- Первый слайд -->
        <div class="item">
            <img src="{{ asset('images/1.jpg') }}">
        </div>

        <!-- Второй слайд -->
        <div class="item">
            <img src="{{ asset('images/2.jpg') }}">
        </div>

        <!-- Третий слайд -->
        <div class="item">
            <img src="{{ asset('images/3.jpg') }}">
        </div>

        <div class="item">
            <img src="{{ asset('images/4.jpg') }}">
        </div>


        <!-- Кнопки-стрелочки -->
        <a class="previous" onclick="previousSlide()">&#10094;</a>
        <a class="next" onclick="nextSlide()">&#10095;</a>
    </div>
@endsection
