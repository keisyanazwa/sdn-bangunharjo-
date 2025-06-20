<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Services\CloudinaryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.gallery.index', compact('galleries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('admin.gallery.create');
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required' => 'Judul foto harus diisi',
            'title.string' => 'Judul foto harus berupa teks',
            'title.max' => 'Judul foto maksimal 255 karakter',
            'image.required' => 'Gambar harus diupload',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus JPG, PNG, JPEG, atau GIF',
            'image.max' => 'Ukuran gambar maksimal 2MB',
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
            $uploadResult = $cloudinary->upload($uploadedFile, 'gallery');
            
            // Simpan data ke database
            Gallery::create([
                'title' => $request->title,
                'image_url' => $uploadResult['image_url'],
                'public_id' => $uploadResult['public_id'], // Menyimpan Cloudinary public_id
            ]);

            return redirect()->route('admin.gallery.index')->with('success', 'Foto galeri berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function show(Gallery $gallery)
    {
        return view('admin.gallery.show', compact('gallery'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(Gallery $gallery, Request $request)
    {
        // Jika request dari gallery manager, tampilkan view gallery_manager dengan data yang akan diedit
        if ($request->has('manager') && $request->manager == 'true') {
            $galleries = Gallery::latest()->get();
            $editGallery = $gallery;
            return view('admin.gallery.gallery_manager', compact('galleries', 'editGallery'));
        }
        
        // Jika tidak, tampilkan view edit biasa
        return view('admin.gallery.edit', compact('gallery'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required' => 'Judul foto harus diisi',
            'title.string' => 'Judul foto harus berupa teks',
            'title.max' => 'Judul foto maksimal 255 karakter',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus JPG, PNG, JPEG, atau GIF',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        try {
            $data = [
                'title' => $request->title,
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
                if ($gallery->public_id && !str_contains($gallery->public_id, '/')) {
                    $cloudinary->delete($gallery->public_id);
                }

                // Upload gambar baru ke Cloudinary
                $uploadResult = $cloudinary->upload($uploadedFile, 'gallery');

                // Update data gambar
                $data['image_url'] = $uploadResult['image_url'];
                $data['public_id'] = $uploadResult['public_id'];
            }

            // Update data di database
            $gallery->update($data);

            // Redirect berdasarkan parameter manager
            if ($request->has('manager') && $request->manager == 'true') {
                return redirect()->route('admin.gallery.index')->with('success', 'Foto galeri berhasil diperbarui.');
            }
            
            return redirect()->route('admin.gallery.index')->with('success', 'Foto galeri berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gallery  $gallery
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Gallery $gallery, Request $request)
    {
        try {
            // Hapus gambar dari Cloudinary jika public_id valid (bukan path lokal)
            if ($gallery->public_id && !str_contains($gallery->public_id, '/')) {
                $cloudinary = new CloudinaryService();
                $cloudinary->delete($gallery->public_id);
            } 
            // Hapus gambar dari storage lokal jika masih menggunakan path lokal
            else if ($gallery->public_id && Storage::disk('public')->exists($gallery->public_id)) {
                Storage::disk('public')->delete($gallery->public_id);
            }

            // Hapus data dari database
            $gallery->delete();

            // Redirect berdasarkan parameter manager
            if ($request->has('manager') && $request->manager == 'true') {
                return redirect()->route('admin.gallery.index')->with('success', 'Foto galeri berhasil dihapus.');
            }
            
            return redirect()->route('admin.gallery.index')->with('success', 'Foto galeri berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan galeri di halaman frontend
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function galleryFrontend()
    {
        $galleries = Gallery::latest()->paginate(12);
        return view('frontend.galeri', compact('galleries'));
    }

    /**
     * Menampilkan detail galeri di halaman frontend
     * 
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function galleryDetail(Gallery $gallery)
    {
        return view('frontend.galeri.detail', compact('gallery'));
    }

    /**
     * Display the gallery manager page.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function galleryManager()
    {
        $galleries = Gallery::latest()->get();
        return view('admin.gallery.gallery_manager', compact('galleries'));
    }

    /**
     * API untuk mendapatkan semua data galeri
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiIndex()
    {
        $galleries = Gallery::latest()->get();
        return response()->json($galleries);
    }

    /**
     * API untuk menyimpan data galeri baru
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required' => 'Judul foto harus diisi',
            'title.string' => 'Judul foto harus berupa teks',
            'title.max' => 'Judul foto maksimal 255 karakter',
            'image.required' => 'Gambar harus diupload',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus JPG, PNG, JPEG, atau GIF',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Validasi gagal, silakan periksa kembali data yang diinput'], 422);
        }

        try {
            // Upload gambar ke Cloudinary
            $uploadedFile = $request->file('image');
            
            // Inisialisasi CloudinaryService
            $cloudinary = new CloudinaryService();
            
            // Upload gambar ke Cloudinary
            $uploadResult = $cloudinary->upload($uploadedFile, 'gallery');
            
            // Simpan data ke database
            $gallery = Gallery::create([
                'title' => $request->title,
                'image_url' => $uploadResult['image_url'],
                'public_id' => $uploadResult['public_id'],
            ]);

            return response()->json([
                'message' => 'Foto galeri berhasil ditambahkan',
                'data' => $gallery
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage(), 'message' => 'Gagal menambahkan foto galeri'], 500);
        }
    }

    /**
     * API untuk mengupdate data galeri
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiUpdate(Request $request, Gallery $gallery)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'title.required' => 'Judul foto harus diisi',
            'title.string' => 'Judul foto harus berupa teks',
            'title.max' => 'Judul foto maksimal 255 karakter',
            'image.image' => 'File harus berupa gambar',
            'image.mimes' => 'Format gambar harus JPG, PNG, JPEG, atau GIF',
            'image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors(), 'message' => 'Validasi gagal, silakan periksa kembali data yang diinput'], 422);
        }

        try {
            $data = ['title' => $request->title];

            // Jika ada gambar baru, upload ke Cloudinary
            if ($request->hasFile('image')) {
                // Inisialisasi CloudinaryService
                $cloudinary = new CloudinaryService();
                
                // Hapus gambar lama dari Cloudinary jika ada
                if ($gallery->public_id && !str_contains($gallery->public_id, '/')) {
                    $cloudinary->delete($gallery->public_id);
                }
                // Hapus gambar lama dari storage lokal jika masih menggunakan path lokal
                else if ($gallery->public_id && Storage::disk('public')->exists($gallery->public_id)) {
                    Storage::disk('public')->delete($gallery->public_id);
                }

                // Upload gambar baru ke Cloudinary
                $uploadResult = $cloudinary->upload($request->file('image'), 'gallery');

                $data['image_url'] = $uploadResult['image_url'];
                $data['public_id'] = $uploadResult['public_id'];
            }

            // Update data di database
            $gallery->update($data);

            return response()->json([
                'message' => 'Foto galeri berhasil diperbarui',
                'data' => $gallery
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage(), 'message' => 'Gagal memperbarui foto galeri'], 500);
        }
    }

    /**
     * API untuk menghapus data galeri
     * 
     * @param  \App\Models\Gallery  $gallery
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiDestroy(Gallery $gallery)
    {
        try {
            // Hapus gambar dari Cloudinary jika public_id valid (bukan path lokal)
            if ($gallery->public_id && !str_contains($gallery->public_id, '/')) {
                $cloudinary = new CloudinaryService();
                $cloudinary->delete($gallery->public_id);
            }
            // Hapus gambar dari storage lokal jika masih menggunakan path lokal
            else if ($gallery->public_id && Storage::disk('public')->exists($gallery->public_id)) {
                Storage::disk('public')->delete($gallery->public_id);
            }

            // Hapus data dari database
            $gallery->delete();

            return response()->json(['message' => 'Foto galeri berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Terjadi kesalahan: ' . $e->getMessage(), 'message' => 'Gagal menghapus foto galeri'], 500);
        }
    }
}