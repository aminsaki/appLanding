<?php

namespace App\Http\Controllers;

use App\Models\SymphonyResult;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserResultController extends Controller
{

   public function store(Request $request)
    {
        $uid = Str::uuid()->toString();

         SymphonyResult::create([
            'uid' => $uid,
            'cello_score' => $request->cello_score,
            'harp_score' => $request->harp_score,
            'piano_score' => $request->piano_score,
            'result' => $request->result
        ]);

        return response()->json([
            'message' => 'نتایج با موفقیت ذخیره شد',
            'uid' => $uid
        ], 201);
    }

    public function show($uid)
{
    $musicResult = SymphonyResult::where('uid', $uid)->first();

    if (!$musicResult) {
        return response()->json(['message' => 'نتیجه یافت نشد'], 404);
    }

    return response()->json($musicResult);
}
}
