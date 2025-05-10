<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserRequest;
use App\Http\Resources\Api\NotificationResource;
use App\Http\Resources\Api\UserResource;
use App\Models\Address;
use App\Models\Post;
use App\Models\User;
use App\Notifications\GeneralNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::query()->select(['id', 'name', 'email'])->get();
        $data['users'] = UserResource::collection($users);
        return $this->api_response(true, 'Fetched successfully', $data);
    }

    public function show($id)
    {
        $user = User::query()->find($id);


        if (!isset($user)) {
            return $this->api_response(false, 'User Not Found', [], 404);
        }
        $data['user'] = new UserResource($user);
        return $this->api_response(true, 'Fetched successfully', $data);
    }

    public function store(UserRequest $request)
    {
        $data = $request->all();
        $data['password'] = Hash::make($data['password']);
        $user = User::query()->create($data);
        return $this->api_response(true, 'Created successfully', ['user' => $user], 200);

    }

    public function update($id, UserRequest $request)
    {
        $user = User::query()->find($id);
        if (!isset($user)) {
            return $this->api_response(false, 'User Not Found', [], 404);
        }

        if (isset($user)) {
            $data = $request->all();
            $data['password'] = Hash::make($data['password']);
            $user->update($data);
            $res['user'] = $user;
            return $this->api_response(true, 'update done ', $res);
        } else {
            return $this->api_response(false, 'error', [], 400);
        }

    }

    public function delete($id)
    {
        $user = User::query()->find($id);
        if (!isset($user)) {
            return $this->api_response(false, 'User Not Found', [], 404);
        }
        $user->delete();
        return $this->api_response(true, 'Deleted successfully');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8'
        ]);
        if ($validator->fails()) {
            $res = [
                'errors' => $validator->errors(),
            ];
            return $this->api_response(false, 'Validation Error', $res, 422);
        }


        $user = User::query()->where('email', $request->email)->first();

        $check = Hash::check($request->password, $user->password);


        if ($check) {

            $res['token'] = $user->createToken('api')->plainTextToken;
            $res['user'] = $user;
            return $this->api_response(true, 'Login Successful', $res);
            // login success
        } else {
            return $this->api_response(false, 'Wrong password', [], 400);
        }
    }

    public function logout()
    {
        $user = auth('api')->user();
        $user->currentAccessToken()->delete();

        return $this->api_response(true, 'Logout Successfully');

    }

    public function myData()
    {
        $user = auth('api')->user();
        $user->load('posts');
//        $user->load('address');
//dd($user->address);
        return $this->api_response(true, 'Fetched successfully', [
            'user' => $user,
        ]);
    }

    public function findPost($id)
    {
        $post = Post::query()->with(['user'])->find($id);
        if (!isset($post)) {
            return $this->api_response(false, "Post Not Found", [], 404);
        }
        $user = $post->user;
        dd($user);

    }

    public function findAddress($id)
    {
        $address = Address::query()->with(['user'])->find($id);
        if (!isset($address)) {
            return $this->api_response(false, "Address Not Found", [], 404);
        }
        $user = $address->user;
        dd($user);

    }

    public function loadUserComments()
    {
        $user = auth('api')->user();
        dd($user->comments);
//        $address = Address::query()->with(['user'])->find($id);
//        if (!isset($address)){
//            return $this->api_response(false , "Address Not Found", [], 404);
//        }
//        $user = $address->user;
//        dd($user);

    }


    public function fetchUsersWithMaterials()
    {

        // function to fetch uses with or without relation whereHas() , with() , whereDoesntHave()

        $users = User::query()
            ->whereDoesntHave('materials')
//            ->whereHas('materials')
            //            ->whereHas('materials' , function ($query) {
//                $query->where('id', 1);
//            })
//                ->where('id',0)
            ->get();
        //            ->map(function ($user) {
//                return [
//                    'id' => $user['id'],
//                    'text' => $user['name'] . ' | ' . $user['email']
//                ];
//            })->all();

//

        $res['users'] = (UserResource::collection($users));
        return $this->api_response(true, 'Fetched successfully', $res);

//        $materials = Material::query()->withCount(['users'])->get();
//        return $materials;
    }

    public function sendNotifications(Request $request)
    {

        $users = User::query()->get();

        $newGeneralNotification = new GeneralNotification($request->get('title'), $request->get('content'), ['database']);


        Notification::send($users, $newGeneralNotification);

        return $this->api_response(true, 'Notification Sent Successfully');
    }

    public function getUserNotification($id)
    {
        $user = User::query()->find($id);

        if (!isset($user)) {
            return $this->api_response(false, 'User Not Found', [], 404);
        }
        $ns = $user->notifications()->paginate(5);
        return $this->api_response(true, 'Fetched successfully', [
            'notifications' => NotificationResource::collection($ns),
            'pagination' => $ns->links()
        ]);
    }

    public function markNotificationAsRead($id , $nid)
    {
        $user = User::query()->find($id);

        if (!isset($user)) {
            return $this->api_response(false, 'User Not Found', [], 404);
        }

        $notification = $user->notifications()->where('id', $nid)->first();
        $notification->markAsRead();
        return $this->api_response(true, 'Notification marked as read');
    }
}
