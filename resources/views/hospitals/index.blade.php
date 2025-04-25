@extends('layouts.app')

@section('content')

<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Add New Hospitals</h1>
    </div>

    <div class="row">

      <div class="col-md-8 form-box">
        <form action="{{ route('hospitals.store') }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="title">Hospital Name :</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="title">Hospital Name in Assamese:</label>
            <input type="text" class="form-control" name="aname">
          </div>
          <div class="form-group">
            <label for="title">Hospital Location ():</label>
            <input type="text" class="form-control @error('location') is-invalid @enderror" value="{{ old('location') }}" name="location">
            @error('location')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="title">Talephone Number :</label>
            <input type="text" class="form-control" name="phone">
          </div>
          <div class="form-group">
            <label for="title">Hospital Mobile Number :</label>
            <input type="text" class="form-control" name="phone2">
          </div>
          <div class="form-group">
            <label for="title">Hospital Email :</label>
            <input type="text" class="form-control" name="email">
          </div>
          <div class="form-group">
            <label for="title">Hospital Whatsapp :</label>
            <input type="text" class="form-control" name="whatsapp">
          </div>
          <div class="form-group">
            <label for="description">Hospital Address:</label>
            <textarea class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}" rows="4" name="address"></textarea>
            @error('address')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="description">Hospital Google map link:</label>
            <input class="form-control" type="text" name="gmap"></textarea>
          </div>          
          <div class="form-group">
            <label for="firstname">Select Level</label>
            <select class="form-control @error('level') is-invalid @enderror" value="{{ old('level') }}"  aria-describedby="Select Level" name="level">
              <option value="">Select Level</option>
              <option value="L1">L1</option>
              <option value="L2">L2</option>
              <option value="L3">L3</option>
            </select>
            @error('level')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>
          <div class="form-group">
            <label for="description">Facebook link:</label>
            <input type="text" class="form-control" rows="1" name="facebook"></textarea>
          </div>
          <div class="form-group">
            <label for="description">Instagram link:</label>
            <input type="text" class="form-control" rows="1" name="instagram"></textarea>
          </div>
          <div class="form-group">
            <label for="description">Twitter link:</label>
            <input type="text" class="form-control" rows="1" name="twitter"></textarea>
          </div>
          <div class="form-group">
            <label for="description">LinkedIn link:</label>
            <input type="text" class="form-control" rows="1" name="linkedin"></textarea>
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
                          <th>Alternative Name</th>
                          <th>Location</th>
                          <th>Contact No </th>
                          <th>Mobile No</th>
                          <th>Email</th>
                          <th>Whatsapp</th>
                          <th>Address</th>
                          <th>Google Map Link</th>
                          <th>Level</th>
                          <th>Facebook</th>
                          <th>Twitter</th>
                          <th>Linkedin</th>
                          <th>Instagram</th>
                          <th>Primary Logo</th>
                          <th>Secondary Logo</th>
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
        ajax: "{{ route('hospitals.index') }}",
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'aname' },
            { data: 'location' },
            { data: 'phone'}, 
            { data: 'phone2'}, 
            { data: 'email'}, 
            { data: 'whatsapp'}, 
            { data: 'address'}, 
            { data: 'gmap'}, 
            { data: 'level'}, 
            { data: 'facebook'}, 
            { data: 'instagram'},
            { data: 'twitter'},
            { data: 'linkedin'}, 
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