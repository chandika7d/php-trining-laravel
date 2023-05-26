function validateInputFileImage(oInput) {
    var _validFileExtensions = [".png", ".jpg", ".jpeg", ".PNG",".JPG",".JPEG",".webp"];
    if (oInput.type == "file") {
        var sFileName = oInput.value;
        var sFilesize = Math.round(oInput.files[0].size / 1024);
        if (sFilesize >= 2048) {
            alert("Maaf, " + sFileName + " ukuran file tidak diijinkan, ukuran file lebih dari 2MB.");
            oInput.value = "";
            return false;
        }

        if (sFileName.length > 0) {
            var blnValid = false;
            for (var j = 0; j < _validFileExtensions.length; j++) {
                var sCurExtension = _validFileExtensions[j];
                if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                    blnValid = true;
                    break;
                }
            }
            if (!blnValid) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "Maaf, " + sFileName + " tipe dokumen yang tidak diijinkan, tipe dokumen yang diijinkan: " + _validFileExtensions.join(", ") + ", dan ukuran file harus di bawah 2MB.",
                });

                oInput.value = "";
                return false;
            }
        }
    }
    return true;
}

function validateNumber(objek) {
    separator = ".";
    a = objek.value;
    b = a.replace(/[^\d]/g, "");
    c = "";
    panjang = b.length;
    j = 0;
    for (i = panjang; i > 0; i--) {
        c = b.substr(i - 1, 1) + c;
    }
    objek.value = c;
}
