<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
//use App\Http\Requests\CreateAuthorRequest;
use App\Models\Author;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request):  View | JsonResponse
    {
        if ($request->has('search')) {
            $search = $request->input('search');
            $authors = Author::query()
                ->where('last_name', 'like', "%{$search}%")
                ->orWhere('first_name', 'like', "%{$search}%")->get();;

            return response()->json(['authors' => $authors]);
        }

        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'asc');
        $authors = Author::query()->orderBy($sort, $direction)->paginate(15);

        if ($request->ajax() ) {
            return response()->json(['authors' => $authors]);
        }

        return view('authors.index' , compact('authors')); //
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
        $validator = Validator::make($request->all(), [
            'last_name' => 'required|string|min:3|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $author = Author::create([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name ?? null,
        ]);

        return response()->json(['success' => true, 'author' => $author]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $author = Author::find($id);
        return response()->json(['author' => $author]);
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
        $validator = Validator::make($request->all(), [
            'last_name' => 'required|string|min:3|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
        ]);


        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $author = Author::find($id);

        $author->update([
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name ?? null,
        ]);

        return response()->json(['success' => true, 'author' => $author]);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $author = Author::find($id);
        $author->delete();

        return response()->json(['success' => true]);
    }
}
