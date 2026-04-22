let currentCropIndex = 0;
let isAdminCrop = false; // Track if we are cropping for user or admin
window.triggerFileInput = function(index) {
    currentCropIndex = index;
    isAdminCrop = false;
    $('#repair_imguser_input').click();
};

window.triggerAdminFileInput = function(index) {
    currentCropIndex = index;
    isAdminCrop = true;
    $('#repair_imgwork_input').click();
};

$(document).ready(function () {
  // Initialize Select2 ONLY for the specific form, preserving DataTables default selects
  $("#FormAddRepair .form-select").select2({
    theme: "bootstrap-5",
    width: "100%",
    dropdownParent: $(document.body),
  });

  // Handle Floating Label for Select2 (Scoped to FormAddRepair)
  $("#FormAddRepair .form-select")
    .on("select2:open", function (e) {
      $(this).closest(".form-floating-custom").addClass("is-focused");
    })
    .on("select2:close", function (e) {
      $(this).closest(".form-floating-custom").removeClass("is-focused");
    })
    .on("change", function (e) {
      if ($(this).val()) {
        $(this).closest(".form-floating-custom").addClass("is-filled");
      } else {
        $(this).closest(".form-floating-custom").removeClass("is-filled");
      }
    });

  // Initial check for pre-filled values
  $("#FormAddRepair .form-select").each(function () {
    if ($(this).val()) {
      $(this).closest(".form-floating-custom").addClass("is-filled");
    }
  });

  ShowDataLocationRoom(); // Initialize DataTable

  // REAL-TIME CAPTCHA VALIDATION
  $(document).on("input", "#captcha_input", function () {
    const userAnswer = parseInt($(this).val());
    const correctAnswer = parseInt($(".captcha-badge").data("answer"));
    const btnSubmit = $("#BtnSubRepair");

    if (userAnswer === correctAnswer) {
      btnSubmit.removeClass("disabled").prop("disabled", false);
      $(this).removeClass("is-invalid").addClass("is-valid");
    } else {
      btnSubmit.addClass("disabled").prop("disabled", true);
      $(this).removeClass("is-valid");
      if ($(this).val() !== "") {
        $(this).addClass("is-invalid");
      } else {
        $(this).removeClass("is-invalid");
      }
    }
  });
});

let croppieInstance = null;
let croppedBlobs = [null, null, null]; // Support up to 3 images for user
let adminCroppedBlobs = [null, null, null]; // Support up to 3 images for admin




// Handle file selection and show cropper (User)
$(document).on('change', '#repair_imguser_input', function() {
    initCroppie(this);
});

// Handle file selection and show cropper (Admin)
$(document).on('change', '#repair_imgwork_input', function() {
    initCroppie(this);
});

function initCroppie(input) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $('#cropModal').modal('show');
            if (croppieInstance) {
                croppieInstance.destroy();
                croppieInstance = null;
            }
            
            $('#cropModal').on('shown.bs.modal', function () {
                if (croppieInstance) croppieInstance.destroy();
                croppieInstance = new Croppie(document.getElementById('croppie-container'), {
                    viewport: { width: 400, height: 225, type: 'square' },
                    boundary: { width: '100%', height: 400 },
                    showZoomer: true,
                    enableOrientation: true,
                    mouseWheelZoom: 'ctrl'
                });
                croppieInstance.bind({
                    url: e.target.result
                });
                $(this).off('shown.bs.modal');
            });
        };
        reader.readAsDataURL(file);
        $(input).val('');
    }
}

// Handle Rotation
$(document).on('click', '#btn-rotate-left', function() {
    if (croppieInstance) {
        croppieInstance.rotate(-90);
    }
});

$(document).on('click', '#btn-rotate-right', function() {
    if (croppieInstance) {
        croppieInstance.rotate(90);
    }
});

