@extends('layout')

@section('title')
    Backend Product Listing
@endsection

@section('css')
<style>
    .error{
        color: orangered;
    }
</style>

@endsection

@section('body')
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">Online Shop</h1>
            <p><a href="{{ route('backend.product.list') }}" class="btn btn-primary my-2">Back to Product List</a></p>
        </div>
    </section>

    <div class="album py-5 bg-light">
        <div class="container">

            <div class="row">
                <div class="col-md-10">
                    <form class="needs-validation" name="addProductForm" id="addProductForm" action="#">
                        <div class="mb-3">
                            <label for="title">Title </label>
                            <input type="text" class="form-control" id="title" name="title" placeholder="Title" required="">

                        </div>
                        <div class="mb-3">
                            <label for="username">Price</label>
                            <input type="text" class="form-control" id="price" name="price" placeholder="Price" required="">
                        </div>
                        <div class="mb-3">
                            <label for="username">Description</label>
                            <textarea class="form-control" id="description" name="description" placeholder="Description" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="username">Category</label>
                            <select class="form-control" id="category" name="category" required>
                                <option value="">Select Category</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="username">Image</label>
                            <input type="file" class="form-control" id="image" name="image" placeholder="Image" required="">
                        </div>
                        <hr class="mb-4">
                        <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
                    </form>
                </div>

            </div>

        </div>
    </div>
@endsection
@section('js')
    <script src=" {{ asset('js/jquery.validate.js') }}"></script>
    <script src=" {{ asset('js/additional-methods.js') }}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#price").on("keyup", function(){
                var valid = /^\d{0,4}(\.\d{0,2})?$/.test(this.value),
                    val = this.value;

                if(!valid){
                    console.log("Invalid input!");
                    this.value = val.substring(0, val.length - 1);
                }
            });

            $.ajax({
                url: "{{ route('api.product-category.list') }}",
                type: "get",
                success: function (response) {
                    $.each(response.data, function(key, value) {
                        $('#category')
                            .append($("<option></option>")
                                .attr("value", value.id)
                                .text(value.name));
                    });
                }
            });

            var url = $(location).attr('href');
            var segments = url.split( '/' );
            var slug = segments[4];
            $.ajax({
                url: "{{ url('http://localhost:8000/api/shop-backend/products') }}/"+slug,
                type: "get",
                success: function (response) {
                    $('#title').val(response.data.name);
                    $('#price').val(response.data.price);
                    $('#description').val(response.data.description);
                    $("#category option").filter(function() {
                        return this.text == response.data.category;
                    }).attr('selected', true);
                },
                error: function (jqXHR, exception) {
                    swal('Product not found')
                        .then((value) => {
                            window.location.href="{{ route('backend.product.list') }}"
                        });
                }
            });

            $("#addProductForm").validate({
                rules: {
                    title: {
                        required: true,
                        minlength: 10
                    },
                    price: {
                        required: true,
                        number: true,
                    },
                    description: {
                        required: true,
                    },
                    image: {
                        required: true,
                        accept: "image/jpg,image/jpeg"
                    },
                },
                errorElement : 'div',
                submitHandler: function(form,e) {
                e.preventDefault();
                    var file_data = $('#image').prop('files')[0];
                    var form_data = new FormData();
                    form_data.append('file', file_data);
                    form_data.append('name', $('#title').val());
                    form_data.append('price', $('#price').val());
                    form_data.append('description', $('#description').val());
                    form_data.append('category', $('#category').find(":selected").val());

                    $.ajax({
                        url: "{{ url('http://localhost:8000/api/shop-backend/products') }}/"+slug+"/update",
                        type: "post",
                        data:form_data,
                        cache:false,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            swal(response.message)
                                .then((value) => {
                                    window.location.href="{{ route('backend.product.list') }}"
                                });
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            swal(response.message);
                        }
                    });
                    return false;
                }
            });

        });
    </script>
@endsection
