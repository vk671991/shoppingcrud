@extends('layout')

@section('title')
    Backend Product Listing
@endsection

@section('css')
    <!-- Custom styles for this template -->
    <link href="{{ asset('css/album.css') }}" rel="stylesheet">
@endsection

@section('body')
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">Online Shop</h1>
            <p><a href="{{ route('backend.product.create') }}" class="btn btn-primary my-2">Add Product</a></p>
        </div>
    </section>

    <div class="album py-5 bg-light">
        <div class="container">

            <div class="row" id="productList">

            </div>
            <div class="row" id="paginationLinks">

            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function() {
            getProducts("{{ route('api.product.list') }}?page=1");
            function getProducts(url){
                $.ajax({
                    url: url,
                    type: "get",
                    success: function (response) {
                        var products = response.data;
                        var links = response.meta.links;
                        var html = '';
                        $.each(products, function (key, val) {

                            if (val.description.length > 100) {
                                var str =  val.description.substr(0,98);
                                var wordIndex = str.lastIndexOf(" ");
                                val.description = str.substr(0, wordIndex) + '..';
                            }

                            html+= '<div class="col-md-4">';
                            html+= '<div class="card mb-4 box-shadow">';
                            html+= '<img class="card-img-top" src="#" alt="'+val.name+'">';
                            html+= '<div class="card-body">';
                            html+= '<h4>'+val.name+'</h4>';
                            html+= '<p class="card-text">Category '+val.category+'</p>';
                            html+= '<p class="card-text">Description '+val.description+'</p>';
                            html+= '<div class="d-flex justify-content-between align-items-center">';
                            html+= '<div class="btn-group">';
                            html+= '<button type="button" class="btn btn-sm btn-outline-secondary deleteProduct" data-slug="'+val.slug+'">Delete</button>';
                            html+= '<a href="{{ url('/shop-backend') }}/'+val.slug+'/edit" class="btn btn-sm btn-outline-secondary">Edit</a>';
                            html+= '</div>';
                            html+= '</div>';
                            html+= '</div>';
                            html+= '</div>';
                            html+= '</div>';
                        });
                        $('#productList').html(html);

                        var linkshtml = '<nav aria-label="...">';
                        linkshtml +='<ul class="pagination">';

                        $.each(links, function (key, val) {
                            var disabled = '';
                            var dataurl = 'data-url="'+val.url+'" id="getProducts"';
                            if(val.url === null){
                                disabled='disabled';
                                dataurl='';
                            }

                            var active = '';
                            if(val.active == true){
                                active='active';
                            }
                            linkshtml +='<li class="page-item '+disabled + active+'">';
                            linkshtml +='<span class="page-link" '+dataurl+' >'+val.label+'</span>';
                            linkshtml +='</li>';
                        });
                        linkshtml +='</ul>';
                        linkshtml +='</nav>';
                        $('#paginationLinks').html(linkshtml);

                        $('.page-link').click(function (){
                            getProducts($(this).attr("data-url"));
                        });

                        $('.deleteProduct').click(function (){
                            deleteProduct($(this).attr("data-slug"));
                        });
                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                        $('#productList').html('Product list not found.');
                    }
                });
            }

            function deleteProduct(slug){
                $.ajax({
                    url: "{{ url('http://localhost:8000/api/shop-backend/products') }}/"+slug+"/delete",
                    type: "POST",
                    success: function (response) {
                        swal(response.message)
                            .then((value) => {
                                getProducts("{{ route('api.product.list') }}?page=1");
                            });
                    },
                    error: function (jqXHR, exception) {
                        swal('Product not found')
                            .then((value) => {
                                getProducts("{{ route('api.product.list') }}?page=1");
                            });
                    }
                });
            }
        });
    </script>
@endsection
