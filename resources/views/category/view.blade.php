@extends('layout.master')
@section('content')
<input type="hidden" id="category-id" value="{{$id}}">
<div class="container">
    <div class="row">
        <div class="col-lg-2">
            <div id="category"></div>
        </div>
        <div class="col-lg-10">
            <div id="post"></div>
        </div>
    </div>
</div>
@endsection
@section('script')
@parent
<script>
    $(document).ready(function () {

        function categoryModel(data) {
            return `
                <h3># ${data.name}</h3>
                <p>${data.posts.length} posts found.</p>
            `
        }

        function postCard(data) {
            return `
            <div class="row">
                <div class="card">
                    <div class="card-header">
                        <img src="https://ui-avatars.com/api/?name=${data.user.name}&size=32&background=random&rounded=true"/>
                        ${data.user.name}
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">${data.title}</h5>
                        <p class="card-text">
                        ${data.content}
                        </p>
                        <a href="#" class="btn btn-warning">Edit</a>
                        <a href="#" class="btn btn-danger">Delete</a>
                    </div>
                    <div class="card-footer text-muted">Created At ${data.created_at}</div>
                    <div class="card-footer text-muted">Updated At ${data.updated_at}</div>
                </div>
            </div>
            `
        }

        function getCategoryById() {
            let id = $("#category-id").val()
            $.ajax({
                url: 'http://127.0.0.1:8000/api/categories/' + id,
                method: 'GET',
                success: function(res) {
                    console.log(res)
                    $("#category").append(categoryModel(res.category))
                    for(let post of res.category.posts) {
                        post.created_at = moment(post.created_at, "YYYYMMDD").fromNow();
                        post.updated_at = moment(post.updated_at, "YYYYMMDD").fromNow();
                        $("#post").append(postCard(post))
                    }
                },
                error: function(err) {
                    console.log(err)
                }
            })
        }

        getCategoryById()

    })
</script>
@endsection
