function handleUploadImg(el, id) {
    const file = el.files[0];
    const reader = new FileReader();

    if (file && file.type.startsWith("image/")) {
        reader.onload = function (e) {
            const preview = document.getElementById(id);
            if (preview) {
                preview.src = e.target.result;
            }
        };
        reader.readAsDataURL(file);
    }
}

const changeImg = (url) => {
    document.getElementById('user_img_detail').src = url;
}

const showToast = (message) => {
    const alertToast = document.getElementById('alert-toast');
    const toastContent = alertToast.querySelector('.toast-body');
    const toastBootstrap = bootstrap.Toast.getOrCreateInstance(alertToast);
    toastContent.textContent = message;
    toastBootstrap.show();
}

const navigate = (url) => window.location.href = url;

const handleChangeDetailImg = (target, url) => {
    const imgItems = document.querySelectorAll('.detail-img-item');
    imgItems.forEach(element => {
        element.style.setProperty('border', 'none', 'important');
    });
    target.style.setProperty('border', '2px solid #dc3545', 'important');
    document.getElementById('detail-img').src = url;
}