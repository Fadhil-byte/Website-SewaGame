# Figma Design Spec - SewaGame Modern Design System

## 1. Design Principles & Foundations
- **Style Concept**: Clean, Modern, SaaS-like, Consistent, & Fully Responsive (Mobile & Desktop).
- **Typography**: `Plus Jakarta Sans` (Google Fonts: 400, 500, 600, 700, 800) with fallbacks.
- **Base Grid**: 12-column responsive grid with fluid breakpoints (`col-12`, `col-sm-6`, `col-lg-4`, `col-xl-3`).

---

## 2. Color Palette & Design Tokens
- **Brand Primary**: `#4F46E5` (Indigo 600) - Main actions, brand highlights, active states
- **Primary Hover**: `#4338CA` (Indigo 700)
- **Primary Subtle / Light**: `#EEF2FF` (Indigo 50) - Active backgrounds, soft pills
- **Secondary / Accent**: `#06B6D4` (Cyan 500)
- **Dark Surface / Navbar**: `#0F172A` (Slate 900) with glassmorphism blur
- **Body Background**: `#F8FAFC` (Slate 50)
- **Card Surface**: `#FFFFFF` with 1px border (`#E2E8F0`)
- **Text Primary**: `#1E293B` (Slate 800)
- **Text Muted**: `#64748B` (Slate 500)

### Status Colors (Subtle Pills):
- **Success (Aktif / Lunas)**: Bg `#ECFDF5`, Border `#A7F3D0`, Text `#047857`
- **Warning (Pending)**: Bg `#FFFBEB`, Border `#FDE68A`, Text `#B45309`
- **Danger (Expired / Ditolak)**: Bg `#FFF1F2`, Border `#FECDD3`, Text `#BE123C`
- **Info**: Bg `#F0F9FF`, Border `#BFDBFE`, Text `#0369A1`

---

## 3. Component Architecture
- **Cards**:
  - Border radius: `16px` (`var(--sg-radius-lg)`)
  - Border: `1px solid var(--sg-border)`
  - Shadow: Soft ambient `var(--sg-shadow-sm)`, elevated to `var(--sg-shadow-lg)` on hover
- **Buttons**:
  - Height: ~40px - 44px
  - Border radius: `12px` (`var(--sg-radius-md)`)
  - Typography: 600 SemiBold with icon alignment
- **Product Card**:
  - Image ratio 16:10 with overflow hidden and smooth zoom on hover
  - Category pill badge floating top-left
  - Direct price display (`Rp 25.000 / 7 hari`)
  - Quick action buttons: "Detail" & "+ Sewa"
- **Clean Table**:
  - Thead: uppercase, `fs-7`, muted text, light slate background (`#F8FAFC`)
  - Tbody: spacious row padding (`1rem 1.25rem`), soft border separators
  - Mobile: wrapped in smooth horizontal scrollable container
- **Admin Stat Card**:
  - Clean white card, pastel icon box, large number typography, clear metric label

---

## 4. Responsive Breakpoints
- **Mobile (< 576px)**: Stacked single column, full width touch targets, hidden dense table headers, padded sticky navigation.
- **Tablet (576px - 991px)**: 2-column product grid, 2-column admin metrics, compact order summary.
- **Laptop & Desktop (>= 992px)**: 3 to 4 column product grid, 4-column admin metrics, split-screen checkout & product details.