// Handle cropping action
$(document).on('click', '#btn-crop', function() {
    if (croppieInstance) {
        croppieInstance.result({
            type: 'blob',
            size: { width: 1280, height: 720 },
            format: 'png',
            quality: 0.9
        }).then(function(blob) {
            if (isAdminCrop) {
                adminCroppedBlobs[currentCropIndex] = blob;
                const url = URL.createObjectURL(blob);
                $(`#adminImageResult${currentCropIndex}`).attr('src', url);
            } else {
                croppedBlobs[currentCropIndex] = blob;
                const url = URL.createObjectURL(blob);
                $(`#imageResult${currentCropIndex}`).attr('src', url);
            }
            
            $('#cropModal').modal('hide');
            
            Swal.fire({
                icon: 'success',
                title: `เตรียมรูปที่ ${currentCropIndex + 1} เรียบร้อย`,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000
            });
        });
    }
});

function toThaiDateString(date) {
  let monthNames = [
    "มกราคม",
    "กุมภาพันธ์",
    "มีนาคม",
    "เมษายน",
    "พฤษภาคม",
    "มิถุนายน",
    "กรกฎาคม",
    "สิงหาคม",
    "กันยายน",
    "ตุลาคม",
    "พฤศจิกายน",
    "ธันวาคม",
  ];

  let year = date.getFullYear() + 543;
  let month = monthNames[date.getMonth()];
  let numOfDay = date.getDate();

  let hour = date.getHours().toString().padStart(2, "0");
  let minutes = date.getMinutes().toString().padStart(2, "0");
  let second = date.getSeconds().toString().padStart(2, "0");

  return `${numOfDay} ${month} ${year} ` + `${hour}:${minutes}:${second} น.`;
}

// Removed immediate redirect for 'งานอาคารสถานที่' so users can fill the repair form first.

// ShowDataLocationRoom(); // Removed immediate call

function ShowDataLocationRoom() {
  // Get year from URL parameter or default to current year/dropdown value
  const urlParams = new URLSearchParams(window.location.search);
  let selectedYear = urlParams.get("year");
  if (!selectedYear) {
    selectedYear = $("#yearFilter").val(); // Fallback to dropdown value
  }

  $("#TbDataRepair").DataTable({
    destroy: true, // Allow re-initialization
    responsive: true,
    processing: true,
    serverMethod: "post",
    ajax: {
      url: "Repair/DataTable/ShowRepari",
      data: function (d) {
        d.year = selectedYear; // Send year to server
      },
    },
    order: [
      [3, "desc"], // เรียงตามใบแจ้งซ่อม (repair_order) ล่าสุด
    ],
    columns: [
      {
        data: "repair_status",
        className: "all",
        render: function (data, type, row) {
          let icon = "";
          let className = "";
          let extraClass = "";
          data = data ? data.trim() : ""; // Trim whitespace
          data = data ? data.trim() : "";
          console.log("Repair Status:", data); // Debug log

          if (data === "รอดำเนินการ") {
            icon = "bi-clock-history";
            className = "badge bg-label-warning";
          } else if (data === "กำลังดำเนินการ") {
            icon = "bi-gear";
            className = "badge bg-label-primary";
            extraClass = "loading-text";
          } else if (
            data.includes("เรียบร้อย") ||
            data.includes("เสร็จสิ้น") ||
            data === "อนุมัติ"
          ) {
            // Match "ดำเนินการเรียบร้อย", "เสร็จสิ้น", etc.
            icon = "bi-check-circle-fill";
            className = "badge bg-success text-white";
          } else if (data.includes("ยกเลิก") || data.includes("ไม่อนุมัติ")) {
            icon = "bi-x-circle";
            className = "badge bg-label-danger";
          } else {
            icon = "bi-question-circle";
            className = "badge bg-label-secondary";
          }
          return `<span class="${className} ${extraClass}"><i class="bi ${icon} me-1"></i> ${data}</span>`;
        },
      },
      {
        data: "repair_caselist",
        className: "all",
        render: function (data, type, row) {
          return `<i class="bi bi-list-check text-muted me-2"></i>${data}`;
        },
      },
      {
        data: "repair_datetime",
        render: function (data, type, row) {
          if (type === "display" && data) {
            return (
              '<i class="bi bi-calendar-check text-muted me-2"></i>' + data
            );
          }
          return data;
        },
      },
      {
        data: "repair_order",
        render: function (data, type, row) {
          return `<i class="bi bi-file-earmark-text text-muted me-2"></i>${data}`;
        },
      },
      {
        data: "UserFullname",
        render: function (data, type, row) {
          return `<i class="bi bi-person text-muted me-2"></i>${data}`;
        },
      },
      {
        data: "repair_ID",
        render: function (data, type, row) {
          let buttons = '<a href="Repair/View/' +
            row.repair_order +
            '" data-id="' +
            row.repair_ID +
            '" id="BtnRepairFullDetail" class="btn btn-sm btn-outline-primary" >รายละเอียด</a>';
            
          // If login and the current user is the owner of this repair
          if (typeof SESSION_PERS_ID !== 'undefined' && SESSION_PERS_ID !== '' && String(row.repair_userID) === String(SESSION_PERS_ID)) {
              if (row.repair_caselist === 'งานอาคารสถานที่') {
                  buttons += ' <a href="Repair/BuildingMemo" class="btn btn-sm btn-outline-warning ms-1" title="ออกบันทึกข้อความ"><i class="bi bi-file-earmark-text"></i> ย้อนหลัง</a>';
              }
          }
          return buttons;
        },
      },
    ],
  });
}

