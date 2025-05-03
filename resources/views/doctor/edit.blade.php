@extends('layouts.app')

@section('content')
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Hospital</h1>
  </div>

  <div class="row">
    <div class="col-md-8 form-box">
      <form action="{{ route('doctors.update', $doctor->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label for="hospital">Select Hospital</label>
            <select class="form-control @error('hospitalId') is-invalid @enderror" name="hospitalId" {{ $userHospitalId !== null ? 'readonly' : '' }} required>
                <option value="">Select Hospital</option>
                @foreach ($hospitals as $hospital)
                    <option value="{{ $hospital->id }}" @if (old('hospitalId', $doctor->hospitalId ?? $userHospitalId) == $hospital->id) selected @endif>
                        {{ $hospital->name }}
                    </option>
                @endforeach
            </select>
            @error('hospitalId')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <div class="form-group">
            <label>Doctor Name:</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $doctor->name) }}" name="name">
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <div class="form-group">
            <label>Doctor Designation:</label>
            <input type="text" class="form-control @error('designation') is-invalid @enderror" value="{{ old('designation', $doctor->designation) }}" name="designation">
            @error('designation')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <div class="form-group">
            <label>Doctor Department:</label>
            <input type="text" class="form-control @error('depertment') is-invalid @enderror" value="{{ old('depertment', $doctor->depertment) }}" name="depertment">
            @error('depertment')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <div class="form-group">
            <label>Index:</label>
            <input type="text" class="form-control @error('indexx') is-invalid @enderror" value="{{ old('indexx', $doctor->indexx) }}" name="indexx">
            @error('indexx')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <div class="form-group">
            <label>Doctor Qualification:</label>
            <input type="text" class="form-control @error('qualification') is-invalid @enderror" value="{{ old('qualification', $doctor->qualification) }}" name="qualification">
            @error('qualification')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <div class="form-group">
            <label>Doctor Specialization:</label>
            <input type="text" class="form-control @error('specialization') is-invalid @enderror" value="{{ old('specialization', $doctor->specialization) }}" name="specialization">
            @error('specialization')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <div class="form-group">
            <label>Doctor Achievement:</label>
            <input type="text" class="form-control @error('achievement') is-invalid @enderror" value="{{ old('achievement', $doctor->achievement) }}" name="achievement">
            @error('achievement')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <div class="form-group">
            <label>Doctor Awards:</label>
            <input type="text" class="form-control @error('awards') is-invalid @enderror" value="{{ old('awards', $doctor->awards) }}" name="awards">
            @error('awards')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <div class="form-group">
            <label>Doctor Profile Details:</label>
            <textarea class="form-control @error('profile_details') is-invalid @enderror" rows="4" name="profile_details">{{ old('profile_details', $doctor->profile_details) }}</textarea>
            @error('profile_details')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    
        <div class="form-group">
            <label>Doctor Photo:</label>
            <input type="file" id="photo" name="photo" accept="image/*" class="@error('photo') is-invalid @enderror" onchange="previewImage(this, '#Photo-preview')">
            <img id="Photo-preview" src="{{ $doctor->photo ? asset('storage/'.$doctor->photo) : '#' }}" height="50" style="{{ $doctor->photo ? '' : 'display:none;' }}">
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

