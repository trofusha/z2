<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Validation\Rule;
use OpenApi\Attributes as OAT;

class UserController extends Controller
{

    #[OAT\Get(
                path: '/api/admin/users',
                summary: 'Display a listing of all users',
                tags: ['admin', 'users'],
                parameters: [
            new OAT\Parameter(ref: '#/components/parameters/page'),
            new OAT\Parameter(ref: '#/components/parameters/per_page'),
            new OAT\Parameter(
                    name: 'sort',
                    description: 'Sort field',
                    in: 'query',
                    required: false,
                    schema: new OAT\Schema(nullable: true, type: 'string', enum: UserService::ALLOWED_FIELDS),
            ),
            new OAT\Parameter(ref: '#/components/parameters/query'),
                ],
                responses: [
            new OAT\Response(
                    response: JsonResponse::HTTP_OK,
                    description: 'Listing of all users',
                    content: new OAT\JsonContent(ref: '#/components/schemas/UserCollection'),
            ),
            new OAT\Response(response: JsonResponse::HTTP_UNPROCESSABLE_ENTITY, ref: '#/components/responses/ValidationErrorsResponse'),
                ],
        )]
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, UserService $userService): UserCollection
    {

        $validated = validator($request->all(), [
            'sort' => [Rule::in(UserService::ALLOWED_FIELDS)],
            'page' => ['integer', 'min:1'],
            'per_page' => ['integer', 'min:1'],
            'query' => ['string', 'min:1'],
                ])->validated();

        return new UserCollection($userService->index($validated)
                        ->paginate(page: $validated['page'] ?? null, perPage: $validated['per_page'] ?? null));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
        return (new UserResource($user))->response()->setStatusCode(JsonResponse::HTTP_OK);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
