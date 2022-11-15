<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Folder;
use App\Http\Requests\FileRequest;
use App\Http\Requests\DocumentRequest;
use App\Http\Requests\MediaRequest;
use App\Http\Requests\BrandbookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        $files = File::where('folder_id', '=', $folder_id)->get();
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
        //return view('resources.create');
    }

    public function createDocument() {
        return view('resources.document_create');
    }

    public function createMedia() {
        return view('resources.media_create');
    }

    public function createBrandbook() {
        return view('resources.brandbook_create');
    }

    public function storeDocument(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|min:4',
            'file' => 'required|mimes:doc,docx,xlsx,pptx,ppt,pdf',
        ]);
        if ($validator->fails()) {
            $errors = array();
            if (array_key_exists('name', $validator->errors()->toArray())) {
                $errors['nameError'] = $validator->errors()->toArray()['name'][0];
            }
            if (array_key_exists('file', $validator->errors()->toArray())) {
                $errors['fileError'] = $validator->errors()->toArray()['file'][0];
            }
            return response()->json($errors);
        }
        $validated = $validator->valid();
        $file = new File;
        $file->added_by = auth()->user()->id;
        $extension = $request->file->extension();
        //$extension = $request->file->getClientOriginalExtension();
        $file->folder_id = Folder::DOCUMENTS;
        $filename = $request->name.'.'.strtolower($extension);
        $file->filename = $filename;
        $file->extension = strtolower($extension);
        $path = $request->file->storeAs('uploads', $filename, 'public');
        $file->path = $path;
        $file->save();
        return response()->json($file);
        //return redirect()->route('resource.folder', Folder::DOCUMENTS)->with('status', 'Ficher uploader avec succes');
    }

    public function storeMedia(Request $request) {
        //$validated = $request->validated();
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|min:4',
            'file' => 'required|mimes:mp3,m4a,wav,mp4,mkv,jpg,png,gif',
        ]);
        if ($validator->fails()) {
            $errors = array();
            if (array_key_exists('name', $validator->errors()->toArray())) {
                $errors['nameError'] = $validator->errors()->toArray()['name'][0];
            }
            if (array_key_exists('file', $validator->errors()->toArray())) {
                $errors['fileError'] = $validator->errors()->toArray()['file'][0];
            }
            return response()->json($errors);
        }
        $validated = $validator->valid();
        $file = new File;
        $file->added_by = auth()->user()->id;
        $extension = $request->file->extension();
        //$extension = $request->file->getClientOriginalExtension();
        $file->folder_id = Folder::MEDIA;
        $filename = $request->name.'.'.strtolower($extension);
        $file->filename = $filename;
        $file->extension = strtolower($extension);
        $path = $request->file->storeAs('uploads', $filename, 'public');
        $file->path = $path;
        $file->save();
        return response()->json([
            'id' => $file->id,
            'filename' => $file->filename,
            'extension' => $file->extension,
            'download' => route('resource.download', $file->id),
        ]);
        //return redirect()->route('resource.folder', FOLDER::MEDIA)->with('status', 'Ficher uploader avec succes');
    }

    public function storeBrandbook(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255|min:4',
            'file' => 'required',
        ]);
        if ($validator->fails()) {
            $errors = array();
            if (array_key_exists('name', $validator->errors()->toArray())) {
                $errors['nameError'] = $validator->errors()->toArray()['name'][0];
            }
            if (array_key_exists('file', $validator->errors()->toArray())) {
                $errors['fileError'] = $validator->errors()->toArray()['file'][0];
            }
            return response()->json($errors);
        }
        $all = ['jpg', 'gif', 'png', 'mp3', 'm4a', 'wav', 'ogg', 'mp4', 'mkv',
            'doc', 'docx', 'xlsx', 'ppt', 'pptx', 'pdf'];
        $extension = strtolower($request->file->extension());
        if (in_array($extension, $all)) {
            return response()->json(['mime' => 'File type not taken into account']);
        }
        $file = new File;
        $file->added_by = auth()->user()->id;
        $extension = $request->file->extension();
        //$extension = $request->file->getClientOriginalExtension();
        $file->folder_id = Folder::BRANDBOOK;
        $filename = $request->name.'.'.strtolower($extension);
        $file->filename = $filename;
        $file->extension = strtolower($extension);
        $path = $request->file->storeAs('uploads', $filename, 'public');
        $file->path = $path;
        $file->save();
        return response()->json($file);
        //return redirect()->route('resource.folder', FOLDER::BRANDBOOK)->with('status', 'Ficher uploader avec succes');
    }

    public function download($id) {
        $file = File::where('id', '=', $id)->first();
        return Storage::download('public/uploads/'.$file->filename);
        //return response()->json(['url' => '/storage/public/uploads/'.$file->filename]);
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
        $extension = $file_req->extension();
        //$extension = $file_req->getClientOriginalExtension();
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
        $file->extension = $extension;
        $file->save();
        return redirect()->route('resource.index', 1)->with('status', 'Ficher uploader avec succes');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\File  $file
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file = File::where('id', '=', $id)->first();
        if ($file->extension == 'pdf') {
            return view('resources.show_doc', ['filename' => $file->filename]);
        }
        //return Storage::url('public/uploads/'.$file->filename);
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
    public function destroy($id)
    {
        $file = File::where('id', '=', $id)->first();
        Storage::delete('public/uploads/'.$file->filename);
        $file->delete();
        return redirect()->route('resource.index')->with('Fichier supprime avec success');
    }
}
