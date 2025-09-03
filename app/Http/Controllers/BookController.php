<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $search = $request->input('search');
            $books = Book::query()->with('authors')
                ->where('title', 'like', "%{$search}%")
                ->orWhereHas('authors', function ($query) use ($search) {
                    $query->where('last_name', 'like', "%{$search}%")
                        ->orWhere('first_name', 'like', "%{$search}%");
                })
                ->get();


            return response()->json(['books' => $books]);
        }

        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');
        $books = Book::query()->orderBy($sort, $direction)->paginate(15);
        $authors = Author::all(['id', 'last_name', 'first_name']);
        //dd($books, $books[0]->authors->pluck('id')->toArray());

        if ($request->ajax() ) {
            return response()->json(['books' => $books, 'authors' => $authors]);
        }

        return view('books.index', [
            'books' => $books,
            'authors' => $authors,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'published_at' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'authors' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $data = $request->except('_token', '_method', 'image','authors');

        $data['authors'] = explode(',', $request->input('authors'));

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->extension() ?: 'jpg';
            $upload_file = Str::random(10) . '.' . $extension;
            $destinationPath = storage_path('app/public/books/');
            $file->move($destinationPath, $upload_file);
            $data['image'] = $upload_file;
        }


        Book::create($data)->authors()->attach($data['authors']);

        return response()->json(['success' => true]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::find($id);
        return response()->json(['book' => $book]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //dd($request->all(), $id);
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'published_at' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'authors' => 'nullable|array|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $data = $request->except('_token','_method','image','authors');

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $extension = $file->extension() ?: 'jpg';
            $upload_file = Str::random(10) . '.' . $extension;
            $destinationPath = storage_path('app/public/books/');
            $file->move($destinationPath, $upload_file);
            $data['image'] = $upload_file;
        }

        if ($request->has('authors') && is_string($request->input('authors'))) {
            $syncAuthors = explode(',', $request->input('authors'));
        } elseif ($request->has('authors') && is_array($request->input('authors'))) {
            $syncAuthors = $request->input('authors');
        }

        $book = Book::find($id);
        $book->update($data);
        if (isset($syncAuthors) && is_array($syncAuthors) && count($syncAuthors)) {
            $book->authors()->sync($syncAuthors);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::find($id);
        if (!is_null($book->image) && File::exists('storage/books/'.$book->image)) {
            File::delete('storage/books/' . $book->image);
        }

        $book->delete();

        return response()->json(['success' => true]);
    }
}
