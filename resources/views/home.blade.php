@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Upload your json') }}</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="panel panel-primary">
                            <div class="panel-body">
                                @if ($message = Session::get('success'))
                                    <div class="alert alert-success alert-block">
                                        <button type="button" class="close" data-dismiss="alert">×</button>
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @endif
                                @if (count($errors) > 0)
                                    <div class="alert alert-danger">
                                        <strong>Whoops!</strong> There were some problems with your input.
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <form action="{{ route('file.upload.post') }}" method="POST"
                                      enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="file" name="file" class="form-control"
                                                   accept="application/json">
                                        </div>
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-success">Upload</button>
                                        </div>
                                    </div>
                                </form>

                                <div class="row">
                                    <div class="col-md-12 mt-4">
                                        @if ($fileName = Session::get('file'))
                                            @php
                                                $json_data = \App\Services\HelperService::getJsonDataFromUploadedFile($fileName);
                                            @endphp
                                            @if(!empty($json_data))
                                                <table class="table table-bordered">
                                                    <tbody>
                                                    @foreach($json_data as $key=>$value)
                                                        <tr>
                                                            <td>{{$key}}</td>
                                                            <td>{{$value}}</td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>
                                                <a href="{{route('file.upload.export', [$fileName])}}" type="button"
                                                   class="btn btn-success">Download as CSV</a>
                                                <a href="{{route('file.upload.exportUsingPackage', [$fileName])}}"
                                                   type="button" class="btn btn-success">Download as CSV Using Laravel
                                                    Package</a>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
