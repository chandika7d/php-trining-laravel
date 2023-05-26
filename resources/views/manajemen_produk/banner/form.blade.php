@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1 class="m-0 text-dark">Form {{isset($id) ? 'Edit' : 'Tambah'}} Banner</h1>
@stop

@section('plugins.Sweetalert2',true)
@section('plugins.Select2',true)

@section('content')
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-body">
                    <form action="{{isset($id) ? '/api/banners/'.$id : '/api/banners'}}" method="post" id="form" enctype="multipart/form-data">
                        @if(isset($id))
                            @method('put')
                        @else
                            @method('post')
                        @endif
                        @csrf
                        <div class="form-group">
                            <label for="name">Banner</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="silahkan isi..">
                            <span class="text-danger" id="name_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="url">Url</label>
                            <input type="text" name="url" class="form-control" id="url" placeholder="silahkan isi..">
                            <span class="text-danger" id="url_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="id_banner_category">Banner Category</label>
                            <select name="id_banner_category" class="form-control" id="id_banner_category"></select>
                            <span class="text-danger" id="id_banner_category_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>

                            <img src="" id="img_image" class="mb-3 img-thumbnail d-none" style="width: 200px; height: 200px;">

                            <input type="file" name="image" class="form-control" id="image" onchange="validateInputFileImage(this)">
                            <small> * File Upload yang diperbolehkan berektensi JPG,JPEG,PNG,webp</small><br>
                            <small> * Maksimal Upload 2MB</small><br>
                            <span class="text-danger" id="image_error"></span>
                        </div>
                        <div class="form-group">
                            <label for="mobile_image">Mobile Image</label>

                            <img src="" id="img_mobile_image" class="mb-3 img-thumbnail d-none" style="width: 200px; height: 200px;">

                            <input type="file" name="mobile_image" class="form-control" id="mobile_image" onchange="validateInputFileImage(this)">
                            <small> * File Upload yang diperbolehkan berektensi JPG,JPEG,PNG,webp</small><br>
                            <small> * Maksimal Upload 2MB</small><br>
                            <span class="text-danger" id="mobile_image_error"></span>
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
        getBannerCategory();

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
                        window.location.href = '/banner';
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

        function getBannerCategory(){
            $.ajax({
                url:'/api/banner-categories',
                type:'get',
                dataType:'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend(){
                    let html = `<option value="">loading...</td>`;
                    $('#id_banner_category').html(html);
                },
                success(data){
                    let html = `<option value="">No Data</td>`;

                    const d = data.map((value,key) => {
                        return `<option value="${value.id}">${value.name}</td>`;
                    });

                    if(d.length > 0){
                        $('#id_banner_category').html(d);
                    }else{
                        $('#id_banner_category').html(html);
                    }
                },
                error(error){
                    console.error(error);
                }
            })
        }

        @if(isset($id))
            getDetail();
            function getDetail(){
                $.ajax({
                    url: '/api/banners/{{$id}}',
                    type: 'get',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success(data){
                        for(const d in data){
                            if(d != 'created_at' && d != 'updated_at' && d != 'image' && d != 'mobile_image'){
                                $('#'+d).val(data[d]);
                            }

                            if(d == 'image' || d == 'mobile_image'){
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

