<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\{StoreRequest};
use App\Models\{File, User};
use Mail;
use App\Mail\FileDownloadLink;
use Illuminate\Support\Str;
use Carbon\Carbon;

class FileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    public function create()
    {
        $users = User::where('role','user')->get();
        return view('files.create',compact('users'));
    }
    public function store(StoreRequest $request)
    {
        $data = $request->all();
        if ($request->hasFile('file')) {
            $fileName = time() . '_' . $request->file('file')->getClientOriginalName();
            $request->file('file')->move(public_path('files'), $fileName);
            $data['file'] = '/files/' . $fileName;
        }
        $data['download_link'] = Str::random(40);
        $data['expires_at'] = Carbon::now()->addSeconds(120);
        $file = File::create($data);
        
        $user = User::find($request->assigned_to);
        Mail::to($user->email)->send(new FileDownloadLink($data['download_link']));

        return redirect()->route('admin.index')->with('success', 'File created successfully. Download link sent to your email.');
    }

    public function download($link)
    {
        \Log::info($link);
        $file = File::where('download_link', $link)->first();

        if ($file && Carbon::now()->lt($file->expires_at)) {
            return response()->download(public_path($file->file));
        }

        abort(404, 'File not found or link has expired.');
    }
}