$(document).on("click", "#BtnRepairFullDetail1", function () {
  $("#ModalShowRepair").modal("show");
  $.post(
    "Repair/DB/CheckRepairFullDetail",
    {
      RepairId: $(this).attr("data-id"),
    },
    function (data) {
      let datetime = new Date(data[0][0].repair_datetime);
      let dateworIf = new Date(data[0][0].repair_datework);
      let datework;

      if (isNaN(dateworIf)) {
        datework = "";
      } else {
        datework = toThaiDateString(dateworIf);
      }

      $("#show_repair_order").text(data[0][0].repair_order);
      $("#show_repair_caselist").text(data[0][0].repair_caselist);
      $("#show_repair_datetime").text(toThaiDateString(datetime));
      $("#show_repair_detail").text(data[0][0].repair_detail);
      $("#show_repair_location").text(
        data[0][0].repair_building +
          " ชั้น " +
          data[0][0].repair_class +
          " ห้อง " +
          data[0][0].repair_room,
      );
      $("#show_repair_userID").text(
        data[0][0].pers_prefix +
          data[0][0].pers_firstname +
          " " +
          data[0][0].pers_lastname,
      );
      $("#show_repair_posi").text(data[0][0].posi_name);
      $("#show_repair_datework").text(datework);
      $("#show_repair_Repairman").text(
        data[1][0].pers_prefix +
          data[1][0].pers_firstname +
          " " +
          data[1][0].pers_lastname,
      );
      $("#show_repair_cause").text(data[0][0].repair_cause);
      $("#show_repair_status").text(data[0][0].repair_status);

      if (data[0][0].repair_imguser) {
          const imgs = data[0][0].repair_imguser.split(',');
          let imgsHtml = '<div class="row g-2">';
          imgs.forEach(img => {
              if (img) {
                  imgsHtml += `
                      <div class="col-12 mb-2">
                          <img src="/uploads/user/Repair/${img}" class="img-fluid rounded border shadow-sm w-100" alt="รูปที่ผู้ใช้งานส่งมา">
                      </div>`;
              }
          });
          imgsHtml += '</div>';
          $("#show_repair_imguser").html(imgsHtml);
      } else {
          $("#show_repair_imguser").html('<span class="text-muted">ไม่มีรูปภาพ</span>');
      }

      if (data[0][0].repair_imgwork) {
          const imgs_w = data[0][0].repair_imgwork.split(',');
          let imgsWorkHtml = '<div class="row g-2">';
          imgs_w.forEach(img => {
              if (img) {
                  imgsWorkHtml += `
                      <div class="col-12 mb-2">
                          <img src="/uploads/admin/Repair/${img}" class="img-fluid rounded border shadow-sm w-100" alt="รูปการดำเนินการของช่าง">
                      </div>`;
              }
          });
          imgsWorkHtml += '</div>';
          $("#show_repair_imgwork").html(imgsWorkHtml);
      } else {
          $("#show_repair_imgwork").html('<span class="text-muted">ไม่มีรูปภาพ</span>');
      }
      $("#show_repair_usersignature").html(
        '<img src="' +
          data[0][0].repair_usersignature +
          '" class="img-fluid" alt="รูปลายมือชื่อ">',
      );

      $("#repair_order").val(data[0][0].repair_order);
      $("#repair_cause").val(data[0][0].repair_cause);
      $("#repair_status").val(data[0][0].repair_status);

      $(".PrintOrder").attr(
        "href",
        "Repair/PrintOrder/" + data[0][0].repair_order,
      );
    },
    "json",
  );
});

