@extends('layout.master')
@section('content')
<input type="hidden" id="post-id" value="{{$id}}">
<div class="container">
    <div id="post"></div>
</div>
@endsection
@section('script')
<script>
    $(document).ready(function () {

        function postCard(data) {
            return `
            <div class="row">
                <div class="card">
                    <div class="card-header">${data.user.name}</div>
                    <div class="card-body">
                        <h5 class="card-title">${data.title}</h5>
                        <p class="card-text">
                        ${data.content}
                        </p>
                        <a href="#" class="btn btn-warning">Edit</a>
                        <a href="#" class="btn btn-danger">Delete</a>
                    </div>
                    <div class="card-footer text-muted">${data.created_at}</div>
                </div>
            </div>
            `
        }

        function getPostById() {
            let id = $("#post-id").val()
            $.ajax({
                url: 'http://127.0.0.1:8000/api/posts/' + id,
                method: 'GET',
                success: function(res) {
                    console.log(res)
                    $("#post").append(postCard(res.post))
                },
                error: function(err) {
                    console.log(err)
                }
            })
        }

        getPostById()

    })
</script>
@endsection
