@extends('layouts.app')

@section('content')

<!-- Begin Page Content -->
  <div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Add News/Event</h1>
    </div>

    <div class="row">

      <div class="col-md-8 form-box">
        <form action="{{ route('news_and_events.store') }}" method="POST" enctype="multipart/form-data">
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
            <label for="title">Title:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" name="name">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>
          
          <div class="form-group">
            <label for="description">Select Date:</label>
            <input type="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}" name="date" />
            @error('date')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
          </div>

          <div class="form-group">
            <label for="description">Description:</label>
            <textarea class="form-control @error('details') is-invalid @enderror" value="{{ old('details') }}" rows="4" name="details"></textarea>
            @error('details')
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
            <label for="photos">Photos:</label>
            <input type="file" id="photos" name="photos[]" accept="image/*" multiple
                  class="@error('photos') is-invalid @enderror"
                  onchange="previewMultipleImages(this, '#Photo-preview-container')">
            <div id="Photo-preview-container" style="display:flex; gap: 10px; flex-wrap: wrap;"></div>
            @error('photos')
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
        <h1 class="h3 mb-0 text-gray-800">News & Events</h1>
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
                          <th>Date</th>
                          <th>Hospital Name</th>
                          <th>Added By</th>
                          <th>Details</th>
                          <th>indexx</th>
                          <th>photos</th>
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
        ajax: "{{ route('news_and_events.index') }}",
        columns: [
            { data: 'id' },
            { data: 'name' },
            { data: 'date' },
            { data: 'hospital_name' },
            { data: 'added_by_name' },
            { data: 'details'}, 
            { data: 'indexx'}, 
            {
                data: null,
                render: function(data, type, row) {
                    if (!row.photos || row.photos.length === 0) {
                        return 'No images';
                    }

                    return row.photos.map(photo => {
                        return `<img src="/storage/${photo.photo_path}" style="max-height:70px;width:auto; margin-right: 5px;" />`;
                    }).join('');
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


// Handle Edit button click
$(document).on('click', '.edit-btn', function() {
  var employeeId = $(this).data('id');
  window.location.href = '/news_and_events/' + employeeId + '/edit'; // Redirect to edit page
});

// Handle Delete button click
$(document).on('click', '.delete-btn', function() {
        var employeeId = $(this).data('id');
        if (confirm('Are you sure you want to delete this News/Event ?')) {
            // Make a DELETE request to delete the employee
            $.ajax({
                url: '/news_and_events/' + employeeId,
                data: {
                    _token: '{{ csrf_token() }}',  // Include CSRF token
                },
                method: 'DELETE',
                success: function(response) {
                    alert('News/Event deleted successfully!');
                    $('#hospital-table').DataTable().ajax.reload(); // Reload the table data
                },
                error: function(xhr) {
                    alert('Error deleting News/Event !');
                }
            });
        }
    });


</script>

<script>
let selectedFiles = [];

function previewMultipleImages(input, previewContainerSelector) {
    const container = document.querySelector(previewContainerSelector);
    container.innerHTML = '';

    selectedFiles = Array.from(input.files); // Reset on new selection

    const newDataTransfer = new DataTransfer();

    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();

        reader.onload = function (e) {
            const wrapper = document.createElement('div');
            wrapper.style.position = 'relative';
            wrapper.style.display = 'inline-block';
            wrapper.style.margin = '5px';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.height = '70px';
            img.style.border = '1px solid #ccc';
            img.style.borderRadius = '4px';

            const removeBtn = document.createElement('span');
            removeBtn.innerHTML = '&times;';
            removeBtn.style.position = 'absolute';
            removeBtn.style.top = '0';
            removeBtn.style.right = '5px';
            removeBtn.style.color = 'white';
            removeBtn.style.backgroundColor = 'red';
            removeBtn.style.borderRadius = '50%';
            removeBtn.style.cursor = 'pointer';
            removeBtn.style.padding = '0 5px';
            removeBtn.title = 'Remove';

            removeBtn.onclick = function () {
                selectedFiles.splice(index, 1); // remove the image
                rebuildFileInput(input); // update the file input
                previewMultipleImages(input, previewContainerSelector); // re-render
            };

            wrapper.appendChild(img);
            wrapper.appendChild(removeBtn);
            container.appendChild(wrapper);
        };

        reader.readAsDataURL(file);
    });
}

function rebuildFileInput(input) {
    const newDataTransfer = new DataTransfer();
    selectedFiles.forEach(file => newDataTransfer.items.add(file));
    input.files = newDataTransfer.files;
}
</script>


@endsection