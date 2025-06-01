<?php

namespace App\Http\Controllers\Backoffice\Operational;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContentRequest;
use App\Models\Content;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class ContentController extends Controller
{
    public function index()
    {
        return view('layouts.index', [
            'title' => 'Konten Website',
            'content' => view('backoffice.content.index')
        ]);
    }

    public function initTable(Request $request)
    {
        if ($request->ajax()) {
            $data = Content::query();

            if ($request->filled('type')) {
                $data->where('type', $request->type);
            }

            $data = $data->orderBy('order', 'asc')->get();

            $data->transform(function ($item, $key) use ($data) {
                $item->is_first = $key === 0;
                $item->is_last = $key === $data->count() - 1;
                return $item;
            });

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $id = $row->id;
                    $btn = '<div class="dropstart">
                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Aksi
                            </button>
                            <ul class="dropdown-menu" style="z-index: 1050 !important; ">
                                <li>
                                    <a class="dropdown-item" href="#" onclick="onEdit(this)" data-id="' . $id . '">
                                        <i class="fa fa-pencil me-2 text-warning"></i>Edit
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="#" onclick="onDelete(this)" data-id="' . $id . '">
                                        <i class="fa fa-trash me-2"></i>Hapus
                                    </a>
                                </li>
                            </ul>
                        </div>
                                ';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('backoffice.content.index');
    }


    public function fetchAll()
    {
        $operation = Content::get();
        return $operation;
    }

    public function store(ContentRequest $request)
    {
        $params = $request->validated();
        $image = $request->file('image');
        if ($image) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/content', $imageName);
            $params['image'] = $imageName;
        }

        $getLastOrder = Content::orderBy('order', 'desc')->first();
        if ($getLastOrder) {
            $params['order'] = $getLastOrder->order + 1;
        } else {
            $params['order'] = 1;
        }

        $operation = Content::insert($params);
        return $this->sendResponse($operation, 'Berhasil Menambahkan Data', 'Gagal Menambahkan Data');
    }

    public function edit($id)
    {
        $operation = Content::find($id);
        return $operation;
    }

    public function update($id, ContentRequest $request)
    {
        $content = Content::findOrFail($id);
        $params = $request->validated();

        $image = $request->file('image');
        if ($image) {
            if ($content->image && Storage::exists('public/content/' . $content->image)) {
                Storage::delete('public/content/' . $content->image);
            }

            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/content', $imageName);
            $params['image'] = $imageName;
        }

        $operation = $content->update($params);
        return $this->sendResponse($operation, 'Berhasil Mengubah Data', 'Gagal Mengubah Data');
    }

    public function destroy($id)
    {
        $content = Content::findOrFail($id);

        if ($content->image && Storage::exists('public/content/' . $content->image)) {
            Storage::delete('public/content/' . $content->image);
        }

        $operation = $content->delete();
        return $this->sendResponse($operation, 'Berhasil Menghapus Data', 'Gagal Menghapus Data');
    }

    public function upOrder($id)
    {
        $content = Content::findOrFail($id);

        $above = Content::where('type', $content->type)
            ->where('order', '<', $content->order)
            ->orderBy('order', 'desc')
            ->first();

        if ($above) {
            $temp = $content->order;
            $content->order = $above->order;
            $above->order = $temp;

            $content->save();
            $above->save();
        }

        return response()->json(['success' => true]);
    }

    public function downOrder($id)
    {
        $content = Content::findOrFail($id);

        $below = Content::where('type', $content->type)
            ->where('order', '>', $content->order)
            ->orderBy('order', 'asc')
            ->first();

        if ($below) {
            $temp = $content->order;
            $content->order = $below->order;
            $below->order = $temp;

            $content->save();
            $below->save();
        }

        return response()->json(['success' => true]);
    }
}
