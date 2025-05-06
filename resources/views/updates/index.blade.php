@extends('layouts.app')

@section('content')

<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Add New Updates</h1>
    </div>

    <div class="row">

      <div class="col-md-8 form-box">
        <form action="{{ route('updates.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="hospital">Select Hospital</label>
            <select class="form-control @error('hospitalId') is-invalid @enderror" aria-describedby="Select hospital" name="hospitalId" {{ $userHospitalId !== null ? 'readonly' : '' }} required>
              <option value="">Select Hospital</option>
              @foreach ($hospitals as $hospital)
                  <option value="{{ $hospital->id }}" @if (old('hospitalId', $userHospitalId) == $hospital->id) selected @endif>
                    {{ $hospital->name }}
                  </option>
              @endforeach
            </select>
            @error('hospitalId')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="form-group">
            <label for="title">title:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>
          
          <div class="form-group">
            <label for="title">Link :</label>
            <input type="text" class="form-control @error('link') is-invalid @enderror" value="{{ old('link') }}" name="link">
            @error('link')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>

          <div class="form-group">
            <label for="title">Index:</label>
            <input type="text" class="form-control @error('indexx') is-invalid @enderror" value="{{ old('indexx') }}" name="indexx">
            @error('indexx')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>
          
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>

    </div>
    
  </div>
  <hr />

  
  <div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Updates</h1>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card-body">
          <div class="table-responsive">
                <table id="hospital-table" class="display nowrap" style="width:100%">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Name</th>
                          <th>Hospital Name</th>
                          <th>Added By</th>
                          <th>Link</th>
                          <th>indexx</th>
                          <th>Actions</th>
                      </tr>
                  </thead>
              </table>


          </div>
        </div>
      </div>
    </div>
  </div>


@endsection


@section('scripts')

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>

<script>
$(function () {
    $('#hospital-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('updates.index') }}",
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'hospital_name' },
            { data: 'added_by_name' },
            { data: 'link'}, 
            { data: 'indexx'}, 
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-primary edit-btn" data-id="${row.id}">Edit</button>
                        <button class="btn btn-danger delete-btn" data-id="${row.id}">Delete</button>
                    `;
                },
                orderable: false,
                searchable: false
            }
        ],
        dom: 'Bfrtip',
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        lengthMenu: [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
        pageLength: 10,
        // dom: 'lbfrtip',
    });
});

// sci contact bg colorcode rgb(244 247 227)

// Handle Edit button click
$(document).on('click', '.edit-btn', function() {
  var employeeId = $(this).data('id');
  window.location.href = '/updates/' + employeeId + '/edit'; // Redirect to edit page
});

// Handle Delete button click
$(document).on('click', '.delete-btn', function() {
        var employeeId = $(this).data('id');
        if (confirm('Are you sure you want to delete this update ?')) {
            // Make a DELETE request to delete the employee
            $.ajax({
                url: '/updates/' + employeeId,
                data: {
                    _token: '{{ csrf_token() }}',  // Include CSRF token
                },
                method: 'DELETE',
                success: function(response) {
                    alert('Update deleted successfully!');
                    $('#hospital-table').DataTable().ajax.reload(); // Reload the table data
                },
                error: function(xhr) {
                    alert('Error deleting update !');
                }
            });
        }
    });


</script>

@endsection