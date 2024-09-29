@extends('admin.layouts.app')
@section('content')

  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Ticket List</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
           
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
     <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">All Ticket List </h3>
              </div><br>

                @if (session('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
              
              <!-- /.card-header -->
                <div class="card-body">
                  <table id="" class="table table-bordered table-striped table-sm ytable">
                    <thead>
                    <tr>
                      <th>SL</th>
                      <th>User</th>
                      <th>Image</th>
                      <th>Subject</th>
                      <th>Service</th>
                      <th>Priority</th>
                      <th>Date</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                        @foreach ($view_ticket as $key=>$row)
                        <tr>
                            <td>{{++$key}}</td>
                            <td>{{ $row->name }}</td>
                            <td><img src="{{ asset($row->image) }}" style="height: 40px; width:60px"></td>
                            <td>{{ $row->subject }}</td>
                            <td>{{ $row->service }}</td>
                            <td>{{ $row->priority }}</td>
                            <td>{{ $row->date }}</td>
                            <td>
                              @if ($row->status == '0')
                              <a href="#" class="btn btn-info btn-xs" style="width:100px;"> Pending </a>
                              @elseif ($row->status == '1')
                              <a href="#" class="btn btn-success btn-xs" style="width:100px;"> Replied </a>
                              @elseif ($row->status == '2')
                              <a href="#" class="btn btn-danger btn-xs" style="width:100px;"> Closed </a>
                              @endif
                          </td>
                            <td >
                                <a href="#" class="btn btn-info btn-sm" title="Edit Data"><i class="fas fa-eye"></i></a>
                                <a href="{{ route('ticket.delete',$row->id) }}" id="delete" class="btn btn-danger btn-sm delete" title="Delete Data"><i class="fas fa-trash-alt"></i></a>
                            </td>
                        </tr>
                    @endforeach
                  
                    </tbody>
                  </table>
                  
                </div>
	          </div>
	      </div>
	  </div>
	</div>
</section>
</div>

@endsection