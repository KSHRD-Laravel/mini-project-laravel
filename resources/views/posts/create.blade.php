@extends('layout.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            @if(auth()->user())
                <hr>
                <input type="hidden" id="user_id" value="{{auth()->user()->id}}">
                <form method="POST" id="post-form" enctype="multipart/form-data">
                    @csrf
                    <!-- Email input -->
                    <div class="form-outline mb-4">
                    <input type="text" id="title" class="form-control" />
                    <label class="form-label" for="title">Title</label>
                    </div>

                    <!-- Password input -->
                    <div class="form-outline mb-4">
                        <input type="Description" id="description" class="form-control" />
                        <label class="form-label" for="description">Description</label>
                    </div>

                    <div class="form-outline mb-4">
                        <label for="">Select Categories: </label>
                        <br>
                        <select name="category" id="category" multiple style="width: 100%;"></select>
                    </div>

                    <div class="form-outline mb-4">
                    <label class="form-label" for="image">Post Image</label>
                    <input type="file" class="form-control" name="image" id="image" accept="image/*"/>
                    </div>

                    <img id="preview" src="" width="50%">

                    <!-- Submit button -->
                    <button type="submit" id="create" class="btn btn-primary btn-block">Create</button>
                </form>
            @else
                <br />
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-4">
                        <a href="{{url('/redirect')}}" class="btn btn-primary">Login with Facebook</a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
@section('script')
@parent
<script>

    $(document).ready(function() {

        // Preview Image
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                $('#preview').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#image").change(function() {
            readURL(this);
        });


        // Get Category Option
        function categoryOption(data) {
            return `
                <option value="${data.id}">${data.name}</option>
            `
        }

        function getAllCategories() {
            $.ajax({
                url: '/api/categories',
                method: 'GET',
                success: function (res) {
                    console.log(res)
                    for(let category of res.categories) {
                        $("#category").append(categoryOption(category))
                    }
                },
                error: function (err) {
                    console.log(err)
                }
            })
        }

        getAllCategories();


        // Create Post
        function createPost() {
            $('#post-form').submit(function(e) {
                e.preventDefault()
                NProgress.start();
                let formData = new FormData(this)
                $.ajax({
                    method: 'POST',
                    url: '/api/posts/image/store',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        console.log(res)
                        post(res.path)
                    },
                    error: function (err) {
                        console.log(err)
                        NProgress.done();
                    }
                })
            })

            function post(image) {
                let post = {
                    "title": $('#title').val(),
                    "content": $('#description').val(),
                    "user_id": $("#user_id").val(),
                    "image": image,
                    "categories": $("#category").val()
                }

                $.ajax({
                    url: '/api/posts',
                    method: 'POST',
                    data: post,
                    success: function (res) {
                        console.log(res)
                        NProgress.done();
                        Swal.fire(
                        'Good job!',
                        'You clicked the button!',
                        'success'
                        )
                    },
                    error: function (err) {
                        console.log(err)
                        NProgress.done();
                    }
                })
            }

        }

        createPost()

    })

</script>
@endsection