// Disable userID initially
$("#repair_userID").prop("disabled", true);

$(document).on("change", "#repair_posi", function () {
  const posiId = $(this).val();
  if (!posiId) return;

  // Reset and Disable while loading
  $("#repair_userID")
    .prop("disabled", true)
    .html('<option value="" selected disabled>กำลังโหลด...</option>')
    .trigger("change");
  $("#repair_phone").val("");

  $.post(
    "../Repair/DB/CheckPosiUser",
    {
      repair_posi: posiId,
    },
    function (data) {
      $("#repair_userID")
        .prop("disabled", false)
        .empty()
        .append('<option value="" selected disabled></option>')
        .trigger("change");

      $.each(data, function (key, val) {
        var optionElement = $("<option>")
          .attr("value", val.pers_id)
          .attr("data-phone", val.pers_phone || "")
          .text(val.pers_prefix + val.pers_firstname + " " + val.pers_lastname);
        $("#repair_userID").append(optionElement);
      });

      // Refresh select2 if initialized
      if ($("#repair_userID").hasClass("select2-hidden-accessible")) {
        $("#repair_userID").select2({
          theme: "bootstrap-5",
          width: "100%",
          dropdownParent: $(document.body),
        });
      }
    },
    "json",
  );
});

// Auto-populate phone number when requester is selected
$(document).on("change", "#repair_userID", function () {
  const selectedOption = $(this).find("option:selected");
  const phone = selectedOption.data("phone");
  if (phone) {
    $("#repair_phone").val(phone).trigger("change");
    // Manually trigger filled state for floating label if needed
    $("#repair_phone").closest(".form-floating").addClass("is-filled");
  } else {
    $("#repair_phone").val("");
  }
});

