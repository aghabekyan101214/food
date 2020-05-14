@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">  {{ $action . " " . $title }}</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form action="{{ $route }}" enctype="multipart/form-data" method="post"
                              class="form-horizontal form-bordered">
                            @csrf

                            <div class="form-body">

                                <div class="form-group">
                                    <label class="control-label col-md-2">{{$title}} Name</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Name" value="{{old("name") }}" required
                                               class="form-control" name="name">
                                        @error('name')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">{{$title}} Category</label>
                                    <div class="col-md-9">
                                        <select name="category" required class="form-control select2" id="category">
                                            <option value="">Select Category</option>
                                            @foreach($category as $val)
                                                <optgroup label="{{ $val->name }}">
                                                    @foreach($val->childrenCategories as $key)
                                                        <option value="{{$key->id}}" @if($key->id == old('category')) selected @endif >{{$key->name}}</option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                        @error('category')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">{{$title}} Description</label>
                                    <div class="col-md-9">
                                        <textarea name="description" cols="30" rows="10" required
                                                  class="form-control">{{old('description')}}</textarea>
                                        @error('description')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">{{$title}} Мeasure</label>
                                    <div class="col-md-9">
                                        <select name="measure" id="measure" class="form-control">
                                            <option value="1" @if(old('measure') == 1) selected @endif>Piece</option>
                                            <option value="2" @if(old('measure') == 2) selected @endif>Kilogram</option>
                                        </select>
                                        @error('measure')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">{{$title}} Quantity</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Quantity" value="{{old("quantity") }}"
                                               class="form-control" name="quantity">
                                        @error('quantity')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-2">{{$title}} Price</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Price" value="{{old("price") }}" required
                                               class="form-control" name="price">
                                        @error('price')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="control-label col-md-2">{{$title}} Images (Multiple)</label>
                                    <div class="col-md-9">
                                        <input type="file" placeholder="Images" required multiple class="form-control"
                                               name="images[]">
                                        @error('images')
                                        <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-offset-11 col-md-9">
                                                    <button type="submit" class="btn btn-success"><i
                                                            class="fa fa-check"></i>
                                                        Submit
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('head')
    <!--This is a Select 2 style -->
    <link href="{{asset('assets/plugins/select2/dist/css/select2.min.css')}}" rel="stylesheet" type="text/css"/>
    <style>
        textarea {
            resize: none;
        }

        input#file-upload-button {
            display: none;
        }
    </style>
@endpush

@push('foot')
    <!--Select2 js-->
    <script src="{{asset('assets/plugins/select2/dist/js/select2.min.js')}}"></script>

    <script !src="">

        $(document).ready(function () {
            $('#category').select2();
        })
    </script>
@endpush
