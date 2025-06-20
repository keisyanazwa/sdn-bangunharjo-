/**
 * JavaScript untuk mengelola operasi CRUD galeri
 */

// Data galeri
let galleryData = [];

// Variabel untuk menyimpan ID galeri yang sedang diedit
let currentGalleryEditId = null;

// Render gallery table
function renderGalleryTable() {
    const tableBody = document.getElementById("galleryTableBody");
    const emptyMessage = document.getElementById("emptyGalleryMessage");
    tableBody.innerHTML = "";

    if (galleryData.length === 0) {
        emptyMessage.style.display = "block";
    } else {
        emptyMessage.style.display = "none";

        galleryData.forEach((gallery, index) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>${gallery.title}</td>
                <td><img src="${gallery.image_url}" alt="${
                gallery.title
            }" class="img-thumbnail" style="max-height: 80px;"></td>
                <td>
                    <button class="btn btn-sm btn-info edit-gallery" data-id="${
                        gallery.id
                    }"><i class="bi bi-pencil"></i> Edit</button>
                    <button class="btn btn-sm btn-danger delete-gallery" data-id="${
                        gallery.id
                    }"><i class="bi bi-trash"></i> Hapus</button>
                </td>
            `;
            tableBody.appendChild(row);
        });

        // Add event listeners for edit and delete buttons
        document.querySelectorAll(".edit-gallery").forEach((btn) => {
            btn.addEventListener("click", function () {
                const galleryId = this.getAttribute("data-id");
                const gallery = galleryData.find((g) => g.id == galleryId);
                if (gallery) {
                    // Set form to edit mode
                    currentGalleryEditId = gallery.id;
                    document.getElementById("galleryFormTitle").textContent =
                        "Edit Foto";
                    document.getElementById("galleryTitle").value =
                        gallery.title;

                    // Scroll to form in mobile view
                    const formCard = document.querySelector(
                        "#galleryModal .col-md-5 .card"
                    );
                    if (window.innerWidth < 768) {
                        formCard.scrollIntoView({ behavior: "smooth" });
                    }
                }
            });
        });

        document.querySelectorAll(".delete-gallery").forEach((btn) => {
            btn.addEventListener("click", function () {
                if (confirm("Apakah Anda yakin ingin menghapus foto ini?")) {
                    const galleryId = this.getAttribute("data-id");
                    deleteGallery(galleryId);
                }
            });
        });
    }
}

// Reset form to add mode
function resetGalleryForm() {
    currentGalleryEditId = null;
    document.getElementById("galleryFormTitle").textContent = "Tambah Foto";
    document.getElementById("galleryForm").reset();
}

// Fetch gallery data from API
function fetchGalleryData() {
    fetch("/api/galleries", {
        method: "GET",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
            "Content-Type": "application/json",
        },
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            galleryData = data;
            renderGalleryTable();
        })
        .catch((error) => {
            console.error("Error fetching gallery data:", error);
            // Tampilkan pesan error yang lebih informatif di konsol, tanpa mengganggu pengguna dengan alert
        });
}

// Save gallery (create or update)
function saveGallery(formData) {
    const url = currentGalleryEditId
        ? `/api/galleries/${currentGalleryEditId}`
        : "/api/galleries";
    const method = currentGalleryEditId ? "PUT" : "POST";

    fetch(url, {
        method: method,
        body: formData,
        headers: {
            "X-CSRF-TOKEN": csrfToken,
        },
    })
        .then((response) => {
            // Periksa status HTTP response
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            fetchGalleryData();
            resetGalleryForm();
            alert(data.message || "Data berhasil disimpan");
            
        })
        .catch((error) => {
            console.error("Error saving gallery:", error);
            // Tampilkan pesan error yang lebih informatif
            if (error.message) {
                alert("Terjadi kesalahan: " + error.message);
            } else {
                alert(
                    "Terjadi kesalahan saat menyimpan data. Silakan coba lagi."
                );
            }
        });
}

// Delete gallery
function deleteGallery(id) {
    fetch(`/api/galleries/${id}`, {
        method: "DELETE",
        headers: {
            "X-CSRF-TOKEN": csrfToken,
            "Content-Type": "application/json",
        },
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            fetchGalleryData();
            alert(data.message || "Data berhasil dihapus");
            
        })
        .catch((error) => {
            console.error("Error deleting gallery:", error);
            if (error.message) {
                alert("Terjadi kesalahan: " + error.message);
            } else {
                alert(
                    "Terjadi kesalahan saat menghapus data. Silakan coba lagi."
                );
            }
        });
}

// Initialize the page
document.addEventListener("DOMContentLoaded", function () {
    // Fetch initial data
    fetchGalleryData();

    // Ambil CSRF token dari meta tag
    const csrfToken = document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content");

    // Cancel edit button
    document
        .getElementById("cancelGalleryBtn")
        .addEventListener("click", function () {
            resetGalleryForm();
        });

    // Save gallery button
    document
        .getElementById("saveGalleryBtn")
        .addEventListener("click", function () {
            const title = document.getElementById("galleryTitle").value;
            const imageInput = document.getElementById("galleryImage");

            // Validasi: judul harus diisi, dan jika menambah baru, gambar harus dipilih
            if (
                title &&
                (currentGalleryEditId || imageInput.files.length > 0)
            ) {
                const formData = new FormData();
                formData.append("title", title);

                // Tambahkan gambar ke formData hanya jika ada file yang dipilih
                if (imageInput.files.length > 0) {
                    formData.append("image", imageInput.files[0]);
                }

                // If editing, use PUT method
                if (currentGalleryEditId) {
                    formData.append("_method", "PUT");
                }

                saveGallery(formData);
            } else {
                alert("Harap isi semua field yang diperlukan");
            }
        });

    // Add responsive behavior for the modal
    $("#galleryModal").on("shown.bs.modal", function () {
        adjustModalLayout();
    });

    window.addEventListener("resize", function () {
        if ($("#galleryModal").hasClass("show")) {
            adjustModalLayout();
        }
    });

    function adjustModalLayout() {
        if (window.innerWidth < 768) {
            // On mobile, stack the columns
            document
                .querySelector("#galleryModal .row")
                .classList.add("flex-column-reverse");
        } else {
            // On desktop, use side-by-side layout
            document
                .querySelector("#galleryModal .row")
                .classList.remove("flex-column-reverse");
        }
    }
});
