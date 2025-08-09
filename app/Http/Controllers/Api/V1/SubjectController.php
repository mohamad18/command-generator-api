<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubjectStoreRequest;
use App\Domain\Subject\Services\SubjectService;
use App\Http\Resources\ResponseResource;
use Illuminate\Database\QueryException;

class SubjectController extends Controller
{
    public function __construct(private SubjectService $service) {}

    public function index()
    {
        $result = json_decode($this->service->getAll());

        // validate the result
        if (is_null($result) || !is_array($result)) {
            return new ResponseResource(404, false, 'No Subject found', []);
        }

        // check if the result is empty
        if (empty($result)) {
            return new ResponseResource(404, false, 'No Subject found', []);
        }

        return new ResponseResource(200, true, 'Subject retrieved successfully', $result);
    }

    public function store(SubjectStoreRequest $request)
    {
        try {
            $created = $this->service->create($request->validated());

            // check if the creation was successful
            if (!$created) {
                return new ResponseResource(404, false, 'Subject creation failed', []);
            }

            return new ResponseResource(201, true, 'Subject created successfully', $created);
        } catch (QueryException $e) {
            return new ResponseResource(500, false, 'Database error: ' . $e->getMessage(), []);
        } catch (\Throwable $e) {
            return new ResponseResource(500, false, 'Unexpected error: ' . $e->getMessage(), []);
        }
    }

    public function show($id)
    {
        try {
            // validation id
            if (!ctype_digit((string) $id) || (int) $id <= 0) {
                return new ResponseResource(
                    422,
                    false,
                    'Invalid Subject ID',
                    []
                );
            }

            // get data from service
            $result = $this->service->getById((int) $id);

            // check if data found
            if (!$result) {
                return new ResponseResource(
                    404,
                    false,
                    'Subject not found',
                    []
                );
            }

            // Return data
            return new ResponseResource(
                200,
                true,
                'Subject retrieved successfully',
                $result
            );
        } catch (QueryException $e) {
            return new ResponseResource(
                500,
                false,
                'Database error: ' . $e->getMessage(),
                []
            );
        } catch (\Throwable $e) {
            return new ResponseResource(
                500,
                false,
                'Unexpected error: ' . $e->getMessage(),
                []
            );
        }
    }

    public function update(SubjectStoreRequest $request, $id)
    {
        try {
            // validation id
            if (!ctype_digit((string) $id) || (int) $id <= 0) {
                return new ResponseResource(
                    422,
                    false,
                    'Invalid Subject ID',
                    []
                );
            }

            $result = $this->service->update($id, $request->validated());

            // check if the update was successful
            if (!$result) {
                return new ResponseResource(404, false, 'Subject update failed', []);
            }

            return new ResponseResource(200, true, 'Subject updated successfully', $result);
        } catch (QueryException $e) {
            return new ResponseResource(500, false, 'Database error: ' . $e->getMessage(), []);
        } catch (\Throwable $e) {
            return new ResponseResource(500, false, 'Unexpected error: ' . $e->getMessage(), []);
        }
    }

    public function destroy($id)
    {
        try {
            // validation id
            if (!ctype_digit((string) $id) || (int) $id <= 0) {
                return new ResponseResource(
                    422,
                    false,
                    'Invalid Subject ID',
                    []
                );
            }

            // get data from service
            $result = $this->service->delete((int) $id);

            // check if data found
            if (!$result) {
                return new ResponseResource(
                    404,
                    false,
                    'Subject not found',
                    []
                );
            }

            // Return data
            return new ResponseResource(
                200,
                true,
                'Subject deleted successfully',
                $result
            );
        } catch (QueryException $e) {
            return new ResponseResource(
                500,
                false,
                'Database error: ' . $e->getMessage(),
                []
            );
        } catch (\Throwable $e) {
            return new ResponseResource(
                500,
                false,
                'Unexpected error: ' . $e->getMessage(),
                []
            );
        }
    }
}
