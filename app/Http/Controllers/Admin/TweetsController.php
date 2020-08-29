<?php

namespace App\Http\Controllers\Admin;

use App\Events\TweetHidden;
use App\Events\TweetShowed;
use App\HiddenTweets;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class TweetsController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            HiddenTweets::create([
                'tweet_id' => $request->input('tweet_id'),
                'user_id' => Auth::id(),
            ]);

            TweetHidden::dispatch($request->input('tweet_id'));
        } catch (Exception $e) {
            report($e);

            return response()->json([
                'created' => false,
            ]);
        }

        return response()->json([
            'created' => true,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return Response
     */
    public function destroy(int $id)
    {
        try {
            $tweet = HiddenTweets::where('tweet_id', $id)
                ->where('user_id', Auth::id())->delete();

            TweetShowed::dispatch($id);
        } catch (Exception $e) {
            report($e);

            return response()->json([
                'deleted' => false,
            ]);
        }

        return response()->json([
            'deleted' => true,
        ]);
    }
}
