<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use App\Models\AddComplaint;
use App\Models\ReplyComplaint;

class ComplaintApi extends Controller
{
    public function addComplaint(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'complaint' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = AddComplaint::create([
            'complaint' => $request->get('complaint')
        ]);

        return json_encode(['MSG' => 'Complaint Add Successfully..']);
    }
    
    public function replyComplaint(Request $request,$compt_id)
    {
        $validator = Validator::make($request->all(), [
            'reply' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        $user = ReplyComplaint::create([
            'compt_id' => $request->get('compt_id'),
            'reply' => $request->get('reply')
        ]);

        return json_encode(['MSG' => 'Reply Complaint Successfully..']);
    }
}
