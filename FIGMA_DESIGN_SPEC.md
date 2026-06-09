# Figma Design Spec - SewaGame

## Color Palette
- Primary: #0d6efd (blue) - btn-primary, navbar brand
- Success: #198754 (green) - btn-success, card success
- Warning: #ffc107 (yellow) - btn-warning, badge
- Info: #0dcaf0 (light blue) - btn-info, card info
- Dark: #212529 - navbar, footer

## Typography
- Headings: h1 display-4 (hero), h2 (page title), h5 (card title)
- Body: 14px default Bootstrap

---

## Pages

### 1. Home - Pembeli (home.blade.php)
Hero section, feature cards (3), how-it-works steps (4)

### 2. Home - Admin (admin/dashboard.blade.php)
Statistik cards (4):
- Total Pengguna - bg-primary (bi-people)
- Total Produk - bg-success (bi-boxes)
- Peminjaman Aktif - bg-warning (bi-calendar-check)
- Total Keuntungan - bg-info (bi-currency-dollar)
Recent Rentals table + Recent Users list

### 3. Manajemen Produk (products/admin_index.blade.php)
- Header: h2 + btn-success Tambah Produk
- Search form: input small + btn-secondary search + clear btn
- Table: ID, Nama, Harga, GitHub, Itch.io, Aksi
- GitHub/Itch.io: btn-dark/btn-outline-secondary or "-"
- Edit/Delete buttons

### 4-13. Other pages (same as before)

---

## Icons (Bootstrap Icons)
bi-controller, bi-boxes, bi-calendar-check, bi-people, bi-currency-dollar, bi-speedometer2, bi-search, bi-x, bi-plus-circle, bi-pencil-square, bi-trash, bi-github, bi-link-45deg

---

## Admin Dashboard Flow
1. Login -> Dashboard admin statistik
2. Kelola Produk (with search)
3. Kelola Peminjaman