document.addEventListener("submit", async function (e) {
  if (e.target && e.target.id === "FormAddRepair") {
    e.preventDefault();

    const form = e.target;
    if (!form.checkValidity()) {
      e.stopPropagation();
      form.classList.add("was-validated");
      return;
    }

    const formData = new FormData(form);
    
    // Remove original repair_imguser from formData to avoid confusion
    formData.delete('repair_imguser');

    // Append all cropped blobs that exist
    croppedBlobs.forEach((blob, index) => {
        if (blob) {
            formData.append('repair_imguser[]', blob, `repair_photo_${index}.png`);
        }
    });

    const repair_posi = formData.get("repair_posi")
      ? $(form).find("#repair_posi option:selected").text()
      : "ไม่ได้ระบุ";
    const repair_userID = formData.get("repair_userID")
      ? $(form).find("#repair_userID option:selected").text()
      : "ไม่ได้ระบุ";
    const repair_building = formData.get("repair_building") || "ไม่ได้ระบุ";
    const repair_class = formData.get("repair_class") || "ไม่ได้ระบุ";
    const repair_room = formData.get("repair_room") || "ไม่มี";
    const repair_phone = formData.get("repair_phone") || "ไม่ได้ระบุ";
    const repair_caselist = formData.get("repair_caselist") || "ไม่ได้ระบุ";
    const repair_detail = formData.get("repair_detail") || "ไม่มี";
    
    let imagesHtml = '';
    croppedBlobs.forEach((blob, index) => {
        if (blob) {
            const url = URL.createObjectURL(blob);
            imagesHtml += `<img src="${url}" class="img-fluid rounded mb-2 border" style="max-height: 150px;"> `;
        }
    });

    const confirmationHtml = `
            <div style="text-align: left; padding: 1rem;">
                <p><strong><i class="bi bi-person-badge"></i> ตำแหน่ง:</strong> ${repair_posi}</p>
                <p><strong><i class="bi bi-person-circle"></i> ผู้แจ้งซ่อม:</strong> ${repair_userID}</p>
                <hr>
                <p><strong><i class="bi bi-building"></i> สถานที่:</strong> อาคาร ${repair_building} ชั้น ${repair_class} ห้อง ${repair_room}</p>
                <p><strong><i class="bi bi-telephone"></i> เบอร์โทรติดต่อ:</strong> ${repair_phone}</p>
                <hr>
                <p><strong><i class="bi bi-tools"></i> รายการแจ้งซ่อม:</strong> ${repair_caselist}</p>
                <p><strong><i class="bi bi-card-text"></i> รายละเอียด:</strong> ${repair_detail}</p>
                ${imagesHtml ? `<hr><p><strong><i class="bi bi-image"></i> รูปภาพที่แนบ (${croppedBlobs.filter(b => b).length} รูป):</strong></p>${imagesHtml}` : ""}
            </div>
        `;

    Swal.fire({
      title: "โปรดยืนยันข้อมูล",
      html: confirmationHtml,
      icon: "info",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "ยืนยันการแจ้งซ่อม",
      cancelButtonText: "ยกเลิก",
      onClose: () => {
        // imageUrl is not defined here, removed to avoid ReferenceError
      },
    }).then(async (result) => {
      if (result.isConfirmed) {
        // Math Challenge Validation
        const captchaInput = document.getElementById("captcha_input");
        if (!captchaInput || !captchaInput.value.trim()) {
          Swal.fire(
            "แจ้งเตือน!",
            "กรุณากรอกผลลัพธ์ตัวเลข (Captcha)",
            "warning",
          );
          return;
        }

        if (signaturePad.isEmpty()) {
          Swal.fire("แจ้งเตือน!", "กรุณาลงลายมือชื่อก่อนบันทึก!", "warning");
          return;
        }

        // ใช้ PNG แทน SVG เพื่อให้ขนาดเล็กลงและแสดงผลถูกต้อง
        const dataURL = signaturePad.toDataURL("image/png", 0.8);
        formData.append("Signature", dataURL);

        const btn = document.getElementById("BtnSubRepair");
        btn.innerHTML =
          '<div id="spinner" class="spinner-border spinner-border-sm text-white" role="status"></div> <span>กำลังบันทึก...</span>';
        btn.classList.add("disabled");

        try {
          const res = await fetch("../Repair/DB/Insert", {
            method: "POST",
            body: formData,
          });

          let responseData;
          try {
            responseData = await res.json();
          } catch (e) {
            console.error("Invalid JSON response:", await res.text());
            throw new Error("Invalid server response");
          }

          if (responseData.status === "success") {
            if (repair_caselist === "งานอาคารสถานที่") {
                Swal.fire({
                  title: "บันทึกแจ้งซ่อมสำเร็จ!",
                  text: "ต้องการทำบันทึกข้อความ (ตามนโยบายงานอาคารสถานที่) ต่อเลยหรือไม่?",
                  icon: "success",
                  showCancelButton: true,
                  confirmButtonColor: "#3085d6",
                  cancelButtonColor: "#6c757d",
                  confirmButtonText: "ไปทำบันทึกข้อความ",
                  cancelButtonText: "กลับหน้าแรก"
                }).then((result) => {
                  if (result.isConfirmed) {
                    window.location.href = "../Repair/BuildingMemo?order=" + responseData.repair_order;
                  } else {
                    window.location.href = "../Repair";
                  }
                });
            } else {
                Swal.fire({
                  title: "สำเร็จ!",
                  text: responseData.message || "บันทึกแจ้งซ่อมสำเร็จ!",
                  icon: "success",
                  confirmButtonColor: "#3085d6",
                  confirmButtonText: "ตกลง!",
                }).then((result) => {
                  if (result.isConfirmed) {
                    window.location.href = "../Repair";
                  }
                });
            }
          } else if (responseData.status === "error") {
            if (responseData.message === "Incorrect Captcha") {
              Swal.fire(
                "แจ้งเตือน!",
                "คำนวณตัวเลขผิด กรุณาคำนวณใหม่",
                "warning",
              );
            } else {
              Swal.fire(
                "แจ้งเตือน!",
                responseData.message || "เกิดข้อผิดพลาดในการบันทึก",
                "error",
              );
            }
          } else {
            // Unexpected status
            console.error("Unknown status:", responseData);
            Swal.fire("ผิดพลาด!", "เกิดข้อผิดพลาดไม่ทราบสาเหตุ", "error");
          }
        } catch (err) {
          console.error("❌ เกิดข้อผิดพลาด:", err);
          Swal.fire("ผิดพลาด!", "เกิดข้อผิดพลาดระหว่างส่งข้อมูล", "error");
        } finally {
          btn.classList.remove("disabled");
          document.getElementById("spinner")?.remove();
          btn.innerHTML = "บันทึกแจ้งซ่อม";
        }
      }
    });
  }
});

