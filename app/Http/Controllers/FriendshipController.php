<?php

namespace App\Http\Controllers;

use App\Friendship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FriendshipController extends Controller
{
    public function sendRequest(Request $request){
        $friend_id = $request->friend_id;
        if(Friendship::where(['user_id' => $request->user()->id, 'friend_id' => $friend_id, 'status' => 'pending'])->exists() ||
            Friendship::where(['user_id' => $request->user()->id, 'friend_id' => $friend_id, 'status' => 'accepted'])->exists()){
            return response()->json(['message' => "requested already"]);
        }
        else{
            $rejected_request = Friendship::where([
                'user_id' => $request->user()->id,
                'friend_id' => $friend_id,
                'status' => 'rejected'])->first();
            if($rejected_request){
                $rejected_request->status = "pending";
                $rejected_request->save();
                return response()->json(['message' => "request sent (it was rejected previously)"]);
            }
        }
        $request->user()->friends()->attach($friend_id, ['status' => 'pending']);
        return response()->json(['message' => "request sent"]);
    }

    public function acceptRequest(Request $request){//この$user_idは現在のユーザーに対してリクエストを送ってきた相手のuserid(自分のではない)
        $user_id = $request->user_id;
        $friendship_request = Friendship::where([
            'user_id' => $user_id,
            'friend_id' => $request->user()->id,
            'status' => 'pending'])->first();
        if($friendship_request){
            $friendship_request->status = 'accepted';
            $friendship_request->save();

            $friendship_request_another_side = Friendship::where([
                'user_id' => $request->user()->id,
                'friend_id' => $user_id])->first();
            if($friendship_request_another_side){
                $friendship_request_another_side->status = 'accepted';
                $friendship_request_another_side->save();
            }else{
                Friendship::create([
                    'user_id' => $request->user()->id,
                    'friend_id' => $user_id,
                    'status' => 'accepted'
                ]);
            }

            return response()->json(['message' => 'Request accepted']);
        }else{
            return response()->json(['message' => 'request not found'], 400);
        }
    }

    public function rejectRequest(Request $request){//この$user_idは現在のユーザーに対してリクエストを送ってきた相手のuserid(自分のではない)
        $user_id = $request->user_id;
        $friendship_request = Friendship::where([
            'user_id' => $user_id,
            'friend_id' => $request->user()->id ,
            'status' => 'pending'])->first();
        if($friendship_request){
            $friendship_request->status = 'rejected';
            $friendship_request->save();
            return response()->json(['message' => 'Request rejected']);
        }
        else{
            return response()->json(['message' => 'request not found'], 400);
        }
    }


    public function unfriend(Request $request){
        $friendship_request = Friendship::where([
            'user_id' => $request->user()->id,
            'friend_id' => $request->friend_id,
            'status' => 'accepted'])->first();
        if(!$friendship_request){
            return response()->json(['message' => 'request not found'], 400);
        }
        $friendship_request->status = 'rejected';
        $friendship_request->save();
        $friendship_request_another_side = Friendship::where([
            'user_id' => $request->friend_id,
            'friend_id' => $request->user()->id,
            'status' => 'accepted'])->first();
        if($friendship_request_another_side){
            $friendship_request_another_side->status = 'rejected';
            $friendship_request_another_side->save();
            return response()->json(['message' => 'unfriended successfully']);
        }
    }
    public function getFriends(Request $request){
        return $request->user()->friends;
    }

    public function getFriendRequestSenders(Request $request){
        $friendship_request_senders = Friendship::where([
            'friend_id' => $request->user()->id,
        ])->whereIn('status', ["pending"])->with('user')->get();

        return $friendship_request_senders->pluck('user');
    }

    public function getStatus(Request $request){
        $friend_id = $request->friend_id;
        $friendship_request_another_side = Friendship::where([
            'user_id' => $friend_id,
            'friend_id' => $request->user()->id,
        ])->whereIn('status', ["pending"])->first();
        if($friendship_request_another_side){
            return response()->json(["status" => "accept?"]);
        }

        $friendship_request = Friendship::where([
            'user_id' => $request->user()->id,
            'friend_id' => $friend_id,
        ])->whereIn('status', ["pending", "accepted", "rejected"])->first();
        if($friendship_request){
            return response()->json(["status" => $friendship_request->status]);
        }else{
            return response()->json(["status" => '']);
        }
    }
}
