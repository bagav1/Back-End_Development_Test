<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NoticeController extends Controller
{
    public function getAll()
    {
        try {
            return response()->json([
                'status' => true,
                'data' => Notice::get()
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'status' => false,
                'error' => $ex->getMessage()
            ], 400);
        }
    }

    public function getId(Int $id)
    {
        try {
            $notice = Notice::with('state')->where('id', $id)->get();
            if (!$notice) {
                return response()->json([
                    'status' => false,
                    'data' => [
                        'error' => 'Id de noticia no encontrado. Id: ' . $id
                    ]
                ], 400);
            }
            return response()->json([
                'status' => true,
                'data' => $notice
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'status' => false,
                'error' => $ex->getMessage()
            ], 400);
        }
    }

    public function create(Request $request)
    {
        try {
            $request->validate([
                'title' => 'required|string',
                'medium' => 'required|string',
                'file' => 'required|mimes:png,jpg,jpeg|max:2048'
            ]);

            $nameFile = uniqid('notice_');
            $extFile = $request->file('file')->extension();
            $ruteFile = 'public/img/notices';

            $notice = Notice::create([
                'title' => $request->title,
                'medium' => $request->medium,
                'date' => Carbon::now('-05:00'),
                'file' => asset(Storage::url($request->file('file')->storeAs($ruteFile, $nameFile . '.' . $extFile)))
            ]);

            return response()->json([
                'status' => true,
                'data' => [
                    'message' => 'Noticia creada correctamente.',
                    'user' => $notice
                ]
            ], 201);
        } catch (Exception $ex) {
            return response()->json([
                'status' => false,
                'error' => $ex->getMessage()
            ], 400);
        }
    }

    public function update(Int $id, Request $request)
    {
        try {
            $notice = Notice::where('id', $id)->first();
            if (!$notice) {
                return response()->json([
                    'status' => false,
                    'data' => [
                        'error' => 'Id de noticia no existente. Id: ' . $id
                    ]
                ], 400);
            }

            $request->validate([
                'title' => 'string',
                'medium' => 'string',
                'file' => 'mimes:png,jpg,jpeg|max:2048'
            ]);

            if ($request->file()) {
                $currentFile = end(explode("/", $notice->file));
                Storage::delete($currentFile);

                $nameFile = uniqid('notice_');
                $extFile = $request->file('file')->extension();
                $ruteFile = 'public/img/notices';

                $request->file = asset(Storage::url($request->file('file')->storeAs($ruteFile, $nameFile . '.' . $extFile)));
            }

            $notice->update($request->all());

            return response()->json([
                'status' => true,
                'data' => [
                    'message' => 'Noticia actualizada correctamente. Id' . $id,
                    'update' => $request->all()
                ]
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'status' => false,
                'error' => $ex->getMessage()
            ], 400);
        }
    }

    public function delete(Int $id)
    {
        try {
            $notice = Notice::where('id', $id)->first();
            if (!$notice) {
                return response()->json([
                    'status' => false,
                    'data' => [
                        'error' => 'Id de noticia no encontrado. Id' . $id
                    ]
                ], 400);
            }
            $notice->delete();
            return response()->json([
                'status' => true,
                'data' => [
                    'message' => 'Noticia eliminada correctamente. Id' . $id
                ]
            ], 200);
        } catch (Exception $ex) {
            return response()->json([
                'status' => false,
                'error' => $ex->getMessage()
            ], 400);
        }
    }
}
