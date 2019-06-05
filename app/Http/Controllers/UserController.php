<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\UserDetail;
use App\Tweets;
use App\TweetLike;
use App\Comments;
use App\User;
use App\Follower;
use Auth;
use DB;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    public function index($id){
    $user = new User();
    $profilefollowers = $users = $uset->get();
    $user = $user->find($id);
    $tweet = new Tweets;
    $tweets = $tweet->get();
    $tweetsCollection = array();
    foreach($tweets as $tweet){
    $newTweet = $tweet;
    $comments = Tweets::find($tweet->id)->comments;
    $newTweet['comments'] = $comments;
    $tweetsCollection[] = $newTweet;
}
    $tweets = $tweetsCollection;
    return view('profilepage',compacts('user','profilefollowers','tweets'));
}

   public function followUser(User $user)
   {
     $user = User::find($profileId);
     if(! $user) {

        return redirect()->back()->with('error', 'User does not exist.');
    }

   $user->followers()->attach(auth()->user()->id);
        return redirect()->back()->with('success', 'Successfully followed the user.');
   }

   public function unFollowUser(User $user)
   {
         $user = User::find($profileId);
         if(! $user) {

        return redirect()->back()->with('error', 'User does not exist.');
    }

    $user->followers()->detach(auth()->user()->id);
    return redirect()->back()->with('success', 'Successfully unfollowed the user.');
    }

public function show(User $user)
{
    $user = Auth::user();
    $user = new User();
    $user = User::find($userId);
    $user = $user->find($id);
    $value = Cache::get('key');
    $tweets = $tweet->where('user_id', $user->id)->get();
    $followers = $user->followers;
    $followings = $user->followings;
    return view('home', compact('user','follower','followings','value');
    }
    public function editProfileDisplay(){
        $currentUser = Auth:: User();
        $currentUserId = $currentUser->id;
        $user = new User();
        $user = $user->find($currentUserId);
        return view('editUserProfile',compact('user'));
    }
    public function getUsers(){
        $users = User::all();
        $users = User::paginate(15);
        return view('index', compact('users'));
        }

    public function profile(){
            $user = Auth::user();
            $userDetail = new UserDetail();
            $userDetail = $userDetail->find($user->id);
            return view('profile',compact('user','userDetail'));
    }

    public function update_avatar(Request $request){

     $request->validate([
         'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
     ]);

     $user = Auth::user();
     $avatarName = $user->id.'_avatar'.time().'.'.request()->avatar->getClientOriginalExtension();
     $request->avatar->storeAs('avatars', $avatarName);
     $user->avatar = $avatarName;
     $user->save();
     return back()
         ->with('success','You have successfully upload image.');

     }
    // this works//////
    public function editProfileDisplay(Request $request){
       $currentUser = Auth:: User();
       $currentUserId = $currentUser->id;
       $user = new UserDetail();
       $user = $user->find($currentUserId);
       return view('edit-profile',compact('user', 'currentUser','currentUserId'));
     }
    // this works////
    public function editProfile(Request $request){
      $currentUser = Auth::user();
      $userDetail = new UserDetail;
      $currentUserId = $currentUser->id;
      $userDetail = $userDetail->find($currentUserId);
      $userDetail->first_name = $request->first_name;
      $userDetail->last_name = $request->last_name;
      $userDetail->username = $request->email;
      $userDetail->gender = $request->gender;
      $userDetail->phone = $request->phone;
      $userDetail->dob = $request->dob;
      $userDetail->country = $request->country;
      $userDetail -> save();
      // return redirect('profile');
      return back()
          ->with('success','You have successfully updated your details.');
     }
    public function getAllUsers(){
        $users = User::get();
        return new UserResource($users);
    }
    public function upload(ImageRequest $request){

        $request->user()->avatar = $request->image;
        $request->user()->save();
        return response( content: null, status: 200);
    }
}
