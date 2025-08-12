@extends('layouts.header-admin')

@include('layouts.navbar-admin')
@include('layouts.sidebar-admin')

<div class="main-content mt-5">
    <div class="container-fluid">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
        @endif

        <div class="card">
            <div class="card-header">
                <span class="font-bold">Toppings</span>
            </div>
            <div class="card-body ">

                <button>
                    <a class="btn btn-sm btn-secondary" href="{{ route('topping.create') }}">Tambah Topping</a>
                </button>

                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Topping</th>
                            <th scope="col">Harga</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($toppings as $topping)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td>{{ $topping->name }}</td>
                            <td>Rp. {{ number_format($topping->price, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('topping.edit', $topping->id) }}" class="btn btn-sm btn-warning text-white d-inline-block">
                                    Edit
                                </a>
                                <div class="d-inline-block">
                                    <form action="{{ route('topping.destroy', $topping->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger text-white">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>