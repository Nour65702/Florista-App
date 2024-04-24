<?php

namespace App\Http\Controllers\Admin\Modify;

use App\Http\Controllers\Controller;
use App\Models\Provider_licence;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ModifyController extends Controller
{
    public function getRequests()
    {

        $request = Provider_licence::all();

        return returnData('Requests', $request);
    }



    public function modify(Request $request, $id)
    {
        try {
            $decision = $request->input("decision");

            DB::beginTransaction();

            $req = Provider_licence::findOrFail($id);
            $name = $req->name;
            $email = $req->email;
            $phone = $req->phone;

            if ($decision == "Accepted") {
                Provider::create([
                    'name' => $name,
                    'email' => $email,
                    'phone' => $phone,
                    'password' => $phone
                ]);


                $req->status = 'Accepted';
                $req->save();
                $message = "You have accepted the provider";
            } else {

                $req->status = 'Rejected';
                $req->save();
                $message = "You have rejected the provider";
            }

            DB::commit();

            return response()->json(['message' => $message]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
