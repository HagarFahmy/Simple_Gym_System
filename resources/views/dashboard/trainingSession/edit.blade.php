@extends('layouts.app')

@section('content')

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Edit Training Session</h3>
        </div>
        <!-- /.box-header -->
        <!-- form start -->
        <form class="form-horizontal" action="{{ route('dashboard.training-sessions.update', $trainingSession->id) }}" method="POST">
            @csrf
            @method('put') 
            <div class="box-body">

            @if($errors->any())
                @foreach($errors->all() as $error)
                <p>{{ $error}}</p>
                @endforeach
            @endif

                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Name</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control"  value="{{ $trainingSession->name }}" id="name" placeholder="Name" name="name">
                        @if($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>

                @if(!$trainingSession->users->count())
                <div class="form-group">
                    <label for="starts_at" class="col-sm-2 control-label">Starts At</label>

                    <div class="col-sm-10">
                        <input type="datetime-local" class="form-control"  value="{{  date('Y-m-d\TH:i', strtotime($trainingSession->starts_at ))}}" id="starts_at" placeholder="starts_at" name="starts_at">
                        @if($errors->has('starts_at'))
                            <span class="text-danger">{{ $errors->first('starts_at') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="finishes_at" class="col-sm-2 control-label">Finishes At</label>

                    <div class="col-sm-10">
                        <input type="datetime-local" class="form-control"  value="{{ date('Y-m-d\TH:i', strtotime($trainingSession->finishes_at ))}}" id="finishes_at" placeholder="finishes_at" name="finishes_at">
                        @if($errors->has('finishes_at'))
                            <span class="text-danger">{{ $errors->first('finishes_at') }}</span>
                        @endif
                    </div>
                </div>
                @endif
                <div class="form-group">
                    <label for="gym" class="col-sm-2 control-label">Gym</label>

                    <div class="col-sm-10">

                        <select name="gym_id" class="form-control" id="gym">
                        <option value="{{ $trainingSession->gym->id }}" selected>{{ $trainingSession->gym->name }}</option>
                        @foreach($gyms as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('gym_id'))
                            <span class="text-danger">{{ $errors->first('gym_id') }}</span>
                        @endif
                    </div>
                </div>

            </div>
            <!-- /.box-body -->
            <div class="box-footer">
                <button type="submit" class="btn btn-info pull-right">Update</button>
            </div>
            <!-- /.box-footer -->
        </form>
    </div>
@endsection
