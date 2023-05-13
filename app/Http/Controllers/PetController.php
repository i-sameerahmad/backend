<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pets = Pet::all();

        return response()->json([
            'data' => $pets,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'gender' => 'required|string',
            'category' => 'required|string',
            'age' => 'required|integer',
            'price' => 'required|numeric',
            'user_id' => 'required|numeric',
            'image' => 'nullable|image|max:2048', // Add validation rules for the image field
        ]);
        $pet = new Pet();
        $pet->title = $validatedData['title'];
        $pet->description = $validatedData['description'];
        $pet->gender = $validatedData['gender'];
        $pet->category = $validatedData['category'];
        $pet->age = $validatedData['age'];
        $pet->price = $validatedData['price'];
        $pet->user_id = $validatedData['user_id'];
        $pet->status = 'pending';
        // $pet->title = $request->input('title');
        // $pet->description = $request->input('description');
        // $pet->category = $request->input('category');
        // $pet->gender = $request->input('gender');
        // $pet->age = $request->input('age');
        // $pet->price = $request->input('price');
        // $pet->breed = $request->input('breed');
        // $pet->user_id = $request->input('user_id');
        // $pet->image = $request->input('image');

        // 'image' => 'nullable|image|max:2048',
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $filename);
            $pet->image = $filename;
        }

        $pet->save();

        return response()->json([
            'data' => $pet,
        ]);
    }

    public function show($id)
    {
        $pet = Pet::find($id);

        if (!$pet) {
            return response()->json([
                'error' => 'Pet not found',
            ], 404);
        }

        return response()->json([
            'data' => $pet,
        ]);
    }

    public function update(Request $request, $id)
    {
        $pet = Pet::find($id);

        if (!$pet) {
            return response()->json([
                'error' => 'Pet not found',
            ], 404);
        }

        $pet->title = $request->input('title');
        $pet->description = $request->input('description');
        $pet->category = $request->input('category');
        $pet->gender = $request->input('gender');
        $pet->age = $request->input('age');
        $pet->price = $request->input('price');
        $pet->status = $request->input('status');

        // Handle image upload
        if ($request->hasFile('image')) {
            $validatedData = $request->validate([
                'image' => 'nullable|image|max:2048',
            ]);
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $filename);
            $pet->image = $filename;
        }

        $pet->save();

        return response()->json([
            'data' => $pet,
        ]);
    }

    public function destroy($id)
    {
        $pet = Pet::find($id);
        if (!$pet) {
            return response()->json([
                'error' => 'Pet not found',
            ], 404);
        }

        $pet->delete();

        return response()->json([
            'message' => 'Pet deleted successfully',
        ]);
    }

}
