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
    
        <div class="form-group">
            <label>Update Photo:</label>
            <input type="file" id="photo" name="photo" accept="image/*" class="@error('photo') is-invalid @enderror" onchange="previewImage(this, '#Photo-preview')">
            <img id="Photo-preview" src="{{ $news_and_event->photo ? asset('storage/'.$news_and_event->photo) : '#' }}" height="50" style="{{ $news_and_event->photo ? '' : 'display:none;' }}">
            @error('photo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
    
    </div>
  </div>

</div>
@endsection


@section('scripts')
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

