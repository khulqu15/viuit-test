<?php

namespace App\Http\Controllers\User;

use App\Actions\User\CreateUser;
use App\Actions\User\EditUser;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
        $users = User::query()
        ->when($request->get('name'), function($query) use($request) {
            $query->where('name', 'LIKE', '%'.$request->get('name').'%');
        })
        ->when($request->get('role'), function($query) use($request) {
            $query->where('role', $request->get('role'));
        })
        ->orderBy('id', $request->get('sort', 'desc'))
        ->paginate(5);

        foreach ($users as $key => $value) {
            $users[$key]['hash'] = $value->hash;
        }
        return Inertia::render('User/Index', ['users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create(): Response
    {
        return Inertia::render('User/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param CreateUser $action
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function store(Request $request, CreateUser $action): RedirectResponse
    {
        $action->store($request->all());
        return redirect()->route('users')->with('success', 'User added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user): Response
    {
        $user->hash = $user->hash;
        return Inertia::render('User/Edit', ['user_data' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @param EditUser $action
     * @return RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, User $user, EditUser $action): RedirectResponse
    {
        $action->update($request->all(), $user);
        return redirect()->route('users')->with('success', 'User has updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return RedirectResponse
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->forceDelete();
        return redirect()->route('users')->with('success', 'User deleted');
    }
}
