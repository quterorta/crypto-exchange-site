<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\ResponseFactory;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $title = 'User';

    private $titleMany = 'Users';

    private $responseFactory;

    public function __construct(
        ResponseFactory $responseFactory
    ) {
        $this->responseFactory = $responseFactory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $title = $this->title;
        $titleMany = $this->titleMany;
        $users = User::paginate(20);

        return $this->responseFactory->view(
            'pages.admin.user.index',
            compact('title', 'titleMany', 'users')
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title = $this->title;
        $titleMany = $this->titleMany;

        return $this->responseFactory->view(
            'pages.admin.user.create',
            compact('title', 'titleMany')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        $user->phone = $request->phone;
        $user->wallet = $request->wallet;
        $user->telegram = $request->telegram;
        $user->save();

        $user->assignRole('user');

        return redirect()->route('user.index')->withSuccess('User successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        return redirect()->route('user.edit', $user->id)->withSuccess('Edit user');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @return Response
     */
    public function edit(User $user)
    {
        $title = $this->title;
        $titleMany = $this->titleMany;

        return $this->responseFactory->view(
            'pages.admin.user.edit',
            compact('title', 'titleMany', 'user')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->wallet = $request->wallet;
        $user->telegram = $request->telegram;
        if ($request->password && $request->password != '') {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('user.index')->withSuccess('User has been changed!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back()->withSuccess('User has been deleted!');
    }
}
