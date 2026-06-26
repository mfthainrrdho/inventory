<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Services\ItemService;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;

class ItemController extends BaseController
{
    protected ItemService $svc;

    public function __construct(ItemService $svc)
    {
        $this->svc = $svc;
    }

    /**
     * Get all items with optional category filter
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        // HAPUS: dd('Method index dipanggil!', $request->all());
        
        try {
            $items = $this->svc->all();

            if ($request->filled('category_id')) {
                $items = $items->where('category_id', (int) $request->category_id);
            }
            
            // HAPUS: dd($items);
            
            return $this->success($items->values(), 'Berhasil mengambil semua data Item');
        } catch (\Exception $e) {

            return $this->error('Terjadi kesalahan: ' . $e->getMessage(), 500);
        }
    }

    public function store(StoreItemRequest $req)
    {
        // HAPUS: dd('Method store dipanggil!', $req->all(), $req->validated());
        
        try {
            $item = $this->svc->create($req->validated());
            return $this->success($item, 'Item berhasil dibuat', 201);
        } catch (\Exception $e) {
            return $this->error('Gagal membuat item: ' . $e->getMessage(), 500);
        }
    }

    public function show($id)
    {
        try {
            $item = $this->svc->find($id);
            return $this->success($item, 'Berhasil mengambil data Item');
        } catch (\Exception $e) {
            return $this->error('Item tidak ditemukan', 404);
        }
    }

    public function update(UpdateItemRequest $req, $id)
    {
        try {
            $item = $this->svc->update($id, $req->validated());
            return $this->success($item, 'Item berhasil diperbarui');
        } catch (\Exception $e) {
            return $this->error('Item tidak ditemukan', 404);
        }
    }

    public function destroy($id)
    {
        try {
            $this->svc->delete($id);
            return $this->success(null, 'Item berhasil dihapus', 204);
        } catch (\Exception $e) {
            return $this->error('Item tidak ditemukan', 404);
        }
    }
}