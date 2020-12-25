@extends('layout.master')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-6">
            <hr>
            <div class="form-outline mb-4">
            <input type="text" id="name" class="form-control" />
            <label class="form-label" for="name">Name</label>
            </div>

            <!-- Submit button -->
            <button type="button" id="create" class="btn btn-primary btn-block">Create</button>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
@parent
<script>
    $(document).ready(function() {
        function createCategory() {
            let category = {
                "name": $("#name").val()
            }
            $.ajax({
                url: '/api/categories',
                method: 'POST',
                data: category,
                success: function(res) {
                    console.log(res)
                },
                error: function(err) {
                    console.log(err)
                }
            })
        }
        $("#create").on('click', function() {
            createCategory()
        })
    })
</script>
@endsection
