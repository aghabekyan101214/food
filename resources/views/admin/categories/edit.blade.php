@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-info">
                <div class="panel-heading">  {{ $action . " " . $title }}</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form action="{{ $route . "/" . $category->id }}" enctype="multipart/form-data" method="post"
                              class="form-horizontal form-bordered">
                            @csrf
                            @method("PUT")
                            <div class="form-body">

                                <div class="form-group">
                                    <label class="control-label col-md-2">Category Name</label>
                                    <div class="col-md-9">
                                        <input type="text" placeholder="Name" value="{{ $category->name }}" required
                                               class="form-control" name="name">
                                        @error('name')
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


    {{--add subcategory--}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-warning">
                <div class="panel-heading">Add Subcategory (Multiple)</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <form action="{{ $route . "/" . $category->id ."/subcategory" }}" enctype="multipart/form-data"
                              method="post" class="form-horizontal">
                            @csrf
                            <div class="form-body">

                                <div class="col-md-12 nopadding">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Subcategory Name</label>
                                        @error('subcategory')
                                            <div class="alert alert-danger">{{ $message }}</div>
                                        @enderror

                                        <div class="input-group col-md-9">
                                            <input type="text" class="form-control" id="subcategory" name="subcategory[]"
                                                   placeholder="Subcategory Name" required>
                                            <div class="input-group-btn ml-1">
                                                <button class="btn btn-warning" type="button"
                                                        onclick="education_fields();">
                                                    <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="clear"></div>
                                <div id="education_fields" class="col-md-12"></div>


                                <div class="form-actions">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-offset-11 col-md-9">
                                                    <button type="submit" class="btn btn-warning"><i
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

    {{--Subcategory Part--}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">Subcategory</div>
                <div class="panel-wrapper collapse in" aria-expanded="true">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <table id="datatable" class="display table table-hover table-striped nowrap" cellspacing="0"
                                   width="100%">
                                <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Options</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($data as $key=>$val)
                                    <tr>
                                        <td>{{$key + 1}}</td>
                                        <td>{{$val->name}}</td>
                                        <td>{{$val->slug}}</td>
                                        <td>
                                            <a href="#" data-id="{{$val->id}}" data-name="{{$val->name}}" data-route="{{$route}}" data-parent="{{$category->id}}"
                                              class="btn btn-info btn-circle edit" data-toggle="modal" data-target="#exampleModal">
                                                <i class="fas fa-edit" style="color: white;"></i>
                                            </a>

                                            <form style="display: inline-block"
                                                  action="{{ $route."/".$category->id."/delete/".$val->id }}"
                                                  method="post">
                                                @csrf
                                                @method("DELETE")
                                                <a href="javascript:void(0);" data-text="Subcategory" class="delForm"
                                                   data-id="{{$val->id}}">
                                                    <button data-toggle="tooltip"
                                                            data-placement="top" title="Remove"
                                                            class="btn btn-danger btn-circle tooltip-danger"><i
                                                            class="fas fa-trash"></i></button>
                                                </a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">

                </div>
            </div>
        </div>
    </div>
@endsection

@push('head')
    <!--This is a datatable style -->
    <link href="{{asset('assets/plugins/datatables/media/css/dataTables.bootstrap.css')}}" rel="stylesheet"
          type="text/css"/>

    <style>
        .swal-modal {
            width: 660px !important;
        }
    </style>
@endpush

@push('foot')
    <!--Datatable js-->
    <script src="{{asset('assets/plugins/datatables/datatables.min.js')}}"></script>
    <!--swal js-->
    <script src="{{asset('assets/plugins/swal/sweetalert.min.js')}}"></script>
    <script !src="">

        $(document).ready(function () {
            $(".edit").click(function () {
                let id = $(this).data('id');
                let name = $(this).data('name');
                let route = $(this).data('route');
                let parent =$(this).data('parent');
                let csrf = "{{ csrf_token() }}";
                let method = 'PUT';

                let element = $('.modal-body')

                element.empty()
                element.append(` <form action="${route}/${parent}/edit/${id}" enctype="multipart/form-data" method="post">
                                    <input type="hidden" name="_token" value="${csrf}">
                                    <input type="hidden" name="_method" value="${method}">
                                    <div class="form-group">
                                      <label>Subcategory Name</label>
                                      <input type="text" class="form-control" value="${name}" name="subcategory">
                                    </div>

                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>`);
            });
        });

        $('#datatable').DataTable();

        var room = 1;

        function education_fields() {
            room++;
            var objTo = document.getElementById('education_fields')
            var divtest = document.createElement("div");
            divtest.setAttribute("class", "form-group removeclass" + room);
            var rdiv = 'removeclass' + room;
            divtest.innerHTML = `
                            <div class="col-md-12 nopadding">
                                <div class="form-group">
                                <label class="control-label col-md-2">Subcategory Name</label>
                                    <div class="input-group col-md-9">
                                        <input type="text" class="form-control" name="subcategory[]"
                                               placeholder="Subcategory Name" required>

                                 <div class="input-group-btn">
                                 <button class="btn btn-danger" type="button" onclick="remove_education_fields(${room});">
                                  <span class="glyphicon glyphicon-minus" aria-hidden="true">
                                 </span> </button></div></div></div></div><div class="clear">
                            </div>`;

            objTo.appendChild(divtest)
        }

        function remove_education_fields(rid) {
            $('.removeclass' + rid).remove();
        }
    </script>
@endpush

