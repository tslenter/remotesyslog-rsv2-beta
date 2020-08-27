@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-header bg-dark text-white">Search</div>
            <div class="card-body bg-dark text-white">
                <form>
                    <div class="form-row">
                        <div class="col-md-6">Searchtext:</div>
                        <div class="col-md-3">From:</div>
                        <div class="col-md-3">To:</div>

                    </div>
                    <div class="form-row">
                        <div class="col-md-6">
                            <input id="searchtext" type="text" class="form-control" name="searchtext" value="{{ $search->searchtext }}" disabled>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="startdatetime" value="{{ $search->startdatetime }}" disabled>
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" name="startdatetime" value="{{ $search->enddatetime }}" disabled>
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
        <br>
        <div class="card">
            <div class="card-header bg-dark text-white">Results</div>
            <div class="card-body bg-dark text-white">
                <table class="table text-white">
                    <thead>
                    <tr>
                        <th scope="col">Elastic ID</th>
                        <th scope="col">Timestamp</th>
                        <th scope="col">Host</th>
                        <th scope="col">Facility</th>
                        <th scope="col">Priority</th>
                        <th scope="col">Program</th>
                        <th scope="col">Message</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($results as $result)
                        <tr>
                            <th scope="row">{{ $result['_id'] }}</th>
                            <td>{{ $result['_source']['DATE'] }}</td>
                            <td>{{ $result['_source']['HOST'] }}</td>
                            <td>{{ $result['_source']['FACILITY'] }}</td>
                            <td>{{ $result['_source']['PRIORITY'] }}</td>
                            <td>{{ $result['_source']['PROGRAM'] }}</td>
                            <td>{{ $result['_source']['MESSAGE'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div><BR>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">

                @for($i = 1; $i <= $total_pages ; $i++)
                    <li class="page-item"><a class="page-link" href="/searches/{{ $search->id }}?page={{ $i }}">{{ $i }}</a></li>
                @endfor

            </ul>
        </nav>
    </div>


@endsection
