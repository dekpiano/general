
let croppieInstance;
let croppedImageBase64 = null;
let bsModal = null;

document.addEventListener('DOMContentLoaded', function() {
    const modalEl = document.getElementById('imageModal');
    if (modalEl) {
        bsModal = new bootstrap.Modal(modalEl);
    }
});

$('#imageInput').on('change', function (e) {
  const file = e.target.files[0];
  if (!file) return;

  const reader = new FileReader();
  reader.onload = function (e) {
    if (croppieInstance) {
      croppieInstance.destroy();
    }

    croppieInstance = new Croppie($('#croppieContainer')[0], {
        viewport: { width: 320, height: 180, type: 'square' }, // 16:9 แนวนอน
        boundary: { width: 350, height: 200 },
        enableOrientation: true , // สำคัญ!m
      showZoomer: true
    });

    croppieInstance.bind({ url: e.target.result });
  };
  reader.readAsDataURL(file);
});

// หมุนซ้าย
$('#rotateLeftBtn').on('click', function() {
    if (croppieInstance) croppieInstance.rotate(-90);
});
// หมุนขวา
$('#rotateRightBtn').on('click', function() {
    if (croppieInstance) croppieInstance.rotate(90);
});

$('#cropBtn').on('click', function () {
    if (!croppieInstance) return;

    croppieInstance.result({
      type: 'base64',
      size: 'original',
      format: 'png',
      quality: 1
    }).then(function (croppedImage) {
      croppedImageBase64 = croppedImage;

      const canvas = $('#croppedCanvas')[0];
      const ctx = canvas.getContext('2d');
      const img = new Image();

      img.onload = function () {
        canvas.width = img.width;
        canvas.height = img.height;
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(img, 0, 0);
        $('#croppedCanvas').show();
        $('#uploadBtn').prop('disabled', false);

        bsModal.hide();
      };

      img.src = croppedImage;
      $('#booking_imgWork').val(croppedImageBase64);
    });
  });

  
