<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookController extends Controller
{
    // Mostrar todos los libros
    public function index()
    {
        $books = Book::all();

        return response()->json([
            'message' => 'Lista de libros',
            'books' => $books
        ], 200);
    }

    // Mostrar un libro por ID
    public function show(int $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Libro no encontrado'
            ], 404);
        }

        return response()->json([
            'message' => 'Libro encontrado',
            'book' => $book
        ], 200);
    }

    // Registrar un libro
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:20|unique:books,isbn',
            'descripcion' => 'nullable|string',
            'cantidad' => 'required|integer|min:1',
            'disponibles' => 'required|integer|min:0|lte:cantidad',
        ]);

        $book = Book::create($validated);

        return response()->json([
            'message' => 'Libro registrado correctamente',
            'book' => $book
        ], 201);
    }

    // Actualizar un libro
    public function update(Request $request, int $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Libro no encontrado'
            ], 404);
        }

        $validated = $request->validate([
            'titulo' => 'sometimes|required|string|max:255',
            'autor' => 'sometimes|required|string|max:255',
            'isbn' => [
                'sometimes',
                'nullable',
                'string',
                'max:20',
                Rule::unique('books', 'isbn')->ignore($book->id),
            ],
            'descripcion' => 'sometimes|nullable|string',
            'cantidad' => 'sometimes|required|integer|min:1',
            'disponibles' => 'sometimes|required|integer|min:0',
        ]);

        $cantidad = $validated['cantidad'] ?? $book->cantidad;
        $disponibles = $validated['disponibles'] ?? $book->disponibles;

        if ($disponibles > $cantidad) {
            return response()->json([
                'message' => 'Los ejemplares disponibles no pueden superar la cantidad total.'
            ], 422);
        }

        $book->update($validated);

        return response()->json([
            'message' => 'Libro actualizado correctamente',
            'book' => $book
        ], 200);
    }

    // Eliminar un libro
    public function destroy(int $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json([
                'message' => 'Libro no encontrado'
            ], 404);
        }

        $book->delete();

        return response()->json([
            'message' => 'Libro eliminado correctamente'
        ], 200);
    }
}
