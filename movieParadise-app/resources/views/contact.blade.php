@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mt-5 mb-5">
        <div class="col-8 offset-2 mt-5">
            <div class="card">
                <div class="card-header bg-secondary">
                    <h3 class="text-white"></h3>
                </div>
                <div class="card-body">
                    
                    @if(Session::has('success'))
                    <div class="alert alert-success">
                        {{ Session::get('success') }}
                        @php
                            Session::forget('success');
                        @endphp
                    </div>
                    @endif
               
                    <form method="POST" action="{{ route('contact-form.store') }}">
              
                        {{ csrf_field() }}
                        <div class="row">
                            <input type="hidden" name="user_id" value="{{$user->id}} ">
                            <input type="hidden" name="email" value="{{$user->email}} ">
                            <input type="hidden" name="name" value="{{$user->name}} ">

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <strong>Objet:</strong>
                                    <input type="text" name="subject" class="form-control text-white" placeholder="Objet" value="{{ old('Objet') }}" required>
                                    @if ($errors->has('subject'))
                                        <span class="text-danger">{{ $errors->first('subject') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group ">
                                    <strong>Message:</strong>
                                    <textarea name="message" rows="3" class="form-control text-white" placeholder="votre message..." required>{{ old('message') }}</textarea>
                                    @if ($errors->has('message'))
                                        <span class="text-danger">{{ $errors->first('message') }}</span>
                                    @endif
                                </div>  
                            </div>
                        </div>
               
                        <div class="form-group text-center">
                            <button class="btn btn-success btn-submit">envoyer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
