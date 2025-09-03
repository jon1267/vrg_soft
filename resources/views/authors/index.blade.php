<!doctype html>
<html lang="en">
<head>
    <title>Authors</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.0/css/all.min.css" integrity="sha512-DxV+EoADOkOygM4IR9yXP8Sb2qwgidEmeqAEmDKIOfPRQZOWbXCzLC6vjbZyy0vPisbH2SyW27+ddLVCN+OMzQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <div class="container">
        <div class="card mt-5">
            <div class="card-header">Authors</div>
            <div class="card-body">
                <button class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#createAuthor"><i class="fa fa-plus"></i> Create Author</button>
                <div class="col-md-3">
                    <input type="text" name="search" id="search" class="form-control mb-2 col-1" placeholder="Search...">
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>
                                <a href="?sort=id&direction={{ request('direction')=='desc' ? 'asc' : 'desc' }}">ID</a>
                            </th>
                            <th>
                                <a href="?sort=last_name&direction={{ request('direction')=='asc' ? 'desc' : 'asc' }}">Last Name</a>
                            </th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody id="authorList">
                    @foreach($authors as $author)
                        <tr>
                            <td>{{ $author->id }}</td>
                            <td>{{ $author->last_name }}</td>
                            <td>{{ $author->first_name }}</td>
                            <td>{{ $author->middle_name }}</td>
                            <td>
                                <button data-id="{{ $author->id }}" class="btn btn-primary btn-sm edit-author"><i class="fa fa-pen"></i> Edit</button>
                                <button data-id="{{ $author->id }}" class="btn btn-danger btn-sm delete-author"><i class="fa fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>

                @if ( method_exists($authors, 'links') )
                <div class="p-2">
                    {{ $authors->links() }}
                </div>
                @endif
            </div>
        </div>

        <!-- Create Author Modal -->
        <div class="modal fade" id="createAuthor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Create Author</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="mt-2">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="last_name" placeholder="Last Name">
                            </div>
                            <div class="mt-2">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" name="first_name" id="first_name" placeholder="First Name">
                            </div>
                            <div class="mt-2">
                                <label for="middle_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" name="middle_name" id="middle_name" placeholder="Middle Name">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary create-author">Save changes</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Author Modal -->
        <div class="modal fade" id="editAuthor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Author</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <input type="hidden" name="author_id" id="author_id">
                            <div class="mt-2">
                                <label for="last_name_edit" class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="last_name" id="last_name_edit" placeholder="Last Name">
                            </div>
                            <div class="mt-2">
                                <label for="first_name_edit" class="form-label">First Name</label>
                                <input type="text" class="form-control" name="first_name" id="first_name_edit" placeholder="First Name">
                            </div>
                            <div class="mt-2">
                                <label for="middle_name_edit" class="form-label">First Name</label>
                                <input type="text" class="form-control" name="middle_name" id="middle_name_edit" placeholder="Middle Name">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary update-author">Update</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

<script>
    $(document).ready(function() {

        //fetchAuthors();

        // Fetch Authors from table
        function fetchAuthors() {
            $.ajax({
                type: 'GET',
                url: '/authors',
                dataType: 'json',
                success: function(response) {
                    //console.log(response);
                    let row = '';
                    $.each(response.authors, function(key, author) {
                        row += `
                        <tr>
                            <td>${author.id}</td>
                            <td>${author.last_name}</td>
                            <td>${author.first_name}</td>
                            <td>${author.middle_name}</td>
                            <td>
                                <button data-id="${author.id}" class="btn btn-primary btn-sm edit-author"><i class="fa fa-pen"></i> Edit</button>
                                <button data-id="${author.id}" class="btn btn-danger btn-sm delete-author"><i class="fa fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                    `;
                    });

                    $('#authorList').html(row);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        // create author
        $(".create-author").on('click', function() {
            let formData = {
                last_name: $("#last_name").val(),
                first_name: $("#first_name").val(),
                middle_name: $("#middle_name").val(),
                _token: '{{ csrf_token() }}'
            }
            //console.log(formData);
            $('.error-message').remove();

            $.ajax({
                type: 'POST',
                url: '/authors',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.errors) {
                        $.each(response.errors, function(key, value) {
                            $("#" + key).after('<div class="error-message text-danger">' + value[0] + '</div>');
                        });
                    } else {
                        $("#createAuthor").modal("hide");
                        //fetchAuthors();
                        location.href = window.location.origin+'/authors';
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        })

        // modal edit form author
        $('body').on('click', '.edit-author', function() {
            let id = $(this).data('id');
            $.ajax({
                type: 'GET',
                url: '/authors/'+id,
                dataType: 'json',
                success: function(response) {
                    //console.log(response);
                    $("#author_id").val(response.author.id);
                    $("#last_name_edit").val(response.author.last_name);
                    $("#first_name_edit").val(response.author.first_name);
                    $("#middle_name_edit").val(response.author.middle_name);
                    $('#editAuthor').modal('show');
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        // update author data
        $(".update-author").on('click', function() {
            let formData = {
                last_name: $("#last_name_edit").val(),
                first_name: $("#first_name_edit").val(),
                middle_name: $("#middle_name_edit").val(),
                _token: '{{ csrf_token() }}'
            }
            let author_id = $("#author_id").val()
            //console.log(formData, author_id);
            $('.error-message').remove();

            $.ajax({
                type: 'PUT',
                url: '/authors/'+author_id,
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.errors) {
                        $.each(response.errors, function(key, value) {
                            $("#"+key+'_edit').after('<div class="error-message text-danger">' + value[0] + '</div>');
                        });
                    } else {
                        $("#editAuthor").modal("hide");
                        $('#search').val('');
                        //fetchAuthors();
                        location.href = window.location.origin+'/authors';
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        })

        // delete author
        $('body').on('click', '.delete-author', function() {
            let id = $(this).data('id');

            if (confirm('Are you sure you want to delete this author?')) {
                $.ajax({
                    type: 'DELETE',
                    url: '/authors/'+id,
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    dataType: 'json',
                    success: function(response) {
                        //fetchAuthors();
                        location.href = window.location.origin+'/authors';
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        });


        // search authors
        let search = '';
        $('#search').on('keyup', function() {
            if (this.value.length > 2) {
                search = $(this).val();

                $.ajax({
                    type: 'GET',
                    url: '/authors/?search='+search,
                    dataType: 'json',
                    success: function(response) {
                        // show search result
                        fetchFilter(response.authors);
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }

            if (this.value.length === 0) {
                search = '';
                //fetchAuthors();
                location.href = window.location.origin+'/authors';
            }
            //console.log(search);
        })

        // filter authors
        function fetchFilter(authors) {
            let row = '';
            $.each(authors, function(key, author) {
                row += `
                        <tr>
                            <td>${author.id}</td>
                            <td>${author.last_name}</td>
                            <td>${author.first_name}</td>
                            <td>${author.middle_name}</td>
                            <td>
                                <button data-id="${author.id}" class="btn btn-primary btn-sm edit-author"><i class="fa fa-pen"></i> Edit</button>
                                <button data-id="${author.id}" class="btn btn-danger btn-sm delete-author"><i class="fa fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                    `;
            });

            $('#authorList').html(row);
        }

    });

</script>

</html>