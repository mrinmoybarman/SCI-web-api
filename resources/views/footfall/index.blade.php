@extends('layouts.app')

@section('content')

<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Add footfall</h1>
    </div>

    <div class="row">

      <div class="col-md-8 form-box">
        <form action="{{ route('footfall.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="firstname">Select Hospital</label>
            <select class="form-control @error('hospitalId') is-invalid @enderror" aria-describedby="Select hospital" name="hospitalId" {{ $userHospitalId !== null ? 'disabled' : '' }} required>
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
            <label for="title">Select Date: <span style="color:red">*</span></label>
            <input type="date" class="form-control" name="date" required>
          </div>
          <div class="form-group">
            <label for="title">Patient Footfall : <span style="color:red">*</span></label>
            <input type="number" class="form-control" name="patient" required>
          </div>
          <div class="form-group">
            <label for="title">Chemo Session : <span style="color:red">*</span></label>
            <input type="number" class="form-control" name="chemo" required>
          </div>
          <div class="form-group">
            <label for="title">Radiation Session : <span style="color:red">*</span></label>
            <input type="number" class="form-control" name="radiation" required>
          </div>
          <div class="form-group">
            <label for="title">No Of Doctors : <span style="color:red">*</span></label>
            <input type="number" class="form-control" name="doctors" required>
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
        <h1 class="h3 mb-0 text-gray-800">Footfalls</h1>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card-body">
          <div class="table-responsive">
              <table id="footfall-table" class="display nowrap" style="width:100%">
                  <thead>
                      <tr> 
                          <th>ID</th>
                          <th>Hospital Name</th>
                          <th>Added By</th>
                          <th>Patinet Footfall</th>
                          <th>Chemo Sessions</th>
                          <th>Radiation Session</th>
                          <th>Totall Doctors</th>
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
    $('#footfall-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('footfall.index') }}",
        columns: [  
            { data: 'id' },
            { data: 'hospital_name' },
            { data: 'added_by_name' },
            { data: 'patient' },
            { data: 'chemo'}, 
            { data: 'radiation'}, 
            { data: 'doctors'}, 
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
  var footfallId = $(this).data('id');
  window.location.href = '/footfall/' + footfallId + '/edit'; // Redirect to edit page
});

// Handle Delete button click
$(document).on('click', '.delete-btn', function() {
        var footfallId = $(this).data('id');
        if (confirm('Are you sure you want to delete this footfall ?')) {
            // Make a DELETE request to delete the employee
            $.ajax({
                url: '/footfall/' + footfallId,
                data: {
                    _token: '{{ csrf_token() }}',  // Include CSRF token
                },
                method: 'DELETE',
                success: function(response) {
                    alert('Footfall deleted successfully!');
                    $('#footfall-table').DataTable().ajax.reload(); // Reload the table data
                },
                error: function(xhr) {
                    alert('Error deleting footfall !');
                }
            });
        }
    });


</script>

@endsection