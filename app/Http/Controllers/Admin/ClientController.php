<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clients = Client::with('user')->paginate();

        return view("Admin.Client.index", compact("clients"));
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $client = Client::with('user')->find($id);
        if(!$client)
        {
            return redirect()->back()->with("error" , "Client not found. It may have been deleted or does not exist.");
        }

        // dd($client);
        return view("Admin.Client.show", compact("client"));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $client = Client::with('user')->find($id);
        if(!$client)
        {
            return redirect()->back()->with("error" , "Client not found. It may have been deleted or does not exist.");
        }

        DB::beginTransaction();
        try
        {
            $client->user->delete();
            $client->delete();

            DB::commit();
            return redirect()->route("admin.client")->with("success" , "Client deleted successfully");
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return redirect()->back()->with("error" , "Client deleted failed. Please try again.");
        }
    }
}
