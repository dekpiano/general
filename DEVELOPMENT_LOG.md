# 📝 DEVELOPMENT LOG: general2025

## 🌟 Overview
This log documents changes, enhancements, and bug fixes applied to the Meeting Room and Facility Booking Admin Approval System (`/Booking/Approve/Admin`) in the `general2025` project.

---

## 🛠️ Implementation History

### 📅 May 19, 2026

#### 1. 🎨 Emerald Theme Implementation (`#15a362`)
- **File Modified:** [UserBookingViewAdmin.php](file:///d:/SkjSystem/general2025/app/Views/User/UserBooking/UserBookingViewAdmin.php)
- **Changes:**
  - Customized CSS `:root` variables to map `--primary-gradient` and `--success-gradient` to use the premium green `#15a362` and a darker accent green `#0e854d`.
  - Added CSS overrides for Sneat Admin primary classes, including:
    - `.btn-primary` (background, border, hover, shadow)
    - `.btn-outline-primary`
    - `.bg-label-primary`
    - `.text-primary`
    - `.page-item.active .page-link` (DataTable pagination)
    - `.page-link`
  - Restyled the **Approved** status badge to a matching emerald background and text (`background: #e8f5e9; color: #15a362; border: 1px solid #c8e6c9;`).
  - Styled the banner icon and card icons to use `#15a362`.

#### 2. 🔔 SweetAlert2 Layering Override
- **File Modified:** [UserBookingViewAdmin.php](file:///d:/SkjSystem/general2025/app/Views/User/UserBooking/UserBookingViewAdmin.php)
- **Changes:**
  - Added a global z-index override:
    ```css
    .swal2-container {
        z-index: 99999 !important;
    }
    ```
    This guarantees that confirm alerts and success notifications display on top of standard Bootstrap modals (like the Signature modal or Detail modal) without being hidden.

#### 3. 🟢 SweetAlert2 Color Tailoring
- **File Modified:** [UserBooking.js](file:///d:/SkjSystem/general2025/assets/js/User/UserBooking/UserBooking.js)
- **Changes:**
  - Updated all confirm popups' `confirmButtonColor` to use `#15a362` (specifically for Room Booking Admin approval flow, Login check flow, and Cancellation alert dialogues).
  - Updated ApexCharts color palettes (`#15a362`) in `UserBooking.js` so that the Location Usage proportion, Top 5 Bookers, and Approval Status donut/pie/bar charts render using the premium green theme.

#### 4. 🐛 SQL Select Column Bug Fix
- **File Modified:** [ConUserBooking.php](file:///d:/SkjSystem/general2025/app/Controllers/ConUserBooking.php)
- **Changes:**
  - Fixed a silent bug in the `BookingDataTableApproveAdmin` method's SELECT statement. The field `tb_booking.booking_imgWork` was missing, which prevented attachment layout/seating plan links ("ผังงาน") from being rendered in the Admin table even when they existed. Added `tb_booking.booking_imgWork` to the active SELECT statement.

#### 5. 📎 Dedicated "ไฟล์แนบ" (Attachment) Column
- **Files Modified:** 
  - [UserBookingViewAdmin.php](file:///d:/SkjSystem/general2025/app/Views/User/UserBooking/UserBookingViewAdmin.php)
  - [UserBooking.js](file:///d:/SkjSystem/general2025/assets/js/User/UserBooking/UserBooking.js)
- **Changes:**
  - Refactored the HTML table to introduce a dedicated `<th>ไฟล์แนบ</th>` column header between "สถานที่" and "สถานะ".
  - Configured DataTable in `UserBooking.js` to render a beautiful green pill button "ดูไฟล์แนบ" (`btn-outline-primary`) inside the new column, which maps to `booking_imgWork` and opens the attachment preview modal on click.
  - Cleared out the previous inline "ผังงาน" attachment links from the Details column to present a cleaner, more readable grid view.

#### 6. 🔍 Interactive Zoom & Pan Attachment Viewer
- **Files Modified:** 
  - [UserBookingViewAdmin.php](file:///d:/SkjSystem/general2025/app/Views/User/UserBooking/UserBookingViewAdmin.php)
  - [UserBooking.js](file:///d:/SkjSystem/general2025/assets/js/User/UserBooking/UserBooking.js)
- **Changes:**
  - Added a control toolbar with Zoom In (`+`), Zoom Out (`-`), and Reset (`Reset`) buttons inside the generic detail modal (`#myModal`) header.
  - Styled a `.zoom-wrapper` layout with automatic overflow management, smooth transform transition transitions, custom box shadow, and native drag-to-grab pointer cursor styles.
  - Implemented client-side interactive zoom logic scaling images on transform scale values, and mouse grab-dragging allowing panning and exploring zoomed attachments effortlessly.
  - Added a smooth loading spinner fallback when loading the attachment image.

#### 7. 📸 100% High-Resolution Image Crop & Upload Fix
- **Files Modified:** 
  - [UserBookingCrop.js](file:///d:/SkjSystem/general2025/assets/js/User/UserBooking/UserBookingCrop.js)
  - [UserBookingAdd.php](file:///d:/SkjSystem/general2025/app/Views/User/UserBooking/UserBookingAdd.php)
  - [UserBookingEdit.php](file:///d:/SkjSystem/general2025/app/Views/User/UserBooking/UserBookingEdit.php)
- **Changes:**
  - Fixed the low-quality blurry image crop bug. The Croppie instances in all three files were previously configured to export the cropped image using `size: 'viewport'` (or type canvas with size viewport), which scaled the output down to the tiny viewport container of **320x180 pixels** (causing severe pixelation/blurriness on zoom modals).
  - Modified the Croppie result settings in all files to use `size: 'original'`, `format: 'png'`, and `quality: 1` (maximum quality). This ensures that the crop maintains the original high-resolution pixels of the source image, making all uploaded diagrams, plans, and blueprints 100% crystal clear.

#### 8. 📅 My Bookings Separation & Admin Sidebar Stats Correction
- **Files Modified:**
  - [ConUserBooking.php](file:///d:/SkjSystem/general2025/app/Controllers/ConUserBooking.php)
  - [UserBookingMain.php](file:///d:/SkjSystem/general2025/app/Views/User/UserBooking/UserBookingMain.php)
  - [UserBookingView.php](file:///d:/SkjSystem/general2025/app/Views/User/UserBooking/UserBookingView.php)
- **Changes:**
  - Split the "My Bookings" sidebar element into two distinct cards: "รายการจองทั้งหมด" (All Bookings) which is public and lists everything, and "รายการจองของฉัน" (My Bookings) which is visible only when logged in.
  - Updated `ConUserBooking::BookingMain` to calculate and feed both general counts (`CountbookingAll`) and logged-in user counts (`CountbookingMy`) cleanly.
  - Fixed a silent bug in `BookingMain` where the administrator pending request stats `NumRowsWaitApprove` was querying for `'ไม่อนุมัติ'` (disapproved) instead of `'รอตรวจสอบ'` (pending approval), which was rendering completely incorrect counts in the officer's widget cards.
  - Enhanced `ConUserBooking::BookingView` to listen to key `My`, filtering database rows strictly to the logged-in user's records while redirecting unauthenticated guests back to the Login flow.
  - Refined `UserBookingView.php` to render dynamic headers ("รายการจองของฉัน" when `$All == 'My'`) and conditionally enable "Edit" and "Cancel" buttons on My Bookings so users can manage their own reservations.

#### 9. 🗑️ Permanent Booking Deletion & Attachment File Unlink Fix
- **Files Modified:**
  - [ConUserBooking.php](file:///d:/SkjSystem/general2025/app/Controllers/ConUserBooking.php)
  - [UserBookingView.php](file:///d:/SkjSystem/general2025/app/Views/User/UserBooking/UserBookingView.php)
- **Changes:**
  - Fixed a missing event listener bug where clicking the "ยกเลิก" (Cancel/Delete) button on the mobile booking card view did absolutely nothing because there was no active click listener on `.delete-btn` in `UserBookingView.php` or imported script file.
  - Implemented an elegant SweetAlert2-based confirmation alert on `.delete-btn` click in `UserBookingView.php` styled with the school green color (`#15a362`) and native loading state.
  - Updated the backend cancellation action `ConUserBooking::BookingCancel` to query the booking record, retrieve the attached file name (`booking_imgWork`), physically delete (unlink) the image from the server directory (`uploads/User/Booking/`) to save server storage, and then permanently delete the database row from the `tb_booking` table.
