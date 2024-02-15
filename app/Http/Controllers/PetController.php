<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Validation\Rule;
use App\Models\Pet;



class PetController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://petstore.swagger.io/v2/',
            'timeout'  => 5,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        return view('create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $pet = new Pet();
        $result = $pet->createPet($request->all());

        if ($result === false || !empty($result['error'])) {
            return redirect()->back()->with('error', $result['error'] ?? 'Failed to add pet.');
        }
    
        return redirect()->route('pet.show', ['id' => $result['id']])->with('success', 'Pet added successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pet = new Pet();
        $result = $pet->findPet($id);
    
        if ($result === false || !empty($result['error'])) {
            return redirect()->back()->with('error', $result['error'] ?? 'Pet details not found.');
        }
    
        return view('show', ['pet' => $result]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pet = new Pet();
        $result = $pet->findPet($id);
    
        if ($result === false || !empty($result['error'])) {
            return redirect()->back()->with('error', $result['error'] ?? 'Pet details not found.');
        }

        return view('edit', ['pet' => $result]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pet = new Pet();
        $result = $pet->updatePet($request->all(), $id);
    
        if ($result === false || !empty($result['error'])) {
            return redirect()->back()->with('error', $result['error'] ?? 'Failed to update pet.');
        }
    
        return redirect()->route('pet.show', ['id' => $id])->with('success', 'Pet updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pet = new Pet();
        $result = $pet->deletePet($id);
    
        if ($result === false || !empty($result['error'])) {
            return redirect()->back()->with('error', $result['error'] ?? 'Failed to delete pet.');
        }
    
        return redirect()->route('pet.create')->with('success', 'Pet deleted successfully.');
    }    
}
