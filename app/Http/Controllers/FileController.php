<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use App\Http\Requests\FileRequest;
use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $folders = Folder::get();
        return view('resources.index', ['folders' => $folders]);
    }

    public function folderContent($folder_id) {
        $folders = Folder::get();
        $files = File::where('folder_id', $folder_id)
                    ->where('owner_id', 1)->get();
        if($folder_id == Folder::DOCUMENTS) {
            return view('resources.document', ['files' => $files]);
        }
        else if($folder_id == Folder::MEDIA) {
            return view('resources.media', ['files' => $files]);
        }
        else {
            return view('resources.brandbook', ['files' => $files]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('resources.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(FileRequest $request)
    {
        $file = new File;
        $file->owner_id = 1;
        $file_req = $request->file;
        $extension = $file_req->getClientOriginalExtension();
        $folder_type = 0;
        if ($extension == 'jpg' || $extension == 'png' || $extension == 'gif') {
            $folder_type = 2;
        }
        else {
            $folder_type = 1;
        }
        $filename = $request->name.'.'.$extension;
        $file_req->storeAs('uploads', $filename, 'public');
        $file->folder_id = $folder_type;
        $file->filename = $request->name;
        $file->save();
        return redirect()->route('resource.index', 1)->with('status', 'Ficher uploader avec succes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show(File $file)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        //
    }
}
