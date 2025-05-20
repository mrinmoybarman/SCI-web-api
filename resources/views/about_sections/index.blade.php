@extends('layouts.app')

@section('content')

<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Add New About Section</h1>
    </div>

    <div class="row">

      <div class="col-md-8 form-box">
        <form action="{{ route('about_sections.store') }}" method="POST" enctype="multipart/form-data">
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
            <label for="title">Name : </label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>

          <div class="form-group">
            <label for="short_description">Short Description:</label>
            <textarea class="form-control @error('short_description') is-invalid @enderror" value="{{ old('short_description') }}" rows="4" name="short_description"></textarea>
            @error('short_description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>

          <div class="form-group">
            <label for="long_description">Long Description:</label>
            <textarea class="form-control @error('long_description') is-invalid @enderror" value="{{ old('long_description') }}" rows="4" name="long_description"></textarea>
            @error('long_description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>

          <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control @error('description') is-invalid @enderror" value="{{ old('description') }}" rows="4" name="description"></textarea>
            @error('description')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>

          <div class="form-group form-check">
            <input type="checkbox" class="form-check-input @error('read_more') is-invalid @enderror" id="read_more" name="read_more" {{ old('read_more') ? 'checked' : '' }}>
            <label class="form-check-label" for="read_more">Is Read More Button Active ?</label>
            @error('read_more')
                <div class="invalid-feedback d-block">
                    {{ $message }}
                </div>
            @enderror
          </div>
          
          <div class="form-group">
            <label for="title">Index : </label>
            <input type="text" class="form-control @error('indexx') is-invalid @enderror" value="{{ old('indexx') }}" name="indexx">
            @error('indexx')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>


          <div class="form-group">
            <label for="logo_primary">Photo:</label>
            <input type="file" id="photo" name="photo" accept="image/*" class="@error('photo') is-invalid @enderror" onchange="previewImage(this, '#Photo-preview')">
            <img id="Photo-preview" src="#" height="50" style="display:none;">
            @error('photo')
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
        <h1 class="h3 mb-0 text-gray-800">About Sections</h1>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card-body">
          <div class="table-responsive">
                <table id="hospital-table" class="display nowrap" style="width:100%">
                  <thead>
                      <tr>
                          <th>ID</th>
                          <th>Hospital Name</th>
                          <th>Added By</th>
                          <th>Name</th>
                          <th>Index</th>
                          <th>Short Description</th>
                          <th>Long Description</th>
                          <th>Description</th>
                          <th>Read More</th>
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
        ajax: "{{ route('about_sections.index') }}",
        columns: [
            { data: 'id' },
            { data: 'hospital_name' },
            { data: 'added_by_name' },
            { data: 'name' },
            { data: 'indexx'}, 
            { data: 'short_description'}, 
            { data: 'long_description'}, 
            { data: 'description'}, 
            { data: 'read_more'}, 
            {
                data: null,
                render: function(data, type, row) {
                    return `<img src="/storage/${row['photo']}" style="max-height:70px;width:auto" />`;
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
  window.location.href = '/about_sections/' + employeeId + '/edit'; // Redirect to edit page
});

// Handle Delete button click
$(document).on('click', '.delete-btn', function() {
        var employeeId = $(this).data('id');
        if (confirm('Are you sure you want to delete this About Section ?')) {
            // Make a DELETE request to delete the employee
            $.ajax({
                url: '/about_sections/' + employeeId,
                data: {
                    _token: '{{ csrf_token() }}',  // Include CSRF token
                },
                method: 'DELETE',
                success: function(response) {
                    alert('About Section deleted successfully!');
                    $('#hospital-table').DataTable().ajax.reload(); // Reload the table data
                },
                error: function(xhr) {
                  console.log(xhr);
                    alert('Error deleting About Section !');
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