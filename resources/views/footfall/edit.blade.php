@extends('layouts.app')

@section('content')
<div class="container-fluid">

  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Footfall</h1>
  </div>

  <div class="row">
    <div class="col-md-8 form-box">
      <form action="{{ route('footfall.update', $footfall->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') <!-- Use PUT or PATCH for updating the resource -->
        
        <div class="form-group">
            <label for="firstname">Select Hospital</label>
            <select class="form-control @error('hospitalId') is-invalid @enderror" aria-describedby="Select hospital" name="hospitalId" {{ $userHospitalId ? 'disabled' : '' }} required>
                <option value="">Select Hospital</option>
                @foreach ($hospitals as $hospital)
                    <option value="{{ $hospital->id }}" @if (old('hospitalId', $footfall->hospitalId) == $hospital->id) selected @endif>
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
            <input type="date" class="form-control" name="date" value="{{ old('date', $footfall->date) }}" required>
        </div>
    
        <div class="form-group">
            <label for="title">Patient Footfall : <span style="color:red">*</span></label>
            <input type="number" class="form-control" name="patient" value="{{ old('patient', $footfall->patient) }}" required>
        </div>
    
        <div class="form-group">
            <label for="title">Chemo Session : <span style="color:red">*</span></label>
            <input type="number" class="form-control" name="chemo" value="{{ old('chemo', $footfall->chemo) }}" required>
        </div>
    
        <div class="form-group">
            <label for="title">Radiation Session : <span style="color:red">*</span></label>
            <input type="number" class="form-control" name="radiation" value="{{ old('radiation', $footfall->radiation) }}" required>
        </div>
    
        <div class="form-group">
            <label for="title">No Of Doctors : <span style="color:red">*</span></label>
            <input type="number" class="form-control" name="doctors" value="{{ old('doctors', $footfall->doctors) }}" required>
        </div>

         <div class="form-group">
            <label for="total_beds">No Of Beds : <span style="color:red">*</span></label>
            <input type="number" class="form-control" name="total_beds" value="{{ old('total_beds', $footfall->total_beds) }}" required>
        </div>
    

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
    
    </div>
  </div>

</div>
@endsection


@section('scripts')
@endsection