$(document).on("click", "#ModalFormAdmin", function () {
  //$(this).css('display', 'none');
  $("#ModalRepairSaveAdmin").modal("show");
  //$('#ModalShowRepair').modal('hide');
});

// Signature Pad Logic - ปรับปรุงให้แสดงผลเต็มและใช้ PNG
const canvas = document.getElementById("signature-pad");
let signaturePad = null;
let isInitialized = false; // ป้องกัน resize ซ้ำ

// กำหนดขนาดคงที่สำหรับ canvas เพื่อให้ลายเซ็นแสดงผลถูกต้อง
const SIGNATURE_WIDTH = 400;
const SIGNATURE_HEIGHT = 150;

function initCanvas() {
  if (!canvas || isInitialized) return;

  // ใช้ ratio เพื่อให้คมชัด แต่กำหนดขนาดให้คงที่
  const ratio = Math.max(window.devicePixelRatio || 1, 1);

  // กำหนดขนาดแสดงผล (CSS pixels)
  canvas.style.width = "100%";
  canvas.style.height = SIGNATURE_HEIGHT + "px";
  canvas.style.maxWidth = SIGNATURE_WIDTH + "px";

  // กำหนดขนาด internal canvas สำหรับความคมชัด
  const displayWidth = Math.min(canvas.offsetWidth, SIGNATURE_WIDTH);
  canvas.width = displayWidth * ratio;
  canvas.height = SIGNATURE_HEIGHT * ratio;

  const ctx = canvas.getContext("2d");
  ctx.scale(ratio, ratio);

  // เติมพื้นหลังขาว
  ctx.fillStyle = "#ffffff";
  ctx.fillRect(0, 0, canvas.width, canvas.height);

  isInitialized = true;
}

