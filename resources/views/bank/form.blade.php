@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="m-0 text-dark">Form {{isset($id) ? 'Edit' : 'Tambah'}} Bank</h1>
@stop

@section('plugins.Sweetalert2',true)

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{isset($id) ? '/api/banks/'.$id : '/api/banks'}}" method="post" id="form" enctype="multipart/form-data">
                        @if(isset($id))
                            @method('put')
                        @else
                            @method('post')
                        @endif
                        @csrf
                        <div class="form-group">
                            <label for="bank">Bank</label>
                            <input type="text" name="bank" class="form-control" id="bank" placeholder="silahkan isi..">
                            <span class="text-danger" id="bank_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>

                            <img src="" id="img_image" class="mb-3 w-50 h-50 img-thumbnail d-none">

                            <input type="file" name="image" class="form-control" id="image" onchange="validateInputFileImage(this)">
                            <small> * File Upload yang diperbolehkan berektensi JPG,JPEG,PNG,webp</small><br>
                            <small> * Maksimal Upload 2MB</small><br>
                            <span class="text-danger" id="image_error"></span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary float-right" id="btn-submit">Save <i class="fa fa-save"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
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
                        window.location.href = '/banks';
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
                url: '/api/banks/{{$id}}',
                type: 'get',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success(data){
                    for(const d in data){
                        if(d != 'created_at' && d != 'updated_at' && d !='image'){
                            $('#'+d).val(data[d]);
                        }

                        if(d == 'image'){
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

