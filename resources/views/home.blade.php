@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center">URL Shortener System</h3> <!-- Unified title for the system -->
                </div>
                <div id="alert-placeholder" class="mt-3"></div>

                <div class="col-md-3">
                    <form id="dataForm" class="row g-3" method="POST">
                        @csrf
                        <div class="col-12">
                            <input type="text" class="form-control" id="inputData" name="long_url"
                                   placeholder="Enter long url" required>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Generate</button>
                        </div>
                    </form>
                </div>

                <div class="col-md-9">
                    <div style="overflow-x: auto;">
                        <table class="table table-bordered table-striped" id="dataTable" style="table-layout: fixed; max-width: 100%;">
                            <thead >
                            <tr>
                                <th style="width: 10%;">Sl</th>
                                <th style="width: 50%;">Long URL</th>
                                <th style="width: 30%;">Short URL</th>
                                <th style="width: 10%;">Count</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $key => $url)
                                <tr>
                                    <td style="width: 10%;">{{$key+1}}</td>
                                    <td style="width: 50%; word-wrap: break-word;">{{$url->long_url ?? ''}}</td>
                                    <td style="width: 30%; word-wrap: break-word;"><a href="{{url('/shorturl/'.$url->short_url)}}">{{url('shorturl').'/'.$url->short_url ?? ''}}</a></td>
                                    <td style="width: 10%;">{{$url->count ?? 0}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#dataForm').on('submit', function(e) {
                e.preventDefault();
                $('#error-long_url').text('');
                $('#long_url').removeClass('is-invalid');
                $('#alert-placeholder').html('');

                let formData = $(this).serialize();

                $.ajax({
                    url: "{{ route('generate.url') }}",
                    method: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            $('#alert-placeholder').html(
                                `<div class="alert alert-success alert-dismissible fade show" role="alert">
                                    ${response.message}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`
                            );

                            let newRow = `
                                <tr>
                                    <td style="width: 10%;">${$('#dataTable tbody tr').length + 1}</td>
                                    <td style="width: 50%; word-wrap: break-word;">${response.data.long_url}</td>
                                    <td style="width: 30%; word-wrap: break-word;">
                                        <a href="{{ url('/shorturl/') }}/${response.data.short_url}" target="_blank">
                                        {{ url('/shorturl/') }}/${response.data.short_url}
                                         </a>
                                     </td>
                                     <td style="width: 10%;">${response.data.count}</td>
                                </tr>
                            `;
                            $('#dataTable tbody').append(newRow);

                            $('#dataForm')[0].reset();
                        }
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            let alertMessage = '';

                            $('.error-message').text('');
                            $('.is-invalid').removeClass('is-invalid');

                            for (const field in errors) {
                                if (errors.hasOwnProperty(field)) {
                                    $(`#error-${field}`).text(errors[field][0]);
                                    $(`#${field}`).addClass('is-invalid');

                                    alertMessage += `<li>${errors[field][0]}</li>`;
                                }
                            }
                            if (alertMessage) {
                                $('#alert-placeholder').html(
                                    `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Validation errors:</strong>
                                        <ul>${alertMessage}</ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                     </div>`
                                );
                            }
                        } else {
                            $('#alert-placeholder').html(
                                `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    An unexpected error occurred.
                                     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>`
                            );
                        }
                    }
                });
            });
        });
    </script>
@endpush

