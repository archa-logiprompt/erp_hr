@extends('layouts.dashboard.app')
@section('content')
    <div class="page-body">
        <div class="col-xl-12">
            <div class="card height-equal">
                <div class="card-header">
                    <h4>General settings form</h4>
               
                </div>
                <div class="card-body">
                    <form class="" method="POST" id="generalsettingsForm" action="{{ url('admin/generalsettings/update', $generaldata->id) }}"
                        novalidate="">
                        @csrf
                        <div class="row g-3">
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01">Prefix</label>
                                <input class="form-control" id="validationCustom01" type="text"
                                    value="{{ $generaldata->prefix }}" placeholder="" name='prefix' required="">

                                @if ($errors->has('prefix'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('prefix') }}
                                    </div>
                                @endif
                            </div>
                            <div class="col-6">
                                <label class="form-label" for="validationCustom01">Staring Number</label>
                                <input class="form-control" id="validationCustom01" type="number"
                                    value="{{ $generaldata->startingNo }}" placeholder="" name='startingNo' required="">

                                @if ($errors->has('startingNo'))
                                    <div class="alert alert-danger mt-2">
                                        {{ $errors->first('startingNo') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-12 mt-3">
                            <button class="btn btn-primary" type="button" id="form-submit-btn">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('generalsettingsForm');

        $('#form-submit-btn').on('click', function(e) {
            e.preventDefault();

            // Get form data
            const formData = new FormData(form);
            const generalId = "{{ $generaldata->id }}"; // Laravel Blade to inject course ID
            const api8000Url =
            `/public/admin/generalsettings/update/${generalId}`; // Web app URL (8000)
            const api8080Url =
            baseurl+"admin/newgeneralsettings/update/"+generalId; // API URL (8080)

            // First, update the generalsettings in the web database (8000)
            $.ajax({
                url: api8000Url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log("Updated in web app (8000):", response);

                    // If successful, now update the generalsettings in the second database via the API (8080)
                    $.ajax({
                        url: api8080Url,
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            console.log("Updated in API (8080):", response);
                            alert("generalsettings updated !");
                            window.location.href =
                                `/public/admin/generalsettings`; // Redirect after success
                        },
                        error: function(xhr) {
                            console.error("Error updating in API (8080):", xhr);
                            alert(
                                "generalsettings updated in web database (8000) but failed in API (8080). Please check logs.");
                        }
                    });
                },
                error: function(xhr) {
                    console.error("Error updating in web app (8000):", xhr);
                    alert("Failed to update generalsettings in web app (8000). Please try again.");
                }
            });
        });
    });
</script>