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
        <div class="card-header">Books</div>
        <div class="card-body">
            <button class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#createBook"><i class="fa fa-plus"></i> Create Book</button>
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
                        <a href="?sort=title&direction={{ request('direction')=='asc' ? 'desc' : 'asc' }}">Title</a>
                    </th>
                    <th>Description</th>
                    <th>Authors</th>
                    <th>Published</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
                </thead>

                <tbody id="booksList">
                @foreach($books as $book)
                    <tr>
                        <td>{{ $book->id }}</td>
                        <td>{{ $book->title }}</td>
                        <td>{{ $book->description }}</td>
                        <td>
                            @foreach($book->authors as $author)
                                {{ $author->first_name }} {{ $author->last_name }}@if(!$loop->last), @endif
                            @endforeach
                        </td>
                        <td>{{ $book->published_at->format('Y-m-d') }}</td>
                        <td>
                            @if($book->image)
                                <img src="{{ asset('storage/books/' . $book->image) }}" alt="Book Image" width="50">
                            @else
                                N/A
                            @endif
                        </td>
                        <td>
                            <button data-id="{{ $book->id }}" class="btn btn-primary btn-sm edit-book"><i class="fa fa-pen"></i> Edit</button>
                            <button data-id="{{ $book->id }}" class="btn btn-danger btn-sm delete-book"><i class="fa fa-trash"></i> Delete</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

            @if ( method_exists($books, 'links') )
            <div>
                {{ $books->links() }}
            </div>
            @endif
        </div>
    </div>

    <!-- Create Book Modal -->
    <div class="modal fade" id="createBook" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create Book</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data">
                        <div class="mt-2">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" id="title" placeholder="Book Title">
                        </div>
                        <div class="mt-2">
                            <label for="description" class="form-label">Description</label>
                            <textarea type="text" class="form-control" name="description" id="description" placeholder="Book description"></textarea>
                        </div>
                        <div class="mt-2">
                            <label for="published_at" class="form-label">Publish date</label>
                            <input type="date" class="form-control" name="published_at" id="published_at" placeholder="Publish date">
                        </div>
                        <div class="mt-2">
                            <label for="authors" class="form-label">Authors</label>
                            <select class="form-select" multiple="multiple" name="authors[]" id="authors">
                                @if(isset($authors) && count($authors))
                                    @foreach($authors as $author)
                                        <option value="{{ $author->id }}">{{ $author->first_name }} {{ $author->last_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="mt-2">
                            <label for="image" class="form-label">Image</label>
                            <input class="form-control" type="file" id="image" name="image" >
                            <div class="mt-2" id="preview-container-img">
                                <!--<img id="preview-img" src="" alt="Book Image" width="100px">-->
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary create-book">Save book</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Update Book Modal -->
    <div class="modal fade" id="editBook" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Update Book</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form enctype="multipart/form-data" id="update-book-form">
                        @csrf
                        <input type="hidden" name="book_id" id="book_id">
                        <div class="mt-2">
                            <label for="title_edit" class="form-label">Book Title</label>
                            <input type="text" class="form-control" name="title" id="title_edit" placeholder="Book Title">
                        </div>
                        <div class="mt-2">
                            <label for="description_edit" class="form-label">Description</label>
                            <input type="text" class="form-control" name="description" id="description_edit" placeholder="Description">
                        </div>
                        <div class="mt-2">
                            <label for="published_at_edit" class="form-label">Publish date</label>
                            <input type="date" class="form-control" name="published_at" id="published_at_edit" placeholder="Publish date">
                        </div>
                        <div class="mt-2">
                            <label for="authors_edit" class="form-label">Authors</label>
                            <select class="form-select" multiple="multiple" name="authors[]" id="authors_edit">
                                @if(isset($authors) && count($authors))
                                    @foreach($authors as $author)
                                        {{--<option value="{{ $author->id }}" @if(in_array($author->id, $books[0]->authors->pluck('id')->toArray())) selected @endif >--}}
                                        <option value="{{ $author->id }}" >
                                            {{ $author->first_name }} {{ $author->last_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="mt-2">
                            <label for="image_edit" class="form-label">Image</label>
                            <input class="form-control" type="file" id="image_edit" name="image" >
                            <div class="mt-2" id="preview-container-image">
                                <img id="preview-image" src="" alt="Book Image" width="100px">
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary update-book">Update</button>
                </div>
            </div>
        </div>
    </div>

</div>
</body>

<script>
$(document).ready(function() {
    // create a book
    $('.create-book').on('click', function() {
        let formData = new FormData();
        let csrfToken = '{{ csrf_token() }}';

        formData.append('title', $('#title').val());
        formData.append('description', $('#description').val());
        formData.append('published_at', $('#published_at').val());
        formData.append('authors', $('#authors').val());
        formData.append('image',  $('#image').get(0).files[0]);
        formData.append('_token', csrfToken);

        //console.log(formData);

        $('.error-message').remove();

        $.ajax({
            method: 'post',
            url: '/books',
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.errors) {
                    $.each(response.errors, function(key, value) {
                        $("#" + key).after('<div class="error-message text-danger">' + value[0] + '</div>');
                    });
                } else {
                    $("#editBook").modal("hide");
                    location.href = window.location.origin+'/books';
                }
            },
            error: function(error) {
                console.log(error);
            }
        });

    });

    // show modal edit book form
    $('body').on('click', '.edit-book', function() {
        let id = $(this).data('id');
        $.ajax({
            type: 'GET',
            url: '/books/'+id,
            dataType: 'json',
            success: function(response) {
                //console.log(response);
                $("#book_id").val(response.book.id);
                $("#title_edit").val(response.book.title);
                $("#description_edit").val(response.book.description);
                $("#published_at_edit").val(response.book.published_at.split('T')[0]); // Date(response.book.published_at)
                $("#preview-container-image img").prop('src', response.book.image ? window.location.origin+'/storage/books/'+response.book.image : '');

                $('#editBook').modal('show');
            },
            error: function(error) {
                console.log(error);
            }
        });
    });

    //update book data
    $('.update-book').on('click', function() {
        let formData = new FormData($('#update-book-form')[0]);
        let csrfToken = '{{ csrf_token() }}';
        let book_id = $("#book_id").val();

        //formData.append('title', $('#title_edit').val());
        //formData.append('description', $('#description_edit').val());
        //formData.append('published_at', $('#published_at_edit').val());
        //formData.append('authors', $('#authors_edit').val());
        //formData.append('image',  $('#image_edit').get(0).files[0]);
        //formData.append('_token', csrfToken);
        //formData.append('_method', 'PUT');

        formData.title = $('#title_edit').val();
        formData.description = $('#description_edit').val();
        formData.published_at = $('#published_at_edit').val();
        formData._token = csrfToken;

        if ($('#image_edit').get(0).files[0] !== 'undefined') {
            formData.image =  $('#image_edit').get(0).files[0];
        }
        if ($('#authors_edit').val() !== 'undefined' || $('#authors_edit').val().length !== 0) {
            formData.authors = $('#authors_edit').val();
        }

        //console.log(formData, book_id);

        $('.error-message').remove();

        $.ajax({
            method: 'post',
            url: '/book/'+book_id,
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                if (response.errors) {
                    $.each(response.errors, function(key, value) {
                        $("#"+key+"_edit").after('<div class="error-message text-danger">' + value[0] + '</div>');
                    });
                } else {
                    $("#createBook").modal("hide");
                    location.href = window.location.origin+'/books';
                }
            },
            error: function(error) {
                console.log(error);
            }
        });

    });

    // change image in modal preview container for edit book
    $('#image_edit').on('change', function() {
        const files = $(this)[0].files;
        $("#preview-container-image").empty();
        if(files.length > 0){
            for(let i = 0; i < files.length; i++){
                const reader = new FileReader();
                reader.onload = function(e){
                    $(`<div class='preview'><img width='80px' src='` + e.target.result + "'></div>").appendTo("#preview-container-image");
                };
                reader.readAsDataURL(files[i]);
            }
        }
    });

    // change image in modal preview container for create book
    $('#image').on('change', function() {
        const files = $(this)[0].files;
        $("#preview-container-img").empty();
        if(files.length > 0){
            for(let i = 0; i < files.length; i++){
                const reader = new FileReader();
                reader.onload = function(e){
                    $(`<div class='preview'><img width='80px' src='` + e.target.result + "'></div>").appendTo("#preview-container-img");
                };
                reader.readAsDataURL(files[i]);
            }
        }
    });

    // delete book
    $('.delete-book').on('click', function() {
        let id = $(this).data('id');

        if (confirm('Are you sure you want to delete this book?')) {
            $.ajax({
                type: 'DELETE',
                url: '/books/'+id,
                data: {
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(response) {
                    location.href = window.location.origin+'/books';
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
    });

    // search book title (authors?)
    let search = '';
    $('#search').on('keyup', function() {
        if (this.value.length > 2) {
            search = $(this).val();

            $.ajax({
                type: 'GET',
                url: '/books/?search='+search,
                dataType: 'json',
                success: function(response) {
                    // show search result
                    console.log(response);
                    fetchFilter(response.books);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        if (this.value.length === 0) {
            search = '';
            location.href = window.location.origin+'/books';
        }
        //console.log(search);
    });

    // filter books title
    function fetchFilter(books) {
        let row = '';
        $.each(books, function(key, book) {

            let bookAuthors = book.authors.map(author => author.first_name + ' ' + author.last_name).join(', ');
            let publishedAt = book.published_at.split('T')[0];

            row += `
                        <tr>
                            <td>${book.id}</td>
                            <td>${book.title}</td>
                            <td>${book.description}</td>
                            <td>${bookAuthors}</td>
                            <td>${publishedAt}</td>
                            <td>
                                <img src="storage/books/${book.image}" alt="Book Image" width="50">
                            </td>
                            <td>
                                <button data-id="${book.id}" class="btn btn-primary btn-sm edit-book"><i class="fa fa-pen"></i> Edit</button>
                                <button data-id="${book.id}" class="btn btn-danger btn-sm delete-book"><i class="fa fa-trash"></i> Delete</button>
                            </td>
                        </tr>
                    `;
        });

        $('#booksList').html(row);
    }

});
</script>

</html>