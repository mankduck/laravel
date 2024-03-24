<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Interfaces\UserServiceInterface as UserService;
use App\Repositories\Interfaces\ProvinceRepositoryInterface as ProvinceRepository;
use App\Repositories\Interfaces\UserRepositoryInterface as UserRepository;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserController extends Controller
{
    protected $userService;
    protected $provinceRepository;
    protected $userRepository;

    public function __construct(
        UserService $userService,
        ProvinceRepository $provinceRepository,
        UserRepository $userRepository,
    ) {
        $this->userService = $userService;
        $this->provinceRepository = $provinceRepository;
        $this->userRepository = $userRepository;
    }
    public function index(Request $request)
    {
        $config = [
            'js' => [
                'backend/js/plugins/switchery/switchery.js',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/library/library.js'
            ],
            'css' => [
                'backend/css/plugins/switchery/switchery.css',
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => 'User'
        ];

        $users = $this->userService->paginate($request);
        $config['seo'] = config('apps.user');

        return view('backend.user.user.index', compact('config', 'users'));
    }

    public function create()
    {
        // $this->authorize('modules', 'user.create');
        $provinces = $this->provinceRepository->all();
        $config = $this->config();
        $config['seo'] = config('apps.user');
        $config['method'] = 'create';
        return view(
            'backend.user.user.create',
            compact(
                'config',
                'provinces',
            )
        );
    }

    public function store(StoreUserRequest $request)
    {
        if ($this->userService->create($request)) {
            return redirect()->route('user.index')->with('success', 'Thêm mới bản ghi thành công');
        }
        return redirect()->route('user.index')->with('error', 'Thêm mới bản ghi không thành công. Hãy thử lại');
    }

    public function edit($id)
    {
        // $this->authorize('modules', 'user.update');
        $user = $this->userRepository->findById($id);
        $provinces = $this->provinceRepository->all();
        $config = $this->config();
        $config['seo'] = config('apps.user');
        $config['method'] = 'edit';
        return view(
            'backend.user.user.create',
            compact(
                'config',
                'provinces',
                'user',
            )
        );
    }

    public function update($id, UpdateUserRequest $request)
    {
        if ($this->userService->update($id, $request)) {
            return redirect()->route('user.index')->with('success', 'Cập nhật bản ghi thành công');
        }
        return redirect()->route('user.index')->with('error', 'Cập nhật bản ghi không thành công. Hãy thử lại');
    }

    public function delete($id)
    {
        // $this->authorize('modules', 'user.destroy');
        $config['seo'] = config('apps.user');
        $user = $this->userRepository->findById($id);
        return view(
            'backend.user.user.delete',
            compact(
                'user',
                'config',
            )
        );
    }

    public function destroy($id)
    {
        if ($this->userService->destroy($id)) {
            return redirect()->route('user.index')->with('success', 'Xóa bản ghi thành công');
        }
        return redirect()->route('user.index')->with('error', 'Xóa bản ghi không thành công. Hãy thử lại');
    }



    private function config()
    {
        return [

            'js' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js',
                'backend/library/location.js',
                // 'backend/plugins/ckfinder_2/ckfinder.js',
                // 'backend/library/finder.js',
            ],
            'css' => [
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
        ];
    }
}
