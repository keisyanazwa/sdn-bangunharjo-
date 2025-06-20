<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $news = News::latest()->get();
        return view('admin.news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.news.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:published,draft',
        ], [
            'title.required' => 'Judul berita harus diisi',
            'title.string' => 'Judul berita harus berupa teks',
            'title.max' => 'Judul berita maksimal 255 karakter',
            'content.required' => 'Konten berita harus diisi',
            'content.string' => 'Konten berita harus berupa teks',
            'image.required' => 'Gambar harus diupload',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus JPG, PNG, JPEG, atau GIF',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'status.required' => 'Status berita harus dipilih',
            'status.in' => 'Status berita harus draft atau published',
        ]);

        try {
            // Upload gambar ke Cloudinary
            $uploadedFile = $request->file('image');
            
            // Pastikan file ada dan valid
            if (!$uploadedFile || !$uploadedFile->isValid()) {
                return redirect()->back()->with('error', 'File gambar tidak valid atau tidak ditemukan');
            }
            
            // Upload ke Cloudinary menggunakan service
            $cloudinary = new CloudinaryService();
            $uploadResult = $cloudinary->upload($uploadedFile, 'news');
            
            // Simpan data ke database
            News::create([
                'title' => $request->title,
                'content' => $request->content,
                'image_url' => $uploadResult['image_url'],
                'public_id' => $uploadResult['public_id'], // Menyimpan Cloudinary public_id
                'status' => $request->status,
            ]);

            return redirect()->route('admin.news.index')->with('success', 'Berita berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(News $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:published,draft',
        ], [
            'title.required' => 'Judul berita harus diisi',
            'title.string' => 'Judul berita harus berupa teks',
            'title.max' => 'Judul berita maksimal 255 karakter',
            'content.required' => 'Konten berita harus diisi',
            'content.string' => 'Konten berita harus berupa teks',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus JPG, PNG, JPEG, atau GIF',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'status.required' => 'Status berita harus dipilih',
            'status.in' => 'Status berita harus draft atau published',
        ]);

        try {
            $data = [
                'title' => $request->title,
                'content' => $request->content,
                'status' => $request->status,
            ];

            // Jika ada gambar baru yang diupload
            if ($request->hasFile('image')) {
                $uploadedFile = $request->file('image');
                
                if (!$uploadedFile || !$uploadedFile->isValid()) {
                    return redirect()->back()->with('error', 'File gambar tidak valid atau tidak ditemukan');
                }
                
                // Inisialisasi CloudinaryService
                $cloudinary = new CloudinaryService();
                
                // Hapus gambar lama dari Cloudinary jika ada
                // Pastikan public_id tidak berisi path lokal (dari sistem lama)
                if ($news->public_id && !str_contains($news->public_id, '/')) {
                    $cloudinary->delete($news->public_id);
                }

                // Upload gambar baru ke Cloudinary
                $uploadResult = $cloudinary->upload($uploadedFile, 'news');

                // Update data gambar
                $data['image_url'] = $uploadResult['image_url'];
                $data['public_id'] = $uploadResult['public_id'];
            }

            // Update data di database
            $news->update($data);

            return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\News  $news
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(News $news)
    {
        try {
            // Hapus gambar dari Cloudinary jika ada
            // Pastikan public_id tidak berisi path lokal (dari sistem lama)
            if ($news->public_id && !str_contains($news->public_id, '/')) {
                $cloudinary = new CloudinaryService();
                $cloudinary->delete($news->public_id);
            }

            // Hapus data dari database
            $news->delete();

            return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan berita di halaman frontend
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function newsFrontend()
    {
        $news = News::where('status', 'published')->latest()->paginate(9);
        return view('news', compact('news'));
    }

    /**
     * Menampilkan detail berita di halaman frontend
     * 
     * @param  \App\Models\News  $news
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function newsDetail(News $news)
    {
        // Pastikan hanya berita yang dipublikasikan yang dapat diakses
        if ($news->status !== 'published') {
            abort(404);
        }
        
        // Ambil berita terkait
        $relatedNews = News::where('id', '!=', $news->id)
                          ->where('status', 'published')
                          ->latest()
                          ->take(3)
                          ->get();
        
        return view('news_detail', compact('news', 'relatedNews'));
    }

    /**
     * Menampilkan halaman pengelolaan berita dengan JavaScript
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function newsManager()
    {
        return view('admin.news.manager');
    }

    /**
     * API untuk mendapatkan semua data berita
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiIndex()
    {
        $news = News::latest()->get();
        return response()->json($news);
    }

    /**
     * API untuk mendapatkan detail berita berdasarkan ID
     * 
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiShow($id)
    {
        try {
            $news = News::findOrFail($id);
            return response()->json($news);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Berita tidak ditemukan'], 404);
        }
    }

    /**
     * API untuk menyimpan data berita baru
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
        ], [
            'title.required' => 'Judul berita harus diisi',
            'title.string' => 'Judul berita harus berupa teks',
            'title.max' => 'Judul berita maksimal 255 karakter',
            'content.required' => 'Konten berita harus diisi',
            'content.string' => 'Konten berita harus berupa teks',
            'image.required' => 'Gambar harus diupload',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus JPG, PNG, JPEG, atau GIF',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'status.required' => 'Status berita harus dipilih',
            'status.in' => 'Status berita harus draft atau published',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Validasi gagal, silakan periksa kembali data yang diinput'], 422);
        }

        try {
            // Upload gambar ke Cloudinary
            $uploadedFile = $request->file('image');
            
            // Upload ke Cloudinary menggunakan service
            $cloudinary = new CloudinaryService();
            $uploadResult = $cloudinary->upload($uploadedFile, 'news');
            
            // Simpan data ke database
            $news = News::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'image_url' => $uploadResult['image_url'],
                'public_id' => $uploadResult['public_id'],
                'status' => $request->status,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'message' => 'Berita berhasil ditambahkan',
                'data' => $news
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage(), 'message' => 'Gagal menambahkan berita'], 500);
        }
    }

    /**
     * API untuk mengupdate data berita
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiUpdate(Request $request, $id)
    {
        $news = News::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
        ], [
            'title.required' => 'Judul berita harus diisi',
            'title.string' => 'Judul berita harus berupa teks',
            'title.max' => 'Judul berita maksimal 255 karakter',
            'content.required' => 'Konten berita harus diisi',
            'content.string' => 'Konten berita harus berupa teks',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus JPG, PNG, JPEG, atau GIF',
            'image.max' => 'Ukuran gambar maksimal 2MB',
            'status.required' => 'Status berita harus dipilih',
            'status.in' => 'Status berita harus draft atau published',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Validasi gagal, silakan periksa kembali data yang diinput'], 422);
        }

        try {
            $data = [
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'status' => $request->status,
            ];

            // Jika ada gambar baru, upload ke Cloudinary
            if ($request->hasFile('image')) {
                // Inisialisasi CloudinaryService
                $cloudinary = new CloudinaryService();
                
                // Hapus gambar lama dari Cloudinary jika ada
                // Pastikan public_id tidak berisi path lokal (dari sistem lama)
                if ($news->public_id && !str_contains($news->public_id, '/')) {
                    $cloudinary->delete($news->public_id);
                }

                // Upload gambar baru ke Cloudinary
                $uploadedFile = $request->file('image');
                $uploadResult = $cloudinary->upload($uploadedFile, 'news');

                $data['image_url'] = $uploadResult['image_url'];
                $data['public_id'] = $uploadResult['public_id'];
            }

            // Update data di database
            $news->update($data);

            return response()->json([
                'message' => 'Berita berhasil diperbarui',
                'data' => $news
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage(), 'message' => 'Gagal memperbarui berita'], 500);
        }
    }

    /**
     * API untuk menghapus data berita
     * 
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiDestroy($id)
    {
        try {
            $news = News::findOrFail($id);
            
            // Hapus gambar dari Cloudinary jika ada
            // Pastikan public_id tidak berisi path lokal (dari sistem lama)
            if ($news->public_id && !str_contains($news->public_id, '/')) {
                $cloudinary = new CloudinaryService();
                $cloudinary->delete($news->public_id);
            }

            // Hapus data dari database
            $news->delete();

            return response()->json(['message' => 'Berita berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage(), 'message' => 'Gagal menghapus berita'], 500);
        }
    }
}