// ฟังก์ชัน resize ที่เก็บลายเซ็นไว้ก่อนแล้ว restore กลับ
function resizeCanvasSafe() {
  if (!canvas || !signaturePad) return;
  
  // ถ้าไม่มีลายเซ็น ให้ init ใหม่ได้
  if (signaturePad.isEmpty()) {
    isInitialized = false;
    initCanvas();
    return;
  }
  
  // ถ้ามีลายเซ็นอยู่แล้ว ให้เก็บไว้ก่อน
  const signatureData = signaturePad.toData();
  
  // ใช้ ratio เพื่อให้คมชัด
  const ratio = Math.max(window.devicePixelRatio || 1, 1);

  // ตรวจสอบว่าขนาดจริงเปลี่ยนหรือไม่
  const displayWidth = Math.min(canvas.offsetWidth, SIGNATURE_WIDTH);
  const newWidth = displayWidth * ratio;
  
  // ถ้าขนาดไม่เปลี่ยน ไม่ต้องทำอะไร (ป้องกัน scroll trigger)
  if (Math.abs(canvas.width - newWidth) < 5) {
    return;
  }

  // กำหนดขนาดแสดงผล (CSS pixels)
  canvas.style.width = "100%";
  canvas.style.height = SIGNATURE_HEIGHT + "px";
  canvas.style.maxWidth = SIGNATURE_WIDTH + "px";

  // กำหนดขนาด internal canvas
  canvas.width = newWidth;
  canvas.height = SIGNATURE_HEIGHT * ratio;

  const ctx = canvas.getContext("2d");
  ctx.scale(ratio, ratio);

  // เติมพื้นหลังขาว
  ctx.fillStyle = "#ffffff";
  ctx.fillRect(0, 0, canvas.width, canvas.height);

  // Restore ลายเซ็นกลับมา
  if (signatureData && signatureData.length > 0) {
    signaturePad.fromData(signatureData);
  }
}

// Initialize if canvas exists
if (canvas) {
  signaturePad = new SignaturePad(canvas, {
    backgroundColor: "rgb(255,255,255)", // พื้นหลังขาว
    penColor: "rgb(0,0,150)", // สีน้ำเงินเข้ม
    minWidth: 1,
    maxWidth: 2.5,
    velocityFilterWeight: 0.7,
  });

  // Init canvas ครั้งแรก
  initCanvas();

  // ใช้ debounce เพื่อป้องกันการ resize ซ้ำเมื่อ scroll บนมือถือ
  let resizeTimeout;
  window.addEventListener("resize", function() {
    clearTimeout(resizeTimeout);
    resizeTimeout = setTimeout(resizeCanvasSafe, 200);
  });

  // Special handling for Modal (UserRepairView.php)
  $("#ModalRepairSaveAdmin").on("shown.bs.modal", function () {
    isInitialized = false;
    initCanvas();
  });
}

const clearBtn = document.getElementById("clear");
if (clearBtn && signaturePad) {
  clearBtn.addEventListener("click", () => {
    signaturePad.clear();
    // เติมพื้นหลังขาวใหม่หลังล้าง
    const ctx = canvas.getContext("2d");
    const ratio = Math.max(window.devicePixelRatio || 1, 1);
    ctx.fillStyle = "#ffffff";
    ctx.fillRect(0, 0, canvas.width / ratio, canvas.height / ratio);
  });
}

$(document).on("submit", "#FormSaveRepairAdmin", function (e) {
  e.preventDefault();

  if (signaturePad.isEmpty()) {
    alert("กรุณาเซ็นก่อนบันทึก!");
    return;
  }

  // ปุ่ม loading
  $("#btnSaveRepair").prop("disabled", true);
  $("#btnSaveText").text("กำลังบันทึก...");
  $("#btnSpinner").show();

  // ใช้ PNG แทน SVG เพื่อให้ขนาดเล็กลงและแสดงผลถูกต้อง
  var dataURL = signaturePad.toDataURL("image/png", 0.8);
  var formData = new FormData(this);
  formData.append("Signature", dataURL);

  // Remove original repair_imgwork from formData to avoid confusion
  formData.delete('repair_imgwork');

  // Append all admin cropped blobs that exist
  adminCroppedBlobs.forEach((blob, index) => {
    if (blob) {
      formData.append('repair_imgwork[]', blob, `admin_photo_${index}.png`);
    }
  });

  $.ajax({
    url: "../../Repair/DB/UpdateWork",
    method: "POST",
    data: formData,
    processData: false,
    contentType: false,
    cache: false,
    dataType: "json", // ให้ jQuery แปรงเป็น JSON ให้อัตโนมัติ
    success: function (response) {
      $("#btnSaveRepair").prop("disabled", false);
      $("#btnSaveText").text("บันทึกข้อมูล");
      $("#btnSpinner").hide();

      $("#ModalRepairSaveAdmin").modal("hide");
      $(".modal-backdrop").remove();

      if (response.status === "success") {
        Swal.fire({
          title: "สำเร็จ!",
          text: response.message,
          icon: "success",
          confirmButtonColor: "#3085d6",
          confirmButtonText: "ตกลง!",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.reload(true);
          }
        });
      } else {
        Swal.fire(
          "แจ้งเตือน!",
          response.message || "บันทึกข้อมูลไม่สำเร็จ!",
          "error",
        );
      }
    },
    error: function (xhr, status, error) {
      console.error("AJAX Error:", status, error);
      console.error("Response Text:", xhr.responseText);

      $("#btnSaveRepair").prop("disabled", false);
      $("#btnSaveText").text("บันทึกข้อมูล");
      $("#btnSpinner").hide();

      var errorMsg = "เกิดข้อผิดพลาดระหว่างบันทึก!";
      if (xhr.status === 404) errorMsg = "ไม่พบ Path สำหรับบันทึกข้อมูล (404)";
      else if (xhr.status === 500) errorMsg = "Server ทำงานผิดพลาด (500)";

      Swal.fire(
        "แจ้งเตือน!",
        errorMsg + "\nกรุณาตรวจสอบ Console (F12)",
        "error",
      );
    },
  });
});

