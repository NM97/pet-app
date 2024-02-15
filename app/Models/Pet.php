<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class Pet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'photoUrls', 'status', 'category', 'tags',
    ];

    protected $client;

    public function __construct()
    {
        parent::__construct();
        $this->client = new Client([
            'base_uri' => 'https://petstore.swagger.io/v2/',
            'timeout'  => 5,
        ]);
    }
    
    public function createPet(array $data)
    {
        $validatedData = validator($data, [
            'name' => 'required|string|max:255',
            'photoUrls' => 'required|url',
        ])->validate();

        $responseData = [
            'name' => $validatedData['name'],
            'photoUrls' => [$validatedData['photoUrls']],
            'status' => 'available',
        ];
        
        if (isset($data['category']) && $data['category'] != '') {
            $responseData['category'] = [
                'id' => 0,
                'name' => $data['category'],
            ];
        }

        if (isset($data['tags']) && $data['tags'] != '') {
            $responseData['tags'] = [[
                'id' => 0,
                'name' => $data['tags'],
            ]];
        }

        try {
            $response = $this->client->post('pet', [
                'json' => $responseData
            ]);

            $statusCode = $response->getStatusCode();
            $responseData = json_decode($response->getBody()->getContents(), true);

            if (($statusCode === 200 || $statusCode === 201) && isset($responseData['id'])) {
                return ['id' => $responseData['id']];
            } else {
                return false;
            }
        } catch (RequestException $e) {
            Log::error('Failed to add pet. Error: ' . $e->getMessage());
            return ['error' => 'Failed to add pet. Error: ' . $e->getMessage()];
        } catch (\Exception $e) {
            Log::error('Failed to add pet. Unknown error occurred.');
            return ['error' => 'Failed to add pet. Unknown error occurred.'];
        }
    }

    public function findPet($id)
    {
        try {
            $response = $this->client->get('pet/' . $id);

            $responseData = json_decode($response->getBody()->getContents(), true);

            if (isset($responseData['id'])) {
                return $responseData;
            } else {
                return false;
            }
        } catch (RequestException $e) {
            Log::error('Failed to fetch pet details. Error: ' . $e->getMessage());
            return ['error' => 'Failed to fetch pet details. Error: ' . $e->getMessage()];
        } catch (\Exception $e) {
            Log::error('Failed to fetch pet details. Unknown error occurred.');
            return ['error' => 'Failed to fetch pet details. Unknown error occurred.'];
        }
    }

    public function updatePet(array $data, $id)
    {
        $validatedData = validator($data, [
            'name' => 'required|string|max:255',
            'photoUrls' => 'required|url',
            'status' => ['required', Rule::in(['available', 'pending', 'sold'])],
        ])->validate();

        $responseData = [
            'id' => $id,
            'name' => $validatedData['name'],
            'photoUrls' => [$validatedData['photoUrls']],
            'status' => $validatedData['status'],
        ];
        
        if (isset($data['category']) && $data['category'] != '') {
            $responseData['category'] = [
                'id' => 0,
                'name' => $data['category'],
            ];
        }

        if (isset($data['tags']) && $data['tags'] != '') {
            $responseData['tags'] = [[
                'id' => 0,
                'name' => $data['tags'],
            ]];
        }

        try {
            $response = $this->client->put('pet', [
                'json' => $responseData
            ]);

            if ($response->getStatusCode() === 200 || $response->getStatusCode() === 201) {
                return true;
            } else {
                return false;
            }
        } catch (RequestException $e) {
            Log::error('Failed to update pet. Error: ' . $e->getMessage());
            return ['error' => 'Failed to update pet. Error: ' . $e->getMessage()];
        } catch (\Exception $e) {
            Log::error('Failed to update pet. Unknown error occurred.');
            return ['error' => 'Failed to update pet. Unknown error occurred.'];
        }
    }

    public function deletePet($id)
    {
        try {
            $client = new Client([
                'base_uri' => 'https://petstore.swagger.io/v2/',
                'timeout'  => 5,
            ]);

            $response = $client->delete('pet/' . $id);

            if ($response->getStatusCode() === 200 || $response->getStatusCode() === 204) {
                return true;
            } else {
                return false;
            }
        } catch (RequestException $e) {
            Log::error('Failed to delete pet. Error: ' . $e->getMessage());
            return ['error' => 'Failed to delete pet. Error: ' . $e->getMessage()];
        } catch (\Exception $e) {
            Log::error('Failed to delete pet. Unknown error occurred.');
            return ['error' => 'Failed to delete pet. Unknown error occurred.'];
        }
    }
}
