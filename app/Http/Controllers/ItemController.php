<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Services\ItemService;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    protected ItemService $svc;

    public function __construct(ItemService $svc)
    {
        $this->svc = $svc;
    }

    public function index()
    {
        return response()->json([
            'status' => 'success',
            'data' => $this->svc->all(),
            'message' => 'Berhasil menarik semua data Item'
        ]);
    }

    public function store(StoreItemRequest $req)
    {
        $item = $this->svc->create($req->validated());
        return response()->json([
            'status' => 'success',
            'data' => $item,
            'message' => 'Item berhasil dibuat'
        ], 201);
    }

    public function show($id)
    {
        try {
            $item = $this->svc->find($id);
            return response()->json([
                'status' => 'success',
                'data' => $item,
                'message' => 'Berhasil mengambil data Item'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => 'Item tidak ditemukan'
            ], 404);
        }
    }

    public function update(UpdateItemRequest $req, $id)
    {
        try {
            $item = $this->svc->update($id, $req->validated());
            return response()->json([
                'status' => 'success',
                'data' => $item,
                'message' => 'Item berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => 'Item tidak ditemukan'
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->svc->delete($id);
            return response()->json([
                'status' => 'success',
                'data' => null,
                'message' => 'Item berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'data' => null,
                'message' => 'Item tidak ditemukan'
            ], 404);
        }
    }
}