@extends('layout.master')
@section('title', 'Welcome Page')

@section('content')
    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Author</th>
                <th scope="col">Publisher</th>
                <th scope="col">Year</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($books as $b)
                <tr>
                    <th scope="row">{{ $b->id }}</th>
                    <td>{{ $b->title }}</td>
                    <td>{{ $b->author }}</td>
                    <td>{{ $b->publisher }}</td>
                    <td>{{ $b->year }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection