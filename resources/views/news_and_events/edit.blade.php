@extends('layouts.app')

@section('content')
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit News/Event</h1>
  </div>

  <div class="row">
    <div class="col-md-8 form-box">
      <form action="{{ route('news_and_events.update', $news_and_event->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="hospital">Select Hospital</label>
            <select class="form-control @error('hospitalId') is-invalid @enderror" name="hospitalId" {{ $userHospitalId !== null ? 'readonly' : '' }} required>
                <option value="">Select Hospital</option>
                @foreach ($hospitals as $hospital)
                    <option value="{{ $hospital->id }}" @if (old('hospitalId', $news_and_event->hospitalId ?? $userHospitalId) == $hospital->id) selected @endif>
                        {{ $hospital->name }}
                    </option>
                @endforeach
            </select>
            @error('hospitalId')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <div class="form-group">
            <label>Edit Title:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $news_and_event->name) }}" name="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <div class="form-group">
            <label>Edit Index:</label>
            <input type="text" class="form-control @error('indexx') is-invalid @enderror" value="{{ old('indexx', $news_and_event->indexx) }}" name="indexx">
            @error('indexx')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <div class="form-group">
            <label>Edit Description:</label>
            <textarea class="form-control @error('details') is-invalid @enderror" rows="4" name="details">{{ old('details', $news_and_event->details) }}</textarea>
            @error('details')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <label>Upload More Photos</label>
        <input type="file" name="photos[]" multiple class="form-control" onchange="previewImages(this)">
        <div class="mt-3">
            <label>Existing Photos</label>
            <div style="display:flex; flex-wrap:wrap;">
                @foreach ($news_and_event->photos as $photo)
                    <div style="position: relative; margin: 5px;">
                        <div style="position: relative; margin: 5px;" id="photo-{{ $photo->id }}">
                          <img src="{{ asset('storage/' . $photo->photo_path) }}" height="70">
                          <button 
                              class="delete-photo-btn" 
                              data-photo-id="{{ $photo->id }}" 
                              style="position:absolute; top:0; right:0; background:red; color:white; border:none;">
                              &times;
                          </button>
                      </div>
                    </div>
                @endforeach
            </div>
            <div id="image-preview-container" class="mt-2" style="display: flex; flex-wrap: wrap;"></div>
        </div>
    
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
    
    </div>
  </div>

</div>
@endsection


@section('scripts')
<script>
function previewImages(input) {
    const previewContainer = document.getElementById('image-preview-container');
    previewContainer.innerHTML = ''; // Clear previous previews

    const files = Array.from(input.files);
    const dt = new DataTransfer();

    files.forEach((file, index) => {
        const reader = new FileReader();

        reader.onload = function(e) {
            const div = document.createElement('div');
            div.style.position = 'relative';
            div.style.display = 'inline-block';
            div.style.margin = '5px';

            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.maxHeight = '100px';
            img.style.border = '1px solid #ddd';
            img.style.padding = '3px';

            const btn = document.createElement('button');
            btn.textContent = '×';
            btn.style.position = 'absolute';
            btn.style.top = '0';
            btn.style.right = '0';
            btn.style.background = 'red';
            btn.style.color = 'white';
            btn.style.border = 'none';
            btn.style.cursor = 'pointer';
            btn.style.padding = '0 6px';
            btn.style.fontSize = '18px';
            btn.style.lineHeight = '1';
            btn.style.borderRadius = '50%';

            btn.onclick = function() {
                div.remove();
                // Remove this file from files list
                const updatedFiles = Array.from(input.files).filter(f => f !== file);
                const newDt = new DataTransfer();
                updatedFiles.forEach(f => newDt.items.add(f));
                input.files = newDt.files;
            };

            div.appendChild(img);
            div.appendChild(btn);
            previewContainer.appendChild(div);
        };

        reader.readAsDataURL(file);
        dt.items.add(file); // Add to DataTransfer initially
    });

    input.files = dt.files;
}

</script>



<script>
    $(document).ready(function() {
        $('.delete-photo-btn').click(function(e) {
            e.preventDefault();

            if (!confirm('Are you sure you want to delete this photo?')) return;

            let photoId = $(this).data('photo-id');
            let token = '{{ csrf_token() }}';

            $.ajax({
                url: '/news-event-photos/' + photoId,
                type: 'POST',
                data: {
                    _token: token,
                    _method: 'DELETE'
                },
                success: function(response) {
                    $('#photo-' + photoId).remove();
                },
                error: function(xhr) {
                    alert('Failed to delete photo.');
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>

@endsection

