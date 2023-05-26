@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="m-0 text-dark">Form {{isset($id) ? 'Edit' : 'Tambah'}} Warna</h1>
@stop

@section('plugins.Sweetalert2',true)

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{isset($id) ? '/api/colors/'.$id : '/api/colors'}}" method="post" id="form">
                        @if(isset($id))
                            @method('put')
                        @else
                            @method('post')
                        @endif
                        @csrf
                        <div class="form-group">
                            <label for="name">Warna</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="silahkan isi..">
                            <span class="text-danger" id="name_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="hex">Hex</label>
                            <input name="hex" id="hex" data-jscolor="{mode:'HSV', position:'right'}" class="form-control">
                            <span class="text-danger" id="hex_error"></span>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="pattern" id="pattern">
                            <label for="pattern">Pattern</label>
                            <span class="text-danger" id="pattern_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="photo">Pattern Image</label>

                            <img src="" id="img_pattern_image" class="mb-3 img-thumbnail d-none" style="width: 200px; height: 200px;">

                            <input type="file" name="pattern_image" class="form-control" id="pattern_image" onchange="validateInputFileImage(this)">
                            <small> * File Upload yang diperbolehkan berektensi JPG,JPEG,PNG,webp</small><br>
                            <small> * Maksimal Upload 2MB</small><br>
                            <span class="text-danger" id="pattern_image_error"></span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary" id="btn-submit">Save <i class="fa fa-save"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script src="{{asset('vendor/jscolor/jscolor.js')}}"></script>
    <script src="{{asset('utils/validate.js')}}"></script>

    <script>
        $('#btn-submit').on('click',function(e){
            e.preventDefault();
            var form = $('#form');

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Untuk tambah data ini?",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, Tambahkan!'
            }).then((result) => {
                if (result.value) {
                    submitApi();
                }
            })
        });

        function submitApi(){
            const form = document.getElementById('form');
            const form_data = new FormData(form);
            // form_data.append('pattern',$('#pattern').is(':checked'));

            $.ajax({
                url: $('#form').attr('action'),
                type:"{{isset($id) ? 'post' : 'post'}}",
                data: form_data,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    accept: "*/*"
                },
                beforeSend(){
                    $('#btn-submit').attr('disabled','true');
                    $('#btn-submit').html('loading <i class="fa fa-spinner"></i>');
                },
                success(data){
                    $('#btn-submit').removeAttr('disabled');
                    $('#btn-submit').html('{{isset($id) ? 'Edit' : 'Save' }} <i class="fa fa-save"></i>');

                    Swal.fire(
                        '',
                        'Data berhasil di {{isset($id) ? 'Edit' : 'Save' }}',
                        'success'
                    );

                    setTimeout(() => {
                        window.location.href = '/colors';
                    }, 500);
                },
                error(error){
                    $('#btn-submit').removeAttr('disabled');
                    $('#btn-submit').html('{{isset($id) ? 'Edit' : 'Save' }} <i class="fa fa-save"></i>');

                    for(const err in error.responseJSON.messages){
                        $(`#${err}_error`).text(error.responseJSON.messages[err][0])
                    }
                },
            })
        }

        @if(isset($id))
        getDetail();
        function getDetail(){
            $.ajax({
                url: '/api/colors/{{$id}}',
                type: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success(data){
                    for(const d in data){
                        if(d != 'created_at' && d != 'updated_at' && d !='pattern_image'){
                            $('#'+d).val(data[d]);
                        }

                        if(d == 'pattern_image'){
                            if(data[d] != '' && data[d] != undefined){
                                $('#img_'+d).removeClass('d-none');
                                $('#img_'+d).addClass('d-block');
                                $('#img_'+d).attr('src',`${data[d]}`);
                            }
                        }
                    }
                },
                error(error){
                    console.error(error)
                }
            });
        }
        @endif
    </script>
@stop
