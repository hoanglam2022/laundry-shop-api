<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Service\ServiceCreateRequest;
use App\Http\Requests\Service\ServiceUpdateRequest;
use App\Http\Resources\BaseResource;
use App\Repositories\ServiceRepository;
use Illuminate\Http\JsonResponse;

class ServiceController extends BaseController
{
    /**
     * Define
     */
    private ServiceRepository $repository;

    /**
     * Init
     */
    public function __construct()
    {
        $this->repository = new ServiceRepository();
    }

    /**
     * Index
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return (new BaseResource(CODE_SUCCESS,
            $this->repository->paginate(request()->all())
        ))->response();
    }

    /**
     * Find one
     * @param $id
     * @return JsonResponse
     */
    public function find($id): JsonResponse
    {
        return (new BaseResource(CODE_SUCCESS,
            $this->repository->find($id)
        ))->response();
    }

    /**
     * Create
     * @param ServiceCreateRequest $request
     * @return JsonResponse
     */
    public function create(ServiceCreateRequest $request): JsonResponse
    {
        return (new BaseResource(CODE_SUCCESS,
            $this->repository->create($request->all())
        ))->response();
    }

    /**
     * Update
     * @param $id
     * @param ServiceUpdateRequest $request
     * @return JsonResponse
     */
    public function update($id, ServiceUpdateRequest $request): JsonResponse
    {
        return (new BaseResource(CODE_SUCCESS,
            $this->repository->update($id, $request->all())
        ))->response();
    }

    /**
     * Delete
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        return (new BaseResource(CODE_SUCCESS,
            $this->repository->delete($id)
        ))->response();
    }
}
