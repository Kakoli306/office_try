@extends('layouts.main')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Company Management</h2>
            </div>
           
        </div>
    </div>
    
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
     
    <table class="table table-bordered">
        <tr>
            <th>No</th>
            <th>Image</th>
            <th>Name</th>
            <th>Website</th>
            <th>Email</th>
            <th>Address</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($companies as $company)
        <tr>
            <td>{{ ++$i }}</td>
            <td><img src="/image/{{ $company->image }}" width="100px"></td>
            <td>{{ $company->name }}</td>
            <td>{{ $company->website }}</td>
            <td>{{ $company->email }}</td>
            <td>{{ $company->address }}</td>
            <td>
                <form action="{{ route('companies.destroy',$company->id) }}" method="POST">
     
                    <a class="btn btn-info" href="{{ route('companies.show',$company->id) }}">Show</a>
      
                    <a class="btn btn-primary" href="{{ route('companies.edit',$company->id) }}">Edit</a>
     
                    @csrf
                    @method('DELETE')
        
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    
    {!! $companies->links() !!}
        
@endsection