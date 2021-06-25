@extends('layouts.app')

@section('content')
<div class="container-fluid" style="background-color: rgba(243, 241, 239, 1); min-height: 100vh; padding:30px 70px 30px 70px;">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header border-0" style="background-color: #f5d7b5;">{{ __('Edit Profile') }}</div>

                <div class="card-body border-0">
                    <form method="POST" action="/edit-profile">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="dob" class="col-md-4 col-form-label text-md-right">Date of Birth</label>
                            <div class="col-md-6">
                                <input class="form-control  @error('dob') is-invalid @enderror" type="date" value="{{ $user->dob }}" id="dob" name="dob">

                                @error('dob')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="form-group row">
                                <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>
                                <div class="col-md-6">
                                    <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" rows="5">{{ $user->address }}</textarea>
                                    
                                    @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                    </div>
                        </div>


                        <div class="form-group row">
                            <legend class="col-form-label col-md-4 pt-0 text-md-right">Gender</legend>
                            <div class="col-md-6">
                                <div class="form-check">
                                    @if($user->gender == 'male')
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="gendermale" value="male" checked>    
                                    @else
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="gendermale" value="male">    
                                    @endif
                                
                                    <label class="form-check-label" for="gendermale">
                                        Male
                                    </label>
                                </div>
                                <div class="form-check">
                                    @if($user->gender == 'female')
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="genderfemale" value="female" checked>
                                    @else
                                    <input class="form-check-input @error('gender') is-invalid @enderror" type="radio" name="gender" id="genderfemale" value="female">
                                    @endif
                                    <label class="form-check-label" for="genderfemale">
                                        Female
                                    </label>
                                    @error('gender')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Update') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
