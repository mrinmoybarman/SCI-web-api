@extends('layouts.app')

@section('content')

<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Add New Doctor</h1>
    </div>

    <div class="row">

      <div class="col-md-8 form-box">
        <form action="{{ route('doctors.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="firstname">Select Hospital</label>
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
            <label for="title">Doctor Name:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>

          <div class="form-group">
            <label for="title">Doctor Designation:</label>
            <input type="text" class="form-control @error('designation') is-invalid @enderror" value="{{ old('designation') }}" name="designation">
            @error('designation')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>
          
          <div class="form-group">
            <label for="title">Doctor Depertment:</label>
            <input type="text" class="form-control @error('depertment') is-invalid @enderror" value="{{ old('depertment') }}" name="depertment">
            @error('depertment')
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
          
          <div class="form-group">
            <label for="title">Doctor Qualification:</label>
            <input type="text" class="form-control @error('qualification') is-invalid @enderror" value="{{ old('qualification') }}" name="qualification">
            @error('qualification')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>

          <div class="form-group">
            <label for="title">Doctor Specialization:</label>
            <input type="text" class="form-control @error('specialization') is-invalid @enderror" value="{{ old('specialization') }}" name="specialization">
            @error('specialization')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>          

          <div class="form-group">
            <label for="title">Doctor Achievement:</label>
            <input type="text" class="form-control @error('achievement') is-invalid @enderror" value="{{ old('achievement') }}" name="achievement">
            @error('achievement')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>

          <div class="form-group">
            <label for="title">Doctor Awards:</label>
            <input type="text" class="form-control @error('awards') is-invalid @enderror" value="{{ old('awards') }}" name="awards">
            @error('awards')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>

          
          <div class="form-group">
            <label for="description">Doctor Profile Details:</label>
            <textarea class="form-control @error('profile_details') is-invalid @enderror" value="{{ old('profile_details') }}" rows="4" name="profile_details"></textarea>
            @error('profile_details')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>
          


          <div class="form-group">
            <label for="logo_primary">Primary Logo (Square):</label>
            <input type="file" id="logo_primary" name="logo_primary" accept="image/*" class="@error('logo_primary') is-invalid @enderror" onchange="previewImage(this, '#logo_primary-preview')">
            <img id="logo_primary-preview" src="#" height="50" style="display:none;">
            @error('logo_primary')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
          
          <div class="form-group">
            <label for="logo_secondary">Secondary Logo (Square):</label>
            <input type="file" id="logo_secondary" name="logo_secondary" accept="image/*" class="@error('logo_secondary') is-invalid @enderror" onchange="previewImage(this, '#logo_secondary-preview')">
            <img id="logo_secondary-preview" src="#" height="50" style="display:none;">
            @error('logo_secondary')
              <div class="invalid-feedback">{{ $message }}</div>
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
        <h1 class="h3 mb-0 text-gray-800">Hospitals</h1>
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
                          <th>Designation</th>
                          <th>Profile Details</th>
                          <th>Department</th>
                          <th>Qualification</th>
                          <th>Specialization</th>
                          <th>Achievement</th>
                          <th>Awards</th>
                          <th>indexx</th>
                          <th>status</th>
                          <th>photo</th>
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
        ajax: "{{ route('doctors.index') }}",
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'hospital_name' },
            { data: 'added_by_name' },
            { data: 'designation'}, 
            { data: 'profile_details'}, 
            { data: 'department'}, 
            { data: 'qualifications'}, 
            { data: 'specializations'}, 
            { data: 'achievments'}, 
            { data: 'awards'}, 
            { data: 'indexx'}, 
            { data: 'status'},
            { data: 'photo'},
            {
                data: null,
                render: function(data, type, row) {
                    return `<img src="/storage/${row['logo_primary']}" style="max-height:70px;width:auto" />`;
                },
                orderable: false,
                searchable: false
            },
            {
                data: null,
                render: function(data, type, row) {
                    return `<img src="/storage/${row['logo_secondary']}" style="max-height:70px;width:auto" />`;
                },
                orderable: false,
                searchable: false
            },
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
  window.location.href = '/hospitals/' + employeeId + '/edit'; // Redirect to edit page
});

// Handle Delete button click
$(document).on('click', '.delete-btn', function() {
        var employeeId = $(this).data('id');
        if (confirm('Are you sure you want to delete this hospital ?')) {
            // Make a DELETE request to delete the employee
            $.ajax({
                url: '/hospitals/' + employeeId,
                data: {
                    _token: '{{ csrf_token() }}',  // Include CSRF token
                },
                method: 'DELETE',
                success: function(response) {
                    alert('Hospital deleted successfully!');
                    $('#hospital-table').DataTable().ajax.reload(); // Reload the table data
                },
                error: function(xhr) {
                    alert('Error deleting hospital !');
                }
            });
        }
    });


</script>


<script>
  function previewImage(input, previewId) {
    const file = input.files[0];
    const preview = document.querySelector(previewId);
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
      }
      reader.readAsDataURL(file);
    } else {
      preview.src = '#';
      preview.style.display = 'none';
    }
  }
</script>

@endsection