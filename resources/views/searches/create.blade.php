
@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-dark text-white">Create Search</div>
            <div class="card-body bg-dark text-white">
                <form action="/searches" method="POST">
                    @csrf
                    <div class="form-row">
                        <div class="col-md-7">Searchtext:</div>
                        <div class="col-md-2">From:</div>
                        <div class="col-md-2">To:</div>
                        <div class="col-md-1"></div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-7">
                            <input id="searchtext" type="text" class="form-control @error('searchtext') is-invalid @enderror" name="searchtext" value="{{ old('searchtext') }}" required autofocus>
                        </div>
                        <div class="col-md-2">
                            <input type="datetime-local" class="form-control @error('startdatetime') is-invalid @enderror" name="startdatetime" id="startdatetime" required>
                        </div>
                        <div class="col-md-2">
                            <input type="datetime-local" class="form-control @error('enddatetime') is-invalid @enderror" name="enddatetime" id="enddatetime" required>
                        </div>
                        <div class="col-md-1">
                            <button type="submit" class="d-flex btn btn-outline-success">Search</button>
                        </div>
                    </div>
                </form>
                @foreach ($errors->all() as $error)
                    <br>
                    <div class="alert alert-danger">
                        <li>{{ $error }}</li>
                    </div>
                @endforeach
            </div>
            </div>
        </div>
    </div>
@endsection
