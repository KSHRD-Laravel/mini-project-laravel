@extends('layout.master')
@section('style')
<link rel="stylesheet" href="{{asset('css/category_chip.css')}}">
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-3">
            @if (auth()->user())
                <img src="{{auth()->user()->image}}" alt="User Profile">
                {{auth()->user()->name}}
            @else
                <br />
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <a href="{{url('/redirect')}}" class="btn btn-primary">Login with Facebook</a>
                    </div>
                </div>
            @endif
        </div>
        <div class="col-lg-6">
            <a href="/post/create" class="btn btn-outline-primary">Create new post</a>
            <br>
            <h3>Posts</h3>
            <div id="post"></div>
        </div>
        <div class="col-lg-3">
            <a href="/category/create" class="btn btn-outline-primary">Create new category</a>
            <br>
            <h3>Categories</h3>
            <div id="category"></div>
        </div>
    </div>
</div>
@endsection
@section('script')
@parent
<script>
    $(document).ready(function() {

        function categoryChip(data) {
            return `
            <a href="/categories/${data.id}">
                <div class="chip">
                    <div class="chip-head">${data.name.substring(0, 1)}</div>
                    <div class="chip-content">${data.name}</div>
                </div>
            </a>
            `
        }

        function postCard(data) {
            return `
            <div class="row">
                <div id="img-container"  style="width: 400px">
                            <img
                            src="/storage/${data.image}"
                            />
                        </div>
                <div class="card">
                    <div class="bg-image hover-overlay ripple" data-mdb-ripple-color="light">

                        <a href="#!">
                        <div class="mask" style="background-color: rgba(251, 251, 251, 0.15)"></div>
                        </a>
                    </div>
                    <div class="card-header">
                        <img src="${data.user.image}"/>
                        ${data.user.name}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">${data.title}</h5>
                        <p class="card-text">
                        ${data.content}
                        </p>
                        <a href="/posts/${data.id}" class="btn btn-primary">View</a>
                        <a href="#" class="btn btn-warning">Edit</a>
                        <a href="#" class="btn btn-danger">Delete</a>
                    </div>
                    <div class="card-footer text-muted">${data.created_at}</div>
                </div>
            </div>
            <br/>
            `
        }

        function getAllCategories() {
            $.ajax({
                url: '/api/categories',
                method: 'GET',
                success: function (res) {
                    console.log(res)
                    for(let category of res.categories) {
                        $("#category").append(categoryChip(category))
                    }
                },
                error: function (err) {
                    console.log(err)
                }
            })
        }

        function getAllPosts() {
            $.ajax({
                url: '/api/posts',
                method: 'GET',
                success: function (res) {
                    console.log(res)
                    for(let post of res.posts) {
                        post.created_at = moment(post.created_at, "YYYYMMDD").fromNow();
                        post.updated_at = moment(post.updated_at, "YYYYMMDD").fromNow();
                        $("#post").append(postCard(post))
                    }


        var options = {
            width: 400,
            zoomWidth: 400,
            offset: {vertical: 0, horizontal: 10}
        };
        new ImageZoom(document.getElementById("img-container"), options);

                },
                error: function (err) {
                    console.log(err)
                }
            })
        }

        getAllCategories();
        getAllPosts();

    })
</script>
@endsection
