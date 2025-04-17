@extends('layouts.master')
@section('title', 'Prime Numbers')
@section('content')
  @php
    function checkPrime($num) {
        if ($num <= 1) return false;
        if ($num == 2) return true;
        if ($num % 2 == 0) return false;

        for ($i = 3; $i <= sqrt($num); $i += 2) {
            if ($num % $i == 0) return false;
        }
        return true;
    }
  @endphp

  <div class="card m-4">
    <div class="card-header">Prime Numbers</div>
    <div class="card-body">
      @foreach (range(1, 100) as $i)
        @if(checkPrime($i))
          <span class="badge bg-primary">{{$i}}</span>
        @else
          <span class="badge bg-secondary">{{$i}}</span>
        @endif
      @endforeach
    </div>
  </div>
@endsection
