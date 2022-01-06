<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\CustomerService;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    private $userService;
    private $customerService;
    private $data;

    /**
     * UserController constructor.
     * @param UserService $userService
     * @param CustomerService $customerService
     */
    public function __construct(UserService $userService, CustomerService $customerService)
    {
        $this->userService = $userService;
        $this->customerService = $customerService;

        $this->data = [
            'icon' => 'flaticon-user',
            'title' => 'Usuários',
            'menu_open_users' => 'kt-menu__item--open'
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->data;
        $data['users'] = $this->userService->paginate();

        return response()->view('management.user.list', $data);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function new()
    {

        $data = $this->data;
        if (Auth::user()->type == "sat") {
            $data['customers'] = $this->customerService->all();
        }
        return view('management.user.new', $data);
    }

    /**
     * @param Int $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Int $id)
    {

        $data = $this->data;
        $data['user'] = $this->userService->show($id);
        $data['customers'] = $this->customerService->all();
        return view('management.user.new', $data);
    }

    /**
     * @param UserRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function save(UserRequest $request)
    {
        try {
            $this->userService->save($request);
            //saveLog(['value' => $request->name, 'type' => 'Salvou usuario', 'local' => 'UserController', 'funcao' => 'save']);
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * @param UserRequest $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function update(Int $id, UserRequest $request)
    {
        try {
            $this->userService->update($request, $request->id);
            saveLog(['value' => $request->name, 'type' => 'Editou usuario', 'local' => 'UserController', 'funcao' => 'update']);
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }

    /**
     * @param Int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Int $id)
    {
        $user = $this->userService->show($id);
        saveLog(['value' => $user->name, 'type' => 'Excluiu usuario', 'local' => 'UserController', 'funcao' => 'destroy']);
        $this->userService->destroy($id);
        return back()->with(['status' => 'Deleted successfully']);
    }

    /**
     * @param Request $request
     * @return array|\Illuminate\Http\JsonResponse
     */
    public function updatePermission(Int $id, Request $request)
    {
        try {
            $this->userService->updateUserAccess($request, $request->id);
            saveLog(['value' => $request->name, 'type' => 'Alterou permissoes', 'local' => 'UserController', 'funcao' => 'updatePermission']);
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => 'internal_error', 'errors' => $e->getMessage()], 400);
        }
    }
}
