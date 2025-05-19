@extends('layout.app')
@section('title','dashboard')
@section('content')
<h1 class="text-5xl">halo, {{ $user->fullname }} selamat datang</h1>
    <a class="text-2xl" href="{{ route('logout') }}">Logout</a>
@endsection