$(document).on("click", "#BtnCleanupImages", function () {
  Swal.fire({
    title: "ยืนยันการล้างไฟล์ขยะ?",
    text: "ระบบจะลบรูปภาพที่ไม่ได้อ้างอิงถึงในฐานข้อมูลออกอย่างถาวร!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#d33",
    cancelButtonColor: "#3085d6",
    confirmButtonText: "ใช่, ฉันต้องการลบ!",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "กำลังล้างไฟล์ขยะ...",
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
          Swal.showLoading();
        },
      });

      $.ajax({
        url: "../../Repair/DB/CleanupImages",
        method: "POST",
        dataType: "json",
        success: function (response) {
          if (response.status === "success") {
            Swal.fire({
              title: "สำเร็จ!",
              text: response.message,
              icon: "success",
              confirmButtonText: "ตกลง",
            });
          } else {
            Swal.fire("แจ้งเตือน!", response.message, "error");
          }
        },
        error: function (xhr) {
          console.error("Cleanup Error:", xhr.responseText);
          Swal.fire("ผิดพลาด!", "เกิดข้อผิดพลาดระหว่างลบไฟล์ขยะ", "error");
        },
      });
    }
  });
});

$(document).on("click", "#BtnMigrateImages", function () {
  Swal.fire({
    title: "ยืนยันการจัดระเบียบไฟล์?",
    text: "ระบบจะย้ายไฟล์รูปภาพที่มีอยู่เดิมไปไว้ในโฟลเดอร์ที่ถูกต้องตามฐานข้อมูล (User/Admin)!",
    icon: "info",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "เริ่มจัดระเบียบ!",
    cancelButtonText: "ยกเลิก",
  }).then((result) => {
    if (result.isConfirmed) {
      Swal.fire({
        title: "กำลังจัดระเบียบไฟล์...",
        text: "กรุณารอสักครู่...",
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
          Swal.showLoading();
        },
      });

      $.ajax({
        url: "../../Repair/DB/MigrateImages",
        method: "POST",
        dataType: "json",
        success: function (response) {
          if (response.status === "success") {
            Swal.fire({
              title: "สำเร็จ!",
              text: response.message,
              icon: "success",
              confirmButtonText: "ตกลง",
            }).then(() => {
                window.location.reload();
            });
          } else {
            Swal.fire("แจ้งเตือน!", response.message, "error");
          }
        },
        error: function (xhr) {
          console.error("Migration Error:", xhr.responseText);
          Swal.fire("ผิดพลาด!", "เกิดข้อผิดพลาดระหว่างย้ายไฟล์", "error");
        },
      });
    }
  });
});
