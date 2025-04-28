@extends('layouts.master')
@section('title', 'Multiplication Table')

@section('content')
<div class="card m-4 col-sm-4">
    <div class="card-header">Multiplication Table of {{ $j }}</div>
    <div class="card-body">
        <table class="table table-bordered table-striped">
            <tbody>
                @foreach (range(1, 10) as $i)
                <tr>
                    <td>{{ $i }} × {{ $j }}</td>
                    <td>= {{ $i * $j }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
